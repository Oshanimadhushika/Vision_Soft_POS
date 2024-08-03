<?php

function saveDeduction($conn, $date, $deduction, $description, $amount){
    $sql = "INSERT INTO deduction (date, deduction, descr, amount) VALUES (?, ?, ?, ?)";
    
            $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
    
            mysqli_stmt_bind_param($stmt, "ssss", $date, $deduction, $description, $amount);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    
           return true;
}

function getLastId($conn){
    $sql = "SELECT `id` FROM `deduction` ORDER BY `id` DESC LIMIT 1";
    
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