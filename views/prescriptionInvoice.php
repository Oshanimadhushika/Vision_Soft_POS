<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Prescription Invoice</title>

    <style>
   


   .contentFrameCol {
     
       height: 500px;
   }

   </style>
</head>

<body>
    <div class="container bg-white p-2 w-full">

    <?php
    
    session_start();
    $_SESSION['selectedDatas'] = '';
    $_SESSION['payeddDatas'] = '';
    $_SESSION['billAmount'] = 0;
    $_SESSION['discount'] = 0;
    $_SESSION['payedAmount'] = 0;
    $_SESSION['officer'] = '';


    $result = null;



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['searchCustoer'])) {
            $regNo = $_POST["searchRegNo"];

            if(!empty($regNo)){
                require_once '../controllers/db.php';
                require_once '../controllers/customerController.php';
                require_once '../controllers/prescriptionController.php';

                $result = searchCustomerbyRegNumber($conn, $regNo);  
                $history = getCustomerJobHistory($conn, $regNo);  
                
                $_SESSION['customerResult'] = $result; 
            }

        }else if(isset($_POST['refresh'])){
            $regNo = $_POST["regNo"];

            if(!empty($regNo)){
                require_once '../controllers/db.php';
                require_once '../controllers/customerController.php';
                require_once '../controllers/prescriptionController.php';

                $result = searchCustomerbyRegNumber($conn, $regNo);  
                $history = getCustomerJobHistory($conn, $regNo);  
                
                $_SESSION['history_result'] = $history;
            }
        }else if(isset($_POST["showData"])){
            $selectedJob = $_POST['jobNo'];
            
            require_once '../controllers/db.php';
            require_once '../controllers/prescriptionController.php';

            $selectedAssesment = getSelectedAssesment($conn, $selectedJob);
            $selectedPrescription = getSelectedPrescription($conn, $selectedJob);

            $_SESSION['assesmentData'] = $selectedAssesment;
            $_SESSION['prescriptionData'] = $selectedPrescription;

        }

              
    }

    

    
    
    ?>

        <div class="row ">

            <div class="col-md-6">
                <h3>Prescription <span class="text-warning">Invoice</span></h3>
            </div>

            
            <!-- <div class="col-md-6">
                <div class="flex items-center ">
                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="search"
                        placeholder="Search Prescription Invoice">
                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700">
                        <i class="fa-solid fa-notes-medical"></i> </button>
                </div>



            </div> -->
        </div>

        <!-- ======================================================================================================== -->



        <form id="prescriptionForm" action="prescriptionInvoice.php" method="post">

            <div class="grid grid-cols-12 gap-1">
                <!-- First row -->
                <div class="col-span-12 p-2 border-2 border-gray-200">

                    <div class="grid grid-cols-12 gap-2 ">

                        <div class="  col-span-2 gap-2 border-2 border-gray-200 p-2">
                            <div>
                                <label for="regNo" class="form-label text-xs font-medium">Reg No:</label>
                                <input type="text" class="form-control h-10" id="regNo" name="regNo" >
                                <?php
                                
                                if($result !== null){
                                $regNum;
                                foreach($result as $data){
                                    $regNumb = $data['registerNo'];
                                }
                                
                                echo '<script>';
                                echo 'document.getElementById("regNo").value="'.$regNumb.'"';
                                echo '</script>';

                                $_SESSION['search_result'] = $regNumb;


                            }
                                
                                ?>


                            </div>

                            <div class="mt-2">
                                <div class="flex items-center ">
                                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="searchRegNo" name="searchRegNo"
                                        placeholder="Search Patient">
                                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="searchCustoer">
                                        <i class="fa-solid fa-notes-medical"></i> </button>
                                </div>
                            </div>

                        </div>

                        <div class="  col-span-2 gap-2 border-2 border-gray-200 p-2">
                            <label for="option" class="form-label text-xs font-medium">Options</label>

                            <div class="">
                                <input type="radio" id="prescription" name="option" value="user"
                                    class="mr-2 font-semibold " checked>
                                <label for="prescription" class="font-semibold text-sm">Prescription</label>
                            </div>

                            <div class="mt-2">
                                <input type="radio" id="invoice" name="option" value="user" class="mr-2 font-semibold ">
                                <label for="invoice" class="font-semibold text-sm">Invoice</label>
                            </div>
                        </div>


                        <div class="  col-span-2 gap-2 border-2 border-gray-200 p-2">
                        <div class="text-center">
                            <label class="form-label text-sm font-medium uppercase text-blue-600" id="cusNameLbl">Mrs B.kusumalatha</label>
                            <div>
                                <label class="form-label text-sm font-medium uppercase text-blue-600" id="cusAddressLbl">Address</label>
                            </div>
                            <label class="form-label text-sm font-medium" id="cusMobileLbl">071236477</label>

                            <?php



                            $regName = "";
                            $regAddress = "";
                            $regMobile = "";
                            if (isset($_SESSION['customerResult'])) {
                                $res = $_SESSION['customerResult'];

                                foreach($res as $data){
                                    $regName = $data['name'];
                                    $regAddress = $data['location'];
                                    $regMobile = $data['teleMobile'];

                            }

                            
                            
                            
                           

                            // Echoing JavaScript to set label texts
                            echo '<script>';
                            echo 'document.getElementById("cusNameLbl").textContent = "'.htmlspecialchars($regName).'";';
                            echo 'document.getElementById("cusAddressLbl").textContent = "'.htmlspecialchars($regAddress).'";';
                            echo 'document.getElementById("cusMobileLbl").textContent = "'.htmlspecialchars($regMobile).'";';
                            echo '</script>';

                        }
                            ?>

                        </div>




                        </div>

                        <div class="  col-span-2 gap-2">
                            <div class="border-2 border-gray-200">
                            <!-- <label for="date" class="form-label text-lg flex justify-center font-bold text-center mt-2 text-green-700" id="jobNo"> -->
                            <input type="text" class="form-control h-10" id="jobNo" name="jobNo" >
                                <?php
                                    $jobNumber; 

                                        if (isset($_SESSION['job_number'])) {
                                            $jobNumber = $_SESSION['job_number'];

                                        echo '<script>';
                                        echo 'document.getElementById("jobNo").value ="'.$jobNumber.'"';
                                        echo '</script>';
                                    
                                    }

                                   
                                ?>
                            </label>

                            </div>

                            <div class="flex mt-3">
                            <label  class="form-label text-sm font-medium  text-center mt-2">Officer</label>

                            <select class="form-select h-10 ml-1"  name="officer" id="officerSelect" required>
                                    <!-- <option value="">Select an option</option> -->
                                    <option value="Gayan">Gayan</option>
                                    <option value="Heshan">Heshan</option>
                                    <option value="Janu">Janu</option>
                                </select>
                                <input  id="hdnOfficer" name="hdnOfficer">  
                                <?php
                                    $officer = isset($_POST['hdnOfficer']);
                                    echo $officer;


                                    $_SESSION['officer'] = $officer;
                                ?> 
                            </div>
                                                  
                        </div>

                        <div class=" flex col-span-3 gap-2">
                            <!-- <table class="table table-bordered custom-table">
                                <thead class="text-xs">
                                    <tr>
                                        <th>Date</th>
                                        <th>Job No</th>
                                        


                                    </tr>
                                </thead>
                                <tbody class="text-xs">
                                
                                    
                                </tbody>
                            </table> -->
                            <?php 

                            
                             if (!empty($history)) {
                                // Display the job history in a table
                                echo '<table class="table table-bordered custom-table" id="customerTable">';
                                echo "<tr><th>Job ID</th><th>Date</th></tr>";
                                foreach ($history as $job) {
                                   
                                    echo '<tr onclick="getRowData(this)">';
                                    echo "<td>" . $job['id'] . "</td>";
                                    echo "<td>" . $job['date'] . "</td>"; // Assuming 'date' is a column in your 'job' table
                                    echo "<td> <button name='showData'>Show</button> </td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "";
                            }
                            ?>
                        </div>

                        <div class="  col-span-1 ">
                            <button type="submit" class="flex flex-col items-center bg-gray-100 shadow-lg p-2 hover:bg-gray-300" name="refresh" >
                                <i class="fas fa-sync-alt text-green-600 text-lg"></i>
                                <span class="text-green-600 font-serif font-semibold">Refresh</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Second row -->
            <div class="col-span-12    contentFrameCol">
                <iframe id="contentFrame" src="prescription.php" class=" w-full   h-full">

                </iframe>
            </div>


            </div>


            

        </form>

    </div>

    <script>

    const prescription = document.getElementById('prescription');
    const invoice = document.getElementById('invoice');
    const contentFrame = document.getElementById('contentFrame');

    prescription.addEventListener('change', () => {
        if (prescription.checked) {
            contentFrame.src = 'prescription.php';
        }
    });

    invoice.addEventListener('change', () => {
        if (invoice.checked) {
            contentFrame.src = 'invoice.php';
        }
    });

    function clearForm() {
        document.getElementById("prescriptionForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }

    function getRowData(row) {
        var jobNo = row.cells[0].innerText;
        document.getElementById("jobNo").value = jobNo;

    }

    document.getElementById('officerSelect').addEventListener('change', function() {
        document.getElementById('hdnOfficer').value = document.getElementById('officerSelect').value;
    });

    </script>

</body>

</html>