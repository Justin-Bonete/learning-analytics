<?php
require_once "../includes/database_connection.php";
session_start();

$district = $_SESSION["district"];
$school_email = $_SESSION["email"];
$dateInput = $_POST['gradeDate']; // Format from form: "YYYY-MM-DDTHH:MM"
$timestamp = date('Y-m-d H:i:s', strtotime($dateInput));
if (!empty($_FILES["csv_file"]["name"])) {
    $filename = $_FILES["csv_file"]["tmp_name"];

    if ($_FILES["csv_file"]["size"] > 0) {
        $file = fopen($filename, "r");

        $school_id = null;
        $grade_level = null;
        $quarter = null;

        // Read file line by line
        while (($row = fgetcsv($file)) !== false) {
            if (empty(array_filter($row))) {
                continue;
            } // Skip empty rows

            // Extract values from COLUMN C (index 2)
            if (isset($row[2])) {
                if (stripos($row[1], "SCHOOL ID") !== false) {
                    $school_id = preg_replace("/[^0-9]/", "", $row[2]); // Extract numbers only
                }
                if (stripos($row[1], "GRADE LEVEL") !== false) {
                    $grade_level = preg_replace("/[^0-9]/", "", $row[2]); // Extract numbers only
                }
                if (stripos($row[1], "TERM") !== false || stripos($row[1], "QUARTER") !== false) {
                    $quarter = preg_replace("/[^0-9]/", "", $row[2]); // Extract numbers only
                }
            }

            // Stop reading when all values are found
            if ($school_id && $grade_level && $quarter) {
                break;
            }
        }

        if (!$school_id || !$grade_level || !in_array((string)$quarter, ['1', '2', '3'], true)) {
            die("Error: Missing school ID, grade level, or valid term (1-3).");
        }

        // Locate "LEARNERS QUARTERLY SUMMATIVE TEST SCORE"
        while (($row = fgetcsv($file)) !== false) {
            if (stripos(implode(" ", $row), "LEARNERS GRADES") !== false) {
                break;
            }
        }

        // Read subject headers
        fgetcsv($file); // Skip header row

        // Hardcoded column mapping
        $db_columns = [
            "english",
            "filipino",
            "aralpan",
            "esp",
            "math",
            "science",
            "mapeh",
            "tle",
        ];

        while (($row = fgetcsv($file)) !== false) {
            if (empty($row[1])) {
                continue;
            } // Skip empty names
            $learner_name = trim($row[1]);

            $scores = array_map(
                fn($val) => is_numeric($val) ? intval($val) : 0,
                array_slice($row, 2, 8)
            );

            if (count($scores) !== 8) {
                die("Error: Mismatch between subjects and scores.");
            }

            // ✅ Check if a record exists
            
            $current_year = date('Y', strtotime($dateInput));
            $check_sql = "SELECT id FROM learners_grade 
                          WHERE school_id = ? AND grade_level = ? AND quarter = ? 
                          AND YEAR(created_at) = ? AND student_name = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param(
                "iiiis",
                $school_id,
                $grade_level,
                $quarter,
                $current_year,
                $learner_name
            );
            $check_stmt->execute();
            $check_stmt->bind_result($existing_id);
            $record_exists = $check_stmt->fetch();
            $check_stmt->close();

            if ($record_exists) {
                // ✅ Filter out columns with a value of 0
                $filtered_columns = [];
                $filtered_scores = [];
                foreach ($db_columns as $index => $column) {
                    if ($scores[$index] != 0) {  // Exclude columns where value is 0
                        $filtered_columns[] = $column;
                        $filtered_scores[] = $scores[$index];
                    }
                }

                // ✅ Ensure there's something to update
                if (empty($filtered_columns)) {
                    die("No valid fields to update."); // Prevent empty UPDATE queries
                }
                
                // ✅ Build dynamic UPDATE query
                $update_sql = "UPDATE learners_grade SET created_by = ?, created_at = ?, ";
                $update_sql .= implode(" = ?, ", $filtered_columns) . " = ? ";
                $update_sql .= "WHERE id = ?";
                
                // ✅ Prepare statement
                $stmt = $conn->prepare($update_sql);
                if (!$stmt) {
                    die("Error preparing update statement: " . $conn->error);
                }
                
                // ✅ Ensure correct parameter order (added $timestamp)
                $update_params = array_merge([$school_email, $timestamp], $filtered_scores, [$existing_id]);
                
                // ✅ Generate correct type string (added 's' for timestamp)
                $types = "ss" . str_repeat("i", count($filtered_scores)) . "i";

                // ✅ Bind parameters dynamically
                $stmt->bind_param($types, ...$update_params);

                if (!$stmt->execute()) {
                    die("Update failed: " . $stmt->error);
                }
                $stmt->close();

            } else {
                // ✅ INSERT new record
                // ✅ INSERT new record
                $insert_sql =
                    "INSERT INTO learners_grade 
                        (school_id, district, grade_level, quarter, student_name, created_by, created_at, " .
                    implode(", ", $db_columns) .
                    ") 
                        VALUES (" .
                    str_repeat("?, ", 14) .
                    "?)"; // Increased parameter count by 1 for created_at
                $stmt = $conn->prepare($insert_sql);
                if (!$stmt) {
                    die("Error preparing insert statement: " . $conn->error);
                }
                
                $stmt->bind_param(
                    "issssss" . str_repeat("i", 8), // Added 's' for the timestamp
                    $school_id,
                    $district,
                    $grade_level,
                    $quarter,
                    $learner_name,
                    $school_email,
                    $timestamp, // Add the timestamp here
                    ...$scores
                );

                if (!$stmt->execute()) {
                    die("Insert failed: " . $stmt->error);
                }
                $stmt->close();
            }
        }

        fclose($file);
        echo "CSV file processed successfully!";
    } else {
        echo "Error: File is empty.";
    }
} else {
    echo "No file uploaded!";
}
?>
