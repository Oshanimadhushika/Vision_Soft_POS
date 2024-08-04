<?php 

require_once "db.php";

function saveBranchData($conn, $id, $name){
    $sql = "INSERT INTO branch (code, name) VALUES (?, ?)";
    
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

function getAllBranche($conn){
    $sql = "SELECT * FROM branch;";
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


function getUserByUserName($conn, $userName){
    // Prepare and bind the query
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $userName);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the user data
    $user = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    return $user;
}


// New function to get users by branch ID
function getUsersByBranch($conn, $branchId) {
    $sql = "SELECT username FROM user WHERE branch_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $branchId);
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);
    $usernames = mysqli_fetch_all($resultData, MYSQLI_ASSOC);   
    mysqli_stmt_close($stmt);

    return array_map(function($user) {
        return $user['username'];
    }, $usernames);
}
