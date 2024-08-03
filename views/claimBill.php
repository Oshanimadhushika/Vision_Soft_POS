<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Claim Bill</title>


</head>

<body class=" ">
    <div class="container bg-white p-3 w-full">

        <div class="row  ">

            <div class="col-md-6">
                <h3>Claim <span class="text-warning">Bill</span></h3>
            </div>


        </div>

        <?php

        session_start();

                    require_once '../controllers/db.php';
                    require_once '../controllers/claimBillController.php';
                    $lastInvoiceNumber = getlastInvoice($conn);
                    $lastInvoiceNum = $lastInvoiceNumber+1;
        
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['searchItemOne'])) {
                    $date = $_POST['date'];
                    $nameOne = $_POST['nameOne'];
                    $nameTwo = $_POST['nameTwo'];
                    $idNo = $_POST['idNo'];
                    $contact = $_POST['contactNo'];
                    $address = $_POST['address'];

                    $descOne = $_POST['descriptionOne'];
                    $descTwo = $_POST['descriptionTwo'];
                    $descThree = $_POST['descriptionThree'];
                    $qtyTwo = $_POST['qtyTwo'];
                    $qtyThree = $_POST['qtyThree'];
                    $amountTwo = $_POST['amountTwo'];
                    $amountThree = $_POST['amountThree'];

                    $keyword = $_POST['itemOne'];

                    require_once '../controllers/db.php';
                    require_once '../controllers/itemController.php';

                    $itemResultOne = searchItemById($conn, $keyword);

                    foreach($itemResultOne as $item){
                        $_SESSION['itemOne'] = $item;
                    }
                            
                }else if (isset($_POST['searchItemTwo'])) {
                    $date = $_POST['date'];
                    $nameOne = $_POST['nameOne'];
                    $nameTwo = $_POST['nameTwo'];
                    $idNo = $_POST['idNo'];
                    $contact = $_POST['contactNo'];
                    $address = $_POST['address'];

                    $descOne = $_POST['descriptionOne'];
                    $descThree = $_POST['descriptionThree'];
                    $qtyOne = $_POST['qtyOne'];
                    $qtyThree = $_POST['qtyThree'];
                    $amountOne = $_POST['amountOne'];
                    $amountThree = $_POST['amountThree'];

                    $keyword = $_POST['itemTwo'];

                    require_once '../controllers/db.php';
                    require_once '../controllers/itemController.php';

                    $itemResultTwo = searchItemById($conn, $keyword);

                    foreach($itemResultTwo as $item){
                        $_SESSION['itemTwo'] = $item;
                    }
                            
                }else if (isset($_POST['searchItemThree'])) {
                    $date = $_POST['date'];
                    $nameOne = $_POST['nameOne'];
                    $nameTwo = $_POST['nameTwo'];
                    $idNo = $_POST['idNo'];
                    $contact = $_POST['contactNo'];
                    $address = $_POST['address'];

                    $descOne = $_POST['descriptionOne'];
                    $descTwo = $_POST['descriptionTwo'];
                    $qtyOne = $_POST['qtyOne'];
                    $qtyTwo = $_POST['qtyTwo'];
                    $amountOne = $_POST['amountOne'];
                    $amountTwo = $_POST['amountTwo'];

                    $keyword = $_POST['itemThree'];

                    require_once '../controllers/db.php';
                    require_once '../controllers/itemController.php';

                    $itemResultThree = searchItemById($conn, $keyword);

                    foreach($itemResultThree as $item){
                        $_SESSION['itemThree'] = $item;
                    }
                            
                }else if (isset($_POST['save'])) {
                    $date = $_POST['date'];
                    $nameOne = $_POST['nameOne'];
                    $nameTwo = $_POST['nameTwo'];
                    $idNo = $_POST['idNo'];
                    $contact = $_POST['contactNo'];
                    $address = $_POST['address'];
                    $itemOne = $_POST['hdnOne'];
                    $itemTwo = $_POST['hdnTwo'];
                    $itemThree = $_POST['hdnThree'];

                    $descOne = $_POST['descriptionOne'];
                    $descTwo = $_POST['descriptionTwo'];
                    $descThree = $_POST['descriptionThree'];
                    $qtyOne = $_POST['qtyOne'];
                    $qtyTwo = $_POST['qtyTwo'];
                    $qtyThree = $_POST['qtyThree'];
                    $amountOne = $_POST['amountOne'];
                    $amountTwo = $_POST['amountTwo'];
                    $amountThree = $_POST['amountThree'];
                    $note = $_POST['note'];
                    $gross = $_POST['grossAmount'];
                    $discount = $_POST['disAmount'];
                    $net = $_POST['netAmount'];

                    require_once '../controllers/db.php';
                    require_once '../controllers/claimBillController.php';

                    $saved = saveClaim($conn, $date, $nameOne, $nameTwo, $idNo, $contact, $address, $itemOne, $itemTwo, $itemThree, $descOne, $descTwo, $descThree, $qtyOne, $qtyTwo, $qtyThree, $amountOne, $amountTwo, $amountThree, $note, $gross, $discount, $net);

                }
            }
        
        
        ?>

        <!-- ======================================================================================================== -->
        <form id="claimBillForm" action="claimBill.php" method="post" class="p-1">
            <!-- 1st row -->
            <div class="col-span-12  border-2 border-gray-300">
                <div class="grid grid-cols-12 gap-4 p-2">

                <div class=" col-span-6">
                    <div class="flex gap-1">
                    <label for="invoNo" class="form-label text-xs font-medium text-center ">Invo No:</label>
                        <input type="text" class="form-control h-6" id="invoNo" name="invoNo">
                        <?php
                         echo '<script>';
                         echo 'document.getElementById("invoNo").value="'.$lastInvoiceNum.'"';
                         echo '</script>'; 
                        ?>
                        <div>
                        <label for="invoNo" class="form-label text-xs font-bold text-red-600 text-center ">Press Enter</label>
                            
                        </div>

                    </div>

                    <div class="flex col-span-4 mt-1 gap-1">
                       <label for="jobNo" class="form-label text-xs font-medium text-center ">Job No:</label>
                        <input type="text" class="form-control h-6" id="jobNo" name="jobNo">
                        <?php
                         echo '<script>';
                         echo 'document.getElementById("jobNo").value="'.$lastInvoiceNum.'"';
                         echo '</script>'; 
                        ?>
                    </div>

                    <div class="flex mt-1 gap-1">
                       <label for="date" class="form-label text-xs font-medium text-center mt-1 ">Date:</label>
                        <input type="date" class="form-control h-6" id="date" name="date">
                        <?php
                                 if(!empty($date)){
                                    echo '<script>';
                                    echo 'document.getElementById("date").value="'.$date.'"';
                                    echo '</script>';
                                }                          
                            ?>

                    </div>
                       
                    </div>

                    <!-- 2nd col -->
                    <div class=" col-span-6">

                        <div class="flex gap-1">
                            <label for="invoNo" class="form-label text-xs font-medium text-center ">Name:</label>
                            <input type="text" class="form-control h-6" id="nameOne" name="nameOne">
                            <input type="text" class="form-control h-6" id="nameTwo" name="nameTwo">
                            <?php
                                 if(!empty($nameOne)){
                                    echo '<script>';
                                    echo 'document.getElementById("nameOne").value="'.$nameOne.'"';
                                    echo '</script>';
                                }                    
                                if(!empty($nameTwo)){
                                    echo '<script>';
                                    echo 'document.getElementById("nameTwo").value="'.$nameTwo.'"';
                                    echo '</script>';
                                }                          
                            ?>

                        </div>

                        <div class="flex mt-1">
                            <div class="flex gap-1">
                            <label for="idNo" class="form-label text-xs font-medium text-center ">Id No:</label>
                            <input type="text" class="form-control h-6" id="idNo" name="idNo">
                            <?php
                                 if(!empty($idNo)){
                                    echo '<script>';
                                    echo 'document.getElementById("idNo").value="'.$idNo.'"';
                                    echo '</script>';
                                }                          
                            ?>
                            </div>

                            <div class="flex gap-1">
                            <label for="contactNo" class="form-label text-xs font-medium text-center ">Contact No:</label>
                            <input type="text" class="form-control h-6" id="contactNo" name="contactNo">
                            <?php
                                 if(!empty($contact)){
                                    echo '<script>';
                                    echo 'document.getElementById("contactNo").value="'.$contact.'"';
                                    echo '</script>';
                                }                          
                            ?>
                            </div>
                        </div>

                        <div class="flex gap-1 mt-1">
                            <label for="address" class="form-label text-xs font-medium text-center ">Address:</label>
                            <input type="text" class="form-control h-6" id="address" name="address">
                            <?php
                                 if(!empty($address)){
                                    echo '<script>';
                                    echo 'document.getElementById("address").value="'.$address.'"';
                                    echo '</script>';
                                }                          
                            ?>
                        </div>

                    
                    </div>


                    <input type="hidden" id="hdnOne" name="hdnOne">
                    <input type="hidden" id="hdnTwo" name="hdnTwo">
                    <input type="hidden" id="hdnThree" name="hdnThree">
                    <?php

                            $one = $_SESSION['itemOne'];
                                 if(!empty($one)){
                                    echo '<script>';
                                    echo 'document.getElementById("hdnOne").value="'.$one['code'].'"';
                                    echo '</script>';
                            }      
                                
                            $two = $_SESSION['itemTwo'];
                            if(!empty($two)){
                                echo '<script>';
                                echo 'document.getElementById("hdnTwo").value="'.$two['code'].'"';
                                echo '</script>';
                            } 
                            
                            $three = $_SESSION['itemThree'];
                            if(!empty($three)){
                                echo '<script>';
                                echo 'document.getElementById("hdnThree").value="'.$three['code'].'"';
                                echo '</script>';
                            } 
                                                        
                            ?>

                </div>
            </div>


            <!-- 2nd row -->
            <div class="col-span-12 gap-4">
                <div class="grid grid-cols-12 gap-4 p-2">
                    <div class="col-span-3">
                        <label for="description"
                            class="form-label text-xs font-medium text-center mt-2">Description:</label>
                            <input type="text" class="form-control h-6 mt-1" id="descriptionOne" name="descriptionOne">
                            <input type="text" class="form-control h-6 mt-1" id="descriptionTwo" name="descriptionTwo">
                            <input type="text" class="form-control h-6 mt-1" id="descriptionThree" name="descriptionThree">
                            <?php

                            $one = $_SESSION['itemOne'];
                                 if(!empty($one)){
                                    echo '<script>';
                                    echo 'document.getElementById("descriptionOne").value="'.$one['description'].'"';
                                    echo '</script>';
                            }      
                                
                            $two = $_SESSION['itemTwo'];
                            if(!empty($two)){
                                echo '<script>';
                                echo 'document.getElementById("descriptionTwo").value="'.$two['description'].'"';
                                echo '</script>';
                            } 
                            
                            $three = $_SESSION['itemThree'];
                            if(!empty($three)){
                                echo '<script>';
                                echo 'document.getElementById("descriptionThree").value="'.$three['description'].'"';
                                echo '</script>';
                            } 
                                                        
                            ?>
                    </div>

                    <div class="col-span-3">
                        <label for="description" class="form-label text-xs font-medium text-center mt-2">Search
                            Item:</label>
                        <div class="flex items-center">
                            <input type="text" class="form-control rounded-full shadow-xl p-2 h-6" id="itemOne" name="itemOne"
                                placeholder="">
                            <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700 " id="searchItemOne" name="searchItemOne">
                                <i class="fa-solid fa-notes-medical"></i>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <input type="text" class="form-control rounded-full shadow-xl p-2 h-6" id="itemTwo" name="itemTwo"
                                placeholder="">
                            <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700" id="searchItemTwo" name="searchItemTwo">
                                <i class="fa-solid fa-notes-medical"></i>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <input type="text" class="form-control rounded-full shadow-xl p-2 h-6" id="itemThree" name="itemThree"
                                placeholder="">
                            <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700" id="searchItemThree" name="searchItemThree">
                                <i class="fa-solid fa-notes-medical"></i>
                            </button>
                        </div>
                    </div>


                    <div class="col-span-3">
                        <label for="qty" class="form-label text-xs font-medium text-center mt-2">Qty:</label>
                        <input type="text" class="form-control h-6 " id="qtyOne" name="qtyOne" >
                        <input type="text" class="form-control h-6 mt-1" id="qtyTwo" name="qtyTwo" >
                        <input type="text" class="form-control h-6 mt-1" id="qtyThree" name="qtyThree" >

                        <?php
                            $one = $_SESSION['itemOne'];
                                 if(!empty($one)){
                                    echo '<script>';
                                    echo 'document.getElementById("qtyOne").value="'.$one['maxStockQty'].'"';
                                    echo '</script>';
                                }    
                                
                                $two = $_SESSION['itemTwo'];
                                if(!empty($two)){
                                    echo '<script>';
                                    echo 'document.getElementById("qtyTwo").value="'.$two['maxStockQty'].'"';
                                    echo '</script>';
                                } 
                                
                                $three = $_SESSION['itemThree'];
                                if(!empty($three)){
                                    echo '<script>';
                                    echo 'document.getElementById("qtyThree").value="'.$three['maxStockQty'].'"';
                                    echo '</script>';
                                } 
                                                        
                            ?>

                    </div>

                    <div class="col-span-3">
                        <label for="amount" class="form-label text-xs font-medium text-center mt-2">Amount:</label>
                        <input type="text" class="form-control h-6 " id="amountOne" name="amountOne" >
                        <input type="text" class="form-control h-6 mt-1" id="amountTwo" name="amountTwo" >
                        <input type="text" class="form-control h-6 mt-1" id="amountThree" name="amountThree" >

                        <?php
                            $one = $_SESSION['itemOne'];
                                 if(!empty($one)){
                                    echo '<script>';
                                    echo 'document.getElementById("amountOne").value="'.$one['salePrice'].'"';
                                    echo '</script>';
                                }    
                                
                                $two = $_SESSION['itemTwo'];
                                if(!empty($two)){
                                    echo '<script>';
                                    echo 'document.getElementById("amountTwo").value="'.$two['salePrice'].'"';
                                    echo '</script>';
                                } 
                                
                                $three = $_SESSION['itemThree'];
                                if(!empty($three)){
                                    echo '<script>';
                                    echo 'document.getElementById("amountThree").value="'.$three['salePrice'].'"';
                                    echo '</script>';
                                } 
                                                        
                            ?>
                    </div>



                </div>
            </div>

            <!-- 3d row -->
            <div class="col-span-12 gap-4">
                <div class="grid grid-cols-12 gap-4 p-2">


                    <div class="col-span-7">

                    </div>


                    <div class="col-span-5">

                        <div class="flex mt-1">
                            <label for="grossAmount" class="font-semibold text-black text-xs">Gross Amount:</label>
                            <input type="text" class="form-control h-6 ml-2" id="grossAmount" name="grossAmount"
                                >

                        </div>

                        <div class="flex mt-1">
                            <label for="disAmount" class="font-semibold text-black text-xs">Discount Amount:</label>
                            <input type="text" class="form-control h-6 ml-2" id="disAmount" name="disAmount" >

                        </div>

                        <div class="flex mt-1 ">
                            <label for="netAmount" class="font-semibold text-black text-xs">Net Amount:</label>
                            <input type="text" class="form-control h-6 ml-2" id="netAmount" name="netAmount" >

                        </div>
                    </div>





                </div>
            </div>

              <!-- 4th row -->
              <div class="col-span-12 ">
                <div class="grid grid-cols-12  p-1">

                        <div class=" col-span-12 ">
                            <label for="note" class="font-semibold text-black text-xs">Notes [Max Length 4000]:</label>
                            <input type="text" class="form-control h-14 w-full " id="note" name="note"
                                >

                        </div>

                </div>
            </div>


            <!-- 5th row -->
            <div class="col-span-12 gap-4">
                <div class="grid grid-cols-12 gap-4 p-2">
                    <div class="col-span-6">
                        <label class="form-label text-xs  text-red-600 font-bold text-center mt-2">Invoice
                            Search:</label>
                        <div class="flex items-center">
                            <input type="text" class="form-control rounded-full shadow-xl p-2 h-8" id="search"
                                placeholder="Search">
                            <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700">
                                <i class="fa-solid fa-notes-medical"></i>
                            </button>
                        </div>

                    </div>

                    <div class="col-span-6">
                        <label class="form-label text-xs  text-red-600 font-bold text-center mt-2">Customer
                            Search:</label>

                        <div class="flex items-center">
                            <input type="text" class="form-control rounded-full shadow-xl p-2 h-8" id="search"
                                placeholder="Search ">
                            <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700">
                                <i class="fa-solid fa-notes-medical"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
    

    <!-- ================================================================================================================== -->
    <div class="row mt-2">
        <div class="col-span-12">
            <div class="mb-3 d-flex justify-content-end gap-3">
                <button type="submit" class="border-2 border-black text-black bg-white p-2 font-semibold w-32"
                    name="submit">SMS</button>
                <button type="submit" class="bg-blue-600 text-white p-1 font-semibold w-32" name="save">Save</button>
                <button type="submit" class="bg-green-600 text-white p-1 font-semibold w-32" name="submit">Bill
                    Print</button>
                <button type="button" class="bg-yellow-500 text-white p-1 font-semibold w-32"
                    onclick="clearForm()">Clear</button>
                <button type="submit" class="bg-red-500 text-white p-1 font-semibold w-32" name="submit">Delete</button>
                <button type="submit" class="bg-black text-white p-1 font-semibold w-32" onclick="exit()"
                    name="submit">Exit</button>
            </div>
        </div>
    </div>
    </form>
    <!-- ======================================================================================================== -->












    </div>

    <script>

        const amountOneInput = document.getElementById('amountOne');
        const amountTwoInput = document.getElementById('amountTwo');
        const amountThreeInput = document.getElementById('amountThree');
        const grossAmountInput = document.getElementById('grossAmount');
        const discountInput = document.getElementById('disAmount');
        const netAmountInput = document.getElementById('netAmount');

        discountInput.addEventListener('input', function() {
            // Get the values from the input fields
            const grossAmount = parseFloat(grossAmountInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            // Calculate the net amount
            const netAmount = grossAmount - discount;

            // Set the calculated net amount to the netAmount input field
            netAmountInput.value = netAmount.toFixed(2); // Use toFixed to format the number to two decimal places
        });

        
            const amountOne = parseFloat(amountOneInput.value) || 0;
            const amountTwo = parseFloat(amountTwoInput.value) || 0;
            const amountThree = parseFloat(amountThreeInput.value) || 0;

            // Calculate the total
            const totalAmount = amountOne + amountTwo + amountThree;

            // Update the grossAmount input field
            grossAmountInput.value = totalAmount.toFixed(2); // Ensure two decimal places
        
        amountOneInput.addEventListener('input', calculateTotal);
        amountTwoInput.addEventListener('input', calculateTotal);
        amountThreeInput.addEventListener('input', calculateTotal);

        


    function clearForm() {
        document.getElementById("claimBillForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>