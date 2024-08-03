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
    <div class="container bg-white p-2 w-full ">

        <div class="row ">

            <div class="col-md-6">
                <h3 class="text-md">Job <span class="text-warning">Status</span></h3>
            </div>


        </div>
        
        <?php
            session_start();
            $_SESSION['jobData'] = '';
            $_SESSION['paymentData'] = '';
            $_SESSION['customerData'] = '';
            $_SESSION['amount'] = 0;
           

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['search'])) {
                    $keyword = $_POST['searchKeyword'];
                    
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
                    $paymentResult = searchPaymentByJob($conn, $keyword);
                    $_SESSION['paymentData'] = $paymentResult;

                    $total = 0;
                    foreach($paymentResult as $pay){
                        $total += $pay['amount'];
                    }

                    $_SESSION['amount'] = $total;


                }else 
                if (isset($_POST['changeStatus'])) {

                    $note = $_POST['note'];
                    $status = $_POST['area'];
                    $id = $_POST['htnInput'];

                    require_once '../controllers/db.php';
                    require_once '../controllers/prescriptionController.php';
                    require_once '../controllers/invoiceController.php';
                    require_once '../controllers/customerController.php';

                    if(empty($note)){
                        $updated = updateOnlyJobStatus($conn, $id, $status);
                    }else{
                        $updated = updateJobStatus($conn, $id, $note, $status);
                    }
                                                    
                    if($updated){
                        echo '<script>alert("Job Status Updated..!")</script>';
                    }else{
                        echo '<script>alert("Something Went Wrong..!")</script>';
                    }


                    $jobResult = searchJob($conn, $id);                
                    if ($jobResult) {
                    $_SESSION['jobData'] = $jobResult;
                    $cusRegNumber = $jobResult['cusRegNumber'];

                    $customerResult = searchCustomerbyRegNumber($conn, $cusRegNumber);
                    $_SESSION['customerData'] = $customerResult;
                    }
                    $paymentResult = searchPaymentByJob($conn, $id);
                    $_SESSION['paymentData'] = $paymentResult;

                    $total = 0;
                    foreach($paymentResult as $pay){
                        $total += $pay['amount'];
                    }

                    $_SESSION['amount'] = $total;

                }
            
            }


        
        ?>

        <!-- ======================================================================================================== -->


        <form id="jobStatusForm" action="jobStatus.php" method="post">
            <div class="grid grid-cols-12 gap-2">
                <!-- First row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">

                    <div class="grid grid-cols-12 gap-3">

                        <div class="  col-span-3 gap-2">
                            <div class=" flex gap-2 mt-3">
                                <label for="invoNo" class="form-label text-xs font-medium text-center ">Reg
                                    No:</label>
                                <div class="border-2 border-gray-200 h-10 w-full">
                                    <label
                                        class="form-label text-md flex justify-center font-bold text-center mt-2 text-black" id="regNo">
                                        <?php
                                            if(!empty($jobResult)){
                                                echo '<script>';
                                                echo 'document.getElementById("regNo").textContent="'.$jobResult['cusRegNumber'].'"';
                                                echo '</script>';
                                            }                          
                                        ?>
                                    </label>

                                </div>
                            </div>



                        </div>

                        <div class="  col-span-1 ">
                            <button type="submit"
                                class="flex flex-col mr-3 justify-center items-center bg-gray-100 shadow-lg p-2 hover:bg-gray-300">
                                <i class="fas fa-sync-alt text-green-600 text-lg"></i>
                                <span class="text-green-600 font-serif font-semibold">Refresh</span>
                            </button>
                        </div>

                        <div class="  col-span-8 gap-1  justify-self-end  ">
                            <div class=" p-1  ">
                                <label for="grnNo" class="form-label text-sm text-red-600 font-bold text-start ">Search
                                    Prescription/Job:</label>
                                <div class="flex items-center w-full">
                                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="searchKeyword" name="searchKeyword"
                                        placeholder="Search ">
                                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="search">
                                        <i class="fa-solid fa-notes-medical"></i> </button>
                                </div>
                            </div>

                            <input type="hidden" name="htnInput" id="htnInput">
                            <?php
                                            if(!empty($jobResult)){
                                                echo '<script>';
                                                echo 'document.getElementById("htnInput").value="'.$jobResult['id'].'"';
                                                echo '</script>';
                                            }                          
                                        ?>


                        </div>


                    </div>
                </div>


                <!-- 2nd row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-1 ">
                        <div class="  col-span-6   p-1">
                            <div class=" gap-2">
                                <label class="form-label text-md font-semibold  "> Name: </label>
                                <div class="flex gap-4">
                                    <span class="font-extrabold"></span>
                                    <label class="text-md font-extrabold text-red-600 uppercase gap-2">
                                    <?php
                                        if(!empty($customerResult)){
                                            foreach($customerResult as $cust){
                                                echo $cust['name'];
                                            }
                                        }
                                    ?> 
                                    </label>
                                </div>


                            </div>

                        </div>

                        <div class="  col-span-6 gap-2  p-1">
                            <div class="flex gap-3">
                                <label class="form-label text-sm font-semibold text-center "> Gender: </label>
                                <div>
                                    <span class="text-sm font-bold text-black uppercase">Female</span>
                                </div>

                            </div>

                            <div class="flex gap-3">
                                <label class="form-label text-sm font-semibold text-center "> Date Of Birth:</label>
                                <div>
                                    <span class="text-sm font-bold text-black uppercase">
                                    <?php
                                    if(!empty($customerResult)){
                                        foreach($customerResult as $cust){
                                            echo $cust['dob'];
                                        }
                                    }
                                    ?> 
                                    </span>
                                </div>

                            </div>

                            <div class="flex gap-3">
                                <label class="form-label text-sm font-semibold text-center "> Contact No: </label>

                                <div>
                                    <span class="text-sm font-bold text-black uppercase">
                                    <?php
                                    if(!empty($customerResult)){
                                        foreach($customerResult as $cust){
                                            echo $cust['teleMobile'];
                                        }
                                    }
                                    ?> 
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- 3rd row -->

                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-1 ">


                        <div class="col-span-12 w-full">
                            <div class="max-h-36 overflow-y-auto">
                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Date</th>
                                            <th>Job No</th>
                                            <th>Status</th>

                                            <th>Notes</th>
                                            <th>Amount</th>

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
                <div class="col-span-12  p-1 ">
                    <div class="grid grid-cols-12 gap-1 ">
                        <div class="col-span-8 w-full border-2 border-gray-200 p-2">
                            <div>
                                <label for="note" class="font-bold text-sm">Enter Notes:</label><br>
                                <textarea id="note" name="note"
                                    class="h-20 mt-1 shadow-md w-full border-2 border-gray-200"></textarea>
                            </div>

                        </div>

                        <div class="col-span-4 w-full border-2 border-gray-200 p-2">
                            <div>
                                <label for="message" class="font-bold text-sm">SMS:</label><br>
                                <textarea id="message" name="message"
                                    class="h-20 mt-1 shadow-md w-full border-2 border-gray-200"></textarea>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- 5th row -->
                <div class="col-span-12  p-1 ">
                    <div class="grid grid-cols-12 gap-1 ">


                        <div class="col-span-9  ">
                            <div class="flex w-2/3  gap-2">
                                <label for="status" class="form-label text-sm font-semibold  mt-2">Status:</label>
                                <select class="form-select" id="area" name="area" class="h-10">
                                    <option value="Collected">Collected</option>
                                    <option value="Collected">FITTING</option>
                                    <option value="Collected">READY</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-span-3 w-full   text-end justify-self-end">
                            <div class="flex justify-start gap-2">
                                <button type="submit" class="bg-black text-white p-2 font-semibold w-24 text-sm"
                                    name="changeStatus">SMS Ready
                                </button>
                                <button type="submit"
                                    class="bg-green-500 text-white p-2 font-semibold w-24" onclick="exit()">Exit</button>
                            </div>

                            <div class="flex gap-2 justify-start mt-2">
                                <input type="checkbox" id="sms-checkbox" name="sms-checkbox"
                                    class="font-semibold text-md">
                                <label for="sms-checkbox " class="font-semibold text-md">Send SMS</label>


                            </div>



                        </div>

                    </div>
                </div>


            </div>


        </form>

    </div>

    <script>
    function clearForm() {
        document.getElementById("jobStatusForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>