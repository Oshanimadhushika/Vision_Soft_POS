<?php

require_once "db.php";

function filterSupplier($conn, $keyword){
    $sql = "SELECT * FROM supplier WHERE code = ? OR name LIKE ? OR refName LIKE ?;";
        $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }

            $searchParam = "%$keyword%";
            mysqli_stmt_bind_param($stmt, "sss", $keyword, $searchParam, $searchParam);
            
            mysqli_stmt_execute($stmt);
            
            $resultData = mysqli_stmt_get_result($stmt);
            
            $searchResults = mysqli_fetch_all($resultData, MYSQLI_ASSOC);   
            
            mysqli_stmt_close($stmt);
        
            if(empty($searchResults)){
                return 'emptyResult';
            } else {
                return $searchResults;
            }
}


function getLastGrnNo($conn){
    $sql = "SELECT `id` FROM `goodrecieddetail` ORDER BY `id` DESC LIMIT 1";
    
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


