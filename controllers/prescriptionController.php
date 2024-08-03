<?php

function saveAssessment($conn, $date, $jobNo, $rightVA, $rightPH, $rightHM, $rightIO, $rightsub, $leftVA, $leftPH, $leftHM, $leftIOL, $leftsub, $note) {
    
    //echo '<script>alert("way..!..!")</script>';
    $sql = "INSERT INTO `assessment`(`rightVa`, `rightPh`, `rightHm`, `rightIol`, `rightSub`, `leftVa`, `leftPh`, `leftHm`, `leftIol`, `leftSub`, `note`, `jobNo`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssssssssss", $rightVA, $rightPH, $rightHM, $rightIO, $rightsub, $leftVA, $leftPH, $leftHM, $leftIOL, $leftsub, $note, $jobNo);

    // Execute the statement
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Insertion successful
        return true;
    } else {
        // Insertion failed
        return false;
    }

    // Close the statement
    $stmt->close();

    return true;
}


function savePrescription($conn, $jobNo, $rightDista, $rightAdd, $prescriptionRightVA, $NPD, $rightMPD, $rightCyl, $rightAxis, $leftDista, $leftAdd, $prescriptionLeftVa, $leftDpd, $leftMpd, $leftCyl, $leftAxis, $prescriptionSh, $tested, $nextvisit, $dueDate) {
    // Prepare the SQL statement with placeholders for data binding
    $sql = "INSERT INTO `prescription`(`rightDista`, `rightAdd`, `rightVa`, `rightNPd`, `rightMPd`, `rightCyl`, `rightAxis`, `leftDista`, `leftAdd`, `leftVa`, `leftDdp`, `leftMdp`, `leftCyl`, `leftAxis`, `sh`, `testedBy`, `nextVisit`, `dueDate`, `jobNo`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if the statement preparation was successful
    if ($stmt === false) {
        // Handle the error (e.g., log the error message)
        echo "Error: " . $conn->error;
        return false; // or handle the error in another way
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("sssssssssssssssssss", $rightDista, $rightAdd, $prescriptionRightVA, $NPD, $rightMPD, $rightCyl, $rightAxis, $leftDista, $leftAdd, $prescriptionLeftVa, $leftDpd, $leftMpd, $leftCyl, $leftAxis, $prescriptionSh, $tested, $nextvisit, $dueDate, $jobNo);


    // Execute the statement
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Insertion successful
        return true;
    } else {
        // Insertion failed
        return false;
    }

    // Close the statement
    $stmt->close();
}


function createJobNumber($conn, $date, $cusRegNo, $officer) {
    $sql = "INSERT INTO job (cusRegNumber, date, officer, status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $cusRegNo, $date, $officer, "start"); // Corrected the parameter order

    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $insertId = $conn->insert_id;
    } else {
        echo "Error: " . $stmt->error;
        $insertId = null; // Handle error condition
    }

    mysqli_stmt_close($stmt); // Moved this line here

    return $insertId;
}




function getCustomerJobHistory($conn, $regNo){
    $jobHistory = array();

    $sql = "SELECT * FROM job WHERE cusRegNumber = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $regNo);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $jobHistory[] = $row;
        }
    }

    $stmt->close();

    return $jobHistory;
}



function getLastJobNumber($conn){
    $result = $conn->query("SELECT MAX(id) AS last_id FROM job");
    if ($result) {
        $row = $result->fetch_assoc();
    
        $lastId = $row['last_id'];
    
        if ($lastId === null) {
            $lastId = 0;
        }
    
        $result->close();
    
       // $conn->close();
    
        return $lastId;
    } else {
        echo "Error: " . $conn->error;
    
        $conn->close();
    
        return null;
    }
}

function getSelectedAssesment($conn, $selectedJob) {
    $sql = "SELECT * FROM assessment WHERE jobNo = ?";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("s", $selectedJob);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $assessments = array();
    
    while ($row = $result->fetch_assoc()) {
    $assessments[] = $row;
    }
    
    $stmt->close();
    
    return $assessments;
}


function getSelectedPrescription($conn, $selectedJob) {
    $sql = "SELECT * FROM prescription WHERE jobNo = ?";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("s", $selectedJob);
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $prescriptions = array();
    
    while ($row = $result->fetch_assoc()) {
        $prescriptions[] = $row;
    }
    
    $stmt->close();
    
    return $prescriptions;
}



function searchJob($conn, $searchJobNo) {
    // SQL query to search for a job by its ID
    $sql = "SELECT `id`, `cusRegNumber`, `date`, `officer`, `status`, `note` FROM `job` WHERE `id` = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check for statement preparation failure
    if (!$stmt) {
        // Handle the error (e.g., log the error message)
        echo "Error preparing SQL statement: " . $conn->error;
        return false; // or handle the error in another way
    }

    // Bind the job ID parameter
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
        // Fetch the row
        $row = $result->fetch_assoc();
        // Close the statement
        $stmt->close();
        // Return the job details
        return $row;
    } else {
        // No job found with the given ID
        echo "No job found with ID: $searchJobNo";
        // Close the statement
        $stmt->close();
        return false;
    }
}


function searchPaymentByJob($conn, $searchJobNo) {
    // SQL query to search for payment details by job number
    $sql = "SELECT `id`, `date`, `type`, `amount`, `jobNumber` FROM `payment` WHERE `jobNumber` = ?";

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
        $payments = $result->fetch_all(MYSQLI_ASSOC);
        // Close the statement
        $stmt->close();
        // Return the payments
        return $payments;
    } else {
        // No payments found for the given job number
        echo "No payments found for job number: $searchJobNo";
        // Close the statement
        $stmt->close();
        return false;
    }
}


function updateJobStatus($conn, $id, $note, $status){
    // Prepare the SQL statement
    $sql = "UPDATE `job` SET `note` = ?, `status` = ? WHERE `id` = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssi", $note, $status, $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Success
        $stmt->close();
        return true;
    } else {
        // Error
        $stmt->close();
        return false;
    }
}

function updateOnlyJobStatus($conn, $id, $status){
    $sql = "UPDATE `job` SET `status` = ? WHERE `id` = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ss", $status, $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Success
        $stmt->close();
        return true;
    } else {
        // Error
        $stmt->close();
        return false;
    }
}

