<?php
require_once('../includes/database_connection.php'); 
session_start();

$school_email = $_SESSION['email'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        $rowNumber = 0;
        $learners = [];

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNumber++;

            if ($rowNumber == 2) { 
                $school_id = trim($data[4]); // Extract School ID
            } elseif ($rowNumber == 3) { 
                $grade_level = trim($data[4]); // Extract Grade Level
            } elseif ($rowNumber == 4) { 
                $quarter = preg_replace("/[^0-9]/", "", trim($data[4])); // Extract Term
            } elseif ($rowNumber >= 8) { // Extract learners' data from row 8 onwards
                if (!empty(trim($data[3]))) { // Ensure student name is not empty
                    $learners[] = [
                        'learner_name' => trim($data[3]),
                        'age' => trim($data[4]),
                        'sex' => trim($data[5]),
                        'attendance' => trim($data[6]),
                        'extra_curricular' => trim($data[7]),
                        'economic_status' => trim($data[8]),
                        'settlement' => trim($data[9]),
                        'mental_health' => trim($data[10]),
                        'feeding_program' => trim($data[11]),
                        'status' => trim($data[12])
                    ];
                }
            }
        }
        fclose($handle);

        if (!in_array((string)($quarter ?? ''), ['1', '2', '3'], true)) {
            die(json_encode(['status' => 'error', 'message' => 'Term must be 1, 2, or 3.']));
        }

        if (empty($learners)) {
            die(json_encode(["status" => "error", "message" => "No learner data found in CSV."]));
        }

        // Debug: Check extracted data
        echo "<pre>";
        print_r([
            "school_id" => $school_id,
            "grade_level" => $grade_level,
            "quarter" => $quarter,
            "learners" => $learners
        ]);
        echo "</pre>";

        // Prepare SELECT statement to check if student exists
        $checkStmt = $conn->prepare("SELECT id FROM students WHERE school_id = ? AND student_name = ?");

        // Prepare INSERT statement for new students
        $insertStmt = $conn->prepare("INSERT INTO students (school_id, grade_level, quarter, student_name, age, sex, quarterly_attendance, extra_curricular, economic_status, settlement, physical_mental_status, feeding_prog_receipt, status, created_by) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Prepare UPDATE statement for existing students
        $updateStmt = $conn->prepare("UPDATE students 
                                      SET grade_level = ?, quarter = ?, age = ?, sex = ?, quarterly_attendance = ?, extra_curricular = ?, economic_status = ?, settlement = ?, physical_mental_status = ?, feeding_prog_receipt = ?, status = ? 
                                      WHERE school_id = ? AND student_name = ?");

        foreach ($learners as $learner) {
            $checkStmt->bind_param("is", $school_id, $learner['learner_name']);
            $checkStmt->execute();
            $checkStmt->store_result();

            if($learner['status'] != 'Active' &&  $learner['status'] != 'Inactive'){
                $learner['status'] = 'Active';
            }
            if ($checkStmt->num_rows > 0) {
                // Student exists → Update
                $updateStmt->bind_param("sssssssssssis", 
                    $grade_level, 
                    $quarter, 
                    $learner['age'], 
                    $learner['sex'], 
                    $learner['attendance'], 
                    $learner['extra_curricular'], 
                    $learner['economic_status'], 
                    $learner['settlement'], 
                    $learner['mental_health'], 
                    $learner['feeding_program'], 
                    $learner['status'], 
                    $school_id, 
                    $learner['learner_name']
                );

                if (!$updateStmt->execute()) {
                    die(json_encode(["status" => "error", "message" => "SQL update failed: " . $updateStmt->error]));
                }
            } else {
                // Student does not exist → Insert
                $insertStmt->bind_param("isssssssssssss", 
                    $school_id, 
                    $grade_level, 
                    $quarter, 
                    $learner['learner_name'], 
                    $learner['age'], 
                    $learner['sex'], 
                    $learner['attendance'], 
                    $learner['extra_curricular'], 
                    $learner['economic_status'], 
                    $learner['settlement'], 
                    $learner['mental_health'], 
                    $learner['feeding_program'], 
                    $learner['status'],
                    $school_email
                );

                if (!$insertStmt->execute()) {
                    die(json_encode(["status" => "error", "message" => "SQL insert failed: " . $insertStmt->error]));
                }
            }
        }

        $checkStmt->close();
        $insertStmt->close();
        $updateStmt->close();
        $conn->close();

        echo json_encode(["status" => "success", "message" => "CSV file processed successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Unable to open file."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
