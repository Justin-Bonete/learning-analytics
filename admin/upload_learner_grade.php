<?php
require_once('../includes/database_connection.php'); 
session_start();

$school_email = $_SESSION['email'];

if (!empty($_FILES['csv_file']['name'])) {
    $filename = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($filename, "r");

        $school_id = null;
        $grade_level = null;
        $quarter = null;

        // Read file line by line
        while (($row = fgetcsv($file)) !== false) {
            if (empty(array_filter($row))) continue; // Skip empty rows

            // Extract values from COLUMN C (index 2)
            if (isset($row[2])) {
                if (stripos($row[1], "SCHOOL ID") !== false) {
                    $school_id = preg_replace('/[^0-9]/', '', $row[2]); // Extract numbers only
                }
                if (stripos($row[1], "GRADE LEVEL") !== false) {
                    $grade_level = preg_replace('/[^0-9]/', '', $row[2]); // Extract numbers only
                }
                if (stripos($row[1], "TERM") !== false || stripos($row[1], "QUARTER") !== false) {
                    $quarter = preg_replace('/[^0-9]/', '', $row[2]); // Extract numbers only
                }
            }

            // Stop reading when all values are found
            if ($school_id && $grade_level && $quarter) break;
        }

        if (!$school_id || !$grade_level || !in_array((string)$quarter, ['1', '2', '3'], true)) {
            die("Error: Missing school ID, grade level, or valid term (1-3).");
        }

        // Locate "LEARNERS QUARTERLY SUMMATIVE TEST SCORE"
        while (($row = fgetcsv($file)) !== false) {
            if (stripos(implode(" ", $row), "LEARNERS GRADES") !== false) break;
        }

        // Read subject headers
        fgetcsv($file); // Skip header row

        // Hardcoded column mapping
        $db_columns = ["english", "filipino", "aralpan", "esp", "math", "science", "mapeh", "tle"];

        while (($row = fgetcsv($file)) !== false) {
            if (empty($row[1])) continue; // Skip empty names
            $learner_name = trim($row[1]);

            $scores = array_map(fn($val) => is_numeric($val) ? intval($val) : 0, array_slice($row, 2, 8));

            if (count($scores) !== 8) die("Error: Mismatch between subjects and scores.");

            // ✅ Check if a record exists
            $current_year = date("Y");
            $check_sql = "SELECT id FROM learners_grade 
                          WHERE school_id = ? AND grade_level = ? AND quarter = ? 
                          AND YEAR(created_at) = ? AND student_name = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("iiiis", $school_id, $grade_level, $quarter, $current_year, $learner_name);
            $check_stmt->execute();
            $check_stmt->bind_result($existing_id);
            $record_exists = $check_stmt->fetch();
            $check_stmt->close();

            if ($record_exists) {
// ✅ UPDATE existing record
$update_sql = "UPDATE learners_grade SET created_by = ?, " . 
    implode(" = ?, ", $db_columns) . " = ? WHERE id = ?";
$stmt = $conn->prepare($update_sql);
if (!$stmt) die("Error preparing update statement: " . $conn->error);

// ✅ Ensure correct parameter order
$update_params = array_merge([$school_email], $scores, [$existing_id]);
$types = "s" . str_repeat("i", 8) . "i";

// ✅ Use call_user_func_array to bind parameters dynamically
$stmt->bind_param($types, ...$update_params);

if (!$stmt->execute()) die("Update failed: " . $stmt->error);
$stmt->close();

            } else {
                // ✅ INSERT new record
                $insert_sql = "INSERT INTO learners_grade 
                        (school_id, grade_level, quarter, student_name, created_by, " . implode(", ", $db_columns) . ") 
                        VALUES (" . str_repeat("?, ", 12) . "?)";
                $stmt = $conn->prepare($insert_sql);
                if (!$stmt) die("Error preparing insert statement: " . $conn->error);

                $stmt->bind_param("issss" . str_repeat("i", 8), 
                    $school_id, $grade_level, $quarter, $learner_name, $school_email,
                    ...$scores
                );

                if (!$stmt->execute()) die("Insert failed: " . $stmt->error);
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
