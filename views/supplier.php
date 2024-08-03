<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save'])) {
                saveSupplier();    
            } elseif (isset($_POST['update'])) {
                updateSupplier();
            } elseif (isset($_POST['delete'])) {
                deleteSupplier();
            }elseif(isset($_POST['search'])){
                $searchWord = $_POST["word"];
                searchSupplier($searchWord);
            }
        }


        function searchSupplier($searchKeyword){
            if(empty($searchKeyword)){
                echo '<script>alert("KeyWord should not be Empty..!")</script>'; 
            }else{
                require_once '../controllers/db.php';
                require_once '../controllers/supplierController.php';

                $result = searchByCode($conn, $searchKeyword);

                if ($result === 'emptyResult') {
                    echo '<script>alert("No results found..!")</script>';
                } else {
                    $finalResult;
                    foreach($result as $supplier){
                        $finalResult = $supplier;
                    }
                   
                    echo '<script>';
                    echo 'document.addEventListener("DOMContentLoaded", function() {';
                     echo '    document.getElementById("name").value = "' . $finalResult['name'] . '";';
                     echo '    document.getElementById("address").value = "' . $finalResult['address'] . '";';
                     echo '    document.getElementById("code").value = "' . $finalResult['code'] . '";';
                     echo '    document.getElementById("date").value = "' . $finalResult['date'] . '";';
                     echo '    document.getElementById("teleMobile").value = "' . $finalResult['mobile'] . '";';
                     echo '    document.getElementById("teleLand").value = "' . $finalResult['landPhone'] . '";';
                     echo '    document.getElementById("email").value = "' . $finalResult['email'] . '";';
                     echo '    document.getElementById("accNum").value = "' . $finalResult['bankAccount'] . '";';
                     echo '    document.getElementById("refName").value = "' . $finalResult['refName'] . '";';
                     echo '    document.getElementById("refMobile").value = "' . $finalResult['refNo'] . '";';
                    echo '});';
                    echo '</script>';
            
                }

            }

        } 


        function saveSupplier(){
            $date = $_POST["date"];
            $code = $_POST["code"];
            $name = $_POST["name"];
            $address = $_POST["address"];
            $teleMobile = $_POST["teleMobile"];
            $teleLand = $_POST["teleLand"];
            $email = $_POST["email"];
            $accNum = $_POST["accNum"];
            $refName = $_POST["refName"];
            $refMobile = $_POST["refMobile"];

            $errors = array();

            require_once '../controllers/db.php';
            require_once '../controllers/supplierController.php';

            if (empty($date) || empty($code) || empty($name) || empty($address) || empty($teleMobile || empty($teleLand) || empty($email) || empty($accNum) || empty($refName) || empty($refMobile))) {
                array_push($errors, "All fields are required");
            }
            
           $saved = saveSupplierDetails($conn, $code, $date, $name, $address, $teleMobile, $teleLand, $email, $accNum, $refName, $refMobile);

           if($saved){
            echo '<script>alert("Saved Successfully..!")</script>'; 
           }else{
            echo '<script>alert("Something went wrong..!")</script>'; 
           }

        }


        function updateSupplier(){
            $date = $_POST["date"];
            $code = $_POST["code"];
            $name = $_POST["name"];
            $address = $_POST["address"];
            $teleMobile = $_POST["teleMobile"];
            $teleLand = $_POST["teleLand"];
            $email = $_POST["email"];
            $accNum = $_POST["accNum"];
            $refName = $_POST["refName"];
            $refMobile = $_POST["refMobile"];

            $errors = array();

            require_once '../controllers/db.php';
            require_once '../controllers/supplierController.php';

            if (empty($date) || empty($code) || empty($name) || empty($address) || empty($teleMobile || empty($teleLand) || empty($email) || empty($accNum) || empty($refName) || empty($refMobile))) {
                array_push($errors, "All fields are required");
            }

            $updated = updateSupplierDetails($conn, $code, $date, $name, $address, $teleMobile, $teleLand, $email, $accNum, $refName, $refMobile);

            if($updated){
                echo '<script>alert("Updated Successfully..!")</script>'; 
               }else{
                echo '<script>alert("Something went wrong..!")</script>'; 
               }
        }


        function deleteSupplier(){
            $code = $_POST["code"];

            $errors = array();

            require_once '../controllers/db.php';
            require_once '../controllers/supplierController.php';

            if(empty($code)){
                echo '<script>alert("Code should not be Empty..!")</script>'; 
            }

            $deleted = deleteSupplierDetails($conn, $code);

            if($deleted){
                echo '<script>alert("Deleted Successfully..!")</script>'; 
               }else{
                echo '<script>alert("Something went wrong..!")</script>'; 
               }

        }

        ?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Master</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>



<body class="p-4 overflow-y-hidden">
    <div class="container mx-auto bg-white p-3 shadow-xl">

      

        <div class="row mb-2">
            <div class="col-md-6">
                <h3>Supplier <span class="text-warning">Master</span></h3>
            </div>
            <div class="col-md-6">
            <form id="searchSupplierForm" action="supplier.php" method="post">
                <div class="flex items-center">
                    <input type="text" class="form-control rounded-full shadow-xl p-2" id="word" name="word"
                        placeholder="Search...">
                    <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700"type="submit" name="search">
                        <i class="fa-solid fa-notes-medical"></i>
                    </button>
                </div>
                </form>
            </div>
        </div>

        <form id="supplierMasterForm" action="supplier.php" method="post">
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="date" class="form-label text-sm font-bold">Date:</label>
                        <input type="date" class="form-control h-7" id="date" name="date" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="code" class="form-label text-sm font-bold">Code:</label>
                        <input type="text" class="form-control h-7" id="code" name="code" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="name" class="form-label text-sm font-bold">Name:</label>
                        <input type="text" class="form-control h-7" id="name" name="name" required>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-9">
                    <div class="mb-2"> 
                        <label for="address" class="form-label text-sm font-bold">Address:</label>
                        <input class="form-control h-7" id="address" name="address" required>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="teleMobile" class="form-label text-sm font-bold">Telephone (Mobile):</label>
                        <input type="tel" class="form-control h-7" id="teleMobile" name="teleMobile" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="teleLand" class="form-label text-sm font-bold">Telephone (Land):</label>
                        <input type="tel" class="form-control h-7" id="teleLand" name="teleLand" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="email" class="form-label text-sm font-bold">Email:</label>
                        <input type="email" class="form-control h-7" id="email" name="email" required>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="accNum" class="form-label text-sm font-bold">Bank Account No:</label>
                        <input type="text" class="form-control h-7" id="accNum" name="accNum" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-1">
                        <label for="refName" class="form-label text-sm font-bold">Ref Name:</label>
                        <input type="text" class="form-control h-7" id="refName" name="refName" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-1">
                        <label for="refMobile" class="form-label text-sm font-bold">Ref Phone No:</label>
                        <input type="text" class="form-control h-7" id="refMobile" name="refMobile" required>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                <div class="mb-3 d-flex justify-content-end gap-1">
                        <label for="submit" class="form-label"></label>
                        <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-28" name="submit">Submit</button>
                        <button type="submit" class="bg-yellow-500 text-white p-2 font-semibold w-28" onclick="clearForm()">Clear</button>
                        <button type="submit" class="bg-green-600 text-white p-2 font-semibold w-28" name="submit">Update</button>
                        <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-28" name="submit">Delete</button>
                        <button type="submit" class="bg-black text-white p-2 font-semibold w-28" onclick="exit()"
                            name="submit">Exit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function clearForm() {
            document.getElementById("supplierMasterForm").reset();
        }
        function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>
