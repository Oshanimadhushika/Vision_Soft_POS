<?php


function saveInvoiceDetails($conn, $jobNumber, $itemData, $paymentData) {
    $sql = "INSERT INTO `invoice` (`jobNumber`, `itemCode`, `description`, `unitPrice`, `qty`, `discount`, `amount`) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

    $reduceItem = array();
    foreach ($itemData as $rowData) {
        
        $reduceItem[] = array(
            'itemCode' => $rowData['code'],
            'qty' => $rowData['qty']
        );
        
         mysqli_stmt_bind_param($stmt, "sssdidd", $jobNumber, $rowData['code'], $rowData['desc'], $rowData['price'], $rowData['qty'], $rowData['disc'], $rowData['amount']);

         if (!mysqli_stmt_execute($stmt)) {
            echo "Error executing SQL statement: " . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return false;
        }
    }
    mysqli_stmt_close($stmt);

    $updated = updateItemQty($conn, $reduceItem);


    if($updated){
       $saved = savePaymentRecord($conn, $jobNumber, $paymentData);

       if($saved){
        return true;
       }
    }else{
        return false;
    }

}


function updateItemQty($conn, $reduceItem) {
   
    foreach ($reduceItem as $item) {
        // Extract item code and quantity
        $itemCode = $item['itemCode'];
        $qtyToReduce = $item['qty'];

        // Prepare SQL UPDATE query to decrement the quantity
        $sql = "UPDATE `item` SET `maxStockQty` = `maxStockQty` - ? WHERE `code` = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("is", $qtyToReduce, $itemCode);

       
        if (!$stmt->execute()) {
            
            echo "Error reducing item quantity for item code $itemCode: " . $stmt->error;
            return false; 
        }
       
        $stmt->close();
    }

    return true; 
}



function savePaymentRecord($conn, $jobNumber, $paymentData) {
    // SQL query to insert payment record
    $sql = "INSERT INTO `payment` (`date`, `type`, `amount`, `jobNumber`) VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check for statement preparation failure
    if (!$stmt) {
        // Handle the error (e.g., log the error message)
        echo "Error preparing SQL statement: " . $conn->error;
        return false; // or handle the error in another way
    }

    // Iterate through $paymentData array
    foreach ($paymentData as $rowData) {
        $date = $rowData['date'];
        $type = $rowData['type'];
        $amount = $rowData['amount'];

        if($amount >0){
            $stmt->bind_param("ssdi", $date, $type, $amount, $jobNumber);
        }


        // Execute the statement
        if (!$stmt->execute()) {
            // Handle the error (e.g., log the error message)
            echo "Error executing SQL statement: " . $stmt->error;
            return false; // or handle the error in another way
        }
    }

    // Close the statement
    $stmt->close();
    return true; // Return true if all payment records were saved successfully
}


function searchInvoiceByJob($conn, $searchJobNo) {
    // SQL query to search for invoices by job number
    $sql = "SELECT `id`, `itemCode`, `description`, `unitPrice`, `qty`, `discount`, `amount` FROM `invoice` WHERE `jobNumber` = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check for statement preparation failure
    if (!$stmt) {
        // Handle the error (e.g., log the error message)
        echo "Error preparing SQL statement: " . $conn->error;
        return false; // or handle the error in another way
    }

    // Bind the job number parameter
    $stmt->bind_param("i", $searchJobNo);

    // Execute the statement
    if (!$stmt->execute()) {
        // Handle the error (e.g., log the error message)
        echo "Error executing SQL statement: " . $stmt->error;
        return false; // or handle the error in another way
    }

    // Get the result set
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch all rows
        $invoices = $result->fetch_all(MYSQLI_ASSOC);
        // Close the statement
        $stmt->close();
        // Return the invoices
        return $invoices;
    } else {
        // No invoices found for the given job number
        echo "No invoices found for job number: $searchJobNo";
        // Close the statement
        $stmt->close();
        return false;
    }
}
