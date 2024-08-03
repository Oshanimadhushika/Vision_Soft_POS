<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Balance Bill</title>
</head>

<body>
    <div class="container bg-white p-4 w-full ">

    <?php

        session_start();
        $_SESSION['jobData'] = '';
        $_SESSION['invoiceData'] = '';
        $_SESSION['PaymentData'] = '';
        $_SESSION['customerData'] = '';
        $customerResult = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['jobNo'])) {
                $searchJobNo = $_POST['jobNo'];

                require_once '../controllers/db.php';
                require_once '../controllers/prescriptionController.php';
                require_once '../controllers/invoiceController.php';
                require_once '../controllers/customerController.php';


                
                $jobResult = searchJob($conn, $searchJobNo);                
                if ($jobResult) {
                    $_SESSION['jobData'] = $jobResult;
                    $cusRegNumber = $jobResult['cusRegNumber'];

                    $customerResult = searchCustomerbyRegNumber($conn, $cusRegNumber);
                    $_SESSION['customerData'] = $customerResult;
                }

               
                $invoiceResult = searchInvoiceByJob($conn, $searchJobNo);
                $_SESSION['invoiceData'] = $invoiceResult;

                $paymentResult = searchPaymentByJob($conn, $searchJobNo);
                $_SESSION['PaymentData'] = $paymentResult;
                
                
            }

            $totalAmount = 0;
                $totalDiscount = 0;
                $totalPaid = 0;
                $balance = 0;
                $invTwo = $_SESSION['invoiceData'];
                foreach($invTwo as $invoice){
                    $totalAmount += $invoice['amount'];
                    $totalDiscount += $invoice['discount'];
                }
                $payableAmount = $totalAmount - $totalDiscount;
               
                $payTwo = $_SESSION['PaymentData'];
                foreach($payTwo as $payment){
                    $totalPaid += $payment['amount'];
                }

                $balance = $payableAmount - $totalPaid;


                $cusResult = $_SESSION['customerData'];
        }


    
    
    ?>

        <div class="row mb-2">

            <div class="col-md-6">
                <h3>Balance <span class="text-warning">Payment</span></h3>
            </div>


        </div>

        <!-- ======================================================================================================== -->


        <form id="billPaymentForm" action="balanceBill.php" method="post">

            <div class="grid grid-cols-12 gap-2 ">
                <!-- First row -->
                <div class="col-span-12  p-3 border-2 border-gray-200">
                    <!-- 1st row 1st div -->
                    <div class="grid grid-cols-12 gap-4 mt-3">


                        <div class=" flex col-span-3 gap-2">
                            <label for="date" class="form-label text-xs font-medium text-center mt-2">Date:</label>
                            <input type="date" class="form-control h-10 " id="date" name="date">
                            <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("date").value="'.$jobResult['date'].'"';
                                    echo '</script>';
                                }                          
                            ?>
                        </div>

                        <div class=" flex col-span-3 gap-2">
                            <label for="jobNo" class="form-label text-xs font-medium">Job No:</label>
                            <input type="text" class="form-control h-10" id="jobNo" name="jobNo" >
                        </div>

                        <div class=" flex col-span-4 gap-2">
                            <label class="form-label text-xs font-medium">Customer:</label>
                            <label class="form-label text-xs font-bold">
                                <?php

                                    if(!empty($customerResult)){
                                        foreach($customerResult as $cust){
                                            echo $cust['registerNo'];
                                        }
                                    }
                                ?> 
                                  <span
                                    class="ml-2 text-uppercase font-bold ">
                                    <?php

                                        if(!empty($customerResult)){
                                            foreach($customerResult as $cust){
                                                echo $cust['name'];
                                            }
                                        }

                                    ?> 
                                    </span></label>
                        </div>

                        <div class=" flex col-span-2 gap-2">
                            <label for="number" class="form-label text-xs font-medium">
                            <?php

                                    if(!empty($customerResult)){
                                        foreach($customerResult as $cust){
                                            echo $cust['teleMobile'];
                                        }
                                    }
                            ?> 
                            </label>
                        </div>
                    </div>

                    <!-- 2nd row 1st div -->
                    <div class="grid grid-cols-12 gap-4 mt-3">


                        <div class="  col-span-2 gap-2">
                            <label for="date" class="form-label text-xs font-medium text-center mt-2">Sale Date:</label>
                            <input type="date" class="form-control h-10 " id="dateTwo" name="dateTwo">
                            <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("dateTwo").value="'.$jobResult['date'].'"';
                                    echo '</script>';
                                }                            
                            ?>
                        </div>

                        <div class="  col-span-2 ">
                            <label for="receiptNo" class="form-label text-xs font-medium">Receipt No:</label>
                            <input type="text" class="form-control h-10" id="receiptNo" name="receiptNo">
                            <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("receiptNo").value="'.$jobResult['id'].'"';
                                    echo '</script>';
                                }                            
                            ?>
                        </div>

                        <div class="  col-span-1 ">
                            <label for="invoiceNo" class="form-label text-xs font-medium">Invoice No:</label>
                            <input type="text" class="form-control h-10" id="invoiceNo" name="invoiceNo">
                            <?php
                                 if(!empty($jobResult)){
                                    echo '<script>';
                                    echo 'document.getElementById("invoiceNo").value="'.$jobResult['id'].'"';
                                    echo '</script>';
                                }                            
                            ?>
                        </div>

                        <div class="  col-span-2 ">
                            <label for="netValue" class="form-label text-xs font-medium">Net Value:</label>
                            <input type="text" class="form-control h-10" id="netValue" name="netValue">
                            <?php
                                 if(!empty($payableAmount)){
                                    echo '<script>';
                                    echo 'document.getElementById("netValue").value="'.$payableAmount.'"';
                                    echo '</script>';
                                }                            
                            ?>
                            
                        </div>

                        <div class="  col-span-1 ">
                            <label for="return" class="form-label text-xs font-medium">Return:</label>
                            <input type="text" class="form-control h-10" id="return" name="return">
                        </div>

                        <div class="  col-span-2 ">
                            <label for="paid" class="form-label text-xs font-medium">Paid:</label>
                            <input type="text" class="form-control h-10" id="paid" name="paid">
                            
                            <?php
                                 if(!empty($totalPaid)){
                                    echo '<script>';
                                    echo 'document.getElementById("paid").value="'.$totalPaid.'"';
                                    echo '</script>';
                                }                            
                            ?>


                        </div>

                        <div class="  col-span-2 ">
                            <label for="balance" class="form-label text-xs font-medium">Balance:</label>
                            <input type="text" class="form-control h-10" id="balance" name="balance">
                            <?php
                                 if(!empty($balance)){
                                    echo '<script>';
                                    echo 'document.getElementById("balance").value="'.$balance.'"';
                                    echo '</script>';
                                }                            
                            ?>
                        </div>
                    </div>
                </div>


                <!-- Second div -->
                <div class="col-span-12  p-3 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-4 ">

                        <div class="  col-span-2 text-start">
                            <label class="text-sm font-semibold">Pay Mode</label>
                            <div class="mt-3">
                                <input type="radio" id="cash" name="payType" value="user" class="mr-2 font-semibold ">
                                <label for="cash" class="font-semibold text-sm">Cash</label>
                            </div>

                            <div>
                                <input type="radio" id="cheque" name="payType" value="user" class="mr-2 font-semibold ">
                                <label for="cheque" class="font-semibold text-sm">Cheque</label>
                            </div>

                            <div>
                                <input type="radio" id="transfer" name="payType" value="user"
                                    class="mr-2 font-semibold ">
                                <label for="transfer" class="font-semibold text-sm">Card/Transfer</label>
                            </div>

                        </div>

                        <div class="col-span-10  ">
                            <div class="max-h-36 overflow-y-auto">

                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Job No</th>
                                            <th>Inv No</th>
                                            <th>Rec No</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                            <th>Pay Type</th>
                                            <th>Balance</th>
                                            <th>#</th>



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

                <!-- Third div -->
                <div class="col-span-12 p-3">

                    <div class="grid grid-cols-12 gap-4 ">

                        <div class="  col-span-6  border-2 border-gray-200 relative">
                            <button type="submit"
                                class="shadow-lg p-2 font-semibold bg-white rounded-md absolute bottom-2 right-2 hover:bg-gray-400">View
                                Update</button>
                        </div>

                        <div class="  col-span-3 border-2 border-gray-200 p-2">
                            <label class="text-red-500 font-bold text-sm"> Search Patient</label>

                            <div class="flex items-center ">
                                <input type="text" class="form-control bg-white rounded-full shadow-xl" id="search"
                                    placeholder="Search...">
                                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700">
                                    <i class="fa-solid fa-notes-medical"></i> </button>
                            </div>
                        </div>

                        <div class="  col-span-3 border-2 border-gray-200 p-2">
                            <label class="text-red-500 font-bold text-sm"> Add Payment</label>
                            <div class="flex items-center ">
                                <input type="text" class="form-control bg-white rounded-full shadow-xl" id="paymentAmount" name = "paymentAmount"
                                    placeholder="">
                                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="addPayment">
                                    <i class="fa-solid fa-notes-medical"></i> </button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            <!-- ======================================================================================================================= -->
            <div class="grid grid-cols-12 gap-2 mt-3">


                <div class="col-span-12  text-end pt-3">
                    <div class="mb-3  gap-3">
                        <label for="submit" class="form-label"></label>
                        <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-32" name="submit">Bill
                            Print</button>
                        <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-32"
                            name="submit">Delete</button>
                        <button type="submit" class="bg-yellow-500 text-white p-2 font-semibold w-32"
                            onclick="clearForm()">Clear</button>
                        <button type="submit" class="bg-black text-white p-2 font-semibold w-32" onclick="exit()"
                            name="submit">Exit</button>
                    </div>
                </div>
            </div>
            <!-- ======================================================================================================== -->


        </form>



    </div>

    <script>
    function clearForm() {
        document.getElementById("billPaymentPage").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>