<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>customer register</title>

    <style>

    </style>
</head>

<body>
    <div class="container bg-white p-4  lg:w-full shadow-md">
        <?php

            // // require_once '../controllers/db.php';
            // require_once '../controllers/customerController.php';
            // $lastCustomerId = getLastCustomerId();
             $lastCustomerId = 12;

        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save'])) {
                saveCustomer();                
            }else if(isset($_POST['search'])){
                searchCustomer();
            }else if(isset($_POST['update'])){
                updateCustomer();
            }else if(isset($_POST['delete'])){
                deleteCustomer();
            }

        }
        

        function saveCustomer(){
            $datepicker = $_POST["datepicker"];
            $registerNo = $_POST["registerNo"];
            $name = $_POST["name"];
            $location = $_POST["location"];
            $address1 = $_POST["address1"];
            $address2 = $_POST["address2"];
            $address3 = $_POST["address3"];
            $loyaltyBarcode = $_POST["loyaltyBarcode"];
            $teleMobile = $_POST["teleMobile"];
            $teleLand = $_POST["teleLand"];
            $nic = $_POST["nic"];
            $dob = $_POST["dob"];
            $age = $_POST["age"];
            $occupation = $_POST["occupation"];
            $area = $_POST["area"];
            $familyDetails = $_POST["familyDetails"];
            $notes = $_POST["notes"];

            if(empty($datepicker) || empty($registerNo) || empty($name) || empty($location) || empty($address1) || empty($address2) || empty($address3) || empty($loyaltyBarcode) || empty($teleMobile) || empty($teleLand) || empty($nic) || empty($dob) || empty($age) || empty($occupation) || empty($area) || empty($familyDetails) || empty($notes)){
                echo '<script>alert("Input Should not be Empty..!")</script>';
            }else{
                
                require_once '../controllers/db.php';
                require_once '../controllers/customerController.php';

                $saved = saveCustomerData($conn, $datepicker, $registerNo, $name, $location, $address1, $address2, $address3, $loyaltyBarcode, $teleMobile, $teleLand, $nic, $dob, $age, $occupation, $area, $familyDetails, $notes);

                if($saved){
                    echo '<script>alert("Customer details Saved Successfully..!..!")</script>';
                }else{
                    echo '<script>alert("Something went wrong..!")</script>';
                }

            }
        }

        function searchCustomer(){
            $keyWord = $_POST['keyword'];

            if(empty($keyWord)){
                echo '<script>alert("Keyword should not be Empty..!")</script>';
            }else{
                require_once '../controllers/db.php';
                require_once '../controllers/customerController.php';

                $result = searchCustomersByKeyword($conn, $keyWord);

                if ($result === 'emptyResult') {
                    echo '<script>alert("No results found..!")</script>';
                } else {
                    // Display the result in a table
                    echo '<table class="table table-bordered custom-table" id="customerTable">';
                    echo '<tr><th>Register No</th><th>Name</th><th>Date</th><th>Bar Code</th><th>Address One</th><th>Address Two</th><th>Address Three</th><th>Nic</th><th>Mobile</th><th>Land Phone</th><th>Occupation</th><th>Area</th><th>DoB</th><th>Age</th><th>Detail</th><th>Note</th><th>Location</th></tr>';
                    foreach ($result as $row) {
                        echo '<tr onclick="getRowData(this)">';
                        echo '<td>' . $row['registerNo'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['datepicker'] . '</td>';
                        echo '<td>' . $row['loyaltyBarcode'] . '</td>';
                        echo '<td>' . $row['addressOne'] . '</td>';
                        echo '<td>' . $row['addressTwo'] . '</td>';
                        echo '<td>' . $row['addressThree'] . '</td>';
                        echo '<td>' . $row['nic'] . '</td>';
                        echo '<td>' . $row['teleMobile'] . '</td>';
                        echo '<td>' . $row['teleLand'] . '</td>';
                        echo '<td>' . $row['accupation'] . '</td>';
                        echo '<td>' . $row['area'] . '</td>';
                        echo '<td>' . $row['dob'] . '</td>';
                        echo '<td>' . $row['age'] . '</td>';
                        echo '<td>' . $row['familyDetails'] . '</td>';
                        echo '<td>' . $row['notes'] . '</td>';
                        echo '<td>' . $row['location'] . '</td>';
                        echo '</tr>';
                    }
                    
                    echo '</table>';
                }
            }
        }


        function updateCustomer(){
            $datepicker = $_POST["datepicker"];
            $registerNo = $_POST["registerNo"];
            $name = $_POST["name"];
            $location = $_POST["location"];
            $address1 = $_POST["address1"];
            $address2 = $_POST["address2"];
            $address3 = $_POST["address3"];
            $loyaltyBarcode = $_POST["loyaltyBarcode"];
            $teleMobile = $_POST["teleMobile"];
            $teleLand = $_POST["teleLand"];
            $nic = $_POST["nic"];
            $dob = $_POST["dob"];
            $age = $_POST["age"];
            $occupation = $_POST["occupation"];
            $area = $_POST["area"];
            $familyDetails = $_POST["familyDetails"];
            $notes = $_POST["notes"];

            if(empty($datepicker) || empty($registerNo) || empty($name) || empty($location) || empty($address1) || empty($address2) || empty($address3) || empty($loyaltyBarcode) || empty($teleMobile) || empty($teleLand) || empty($nic) || empty($dob) || empty($age) || empty($occupation) || empty($area) || empty($familyDetails) || empty($notes)){
                echo '<script>alert("Input Should not be Empty..!")</script>';
            }else{
                require_once '../controllers/db.php';
                require_once '../controllers/customerController.php';

                $updated = updateCustomerData($conn, $datepicker, $registerNo, $name, $location, $address1, $address2, $address3, $loyaltyBarcode, $teleMobile, $teleLand, $nic, $dob, $age, $occupation, $area, $familyDetails, $notes);

                if($updated){
                    echo '<script>alert("Customer details Updated Successfully..!..!")</script>';
                }else{
                    echo '<script>alert("Something went wrong..!")</script>';
                }

            }
        }

        function deleteCustomer(){
            require_once '../controllers/db.php';
            require_once '../controllers/customerController.php';

            $id = $_POST["registerNo"];

            if(empty($id)){
                echo '<script>alert("Code should not be Empty..!")</script>';
            }else{
                $deleted = deleteCustomerData($conn, $id);

                if($deleted){
                    echo '<script>alert("Customer Deleted Successfully..!")</script>';
                }else{
                    echo '<script>alert("Something went wrong..!")</script>';
                }
            }
        }
        ?>

        <div class="row mb-2">

        <div class="col-md-6">
            <h3>Customer <span class="text-warning">Register</span></h3>
        </div>

        <div class="col-md-6">
        <form id="customerSearchForm" action="customer_register.php" method="post" class="mt-3">
            <div class="flex items-center ">
                <input type="text" class="form-control bg-white rounded-full shadow-xl" id="keyword" name="keyword"
                    placeholder="Search...">
                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="search">
                    <i class="fa-solid fa-notes-medical"></i> </button>
            </div>
        </div>
        </form>
        </div>

        <form id="customerRegistrationForm" action="customer_register.php" method="post" class="mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3 ">
                    <label for="datepicker" class="form-label text-sm font-bold">Date:</label>
                    <input type="date" class="form-control " id="datepicker" name="datepicker" required>
                </div>
            </div>



            <div class="col-md-3">
                <div class="mb-3">
                    <label for="registerNo" class="form-label text-sm font-bold">Register No:</label>
                    <input type="text" class="form-control" id="registerNo" name="registerNo" required>
                    <?php
                        echo '<script>';
                        echo 'document.getElementById("registerNo").value="'.$lastCustomerId.'"';
                        echo '</script>';                        
                ?>
                </div>
            </div>

            <div class="col-md-4">
                <label for="loyaltyBarcode" class="form-label text-sm font-bold">Loyalty Barcode:</label>
                <input type="text" class="form-control" id="loyaltyBarcode" name="loyaltyBarcode">
            </div>



        </div>

        <div class="row">

            <div class="col-md-3">

                <div class="mb-2">
                    <label for="name" class="form-label text-sm font-bold">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

               
                <div class="">
                    <label for="teleMobile" class="form-label text-sm font-bold">Telephone (Mobile):</label>
                    <input type="tel" class="form-control" id="teleMobile" name="teleMobile">
                </div>



       


            </div>
            <div class="col-md-3">

                <div class="mb-2">
                    <label for="location" class="form-label text-sm font-bold">Location:</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>

                <div class="">
                    <label for="teleLand" class="form-label text-sm font-bold">Telephone (Land):</label>
                    <input type="tel" class="form-control" id="teleLand" name="teleLand">
                </div>

            </div>

            <div class="col-md-3">

                <div class="mb-3">
                    <label for="address" class="form-label text-sm font-bold">Address:</label>
                    <input class="form-control" id="address1" name="address1"></input>
                    <input class="form-control" id="address2" name="address2"></input>
                    <input class="form-control" id="address3" name="address3"></input>

                </div>


            </div>

            <div class="col-md-3">
                <div class="mb-2">
                    <label for="occupation" class="form-label text-sm font-bold">Occupation:</label>
                    <input type="text" class="form-control" id="occupation" name="occupation">
                </div>

                <div class="">
                    <label for="area" class="form-label text-sm font-bold">Area:</label>
                    <select class="form-select" id="area" name="area">
                        <option>Main Street</option>
                        <option>City Center</option>
                        <option>Suburban Area</option>
                    </select>
                </div>


            </div>


        </div>

        <div class="row">
           

            <!-- ======================================================== -->
            <!-- <div class="col-md-3">
                <div class="mb-3">
                    <label for="occupation" class="form-label text-sm font-bold">Occupation:</label>
                    <input type="text" class="form-control" id="occupation" name="occupation">
                </div>

            </div> -->

            <!-- ================================================================== -->
            <!-- <div class="col-md-3">
                <div class="mb-3">
                    <label for="area" class="form-label text-sm font-bold">Area:</label>
                    <select class="form-select" id="area" name="area">
                        <option>Main Street</option>
                        <option>City Center</option>
                        <option>Suburban Area</option>
                    </select>
                </div>

            </div> -->
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="nic" class="form-label text-sm font-bold">NIC:</label>
                    <input type="text" class="form-control" id="nic" name="nic">
                </div>


            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="dob" class="form-label text-sm font-bold">DOB:</label>
                    <input type="date" class="form-control" id="dob" name="dob">
                </div>



            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="age" class="form-label text-sm font-bold">Age (Years):</label>
                    <input type="text" class="form-control" id="age" name="age">
                </div>


            </div>
        </div>




        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="familyDetails" class="form-label text-sm font-bold">Family Details:</label>
                    <textarea class="form-control" id="familyDetails" name="familyDetails" rows="3"></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="notes" class="form-label text-sm font-bold">Notes:</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
            </div>
        </div>





        <div class="row">
        <div class="col-md-12">
                    <div class="mb-3 d-flex justify-content-end gap-3">
                        <label for="submit" class="form-label"></label>
                        <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-32" name="submit">Submit</button>
                        <button type="submit" class="bg-yellow-500 text-white p-2 font-semibold w-32" onclick="clearForm()">Clear</button>
                        <button type="submit" class="bg-green-600 text-white p-2 font-semibold w-32" name="submit">Update</button>
                        <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-32" name="submit">Delete</button>
                        <button type="submit" class="bg-black text-white p-2 font-semibold w-32" onclick="exit()"
                            name="submit">Exit</button>
                    </div>
                </div>
        </div>
        </form>


        </div>

        <script>

        function getRowData(row) {
        var regNo = row.cells[0].innerText;
        var name = row.cells[1].innerText;
        var date = row.cells[2].innerText;
        var barcode = row.cells[3].innerText;
        var add1 = row.cells[4].innerText;
        var add2 = row.cells[5].innerText;
        var add3 = row.cells[6].innerText;
        var nic = row.cells[7].innerText;
        var mobile = row.cells[8].innerText;
        var land = row.cells[9].innerText;
        var occupation = row.cells[10].innerText;
        var area = row.cells[11].innerText;
        var dob = row.cells[12].innerText;
        var age = row.cells[13].innerText;
        var detail = row.cells[14].innerText;
        var note = row.cells[15].innerText;
        var loc = row.cells[16].innerText;

        document.getElementById("registerNo").value = regNo;
        document.getElementById("name").value = name;
        document.getElementById("datepicker").value = date;
        document.getElementById("loyaltyBarcode").value = barcode;
        document.getElementById("address1").value = add1;
        document.getElementById("address2").value = add2;
        document.getElementById("address3").value = add3;
        document.getElementById("nic").value = nic;
        document.getElementById("teleMobile").value = mobile; 
        document.getElementById("teleLand").value = land;
        document.getElementById("occupation").value = occupation;
        document.getElementById("area").value = area;
        document.getElementById("dob").value = dob;
        document.getElementById("age").value = age;
        document.getElementById("familyDetails").value = detail; 
        document.getElementById("notes").value = note;
        document.getElementById("location").value = loc;


        }


        function clearForm() {
        document.getElementById("customerRegistrationForm").reset();
        }

        function exit() {
        window.location.href = "index.php";
        }
        </script>

        </body>

        </html>