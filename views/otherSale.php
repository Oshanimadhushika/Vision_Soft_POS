<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Other Sale</title>
</head>

<body>
    <div class="container bg-white p-4 w-full shadow-md">
        <?php

        session_start();
        $_SESSION['customerSearchResult'] = '';
        $_SESSION['payeddDatas'] = '';
        $_SESSION['itemSearchResult'] = '';
        $_SESSION['selectedData'] = '';
        $_SESSION['totalAmount'] = 0;
        $_SESSION['totalDiscount'] = 0;
        $_SESSION['payable'] = 0;
        $_SESSION['paid'] = 0;
        $_SESSION['balance'] = 0;



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['searchCustomer'])) {
                $searchKeyword = $_POST['customerSearchKeyword'];

                if(empty($searchKeyword)){
                    echo '<script>alert("Keyword should not be Empty..!")</script>';
                }else{
                    require_once '../controllers/db.php';
                    require_once '../controllers/customerController.php';
    
                    $result = searchCustomersByKeyword($conn, $searchKeyword);
                    $_SESSION['customerSearchResult'] = $result;



                }

            }else if (isset($_POST['searchItem'])) {
                $keyword = $_POST['itemSearchKeyword'];

                require_once '../controllers/db.php';
                require_once '../controllers/itemController.php';
                $searchResult = searchItemByKeyword($conn, $keyword);
                $_SESSION['itemSearchResult'] = $searchResult;

            }else if (isset($_POST['addItem'])) {
                $code = $_POST['code'];
                $description = $_POST['description'];
                $qty = $_POST['qty'];
                $unitPrice = $_POST['price'];
                $discount = $_POST['discount'];
                $amount = $_POST['amount'];

                // selected Data
                $rowData = array(
                    "code" => $code,
                    "qty" => $qty,
                    "disc" => $discount,
                    "price" => $unitPrice,
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


                //Total Amount
                if (!isset($_SESSION['totalAmount'])) {
                    $_SESSION['totalAmount'] = 0;
                }
                $total = $_SESSION['totalAmount'];
                $total += $qty * $unitPrice;
                $_SESSION['totalAmount'] = $total;


                //Total Discount
                if (!isset($_SESSION['totalDiscount'])) {
                    $_SESSION['totalDiscount'] = 0;
                }
                $dis = $_SESSION['totalDiscount'];
                $dis += $discount;
                $_SESSION['totalDiscount'] = $dis;


                $payable = $total - $dis;
                $_SESSION['payable'] = $payable;

            }else if(isset($_POST['savePayment'])) {
                $payedAmount = $_POST['savePayment'];
                $_SESSION['paid'] = $payedAmount;

                $balance = $_SESSION['payable'] - $payedAmount;
                $_SESSION['balance'] = $balance;

                

                $rowData = array(
                    "net" => $_SESSION['payable'],
                    "type" => "Cash",
                    "amount" => $payedAmount,
                    "balance" => $balance,
                );

                if(isset($_SESSION['payeddDatas']) && is_array($_SESSION['payeddDatas'])) {
                    $data = $_SESSION['payeddDatas'];
                } else {
                    $data = array();
                }

                $data[] = $rowData;

                echo var_dump($data);

                $_SESSION['payeddDatas'] = $data;
            }
        }



        
        ?>

        <div class="row mb-2">

            <div class="col-md-6">
                <h3>Other <span class="text-warning">Sale</span></h3>
            </div>

            <div class="col-md-6">
            <form id="otherSaleForm" action="otherSale.php" method="post">
                <div class="flex items-center ">
                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="customerSearchKeyword"  id="customerSearchKeyword"
                        placeholder="Search Customer ">
                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="searchCustomer">
                        <i class="fa-solid fa-notes-medical"></i> </button>
                </div>
                </form>



            </div>


        </div>

        <!-- ======================================================================================================== -->


        <form id="otherSalePage" action="otherSale.php" method="post">

            <div class="grid grid-cols-12 gap-2 ">
                <!-- First row -->
                <div class="col-span-12  p-3 border-2 border-gray-200">

                    <!-- 1st row 1st div -->
                    <div class="grid grid-cols-12 gap-4 ">


                        <div class="  col-span-3  ">
                            <label class="form-label text-xs font-medium">Search Item:</label>

                            <div class="flex items-center  ">

                                <input type="text" class="form-control bg-white rounded-full shadow-xl" id="itemSearchKeyword" name="itemSearchKeyword"
                                    placeholder="Search.. ">
                                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="searchItem">
                                    <i class="fa-solid fa-notes-medical"></i> </button>
                            </div>
                        </div>



                        <div class="  col-span-1 ">
                            <label for="invoiceNo" class="form-label text-xs font-medium">Invoice No:</label>
                            <input type="text" class="form-control h-10" id="invoiceNo" name="invoiceNo">
                        </div>

                        <div class="  col-span-2 ">
                            <label for="date" class="form-label text-xs font-medium text-center mt-2">Date:</label>
                            <input type="date" class="form-control h-10 " id="date" name="date">
                        </div>

                        <div class="  col-span-2 ">
                            <label for="cusNo" class="form-label text-xs font-medium">Customer No:</label>
                            <select class="form-select h-10" id="cusNo" name="cusNo">
                                <!-- <option value="">Select an option</option> -->
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        <div class="  col-span-4 gap-1 ">
                            <label for="cusName" class="form-label text-xs font-medium">Customer Name:</label>
                            <div class="flex">
                                <select class="form-select h-10" id="payType" name="payType">
                                    <!-- <option value="">Select an option</option> -->
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Online Transfer">Online Transfer</option>
                                </select>
                                <input type="text" class="form-control h-10" id="cusName" name="cusName">
                            </div>


                        </div>


                    </div>
                </div>


                <!-- Second row -->
                <div class="col-span-12  p-2  ">
                    <div class="grid grid-cols-12 gap-3 ">

                        <!-- second row 1st col -->

                        <div class="  col-span-3 p-2 text-start border-2 border-gray-200 ">

                            <div class="flex mt-3 ">
                                <label for="billTotal" class="font-semibold text-black text-xs">Bill Total:</label>
                                <input type="text" class="form-control h-8" id="billTotal" name="billTotal">

                                <?php
                                if($_SESSION['totalAmount']){
                                    echo '<script>';
                                    echo 'document.getElementById("billTotal").value="'.$_SESSION['totalAmount'].'"';
                                    echo '</script>';
                                }
                                    
                                ?>

                            </div>

                            <div class="flex mt-2 ">
                                <label for="discountRs" class="form-label text-black font-semibold text-xs">Dis
                                    Rs:</label>
                                <input type="text" class="form-control h-8" id="discountRs" name="discountRs">
                                <?php
                                if($_SESSION['totalDiscount']){
                                    echo '<script>';
                                    echo 'document.getElementById("discountRs").value="'.$_SESSION['totalDiscount'].'"';
                                    echo '</script>';
                                }
                                    
                                ?>

                            </div>

                            <div class="flex mt-2 ">
                                <label for="payableRs" class="font-semibold text-black text-xs">Payable Rs:</label>
                                <input type="text" class="form-control  h-8" id="payableRs" name="payableRs">
                                <?php
                                if($_SESSION['payable']){
                                    echo '<script>';
                                    echo 'document.getElementById("payableRs").value="'.$_SESSION['payable'].'"';
                                    echo '</script>';
                                }
                                    
                                ?>

                            </div>

                            <div class="flex mt-2 ">
                                <label for="paid" class="font-semibold text-black text-xs">Paid:</label>
                                <input type="text" class="form-control h-8 ml-2" id="paid" name="paid">

                            </div>

                            <div class="flex mt-3 ">
                                <label for="dueBalance" class="font-semibold text-black text-xs">Due Balance:</label>
                                <input type="text" class="form-control h-8 ml-2" id="dueBalance" name="dueBalance">

                            </div>

                        </div>

                        <!-- second row 2nd col -->

                        <div class="col-span-9  w-full p-2">
                            <!-- 1st row -->
                            <div class="grid grid-cols-12 gap-1 ">

                                <div class="col-span-2">
                                    <label for="code" class="form-label text-xs font-medium">Code:
                                    </label>
                                    <select class="form-select h-10" id="code" name="code" onchange="updateInputs(this)">
                                        <option value="">Select an option</option>
                                        <?php
                                        $itemResult = $_SESSION['itemSearchResult'];
                                    if ($itemResult != null) {
                                        foreach ($itemResult as $item) {
                                            echo '<option value="' . $item['code'] . '" data-price="' . $item['salePrice'] . '" barcode="' . $item['barcode'] . '" data-description="' . $item['description'] . '">' . $item['code'] . '</option>';
                                            }
                                    }
                                    ?>
                                    </select>
                                    <input type="text" class="form-control h-10" id="amount" name="amount">

                                </div>

                                <div class="col-span-4">
                                    <label for="description" class="form-label text-xs font-medium">Description:</label>
                                    <input type="text" class="form-control h-10" id="description" name="description">
                                </div>

                                <div class="col-span-2">
                                    <label for="qty" class="form-label text-xs font-medium">Qty:</label>
                                    <input type="text" class="form-control" id="qty" name="qty">
                                </div>

                                <div class="col-span-2">
                                    <label for="price" class="form-label text-xs font-medium">Price:</label>
                                    <input type="text" class="form-control" id="price" name="price">
                                </div>
                                <input type="hidden" class="form-control" id="actualAmount" name="actualAmount">

                                <div class="col-span-2 ">
                                    <label for="discount" class="form-label text-xs font-medium">Discount:</label>
                                    <input type="text" class="form-control w-full" id="discount" name="discount">
                                </div>

                                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="addItem">
                                <i class="fa-solid fa-notes-medical"></i> </button>

                                <!-- Table -->
                                <div class="col-span-12 mt-2">
                                    <div class="max-h-36 overflow-y-auto">

                                        <table class="table table-bordered custom-table">
                                            <thead class="text-xs">
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
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
                                </div>
                            </div>
                        </div>


                    </div>

                </div>


                <!-- 3rd row -->
                <div class="col-span-12  p-1 ">
                    <div class="grid grid-cols-12 gap-2 ">

                        <!-- second row 1st col -->

                        <div class="  col-span-3 p-2 text-start border-2 border-gray-200 h-30">
                            <label class="font-semibold text-sm flex justify-center text-center">Hold No</label>
                            <div class=" ">
                                <label for="billTotal" class="font-semibold text-sm">Payment:</label>
                                <input type="text" class="form-control h-8" id="savePayment" name="savePayment">
                            </div>
                        </div>

                        <!-- second row 2nd col -->

                        <div class="col-span-9  w-full ">
                            <!-- 1st row -->

                            <div class="max-h-36 overflow-y-auto">

                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>#</th>
                                            <th>Bill No</th>
                                            <th>Net</th>
                                            <th>Pay Type</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
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
                                                            echo "<td>" . $row['net'] . "</td>";
                                                            echo "<td>" . $row['type'] . "</td>";
                                                            echo "<td>" . $row['amount'] . "</td>";
                                                            echo "<td>" . $row['balance'] . "</td>";
                                                            echo "</tr>";
                                                        }
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


            <!-- ======================================================================================================================= -->
            <div class="grid grid-cols-12">


                <div class="col-span-12  text-end pt-1">
                    <div class=" gap-4">
                        <button type="submit"
                            class="bg-white text-black p-1 pl-2 pr-2 font-semibold border-2 border-black w-32"
                            name="submit">SMS
                        </button>
                        <button type="submit" class="bg-blue-600 text-white p-1  font-semibold ml-3 w-32"
                            name="submit">Print
                        </button>

                        <button type="submit" class="bg-black text-white p-1 font-semibold ml-3  w-32" onclick="exit()"
                            name="submit">Exit</button>
                    </div>
                </div>
            </div>
            <!-- ======================================================================================================== -->


        </form>

    </div>





    <script>

        function updateInputs(select) {
            var selectedIndex = select.selectedIndex;
            var price = select.options[selectedIndex].getAttribute('data-price');
            var description = select.options[selectedIndex].getAttribute('data-description');
            var barcode = select.options[selectedIndex].getAttribute('barcode');
            
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
                       
        }

        const qtyInput = document.getElementById('qty');
        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount');
        const actualAmountInput = document.getElementById('actualAmount');

         qtyInput.addEventListener('input', function() {
            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
     
            const amount = qty * price;
     
            document.getElementById('amount').value = amount;
            document.getElementById('actualAmount').value = amount;
        });


        discountInput.addEventListener('input', function() {
            const discount = parseFloat(discountInput.value) || 0;
            const total = parseFloat(actualAmountInput.value) || 0;
     
            const amount = total - discount;
     
            document.getElementById('amount').value = amount;
            //document.getElementById('actualAmount').value = amount;
        });

    function clearForm() {
        document.getElementById("otherSalePage").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>