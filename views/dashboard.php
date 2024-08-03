<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Dashboard</title>
</head>

<body>
    <div class="container bg-white p-2 w-full">

        <div class="row ">

            <div class="w-full">
                <h3 class="text-md">Welcome to the <span class="text-warning">Dashboard</span></h3>
            </div>

           
        </div>

        <?php

            session_start();
            $_SESSION['jobData'] = '';
            $_SESSION['invoiceData'] = '';
            $_SESSION['PaymentData'] = '';
            $_SESSION['customerData'] = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['search'])) {
                    $keyword = $_POST['keyword'];
    
                    require_once '../controllers/db.php';
                    require_once '../controllers/prescriptionController.php';
                    require_once '../controllers/invoiceController.php';
                    require_once '../controllers/customerController.php';
    
    
                    
                    $jobResult = searchJob($conn, $keyword);                
                    if ($jobResult) {
                        $_SESSION['jobData'] = $jobResult;
                        $cusRegNumber = $jobResult['cusRegNumber'];
    
                        $customerResult = searchCustomerbyRegNumber($conn, $cusRegNumber);
                        $_SESSION['customerData'] = $customerResult;
                    }
    
                   
                    $invoiceResult = searchInvoiceByJob($conn, $keyword);
                    $_SESSION['invoiceData'] = $invoiceResult;
    
                    $paymentResult = searchPaymentByJob($conn, $keyword);
                    $_SESSION['PaymentData'] = $paymentResult;
                    
                    
                }
            }


        
        
        ?>

        <!-- ======================================================================================================== -->


        <form id="dashboardForm" action="dashboard.php" method="post">
            <div class="grid grid-cols-12 gap-2">
                <!-- First row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">

                    <div class="grid grid-cols-12 xl:gap-3 lg:gap-2">

                        <div class="  col-span-3 gap-2">
                            <div class="border-2 border-gray-200 p-1">
                                <label for="grnNo" class="form-label text-xs text-red-600 font-semibold">Search
                                    Patient:</label>
                                <div class="flex items-center ">
                                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="keyword" name="keyword"
                                        placeholder="Search ">
                                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="search">
                                        <i class="fa-solid fa-notes-medical"></i> </button>
                                </div>
                            </div>

                            <div class=" flex gap-2 mt-3">
                                <label for="invoNo" class="form-label text-xs font-medium text-center ">Reg
                                    No:</label>
                                <div class="border-2 border-gray-200 h-10 w-full">
                                    <label
                                        class="form-label text-md flex justify-center font-bold text-center mt-2 text-black" id="reNoLbl">
                                        <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("reNoLbl").textContent="'.$jobResult['cusRegNumber'].'"';
                                    echo '</script>';
                                }else{
                                    echo '<script>';
                                    echo 'document.getElementById("reNoLbl").textContent="0000"';
                                    echo '</script>';
                                }                          
                            ?>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="  col-span-2 pl-2 pr-2">
                            <div class="flex justify-center">
                            <button type="submit"
                                class=" bg-gray-100 shadow-lg p-2 hover:bg-gray-300">
                                <i class="fas fa-sync-alt text-green-600 text-lg"></i>
                                <span class="text-green-600 font-serif font-semibold">Refresh</span>
                            </button>
                            </div>
                           
                        </div>

                        <div class="  col-span-4 gap-1 border-2 border-gray-200 text-center p-1">
                            <div class="flex gap-4 justify-center ">
                                <div class="">
                                    <label class="form-label text-xs font-semibold text-center " >Reg Date: 
                                           
                                            <label  class="text-xs font-normal" id="regDate" for="">
                                            <?php
                            if(!empty($customerResult)){
                                foreach($customerResult as $cust){
                                    echo $cust['datepicker'];
                                }
                            }else{
                                echo "12-12-2121";
                            }                       
                            ?>
                                            </label>
                                           
                            </label>
                                </div>

                                <div>
                                    <label class="form-label text-xs font-medium text-center ">Reg No:
                                        <span class="text-xs font-normal" id="regNoo">
                                <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("regNoo").textContent="'.$jobResult['cusRegNumber'].'"';
                                    echo '</script>';
                                }else{
                                    echo '<script>';
                                    echo 'document.getElementById("regNoo").textContent="0000"';
                                    echo '</script>';
                                }                          
                            ?>
                                        </span></label>
                                </div>

                            </div>

                            <div>
                            <label class="form-label text-sm text-red-600 font-bold text-center uppercase" id="cusName">
                            <?php
                            if(!empty($customerResult)){
                                foreach($customerResult as $cust){
                                    echo $cust['name'];
                                }
                            }else{
                                echo "sample Name";
                            }                       
                            ?>
                            </label>
                            </div>
                           

                            <div>
                            <label
                                class="form-label text-xs text-red-800 font-bold text-center uppercase">
                                <?php
                            if(!empty($customerResult)){
                                foreach($customerResult as $cust){
                                    echo $cust['addressOne'].','.$cust['addressTwo'].','.$cust['addressThree'];
                                }
                            }else{
                                echo "sample Address";
                            }                                             
                            ?>
                            </label>
                            </div>
                         

                            <div class="flex gap-4 text-center  justify-center">
                                <div>
                                    <label class="form-label text-xs font-semibold text-center">Date Of Birth:
                                        <span class="text-xs font-normal">2000/10/20</span></label>
                                </div>

                                <div>
                                    <label class="form-label text-xs font-semibold text-center ">Age:
                                        <span class="text-xs font-normal">
                                        <?php
                            if(!empty($customerResult)){
                                foreach($customerResult as $cust){
                                    echo $cust['age'];
                                }
                            }else{
                                echo "sample age";
                            }                       
                            ?>
                                        </span></label>
                                </div>

                            </div>

                            <label class="form-label text-xs font-semibold text-center ">Contact: <span
                                    class="text-xs font-normal">
                            <?php
                            if(!empty($customerResult)){
                                foreach($customerResult as $cust){
                                    echo $cust['teleMobile'];
                                }
                            }else{
                                echo "sample telemobile";
                            }                       
                            ?>
                                </span></label>

                        </div>

                        <div class="  col-span-3 gap-2 border-2 border-gray-200 text-center p-1">
                            <div>
                                <label class="form-label text-sm font-semibold text-center "> Job No: <span
                                        class="text-sm font-semibold text-red-700" id="jobNum">
                                <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("jobNum").textContent="'.$jobResult['id'].'"';
                                    echo '</script>';
                                }else{
                                    echo '<script>';
                                    echo 'document.getElementById("jobNum").textContent="0000"';
                                    echo '</script>';
                                }                          
                            ?>
                                    </span></label>

                            </div>

                            <div>
                                <label class="form-label text-sm font-semibold text-center">Status: <span
                                        class="text-sm font-semibold font-mono text-red-700" id="sts">
                                    <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("sts").textContent="'.$jobResult['status'].'"';
                                    echo '</script>';
                                }else{
                                    echo '<script>';
                                    echo 'document.getElementById("sts").textContent="----"';
                                    echo '</script>';
                                }                          
                            ?>
                                    </span></label>

                            </div>

                            <div>
                                <label class="form-label text-sm font-semibold text-center ">Date: <span
                                        class="text-sm font-semibold text-red-700" id="jbDate">
                                        <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("jbDate").textContent="'.$jobResult['date'].'"';
                                    echo '</script>';
                                }else{
                                    echo '<script>';
                                    echo 'document.getElementById("jbDate").textContent="----"';
                                    echo '</script>';
                                }  
                                ?>
                                    </span></label>

                            </div>


                            <div>
                                <label class="form-label text-sm font-semibold text-center">Last Job No: <span
                                        class="text-sm font-semibold text-red-700" id="lastJobNo">
                                        <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("lastJobNo").textContent="'.$jobResult['id'].'"';
                                    echo '</script>';
                                }else{
                                    echo '<script>';
                                    echo 'document.getElementById("lastJobNo").textContent="0000"';
                                    echo '</script>';
                                }                          
                            ?>
                                    </span></label>

                            </div>


                        </div>
                    </div>
                </div>


                <!-- Second row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-4 ">
                        <div class="col-span-12">
                            <div class="xl:max-h-28 lg:max-h-24 overflow-y-auto">
                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Date</th>
                                            <th>Job No</th>
                                            <th>Notes</th>
                                            <th>Dist R</th>
                                            <th>Cyl R</th>
                                            <th>Axis</th>
                                            <th>Dist L</th>
                                            <th>Cyl L</th>
                                            <th>Axis L</th>
                                            <th>Add R</th>
                                            <th>Add L</th>




                                        </tr>
                                    </thead>
                                    <tbody class="text-xs">
                                        <tr>
                                            <td>001</td>
                                            <td>Electronics</td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td>Clothing</td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td>Furniture</td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td>Furniture</td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td>Furniture</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>




                    </div>
                </div>

                <!-- Third row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">
                            <div class="grid grid-cols-12 gap-1 ">
                                <div class="col-span-2 p-3">
                                    <div class="bg-green-200 p-3 text-center flex justify-center items-center font-semibold ">
                                        <span class="text-green-800 font-extrabold font-sans">Job Status</span></div>
                                </div>

                                <div class="col-span-10 w-full">
                                    <div class="xl:max-h-24 lg:max-h-20 overflow-y-auto">
                                        <table class="table table-bordered custom-table">
                                            <thead class="text-xs">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Job No</th>
                                                    <th>Status</th>
                                                    <th>Notes</th>
                                                    <th>#</th>

                                                </tr>
                                            </thead>
                                            <tbody class="text-xs">
                                            <?php
                                    if (isset($_SESSION['jobData'])) {

                                        $jobData = $_SESSION['jobData'];

                                        IF($jobData){
                                            echo "<tr>";
                                            echo "<td>" . $jobData['date'] . "</td>";
                                            echo "<td>" . $jobData['id'] . "</td>";
                                            echo "<td>" . $jobData['status'] . "</td>";
                                            echo "<td>" . $jobData['note'] . "</td>";
                                            echo "<td>" . $_SESSION['amount'] . "</td>";
                                            echo "</tr>";

                                        }
                                         
                                               
                                            
                                    }
                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                </div>


                 <!-- 4th row -->
                 <div class="col-span-12  p-1 border-2 border-gray-200">
                        <div class="grid grid-cols-12 gap-1 ">
                            <div class="col-span-2 p-3">
                                <div class="bg-green-200 p-3 text-center flex justify-center items-center font-semibold ">
                                    <span class="text-green-800 font-extrabold font-sans">Sold Item</span></div>
                            </div>

                            <div class="col-span-10 w-full">
                                <div class="max-h-24 overflow-y-auto">
                                    <table class="table table-bordered custom-table">
                                        <thead class="text-xs">
                                            <tr>
                                                <th>Job No</th>
                                                <th>Item Code</th>
                                                <th>Description</th>

                                                <th>Qty</th>
                                                <th>Discount</th>
                                                <th>Amount</th>






                                            </tr>
                                        </thead>
                                        <tbody class="text-xs">
                                        <?php
                                    if (isset($_SESSION['invoiceData'])) {

                                        $invoiceData = $_SESSION['invoiceData'];

                                     //   echo var_dump($invoiceData);

                                     foreach($invoiceData as $data){
                                        echo "<tr>";
                                        echo "<td>" . $data['id'] . "</td>"; // Assuming 'id' is the job number
                                        echo "<td>" . $data['itemCode'] . "</td>";
                                        echo "<td>" . $data['description'] . "</td>";
                                        echo "<td>" . $data['qty'] . "</td>";
                                        echo "<td>" . $data['discount'] . "</td>";
                                        echo "<td>" . $data['amount'] . "</td>";
                                        echo "</tr>";
                                    }
                                                                                
                                    }
                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                </div>

                 <!-- 5th row -->
                 <div class="col-span-12  p-1 border-2 border-gray-200">
                        <div class="grid grid-cols-12 gap-1 ">
                            <div class="col-span-2 p-3">
                                <div class="bg-green-200 p-3 text-center flex justify-center items-center font-semibold ">
                                    <span class="text-green-800 font-extrabold font-sans">Received Cash</span></div>
                            </div>

                            <div class="col-span-10 w-full">
                                <div class="max-h-24 overflow-y-auto">
                                    <table class="table table-bordered custom-table">
                                        <thead class="text-xs">
                                            <tr>
                                                <th>Job No</th>
                                                <th>Date</th>
                                                <th>Bill No</th>
                                                <th>Net Amount</th>
                                                <th>Pay Mode</th>
                                                <th>Paid Amount</th>
                                                <th>Balance</th>

                                            </tr>
                                        </thead>
                                        <tbody class="text-xs">
                                        <?php

                                            if (isset($_SESSION['PaymentData'])) {
                                                $paymentData = $_SESSION['PaymentData']; // Assign to $paymentData instead of $data
                                                if (!empty($paymentData)) { // Check if $paymentData is not empty
                                                    foreach ($paymentData as $row) { // Iterate through $paymentData
                                                        echo "<tr>";
                                                        echo "<td>" . $row['jobNumber'] . "</td>";
                                                        echo "<td>" . $row['jobNumber'] . "</td>";
                                                        echo "<td>" . $row['id'] . "</td>";
                                                        echo "<td>" . $row['amount'] . "</td>";
                                                        echo "<td>" . $row['amount'] . "</td>";
                                                        echo "<td>" . $row['type'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>No payment data available</td></tr>";
                                                }
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                </div>


            </div>
           

        </form>

    </div>

    <script>
    function clearForm() {
        document.getElementById("dashboardForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>