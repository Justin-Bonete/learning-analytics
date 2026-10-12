<?php
require_once "../includes/database_connection.php";
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $district = $_SESSION["district"];
    $school_email = $_SESSION["email"];
    $dateInput = $_POST['gradeDate']; // Format from form: "YYYY-MM-DDTHH:MM"
    $timestamp = date('Y-m-d H:i:s', strtotime($dateInput));

    if (!empty($_FILES["csv_file"]["name"])) {
        $filename = $_FILES["csv_file"]["tmp_name"];

        if ($_FILES["csv_file"]["size"] > 0) {
            $file = fopen($filename, "r");
            if ($file === false) {
                throw new Exception("Failed to open the uploaded file");
            }

            $school_id = null;
            $grade_level = null;
            $quarter = null;

            // Read file line by line
            while (($row = fgetcsv($file)) !== false) {
                if (empty(array_filter($row))) {
                    continue;
                }

                if (isset($row[2])) {
                    if (stripos($row[1], "SCHOOL ID") !== false) {
                        $school_id = preg_replace("/[^0-9]/", "", $row[2]);
                    }
                    if (stripos($row[1], "GRADE LEVEL") !== false) {
                        $grade_level = preg_replace("/[^0-9]/", "", $row[2]);
                    }
                    if (stripos($row[1], "TERM") !== false || stripos($row[1], "QUARTER") !== false) {
                        $quarter = preg_replace("/[^0-9]/", "", $row[2]);
                    }
                }

                if ($school_id && $grade_level && $quarter) {
                    break;
                }
            }

            if (!$school_id || !$grade_level || !in_array((string)$quarter, ['1', '2', '3'], true)) {
                throw new Exception("Missing school ID, grade level, or valid term (1-3)");
            }

            // Locate "LEARNERS GRADES" section
            while (($row = fgetcsv($file)) !== false) {
                if (stripos(implode(" ", $row), "LEARNERS GRADES") !== false) {
                    break;
                }
            }

            fgetcsv($file); // Skip header row

            while (($row = fgetcsv($file)) !== false) {
                if (empty($row[1])) {
                    continue;
                }

                $learner_name = trim($row[1]);
                $scores = array_map(
                    function($val) {
                        $val = trim($val);
                        return is_numeric($val) ? intval($val) : 0;
                    },
                    array_slice($row, 2, 10)
                );

                $db_columns = range("a", chr(ord("a") + count($scores) - 1));
                $scores = array_slice($scores, 0, count($db_columns));

                // Check if record exists
                $current_year = date('Y', strtotime($dateInput));
                $check_sql = "SELECT id FROM learners_grade_shs 
                              WHERE school_id = ? AND grade_level = ? AND quarter = ? 
                              AND student_name = ? AND YEAR(created_at) = ?";
                $check_stmt = $conn->prepare($check_sql);
                if (!$check_stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $check_stmt->bind_param(
                    "iiiss",
                    $school_id,
                    $grade_level,
                    $quarter,
                    $learner_name,
                    $current_year
                );
                
                if (!$check_stmt->execute()) {
                    throw new Exception("Execute failed: " . $check_stmt->error);
                }
                
                $check_stmt->bind_result($existing_id);
                $record_exists = $check_stmt->fetch();
                $check_stmt->close();

                if ($record_exists) {
                    // Update existing record
                    $filtered_columns = [];
                    $filtered_scores = [];
                    foreach ($db_columns as $index => $column) {
                        if ($scores[$index] != 0) {
                            $filtered_columns[] = $column;
                            $filtered_scores[] = $scores[$index];
                        }
                    }

                    if (empty($filtered_columns)) {
                        continue;
                    }

                    $update_sql = "UPDATE learners_grade_shs SET created_by = ?, created_at = ?, ";
                    $update_sql .= implode(" = ?, ", $filtered_columns) . " = ? ";
                    $update_sql .= "WHERE id = ?";

                    $stmt = $conn->prepare($update_sql);
                    if (!$stmt) {
                        throw new Exception("Prepare failed: " . $conn->error);
                    }

                    $types = "ss" . str_repeat("i", count($filtered_scores)) . "i";
                    $params = array_merge([$school_email, $timestamp], $filtered_scores, [$existing_id]);

                    if (!$stmt->bind_param($types, ...$params)) {
                        throw new Exception("Bind param failed: " . $stmt->error);
                    }

                    if (!$stmt->execute()) {
                        throw new Exception("Execute failed: " . $stmt->error);
                    }
                    $stmt->close();
                } else {
                    // Insert new record
                    $insert_sql = "INSERT INTO learners_grade_shs 
                                  (school_id, district, grade_level, quarter, 
                                  student_name, created_by, created_at, " .
                                  implode(", ", $db_columns) . ") 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, " . 
                                  str_repeat("?, ", count($db_columns) - 1) . "?)";

                    $stmt = $conn->prepare($insert_sql);
                    if (!$stmt) {
                        throw new Exception("Prepare failed: " . $conn->error);
                    }

                    $types = "issssss" . str_repeat("i", count($db_columns));
                    $params = array_merge(
                        [$school_id, $district, $grade_level, $quarter, 
                         $learner_name, $school_email, $timestamp],
                        $scores
                    );

                    if (!$stmt->bind_param($types, ...$params)) {
                        throw new Exception("Bind param failed: " . $stmt->error);
                    }

                    if (!$stmt->execute()) {
                        throw new Exception("Execute failed: " . $stmt->error);
                    }
                    $stmt->close();
                }
            }

            fclose($file);
            echo json_encode(["success" => true, "message" => "CSV file processed successfully!"]);
        } else {
            throw new Exception("Error: File is empty");
        }
    } else {
        throw new Exception("No file uploaded");
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>