<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Invoice</title>

</head>

<body>
    <div class="border-2 border-gray-200 p-1 mb-3">
        <?php

        session_start();
                     

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['searchItem'])) {
                $inDate = isset($_POST['date']) ? $_POST['date'] : '';
                $inNo = isset($_POST['invNum']) ? $_POST['invNum'] : '';
                $lensType = isset($_POST['lensType']) ? $_POST['lensType'] : '';
                $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
                $coating = isset($_POST['coating']) ? $_POST['coating'] : '';
                $tint = isset($_POST['tint']) ? $_POST['tint'] : '';
                $design = isset($_POST['design']) ? $_POST['design'] : '';
                $keyword = isset($_POST['itemKeyword']) ? $_POST['itemKeyword'] : '';
               
                require_once '../controllers/itemController.php';

                $itemResult = searchItemByKeyword($conn, $keyword);
   
                if($itemResult === 'emptyResult'){
                   echo '<script>alert("Empty Result..!");</script>';
                }
                
            }else if(isset($_POST['addItem'])){
                $inDate = isset($_POST['date']) ? $_POST['date'] : '';
                $inNo = isset($_POST['invNum']) ? $_POST['invNum'] : '';
                $lensType = isset($_POST['lensType']) ? $_POST['lensType'] : '';
                $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
                $coating = isset($_POST['coating']) ? $_POST['coating'] : '';
                $tint = isset($_POST['tint']) ? $_POST['tint'] : '';
                $design = isset($_POST['design']) ? $_POST['design'] : '';
                 
                $itemCode = $_POST['itemCode'];
                $qty = $_POST['qty'];
                $price = $_POST['price'];
                $discount = $_POST['disAmount'];
                $amount = $_POST['amount'];
                $description = $_POST['item'];
                $discountedPrice = $amount - $discount;

                // bill amount
                if (!isset($_SESSION['billAmount'])) {
                    $_SESSION['billAmount'] = 0;
                }
            
                $total = $_SESSION['billAmount'];
            
                $total += $discountedPrice;
            
            
                $_SESSION['billAmount'] = $total;



                // discount
                if (!isset($_SESSION['discount'])) {
                    $_SESSION['discount'] = 0;
                }
            
                $totDiscount = $_SESSION['discount'];
            
                $totDiscount += $discount;
                        
                $_SESSION['discount'] = $totDiscount;



                // selected Data
                $rowData = array(
                    "code" => $itemCode,
                    "qty" => $qty,
                    "disc" => $discount,
                    "price" => $price,
                    "amount" => $amount,
                    "desc" => $description
                );

                if(isset($_SESSION['selectedDatas']) && is_array($_SESSION['selectedDatas'])) {
                    $data = $_SESSION['selectedDatas'];
                } else {
                    $data = array();
                }

                $data[] = $rowData;

                $_SESSION['selectedDatas'] = $data;

            }else if(isset($_POST['payAmount'])){
                
                $inNo = isset($_POST['invNum']) ? $_POST['invNum'] : '';
                $lensType = isset($_POST['lensType']) ? $_POST['lensType'] : '';
                $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
                $coating = isset($_POST['coating']) ? $_POST['coating'] : '';
                $tint = isset($_POST['tint']) ? $_POST['tint'] : '';
                $design = isset($_POST['design']) ? $_POST['design'] : '';

                $payedAmount = $_POST['payAmount'];
                $inDate = isset($_POST['date']) ? $_POST['date'] : '';
                $payedType = isset($_POST['payType']) ? $_POST['payType'] : '';

                $rowData = array(
                    "date" => $inDate,
                    "type" => $payedType,
                    "amount" => $payedAmount,
                );

                if(isset($_SESSION['payeddDatas']) && is_array($_SESSION['payeddDatas'])) {
                    $data = $_SESSION['payeddDatas'];
                } else {
                    $data = array();
                }

                $data[] = $rowData;

                $_SESSION['payeddDatas'] = $data;

              // payed amount
                if (!isset($_SESSION['payedAmount'])) {
                    $_SESSION['payedAmount'] = 0;
                }

                // Convert $payedAmount to a number if it's a string
                $payedAmount = isset($payedAmount) ? floatval($payedAmount) : 0;

                // Add $payedAmount to the total payed amount
                $totPayed = $_SESSION['payedAmount'] + $payedAmount;

                // Update the total payed amount in the session
                $_SESSION['payedAmount'] = $totPayed;


            }if(isset($_POST['receiptPrint'])){

            require_once '../controllers/db.php';
            require_once '../controllers/invoiceController.php';
        
            // Initialize variables
            $jobNumber = isset($_SESSION['job_number']) ? $_SESSION['job_number'] : null;
            $itemData = isset($_SESSION['selectedDatas']) ? $_SESSION['selectedDatas'] : array();
            $paymentData = isset($_SESSION['payeddDatas']) ? $_SESSION['payeddDatas'] : array();
        
            // Call the function to save invoice details
            $saved = saveInvoiceDetails($conn, $jobNumber, $itemData, $paymentData);

            if($saved){
                echo '<script>alert("Done..!")</script>';
            }else{
                echo '<script>alert("Something went wrong..!")</script>';
            }
        }

        }

        



           


        
        ?>
        <h3 class="text-lg font-bold">Invoice</h3>
        <form id="invoiceForm" action="invoice.php" method="post">
            <div class="grid grid-cols-12 gap-2 ">
                <!-- First row -->
                <div class="col-span-12  p-1 ">

                    <div class="grid grid-cols-12 gap-2 ">

                    
                        <div class="  col-span-2 gap-2">
                            <label for="date" class="form-label text-xs font-medium text-center mt-2">Invo Date:</label>
                            <input type="date" class="form-control h-10 " id="date" name="date">
                            <?php 
                                if(!empty($inDate)){
                                    echo '<script>';
                                    echo 'document.getElementById("date").value="'.$inDate.'"';
                                    echo '</script>';
                                }
                            ?>
                        </div>

                        <div class="  col-span-2 gap-2">
                            <label for="jobNo" class="form-label text-xs font-medium text-center mt-2">Invo
                                No:</label>


                            <div class="flex mb-0 gap-1">
                                <input type="text" class="form-control h-10 " id="invNum" name="invNum">

                                <button
                                    class="form-label text-sm  font-bold text-center  p-2 text-black border-2 border-gray-200 bg-slate-400 rounded-sm hover:bg-gray-300">...</button>
                            </div>

                        </div>

                        <div class="  col-span-1 ">
                            <label for="lenseType" class="form-label text-xs font-medium text-center mt-2">Lense
                                Type:</label>
                            <select class="form-select h-10" id="lensType" name="lensType">
                                <option value="">Select an option</option> 
                                 <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option>
                            </select>
                        </div>

                        <div class="  col-span-1 ">
                            <label for="brand" class="form-label text-xs font-medium text-center mt-2">Brand</label>
                            <select class="form-select h-10" id="brand" name="brand">
                                 <option value="">Select an option</option> 
                                 <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option> 
                            </select>
                        </div>

                        <div class="  col-span-1 ">
                            <label for="coating" class="form-label text-xs font-medium text-center mt-2">Coating</label>
                            <select class="form-select h-10" id="coating" name="coating">
                                <!-- <option value="">Select an option</option> -->
                                <!-- <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option> -->
                            </select>
                        </div>

                        <div class="  col-span-2 ">
                            <label for="tint" class="form-label text-xs font-medium text-center mt-2">Tint</label>
                            <select class="form-select h-10" id="tint" name="tint">
                                <!-- <option value="">Select an option</option> -->
                                <!-- <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option> -->
                            </select>
                        </div>

                        <div class="  col-span-2 ">
                            <label for="design" class="form-label text-xs font-medium text-center mt-2">Design</label>
                            <select class="form-select h-10" id="design" name="design">
                                <!-- <option value="">Select an option</option> -->
                                <!-- <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option>
                                    <option value="SELECTION">SELECTION</option> -->
                            </select>
                        </div>

                        <div class="  col-span-1 gap-2">
                            <button
                                class="form-label text-xs  font-bold text-center  p-2 text-gray-700 border-2 border-gray-200 bg-slate-400 rounded-sm hover:bg-gray-300 w-full">Clear</button>


                            <button
                                class="form-label text-xs  font-bold text-center  p-2 text-gray-700 border-2 border-gray-200 bg-slate-400 rounded-sm hover:bg-gray-300 w-full">Add</button>


                        </div>

                    </div>
                </div>

                <!-- Second row -->
                <div class="col-span-12  p-1 ">

                    <div class="grid grid-cols-12 gap-2 ">

                        <div class="  col-span-2 gap-2">
                            <div class="flex items-center ">
                                <input type="text" class="form-control bg-white rounded-full shadow-xl" id="itemKeyword" name="itemKeyword"
                                    placeholder="Search Item ">
                                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="searchItem">
                                    <i class="fa-solid fa-notes-medical"></i> </button>
                            </div>
                        </div>

                        <div class="flex  col-span-2 gap-1">
                            <label for="itemCode" class="form-label text-xs font-medium text-center mt-2">Item
                                Code</label>
                                <select class="form-select h-10" id="itemCode" name="itemCode" onchange="updateInputs(this)">
                                    <?php
                                    if ($itemResult != null) {
                                        foreach ($itemResult as $item) {
                                            echo '<option value="' . $item['code'] . '" data-price="' . $item['salePrice'] . '" barcode="' . $item['barcode'] . '" data-description="' . $item['description'] . '">' . $item['code'] . '</option>';
                                            }
                                    }
                                    ?>
                                </select>

                        

                        </div>

                        <div class=" flex col-span-2 gap-1">
                            <label for="bar" class="form-label text-xs font-medium text-center mt-2">Bar</label>
                            <input type="text" class="form-control h-10" id="bar" name="bar">
                        </div>

                        <div class=" flex col-span-3 gap-1">
                            <label for="item" class="form-label text-xs font-medium text-center mt-2">Item </label>
                            <input type="text" class="form-control h-10" id="item" name="item">
                        </div>

                        <div class=" flex col-span-3 ">
                            <label for="coating" class="form-label text-xs font-medium text-center mt-2">Display On
                                Bill</label>
                            <select class="form-select h-10" id="code" name="code">
                                <!-- <option value="">Select an option</option> -->
                                <!-- <option value="SELECTION">SELECTION</option>
                                <option value="SELECTION">SELECTION</option>
                                <option value="SELECTION">SELECTION</option> -->
                            </select>
                        </div>


                        <input type="hidden" id="dataArrayInput" name="dataArrayInput" value="">
                        <?php 
                        echo '<script>';
                        echo 'var datas = '.$jsonData.';';
                        echo 'document.getElementById("dataArrayInput").value = JSON.stringify(datas);';
                        echo '</script>';
                        
                        ?> 


                    </div>
                </div>

                <!-- Third row -->
                <div class="col-span-12  p-1 mt-2">


                    <div class="grid grid-cols-12 gap-4 mt-1">


                        <!-- 1st col -->
                        <div class="  col-span-6 ">


                            <div class="grid grid-cols-12 gap-2 ">

                                <div class="  col-span-3 gap-1">
                                    <label for="qty" class="form-label text-xs font-medium text-center mt-2">QTY
                                    </label>
                                    <input type="text" class="form-control h-10" id="qty" name="qty">

                                </div>

                                <div class="  col-span-2 gap-1">
                                    <label for="price" class="form-label text-xs font-medium text-center mt-2">Price
                                    </label>
                                    <input type="text" class="form-control h-10" id="price" name="price">
                                    
                                </div>

                                <div class="  col-span-2 gap-1">
                                    <label for="discount"
                                        class="form-label text-xs font-medium text-center mt-2">Discount</label>
                                    <input type="text" class="form-control h-10" id="discount" name="discount" >
                                </div>

                                <div class="  col-span-3 gap-1">
                                    <label for="disAmount"
                                        class="form-label text-xs font-medium text-center mt-2">Discount Amount
                                    </label>
                                    <input type="text" class="form-control h-10" id="disAmount" name="disAmount"
                                        >
                                </div>

                                <div class="  col-span-2 gap-1">
                                    <label for="amount" class="form-label text-xs font-medium text-center mt-2"> Amount
                                    </label>
                                    <input type="text" class="form-control h-10" id="amount" name="amount">
                                </div>

                                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="addItem">
                                    <i class="fa-solid fa-notes-medical"></i> </button>

                            </div>
                            

                            <div class="grid grid-cols-12 gap-2 mt-3">

                                <div class="  col-span-5 gap-1  border-2 border-gray-200 p-1">
                                    <label class="form-label text-sm font-bold text-center mt-2">Total
                                    </label>
                                    <div>
                                        <div class="flex mt-2 gap-1 ">
                                            <label for="total" class="font-semibold text-xs">Bill Total Rs:</label>
                                            <div type="text" class="form-control h-8 p-1 text-end" ><span class="font-semibold text-lg text-red-600" id="totBill">
                                                <?php
                                                if (isset($_SESSION['billAmount'])) {
                                                    $billAmount = $_SESSION['billAmount'];
                                                    echo $billAmount;
                                                } 
                                                
                                                ?>
                                            </span></div>

                                        </div>

                                        <div class="flex mt-2 gap-1">
                                            <label for="dis" class="font-semibold text-xs text-center">Discount:</label>
                                            <div type="text" class="form-control h-8 p-1 text-end" ><span class="font-semibold text-lg text-red-600">
                                            <?php
                                                if (isset($_SESSION['discount'])) {
                                                    $discount = $_SESSION['discount'];
                                                    echo $discount;
                                                } 
                                                
                                                ?>
                                            </span></div>

                                        </div>

                                        <div class="flex mt-2 gap-1">
                                            <label for="payable" class="font-semibold text-xs">Payable:</label>
                                            <div type="text" class="form-control h-8 p-1 text-end" ><span class="font-semibold text-lg text-red-600">
                                            <?php

                                                $tot;
                                                $dis;
                                                if (isset($_SESSION['discount'])) {
                                                    $dis = $_SESSION['discount'];
                                                }
                                                  
                                                if (isset($_SESSION['billAmount'])) {
                                                $tot = $_SESSION['billAmount'];
                                                }
                                                
                                                echo $tot - $dis;
                                                ?>
                                            </span></div>

                                        </div>

                                        <div class="flex mt-2 gap-1">
                                            <label for="paid" class="font-semibold text-xs">Paid:</label>
                                            <div type="text" class="form-control h-8 p-1 text-end" ><span class="font-semibold text-lg text-red-600">
                                            <?php
                                                if (isset($_SESSION['payedAmount'])) {
                                                    $amount = $_SESSION['payedAmount'];
                                                    echo $amount;
                                                } 
                                                
                                                ?>
                                            </span></div>

                                        </div>

                                        <div class="flex mt-2 gap-1">
                                            <label for="dueBalnce" class="font-semibold text-xs">Due Balance:</label>
                                            <div type="text" class="form-control h-8 p-1 text-end" ><span class="font-semibold text-lg text-red-600">
                                            <?php

                                                $tot;
                                                $dis;
                                                $toPay;
                                                $payed;

                                                if (isset($_SESSION['discount'])) {
                                                    $dis = $_SESSION['discount'];
                                                }
                                                
                                                if (isset($_SESSION['billAmount'])) {
                                                    $tot = $_SESSION['billAmount'];
                                                }

                                                if (isset($_SESSION['payedAmount'])) {
                                                    $payed = $_SESSION['payedAmount'];
                                                }

                                                $toPay = $tot - $dis;
                                                
                                                if($toPay > $payed){
                                                    echo $toPay - $payed;
                                                }else{
                                                    echo 0.00;
                                                }


                                            ?>
                                            </span></div>

                                        </div>
                                    </div>

                                </div>

                                <div class="  col-span-7 gap-1">

                                    <!-- cash -->
                                    <div class="bg-gray-300 p-2 rounded-md">
                                        <label class="text-sm font-semibold">Pay Mode</label>
                                        <div>
                                        <label class="text-xs font-semibold">Rs</label>
                                        <input type="text" class="form-control h-8" id="payAmount" name="payAmount">
                                        </div>
                                        

                                    </div>

                                    <!-- pay mode -->
                                    <div class="p-2 bg-gray-300 mt-4 rounded-md">
                                        <label class="text-sm font-semibold">Pay Mode</label>

                                        <div class="flex gap-3">
                                        <div class="">
                                            <input type="radio" id="cash" name="payType" value="cash"
                                                class="mr-2 font-semibold ">
                                            <label for="cash" class="font-semibold text-sm">Cash</label>
                                        </div>

                                        <div>
                                            <input type="radio" id="cheque" name="payType" value="cheque"
                                                class="mr-2 font-semibold ">
                                            <label for="cheque" class="font-semibold text-sm">Cheque</label>
                                        </div>

                                        <div>
                                            <input type="radio" id="transfer" name="payType" value="cardOrTransfer"
                                                class="mr-2 font-semibold ">
                                            <label for="transfer" class="font-semibold text-sm">Card/Transfer</label>
                                        </div>
                                        </div>

                                    </div>

                                </div>



                            </div>

                        </div>





                        <!-- 2nd col -->
                        <div class="  col-span-6 gap-2">
                            <div class=" mt-3">
                                <label class="form-label text-xs font-bold text-black mt-2">Soled Item</label>
                                <div class="grid grid-cols-12 gap-3">
                                    <div class="col-span-9">
                                        <table id="TableHighlight" class="table table-bordered custom-table font-normal">
                                            <thead class="text-xs">
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>

                                                    <th>Discount</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs">
                                                <?php 
                                                 if (isset($_SESSION['selectedDatas'])) {
                                                    $data = $_SESSION['selectedDatas'];
                                                
                                                    // Check if $data is a string, convert it to an array if necessary
                                                    if (is_string($data)) {
                                                        $data = json_decode($data, true); // Assuming 'selectedDatas' is stored as JSON
                                                    }
                                                
                                                    // Check if $data is now an array
                                                    if (is_array($data)) {
                                                        foreach($data as $index => $row) {  
                                                            echo "<tr>";
                                                            echo "<td>" . $row['code'] . "</td>";
                                                            echo "<td>" . $row['desc'] . "</td>";
                                                            echo "<td>" . $row['price'] . "</td>";
                                                            echo "<td>" . $row['qty'] . "</td>";
                                                            echo "<td>" . $row['disc'] . "</td>";
                                                            echo "<td>" . $row['amount'] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    } 
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-span-2 ">
                                        <button type="submit"
                                            class="bg-yellow-500 justify-end  text-white font-semibold p-2"
                                            name="submit">Delete[Cash]</button>
                                    </div>
                                </div>

                            </div>


                            <div class=" mt-3">
                                <label class="form-label text-xs font-bold text-black mt-2">Cash Received</label>
                                <div class="grid grid-cols-12 gap-3">
                                    <div class="col-span-9">
                                        <table id="TableHighlight" class="table table-bordered custom-table font-normal mt-2 w-full h-32">
                                            <thead class="text-xs">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Pay Type</th>
                                                    <th>Paid</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs">
                                                <?php
                                                 if (isset($_SESSION['payeddDatas'])) {
                                                    $data = $_SESSION['payeddDatas'];
                                                
                                                    // Check if $data is a string, convert it to an array if necessary
                                                    if (is_string($data)) {
                                                        $data = json_decode($data, true); // Assuming 'selectedDatas' is stored as JSON
                                                    }
                                                
                                                    // Check if $data is now an array
                                                    if (is_array($data)) {
                                                        foreach($data as $index => $row) {  
                                                            echo "<tr>";
                                                            echo "<td>" . ($index + 1) . "</td>";
                                                            echo "<td>" . $row['date'] . "</td>";
                                                            echo "<td>" . $row['type'] . "</td>";
                                                            echo "<td>" . $row['amount'] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    } 
                                                }
                                                
                                                ?>



                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-span-2 ">
                                        <button type="submit"
                                            class="bg-yellow-500 justify-end  text-white font-semibold p-2"
                                            name="submit">Delete[Cash]</button>
                                    </div>
                                </div>
                            </div>


                        </div>





                        <!-- end 2 6 col -->
                    </div>


                </div>
            </div>

                <!-- ==================================================================================================== -->

                <div class="grid grid-cols-12 gap-2 mt-5">
                    <div class="col-span-3">

                    </div>
                    <div class="col-span-9 text-end justify-self-end">
                        <div class="mb-3 gap-3">
                            <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-32 text-sm" name="submit">Patient Register</button>
                            <button type="submit" class="bg-white text-blue-700 border-2 border-blue-700 p-1 font-semibold w-24" name="receiptPrint">Print(Reci)</button>
                            <button type="submit" class="bg-white text-blue-700 border-2 border-blue-700 p-1 font-semibold w-24"
                                name="invoicePrint">Print(Invo)</button>
                                <button type="submit" class="bg-white text-blue-700 border-2 border-blue-700 p-1 font-semibold w-24"
                                name="invPresPrint">Invo+Presc</button>
                            <button type="submit" class="bg-black text-white p-2 font-semibold w-24" name="sms">SMS
                                </button>
                            <button type="submit" class="bg-green-500 text-white p-2 font-semibold w-24"
                                onclick="clearForm()">Clear</button>
                           
                        </div>
                    </div>
                </div>

        </form>
    </div>



    <script>

        const qtyInput = document.getElementById('qty');
        const priceInput = document.getElementById('price');
        const amountInput = document.getElementById('amount');
        const discountInput = document.getElementById('discount');
        const discountAmountInput = document.getElementById('disAmount');


        qtyInput.addEventListener('input', function() {
            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
     
            const amount = qty * price;
     
            amountInput.value = amount.toFixed(2);
        });

        discountInput.addEventListener('input', function(){
            const discount = parseFloat(discountInput.value) || 0;
            const fullAmount = parseFloat(amountInput.value) || 0;

            const discountTotal = (fullAmount*discount)/100;
           // const newTotal = amountInput - (fullAmount*discount)/100;

            discountAmountInput.value = discountTotal.toFixed(2);
           // amountInput.value = newTotal.toFixed(2);           
        });

        function updateInputs(select) {
            var selectedIndex = select.selectedIndex;
            var price = select.options[selectedIndex].getAttribute('data-price');
            var description = select.options[selectedIndex].getAttribute('data-description');
            var barcode = select.options[selectedIndex].getAttribute('barcode');
            
            document.getElementById('bar').value = barcode;
            document.getElementById('item').value = description;
            document.getElementById('price').value = price;
        }

        function clearForm() {
            document.getElementById("prescriptionForm").reset();
        }

        function exit() {
            window.location.href = "index.php";
        }

        document.addEventListener("DOMContentLoaded", function () {
        var tableRows = document.querySelectorAll("#TableHighlight tbody tr");

        tableRows.forEach(function (row) {
            row.addEventListener("click", function () {
                tableRows.forEach(function (r) {
                    r.classList.remove("bg-gray-300");
                });

                row.classList.add("bg-gray-300");
            });
        });
    });


    </script>
</body>

</html>