<?php 

require_once "db.php";

function searchCategoryByCode($conn, $searchWord){
    $sql = "SELECT * FROM category WHERE id = ? OR name LIKE ?";
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

function saveCategoryData($conn, $id, $name){
    $sql = "INSERT INTO category (id, name) VALUES (?, ?)";
    
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

function updateCategoryData($conn, $id, $name){
    $sql = "UPDATE category SET name=? WHERE id=?;";

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

function deleteCategoryData($conn, $id){
    $sql = "DELETE FROM category WHERE id = ?;";
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

function getAllCategory($conn){
    $sql = "SELECT * FROM category;";
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