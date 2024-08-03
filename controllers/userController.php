<?php 

require_once "db.php";

function saveUserData($conn, $userName, $branch, $password){
    $sql = "INSERT INTO user (username, branch, password) VALUES (?, ?, ?)";
    
            $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
    
            mysqli_stmt_bind_param($stmt, "sss", $userName, $branch, $password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    
           return true;
}