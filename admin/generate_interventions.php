<?php
   include('../includes/database_connection.php');
       
    $generation_type = $_REQUEST['type'];

    $table_intervention = '';
    if($generation_type == 'mps'){
        $table_intervention = 'interventions';
    }else{
        $table_intervention = 'lop_interventions';
    }

    $scores = [
        "english" => $_REQUEST['english'],
        "filipino" => $_REQUEST['filipino'],
        "aralingpanlipunan" => $_REQUEST['aralpan'],
        "esp" => $_REQUEST['esp'],
        "math" => $_REQUEST['math'],
        "science" => $_REQUEST['science'],
        "mapeh" => $_REQUEST['mapeh'],
        "tle" => $_REQUEST['tle']
    ];

    // ✅ Mapping of text values to numeric equivalents
    function map_to_numeric($value) {
        $mapping = [
            "Highly Accessible" => 3,
            "Moderately Accessible" => 2,
            "Last Mile Schools" => 1
        ];
        return isset($mapping[$value]) ? $mapping[$value] : 1; // Default to 0 if value is invalid
    }
    // ✅ Mapping of text values to numeric equivalents
    function map_to_numeric2($value) {
        $mapping = [
            "Fully Equipped" => 3,
            "Moderately Equipped" => 2,
            "Minimally Equipped" => 1
        ];
        return isset($mapping[$value]) ? $mapping[$value] : 1; // Default to 0 if value is invalid
    }
    // ✅ Mapping of text values to numeric equivalents
    function map_to_numeric3($value) {
        $mapping = [
            "High speed internet" => 3,
            "Average speed internet" => 2,
            "No internet" => 1
        ];
        return isset($mapping[$value]) ? $mapping[$value] : 1; // Default to 0 if value is invalid
    }


    if(isset($_REQUEST['district'])){
        // ✅ Get the district and scores from the request
        $district = $_REQUEST['district'];
        // ✅ Fetch school information based on district
        $sql = "SELECT accessibility, facilities, internetconnectivity FROM schools WHERE district = ?";
        $stmt = $DB->prepare($sql);
        $stmt->bind_param("s", $district);
        $stmt->execute();
        $result = $stmt->get_result();
        $school_data = $result->fetch_assoc();
    }
    
    if(isset($_REQUEST['school_name'])){
        // ✅ Get the district and scores from the request
        $school_name = $_REQUEST['school_name'];
        // ✅ Fetch school information based on district
        $sql = "SELECT accessibility, facilities, internetconnectivity FROM schools WHERE school_name = ?";
        $stmt = $DB->prepare($sql);
        $stmt->bind_param("s", $school_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $school_data = $result->fetch_assoc();
    }



    // ✅ Map the text-based values to numeric
    $accessibility = map_to_numeric($school_data['accessibility']);
    $facilities = map_to_numeric2($school_data['facilities']);
    $internet = map_to_numeric3($school_data['internetconnectivity']);

    $interventions = [];
    // Initialize an empty array for subject names that need interventions
    $subjects_needing_interventions = [];

    if($generation_type == 'mps'){
        foreach ($scores as $subject => $score) 
        {
                $subjects_needing_interventions[] = $subject;
        }
    }else{
        foreach ($scores as $subject => $score) 
        {
                $subjects_needing_interventions[] = $subject;
        }

    }

    // If there are subjects that need interventions, construct the WHERE clause
    if (!empty($subjects_needing_interventions)) {
        $subjects_list = implode("', '", $subjects_needing_interventions); // Prepare subject list for query
        $sql_interventions = "SELECT * FROM $table_intervention WHERE subject IN ('$subjects_list')";

        // Execute the query
        $result_interventions = $DB->query($sql_interventions);

        // Store fetched interventions in an associative array
        $interventions = [];
        while ($row = $result_interventions->fetch_assoc()) {
            $interventions[] = [
                "subject" => $row['subject'],
                "score_range_start" => $row['score_range_start'],
                "score_range_end" => $row['score_range_end'],
                "intervention_description" => $row['id']
            ];
        }
    } else {
        echo "No subjects need interventions.";
    }


    $school_interventions_withintervention = [];
    // Fetch all interventions
    $sql = "SELECT id, accessibility_score, facilities_score, internet_score, interventions FROM school_interventions";
    $result = $conn->query($sql);

    $school_interventions = [];

    while ($row = $result->fetch_assoc()) {
        $school_interventions[] = [
            "id" => $row["id"],
            "accessibility_score" => $row["accessibility_score"],
            "facilities_score" => $row["facilities_score"],
            "internetconnectivity_score" => $row["internet_score"]
        ];

        $school_interventions_withintervention[$row["id"]] = $row["interventions"];
    }


    // ✅ Add interventions to the data to be passed to Python script
    $data = [
        "scores" => $scores,
        "school_info" => [
            "accessibility" => $accessibility,
            "facilities" => $facilities,
            "internet" => $internet
        ],
        "interventions" => $interventions,
        "school_interventions" => $school_interventions
    ];

// ✅ Convert data to JSON string
$jsonInput = json_encode($data);

// ✅ Define the Flask API endpoint
$flaskUrl = "https://navarrogryan.pythonanywhere.com/analyze";

// ✅ Initialize cURL
$ch = curl_init($flaskUrl);

// ✅ Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonInput);

// ✅ Execute the request and get the response
$response = curl_exec($ch);

// ✅ Check for cURL errors
if ($response === false) {
   // echo "cURL Error: " . curl_error($ch);
} else {
  //  echo "Flask Response: " . $response; // ✅ Output Flask response
}

// ✅ Close cURL session
curl_close($ch);

// Show output from Python script
//echo "<pre>$command</pre>";

// ✅ Parse the output
$lines = explode("\n", trim($response));
$subjectsNeedingImprovement = [];
$interventionsPerSubject = [];
$subjectsGood = [];
$cause = "";
$intervention = "";

// ✅ Parse the output
foreach ($lines as $line) {
    if (strpos($line, "Interventions Per Subject:") !== false) {
        $isInterventionSection = true; // Start capturing interventions
        continue;
    }

    if (isset($isInterventionSection) && strpos($line, "- ") === 0) {
        $line = trim($line, "- ");
        list($subject, $interventionText) = explode(": ", $line, 2);
        $interventionsPerSubject[trim($subject)] = trim($interventionText);
    }
}

foreach ($lines as $line) {
    if (strpos($line, "Subjects Needing Improvement:") !== false) {
        $subjectsStr = trim(str_replace("Subjects Needing Improvement: ", "", $line), "{}");
        if (!empty($subjectsStr)) {
            $subjectsArray = explode(", ", $subjectsStr);
            foreach ($subjectsArray as $subject) {
                if (strpos($subject, ": ") !== false) {
                    list($key, $value) = explode(": ", $subject, 2);
                    $subjectsNeedingImprovement[trim($key, "'")] = floatval($value);
                }
            }
        }
    } elseif (strpos($line, "Subjects Good:") !== false) {
        $subjectsStr = trim(str_replace("Subjects Good: ", "", $line), "{}");
        if (!empty($subjectsStr)) {
            $subjectsArray = explode(", ", $subjectsStr);
            foreach ($subjectsArray as $subject) {
                if (strpos($subject, ": ") !== false) {
                    list($key, $value) = explode(": ", $subject, 2);
                    $subjectsGood[trim($key, "'")] = floatval($value);
                }
            }
        }
    } elseif (strpos($line, "Identified Cause:") !== false) {
        $cause = str_replace("Identified Cause: ", "", $line);
    } elseif (strpos($line, "General Intervention:") !== false) {
        $intervention = str_replace("General Intervention: ", "", $line);
    }
}

// ✅ Display the results with HTML
echo "<div style='font-family: Arial, sans-serif; padding: 20px;'>";

echo "<div class='row'>";
echo "<div class='col-md-4 col-xs-12 col-sm-12'>";
echo "<h3>📉 Subjects Needing Improvement</h3>";
if (!empty($subjectsNeedingImprovement)) {
    echo "<table border='1' cellspacing='0' cellpadding='5' style='width: 100%; text-align: left; border-collapse: collapse;'>";
    echo "<tr style='background-color: #f8d7da;'>
            <th style='width: 40%;'>Subject</th>
            <th style='width: 20%;'>Score (%)</th>
            <th style='width: 40%;'>Mastery Level</th>
          </tr>";
    
    foreach ($subjectsNeedingImprovement as $subject => $score) {
        $masteryLevel = getMasteryLevel($score, $generation_type);
        echo "<tr>
                <td style='text-transform: uppercase;'>$subject</td>
                <td>$score%</td>
                <td>$masteryLevel</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>✅ No subjects need improvement.</p>";
}

echo "<br><h3>📈 Subjects Performing Well</h3>";
if (!empty($subjectsGood)) {
    echo "<table border='1' cellspacing='0' cellpadding='5' style='width: 100%; text-align: left; border-collapse: collapse;'>";
    echo "<tr style='background-color: #d4edda;'>
            <th style='width: 40%;'>Subject</th>
            <th style='width: 20%;'>Score (%)</th>
            <th style='width: 40%;'>Mastery Level</th>
          </tr>";
    
    foreach ($subjectsGood as $subject => $score) {
        $masteryLevel = getMasteryLevel($score, $generation_type);
        echo "<tr>
                <td style='text-transform: uppercase;'>$subject</td>
                <td>$score%</td>
                <td>$masteryLevel</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>✅ No subjects performed well.</p>";
}

// Function to determine mastery level based on score
function getMasteryLevel($score, $generation_type) {
    if($generation_type == 'mps'){
        if ($score >= 96 && $score <= 100) {
            return "Mastered";
        } elseif ($score >= 86 && $score <= 95.99) {
            return "Closely Approximating Mastery";
        } elseif ($score >= 66 && $score <= 85.99) {
            return "Moving Toward Mastery";
        } elseif ($score >= 35 && $score <= 65.99) {
            return "Average";
        } elseif ($score >= 15 && $score <= 34.99) {
            return "Low";
        } elseif ($score >= 5 && $score <= 14.99) {
            return "Very Low";
        } elseif ($score >= 0 && $score <= 4.99) {
            return "Absolutely No Mastery";
        }
    }else{
        if ($score >= 90) return 'Highly Proficient (A)';
        if ($score >= 85) return 'Proficient (P)';
        if ($score >= 80) return 'Nearly Proficient (AP)';
        if ($score >= 75) return 'Low Proficient (D)';
        return 'Not Proficient (B)';
    }
}

echo "</div>";

echo "<div class='col-md-8 col-xs-12 col-sm-12'>";


echo "<h3>⚠️ Cause of Poor Performance</h3>";
echo "<p style='margin-left:2vh;'>$cause</p>";


$sql_interventions = "SELECT id, intervention_description FROM $table_intervention";
$result_interventions = $DB->query($sql_interventions);

$intervention_descriptions = []; // Store intervention descriptions mapped by ID
while ($row = $result_interventions->fetch_assoc()) {
    $intervention_descriptions[$row['id']] = $row['intervention_description'];
}


// ✅ Display the interventions per subject in HTML
echo "<h3>📌 Interventions Per Subject</h3>";

if (!empty($interventionsPerSubject)) {
    echo "<ul>";
    foreach ($interventionsPerSubject as $subject => $interventionId) {
        // 🔹 Get the intervention description based on the ID
        $interventionText = isset($intervention_descriptions[$interventionId]) ? $intervention_descriptions[$interventionId] : "No intervention found";

        echo "<li><b>$subject</b>: $interventionText</li>";
    }
    echo "</ul>";
} else {
    echo "<p>✅ No additional interventions needed.</p>";
}

echo "<h3>🎯 General Intervention</h3>";
$intervention_text = isset($school_interventions_withintervention[$intervention]) ? $school_interventions_withintervention[$intervention] : "No intervention found";
echo "<p style='margin-left:2vh;'><b>$intervention_text</b></p>";


echo "</div>";
echo "</div>";

echo "</div>";

?>
