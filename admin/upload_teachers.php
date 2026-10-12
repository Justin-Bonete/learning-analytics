<?php
require_once('../includes/database_connection.php'); 
session_start();

$school_email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        $rowNumber = 0;
        $teachers = [];

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNumber++;

            // Extract School ID from row 2, column 2
            if ($rowNumber == 2) { 
                $school_id = trim($data[2]); 
            }

            // Extract teacher data from row 8 onwards
            if ($rowNumber >= 8) { 
                if (!empty($data[1])) { // Ensure we have a teacher name
                    $teachers[] = [
                        'teacher_name'   => trim($data[1]),
                        'sex'            => trim($data[2]),
                        'years_exp'      => trim($data[3]),
                        'position'       => trim($data[4]),
                        'grade_level'    => trim($data[5]),
                        'major'          => trim($data[6]),
                        'education'      => trim($data[7]),
                        'no_of_trainings'=> trim($data[8]),
                        'email'          => trim($data[9]) // ✅ Added email field
                    ];
                }
            }
        }
        fclose($handle);

        if (empty($teachers)) {
            die(json_encode(["status" => "error", "message" => "No teacher data found in CSV."]));
        }

        // Prepare SQL statements
        $checkStmt = $conn->prepare("SELECT id FROM teachers_profiling WHERE email = ?");
        $updateStmt = $conn->prepare("UPDATE teachers_profiling SET teacher_name = ?, sex = ?, years_exp = ?, position = ?, grade_level = ?, major = ?, education = ?, no_of_trainings = ? WHERE email = ?");
        $insertStmt = $conn->prepare("INSERT INTO teachers_profiling (school_id, teacher_name, sex, years_exp, position, grade_level, major, education, no_of_trainings, email, password, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$checkStmt || !$updateStmt || !$insertStmt) {
            die(json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]));
        }

        foreach ($teachers as $teacher) {
            $checkStmt->bind_param("s", $teacher['email']);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                // Teacher exists, update record
                $updateStmt->bind_param("sisssssss", 
                    $teacher['teacher_name'], 
                    $teacher['sex'], 
                    $teacher['years_exp'], 
                    $teacher['position'], 
                    $teacher['grade_level'], 
                    $teacher['major'], 
                    $teacher['education'], 
                    $teacher['no_of_trainings'], 
                    $teacher['email']
                );
                $updateStmt->execute();
            } else {
                // Teacher does not exist, insert new record with default password (MD5 hashed "1234")
                $defaultPassword = md5("1234"); // ✅ Hash default password

                $insertStmt->bind_param("isssssssssss", 
                    $school_id, 
                    $teacher['teacher_name'], 
                    $teacher['sex'], 
                    $teacher['years_exp'], 
                    $teacher['position'], 
                    $teacher['grade_level'], 
                    $teacher['major'], 
                    $teacher['education'], 
                    $teacher['no_of_trainings'], 
                    $teacher['email'], 
                    $defaultPassword, // ✅ Save hashed password
                    $school_email
                );
                $insertStmt->execute();
            }
        }

        // Close statements and connection
        $checkStmt->close();
        $updateStmt->close();
        $insertStmt->close();
        $conn->close();

        echo json_encode(["status" => "success", "message" => "CSV file uploaded and processed successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Unable to open file."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
