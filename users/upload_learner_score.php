<?php
require_once "../includes/database_connection.php";
session_start();

$district = $_SESSION["district"];
$school_email = $_SESSION["email"];
$dateInput = $_POST['scoreDate']; // Format from form: "YYYY-MM-DDTHH:MM"
$timestamp = date('Y-m-d H:i:s', strtotime($dateInput));
if (!empty($_FILES["csv_file"]["name"])) {
    $filename = $_FILES["csv_file"]["tmp_name"];

    if ($_FILES["csv_file"]["size"] > 0) {
        $file = fopen($filename, "r");

        $school_id = null;
        $grade_level = null;
        $quarter = null;
        $year = date('Y', strtotime($dateInput));

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

            if ($school_id && $grade_level && $quarter) {
                break;
            }
        }

        if (!$school_id || !$grade_level || !in_array((string)$quarter, ['1', '2', '3'], true)) {
            die("Error: Missing school ID, grade level, or valid term (1-3).");
        }

        rewind($file);
        $row_index = 0;
        $total_scores = [];

        while (($row = fgetcsv($file)) !== false) {
            $row_index++;
            if ($row_index === 8) {
                $row = array_map("trim", $row);
                $total_scores = array_slice($row, 2, 8);
                $total_scores = array_map(
                    fn($val) => is_numeric($val) ? intval($val) : 0,
                    $total_scores
                );
                break;
            }
        }

        if (count($total_scores) !== 8 || array_sum($total_scores) === 0) {
            die("Error: Unable to extract valid total scores.");
        }

        while (($row = fgetcsv($file)) !== false) {
            if (
                stripos(
                    implode(" ", $row),
                    "LEARNERS QUARTERLY SUMMATIVE TEST SCORE"
                ) !== false
            ) {
                break;
            }
        }
        fgetcsv($file);

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
            }
            $learner_name = trim($row[1]);
            $scores = array_map(
                fn($val) => is_numeric($val) ? intval($val) : 0,
                array_slice($row, 2, 8)
            );
            if (count($scores) !== 8) {
                die("Error: Mismatch between subjects and scores.");
            }

            // Check if record exists
            $check_sql =
                "SELECT COUNT(*) FROM learners_score WHERE school_id = ? AND grade_level = ? AND quarter = ? AND student_name = ? AND YEAR(created_at) = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param(
                "iissi",
                $school_id,
                $grade_level,
                $quarter,
                $learner_name,
                $year
            );
            $check_stmt->execute();
            $check_stmt->bind_result($count);
            $check_stmt->fetch();
            $check_stmt->close();

            if ($count > 0) {
                // Filter out subjects with a score of 0
                $filtered_columns = [];
                $filtered_scores = [];
                foreach ($db_columns as $index => $column) {
                    if ($scores[$index] != 0) {  // Exclude subjects with a score of 0
                        $filtered_columns[] = $column;
                        $filtered_scores[] = $scores[$index];
                    }
                }

                // Ensure total scores are always updated
                $total_columns = ['t_english', 't_filipino', 't_aralpan', 't_esp', 't_math', 't_science', 't_mapeh', 't_tle'];
                $update_columns = array_merge($filtered_columns, $total_columns);

                // Build the update query dynamically
                $update_sql = "UPDATE learners_score SET created_by = ?, ";
                $update_sql .= implode(" = ?, ", $update_columns) . " = ? ";
                $update_sql .= "WHERE school_id = ? AND grade_level = ? AND quarter = ? AND student_name = ? AND YEAR(created_at) = ?";

                // Prepare statement
                $update_stmt = $conn->prepare($update_sql);

                // Merge parameters dynamically
                $params = array_merge([$school_email], $filtered_scores, $total_scores, [
                    $school_id,
                    $grade_level,
                    $quarter,
                    $learner_name,
                    $year,
                ]);

                // Generate the type string dynamically
                $types = "s" . str_repeat("i", count($filtered_scores) + count($total_scores)) . "iissi";

                // Bind parameters dynamically
                $update_stmt->bind_param($types, ...$params);

                if (!$update_stmt->execute()) {
                    die("Update failed: " . $update_stmt->error);
                }
                $update_stmt->close();

            } else {
                // INSERT new record with timestamp
                $insert_sql =
                    "INSERT INTO learners_score 
                    (school_id, district, grade_level, quarter, student_name, created_by, created_at, " .
                    implode(", ", $db_columns) .
                    ", t_english, t_filipino, t_aralpan, t_esp, t_math, t_science, t_mapeh, t_tle) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, " . str_repeat("?, ", 15) . "?)";

                $insert_stmt = $conn->prepare($insert_sql);

                $params = array_merge(
                    [
                        $school_id,
                        $district,
                        $grade_level,
                        $quarter,
                        $learner_name,
                        $school_email,
                        $timestamp
                    ],
                    $scores,
                    $total_scores
                );

                $types = "issssss" . str_repeat("i", 16);
                $insert_stmt->bind_param($types, ...$params);

                if (!$insert_stmt->execute()) {
                    die("Insert failed: " . $insert_stmt->error);
                }
                $insert_stmt->close();
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
