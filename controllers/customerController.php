<?php




function saveCustomerData($conn, $datepicker, $registerNo, $name, $location, $address1, $address2, $address3, $loyaltyBarcode, $teleMobile, $teleLand, $nic, $dob, $age, $occupation, $area, $familyDetails, $notes){

    $sql = "INSERT INTO customer (datepicker, name, location, addressOne, addressTwo, addressThree, loyaltyBarcode, teleMobile, teleLand, nic, dob, age, accupation, area, familyDetails, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_stmt_init($conn);
  
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }
    
    // Corrected data types for mysqli_stmt_bind_param
    mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $datepicker, $name, $location, $address1, $address2, $address3, $loyaltyBarcode, $teleMobile, $teleLand, $nic, $dob, $age, $occupation, $area, $familyDetails, $notes);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return true;
}


function searchCustomersByKeyword($conn, $keyWord){
    $sql = "SELECT * FROM customer WHERE registerNo = ? OR nic = ? OR name LIKE ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

    $searchParam = "%$keyWord%";
    mysqli_stmt_bind_param($stmt, "sss", $keyWord, $keyWord, $searchParam);
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

function updateCustomerData($conn, $datepicker, $registerNo, $name, $location, $address1, $address2, $address3, $loyaltyBarcode, $teleMobile, $teleLand, $nic, $dob, $age, $occupation, $area, $familyDetails, $notes){
    $sql = "UPDATE customer SET datepicker=?, name=?, location=?, addressOne=?, addressTwo=?, addressThree=?, loyaltyBarcode=?, teleMobile=?, teleLand=?, nic=?, dob=?, age=?, accupation=?, area=?, familyDetails=?, notes=? WHERE registerNo=?;";

    $stmt = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../views/index.php?error=stmtError");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "sssssssssssssssss", $datepicker, $name, $location, $address1, $address2, $address3, $loyaltyBarcode, $teleMobile, $teleLand, $nic, $dob, $age, $occupation, $area, $familyDetails, $notes, $registerNo);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        return true; 
}

function deleteCustomerData($conn, $id){
    $sql = "DELETE FROM customer WHERE registerNo = ?;";
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


function searchCustomerbyRegNumber($conn, $regNo){
    $sql = "SELECT * FROM customer WHERE registerNo = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../views/index.php?error=stmtError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $regNo);
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


function getLastCustomerId(){
    require_once "db.php";
    $sql = "SELECT `registerNo` FROM `customer` ORDER BY `registerNo` DESC LIMIT 1";
    
    $result = mysqli_query($conn, $sql);

    if (!$result) {
       // Handle error
       echo "Error: " . mysqli_error($conn);
       return false;
   }

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        return $row['registerNo'];
   } else {
        return null;
   }
}