<?php


function saveClaim($conn, $date, $nameOne, $nameTwo, $idNo, $contact, $address, $itemOne, $itemTwo, $itemThree, $descOne, $descTwo, $descThree, $qtyOne, $qtyTwo, $qtyThree, $amountOne, $amountTwo, $amountThree, $note, $gross, $discount, $net) {
    // Prepare the SQL statement
    $sql = "INSERT INTO `claiminvoice` 
            (`date`, `nameOne`, `nameTwo`, `idNo`, `contact`, `address`, `itemOne`, `itemTwo`, `itemThree`, 
            `descOne`, `descTwo`, `descThree`, `qtyOne`, `qtyTwo`, `qtyThree`, `amountOne`, `amountTwo`, `amountThree`, 
            `note`, `gross`, `discount`, `netAmount`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssssssssssiiiiiiisddd", 
        $date, $nameOne, $nameTwo, $idNo, $contact, $address, $itemOne, $itemTwo, $itemThree, 
        $descOne, $descTwo, $descThree, $qtyOne, $qtyTwo, $qtyThree, $amountOne, $amountTwo, $amountThree, 
        $note, $gross, $discount, $net
    );

    $success = $stmt->execute();

    // Close the statement
    $stmt->close();

    // If the insertion was successful, fetch the last inserted ID
    if ($success) {
        $lastId = $conn->insert_id;

        // Fetch the newly inserted row from the database
        $sql = "SELECT * FROM `claiminvoice` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $lastId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Close the statement
        $stmt->close();

        // Return the fetched row
        return $row;
    } else {
        return false; // Return false if the insertion failed
    }
}

function getlastInvoice($conn){
    $sql = "SELECT `id` FROM `claiminvoice` ORDER BY `id` DESC LIMIT 1";
    
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