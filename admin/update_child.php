<?php
    // Include the database connection
    include_once "../config.php";

    // Check if the form has been submitted with child data
    if (isset($_POST['child_id'])) {
        $child_id = $_POST['child_id'];
        $name = $_POST['name'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $medical_history = $_POST['medical_history'];
        $special_needs = $_POST['special_needs'];

        // Prepare the SQL query to update the child's data
        $sql = "UPDATE child SET 
                name = :name, 
                date_of_birth = :date_of_birth, 
                gender = :gender, 
                medical_history = :medical_history, 
                special_needs = :special_needs 
                WHERE child_id = :child_id";

        try {
            // Prepare the SQL statement and bind the parameters
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':medical_history', $medical_history, PDO::PARAM_STR);
            $stmt->bindParam(':special_needs', $special_needs, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect back to dashboard with success
                header("Location: ../admin_children.php?child=updated");
                exit();
            } else {
                // Redirect with error message
                header("Location: ../admin_children.php?child=error");
                exit();
            }
        } catch (PDOException $e) {
            // Handle database connection errors
            echo 'Error: ' . $e->getMessage();
            header("Location: ../admin_children.php?child=error");
            exit();
        }
    } else {
        echo "No data received!";
    }
?>
