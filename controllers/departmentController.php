<?php

require_once "db.php";

function searchDepartmentbyCode($conn, $searchWord){
    $sql = "SELECT * FROM department WHERE id = ? OR name LIKE ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

    $searchParam = "%$searchWord%";
    mysqli_stmt_bind_param($stmt, "ss", $searchWord, $searchParam);
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


function saveDepartmentData($conn, $id, $name){
    $sql = "INSERT INTO department (id, name) VALUES (?, ?)";
    
            $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
    
            mysqli_stmt_bind_param($stmt, "ss", $id, $name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    
           return true;
}


function updateDepartmentData($conn, $id, $name){
    $sql = "UPDATE department SET name=? WHERE id=?;";

    $stmt = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../views/index.php?error=stmtError");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "ss", $name, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        return true;
}


function deleteDepartmentDeta($conn, $id){
    $sql = "DELETE FROM department WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return true;
}


function getAllDepartment($conn){
    $sql = "SELECT * FROM department;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

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
