<?php

// Function to save adjusted data to the database
function saveAdjustedData($conn, $adjustedData) {
    // Check if adjusted data is provided
    if (!empty($adjustedData)) {
        // Prepare the SQL statement
        $sql = "INSERT INTO `ajustment`(`itemCode`, `reason`, `ajusted`, `note`) VALUES (?, ?, ?, ?)";

        // Prepare and bind the statement
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssis", $itemCode, $reason, $adjusted, $note);

        // Iterate through each adjusted data record
        foreach ($adjustedData as $data) {
            // Extract data for each record
            $itemCode = $data['itemCode'];
            $reason = $data['reason'];
            $adjusted = $data['adjusted'];
            $note = $data['remark'];

            // Execute the statement
            if (!mysqli_stmt_execute($stmt)) {
                // If execution fails, return false
                return false;
            }
        }

        // Close the statement
        mysqli_stmt_close($stmt);

        // Return true if all records are successfully inserted
        return true;
    }

    // Return false if adjusted data is empty
    return false;
}

function  getLatId($conn){
    $sql = "SELECT `id` FROM `ajustment` ORDER BY `id` DESC LIMIT 1";
    
         $result = mysqli_query($conn, $sql);
    
         if (!$result) {
            // Handle error
            echo "Error: " . mysqli_error($conn);
            return false;
        }
    
         $row = mysqli_fetch_assoc($result);
    
         if ($row) {
             return $row['id'];
        } else {
             return null;
        }
}

