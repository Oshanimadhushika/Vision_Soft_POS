<?php 

    require_once "db.php";

    function saveSupplierDetails($conn, $code, $date, $name, $address, $teleMobile, $teleLand, $email, $accNum, $refName, $refMobile){
        $isExists = checkCodeExists($conn, $code);
    
        if($isExists === false){
    
            $sql = "INSERT INTO supplier (code, date, name, address, mobile, landPhone, email, bankAccount ,refName, refNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
            $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
    
            mysqli_stmt_bind_param($stmt, "ssssssssss", $code, $date, $name, $address, $teleMobile, $teleLand, $email, $accNum, $refName, $refMobile);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    
           return true;
        }else{
            return false;
        }
    
    }
    
    
    function updateSupplierDetails($conn, $code, $date, $name, $address, $teleMobile, $teleLand, $email, $accNum, $refName, $refMobile){
        $sql = "UPDATE supplier SET date = ?, name = ?, address = ?, mobile = ?, landPhone = ?, email = ?, bankAccount = ?, refName = ?, refNo = ? WHERE code = ?";

        $stmt = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../views/index.php?error=stmtError");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "ssssssssss", $date, $name, $address, $teleMobile, $teleLand, $email, $accNum, $refName, $refMobile, $code);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        return true;
    }


    function deleteSupplierDetails($conn, $code){
        $check = checkCodeExists($conn, $code);

        if($check){
            $deleted = deleteSupplierData($conn, $code);
            if($deleted){
                return true;
            }else{
                return false;
            }
        }else{
            header("Location: ../views/index.php?error=NotFound"); 
        }
    }

    function deleteSupplierData($conn, $code){
        $sql = "DELETE FROM supplier WHERE code = ?;";
        $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $code);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return true;
    }

    function checkCodeExists($conn, $code){
        $sql = "SELECT * FROM supplier WHERE code = ?;";
        $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $code);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
    
            if(mysqli_fetch_assoc($resultData)){
                return true;
            }else{
                return false;
            }
            mysqli_stmt_close($stmt);
    }

    function searchByCode($conn, $word){
        $sql = "SELECT * FROM supplier WHERE code = ?;";
        $stmt = mysqli_stmt_init($conn);
    
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../views/index.php?error=stmtError");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $word);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $searchResults = mysqli_fetch_all($resultData, MYSQLI_ASSOC);   
            mysqli_stmt_close($stmt);

            if(empty($searchResults)){
                return 'emptyResult';
            }else{
                return $searchResults;
            }
    }

    function getAllSupplier($conn){
    $sql = "SELECT * FROM supplier;";
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


    

?>