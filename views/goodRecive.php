<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Purchasing Invoice</title>
</head>

<body>
    <div class="container bg-white p-4 w-full ">

    <?php

    require_once "../controllers/db.php";
    require_once "../controllers/supplierController.php";
    require_once "../controllers/goodReciveController.php";
    $data= null;
        
    //$supplierList = getAllSupplier($conn);

    $lastGrnNumber = getLastGrnNo($conn);
    $lastGrnNumber = $lastGrnNumber +1;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["search"])) {
        $keyword = $_POST["keyword"];
        $selectedDate = $_POST["date"];
        //$data = json_decode($_POST["dataArrayInput"], true);


    if(empty($keyword)){
        echo '<script>alert("Empty Field..!")</script>';
    } else {
        

        $supplierList = filterSupplier($conn, $keyword);

    }
    }else if(isset($_POST["searchItem"])){
        $keyword = $_POST["itemKeyword"];
        $selectedCmName = $_POST["companyName"];
        $selectedCmCode = $_POST["hdnSupCode"];
        $selectedDate = $_POST["date"];
        $enteredInvoiceNo = $_POST["invoiceNo"];
            
        if (isset($_POST["dataArrayInput"]) && !empty($_POST["dataArrayInput"])) {
            $data = json_decode($_POST["dataArrayInput"], true);
            $jsonData = json_encode($data);
        } else {
            echo "empty";
        }      
        

        if(empty($keyword)){
            echo '<script>alert("Empty Field..!")</script>';
        } else {
            require_once "../controllers/itemController.php";

            $itemList = searchItemByKeyword($conn, $keyword);

        }
    }else if(isset($_POST["saveGrn"])){
        $keyword = $_POST["itemKeyword"];
        $selectedCmName = $_POST["companyName"];
        $selectedCmCode = $_POST["hdnSupCode"];
        $selectedDate = $_POST["date"];
        $enteredInvoiceNo = $_POST["invoiceNo"];

        $data = json_decode($_POST["dataArrayInput"], true); 

        $code = $_POST["hdnItemCode"];
        $qty = $_POST["Qty"];
        $desc = $_POST["description"];
        $price = $_POST["price"];
        $discount = $_POST["discountRs"];
        $amount = $_POST["amount"];

        $rowData = array(
        "code" => $code,
        "qty" => $qty,
        "disc" => $discount,
        "price" => $price,
        "amount" => $amount,
        "desc" => $desc
    );

    $data[] = $rowData;
    $jsonData = json_encode($data);

    }else if(isset($_POST["saveAll"])){
        $selectedCmName = $_POST["companyName"];
        $selectedDate = $_POST["date"];
        $enteredInvoiceNo = $_POST["invoiceNo"];

        $data = json_decode($_POST["dataArrayInput"], true); 

        require_once "../controllers/itemController.php";

        $saved = saveGoodReciedData($conn, $selectedCmName, $selectedDate, $enteredInvoiceNo, $data);

        if($saved){
            echo '<script>alert("Saved Successfully..!..!")</script>';
        }else{
            echo '<script>alert("Something went wrong..!")</script>';
        }

    }else if(isset($_POST["searchGrn"])){
        
    }

    }

    ?>

    <div class="row mb-2">

    <div class="col-md-6">
        <h3>Purchasing <span class="text-warning">Invoice</span></h3>
    </div>

    <div class="col-md-6">
    <form id="goodRecivePage" action="goodRecive.php" method="post">    
    <div class="flex items-center ">
        <input type="text" class="form-control bg-white rounded-full shadow-xl" id="search"
                placeholder="Search Purchasing Invoice">
            <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="searchGrn">
                <i class="fa-solid fa-notes-medical"></i> </button>
                
        </div>
        </form>



</div>
</div>

<!-- ======================================================================================================== -->


<form id="goodRecivePage" action="goodRecive.php" method="post">
<div class="grid grid-cols-12 gap-2">
    <!-- First row -->
    <div class="col-span-12  p-3 border-2 border-gray-200">
        <label class="text-sm font-semibold">Our details</label>

        <div class="grid grid-cols-12 gap-4 mt-3">
            <div class=" flex col-span-6 gap-2">
                <label for="grnNo" class="form-label text-xs font-medium">Our No (GRN No):</label>
                <input type="text" class="form-control h-10" id="grnNo" name="grnNo" >
                <?php
                        echo '<script>';
                        echo 'document.getElementById("grnNo").value="'.$lastGrnNumber.'"';
                        echo '</script>';                        
                ?>
            </div>

            <div class=" flex col-span-6 gap-2">
                <label for="date" class="form-label text-xs font-medium text-center mt-2">Date:</label>
                <input type="date" class="form-control h-10 " id="date" name="date">
                <?php
                        echo '<script>';
                        echo 'document.getElementById("date").value="'.$selectedDate.'"';
                        echo '</script>';                        
                ?>
            </div>
        </div>
    </div>

    <!-- Second row -->
    <div class="col-span-12  p-3 border-2 border-gray-200">
        <label class="text-sm font-semibold">Company details</label>
        <div class="grid grid-cols-12 gap-4 ">
            <div class="  col-span-3 ">
            <div class="flex items-center mt-4">
                <input type="text" class="form-control bg-white rounded-full shadow-xl" id="keyword" name="keyword" placeholder="Search">
                <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" type="submit" id="searchButton" name="search">
                    <i class="fa-solid fa-notes-medical"></i>
                </button>
            </div>

            </div>

            <div class="  col-span-3 gap-2">
                <label for="companyCode" class="form-label text-xs font-medium text-center">Company Code:</label>
                    <select type="text" class="form-control h-8" id="supplier" name="supplier" onchange="updateCompanyName()">
                    <?php

                    //insert blocked option
                    if(!empty($supplierList)){

                        foreach ($supplierList as $supplier) {
                            // echo '<option value="' . $supplier['name'] . '">' . $supplier['code'] . '</option>';
                            echo '<option value="' . $supplier['name'] . '" data-id="' . $supplier['code'] . '">' . $supplier['code'] . '</option>';
                        }
                    }

                    if($selectedCmCode){
                        echo '<option value="' . $selectedCmCode . '">' . $selectedCmCode . '</option>';
                    }
                    
                    ?>

                </select>

                <input type="hidden" id="hdnSupCode" name="hdnSupCode" value="">
     
            </div>


            <div class="  col-span-3 gap-2">
                <label for="companyName" class="form-label text-xs font-medium text-center">Company
                    Name:</label>
                <input type="text" class="form-control h-8 " id="companyName" name="companyName">
                <?php
                    echo '<script>';
                    echo 'document.getElementById("companyName").value="'.$selectedCmName.'"';
                    echo '</script>';
                ?>
            </div>



            <div class="  col-span-3 gap-2">
                <label for="invoiceNo" class="form-label text-xs font-medium text-center ">Invoice
                    No:</label>
                <input type="text" class="form-control h-8 " id="invoiceNo" name="invoiceNo">
                <?php
                
                echo '<script>';
                echo 'document.getElementById("invoiceNo").value="'.$enteredInvoiceNo.'"';
                echo '</script>'; 
                                       
        ?>
            </div>
        </div>
    </div>

    <!-- Third row -->
    <div class="col-span-12 p-3 border-2 border-gray-200">
        <label class="text-sm font-semibold">Invoice details</label>

        <!-- First row with 7 columns -->
        <div class="grid grid-cols-12 gap-4 ">
            <div class="  col-span-2">
                <div class="flex items-center mt-4">
                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="itemKeyword" name="itemKeyword"
                        placeholder="Search...">
                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="searchItem" id="searchItem" onclick="searchItem()"  >
                        <i class="fa-solid fa-notes-medical"></i> </button>
                </div>
            </div>

            <div class="  col-span-2 ">
                <label for="itemCode" class="form-label text-xs">Item Code:</label>
                <select type="text" class="form-control h-8" id="itemCode" name="itemCode" onchange="updateItemDetails()">
                    <?php

                    // insert blocked option
                    if(!empty($itemList)){
                        foreach ($itemList as $item) {
                            echo '<option value="' . $item['description'] . '" data-id="' . $item['code'] . '">' . $item['code'] . '</option>';
                        }
                    }

                    if($selectedItemCode){
                        echo '<option value="' . $selectedItemCode . '">' . $selectedItemCode . '</option>';
                    }

                    ?>

                </select>

                <input type="hidden" id="hdnItemCode" name="hdnItemCode" value="">
                
            </div>

            <div class="  col-span-3 ">
                <label for="description" class="form-label text-xs">Description:</label>
                <input type="text" class="form-control h-8" id="description" name="description" >
                <?php
                    echo '<script>';
                    echo 'document.getElementById("description").value="'.$selectedItemName.'"';
                    echo '</script>';
                ?>
            </div>



            <div class="  col-span-1 ">
                <label for="Qty" class="form-label text-xs">Qty:</label>
                <input type="text" class="form-control w-full h-8" id="Qty" name="Qty">
            </div>

            <div class="  col-span-1">
                <label for="discountRs" class="form-label text-xs">Dis Rs:</label>
                <input type="text" class="form-control w-full h-8" id="discountRs" name="discountRs">
            </div>

            <div class="  col-span-1 ">
                <label for="price" class="form-label text-xs">Price:</label>
                <input type="text" class="form-control w-full h-8" id="price" name="price">
            </div>

            <div class="  col-span-2 ">
                <label for="amount" class="form-label text-xs">Amount:</label>
                <input type="text" class="form-control w-full h-8" id="amount" name="amount">
            </div>

            <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" name="saveGrn" id="saveGrn"><i class="fa-solid fa-notes-medical"></i> </button>
        </div>

        <!-- Second row with table -->
        <div class="col-span-12 mt-2">
            <table class="table table-bordered custom-table" id="tbl">
                <thead class="text-xs">
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Qty</th>
                        <th>Dis%</th>
                        <th>Price</th>
                        <th>Amount</th>


                    </tr>
                </thead>
                <tbody class="text-xs">
                    
                    <?php
    
                    if($data !== null){
                        foreach($data as $index => $row) {
                            // Output a table row for each row of data
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>"; // Increment index by 1 to start from 1
                            echo "<td>" . $row['code'] . "</td>";
                            echo "<td>" . $row['desc'] . "</td>";
                            echo "<td>Size</td>"; // Add the size column, adjust as needed
                            echo "<td>" . $row['qty'] . "</td>";
                            echo "<td>" . $row['disc'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['amount'] . "</td>";
                            echo "</tr>";
                        }
                    }
    
                    ?>
                   
                   
                </tbody>
            </table>
            
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


<!-- ======================================================================================================================= -->
        <div class="grid grid-cols-12 gap-2 mt-3">
            <div class="col-span-6  text-start">

                <div>
                    <label class="form-label text-blue-700 font-bold text-md">Bill Total Amount:</label>
                    <span class="text-blue-700 font-bold text-md">15000</span>
                </div>
                <div>
                    <label class="form-label text-red-700 font-bold text-md">Bill Status:</label>
                    <span class="text-red-700 font-bold text-md">Running</span>
                </div>

            </div>

            <div class="col-span-6  text-end pt-3">
                <div class="mb-3  gap-3">
                    <label for="submit" class="form-label"></label>
                    <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-28" name="saveAll">Bill Close</button>
                    <button type="submit" class="bg-yellow-500 text-white p-2 font-semibold w-28" onclick="clearForm()">Clear</button>
                    <button type="submit" class="bg-green-600 text-white p-2 font-semibold w-28" name="update">Update</button>
                    <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-28" name="delete">Delete</button>
                    <button type="submit" class="bg-black text-white p-2 font-semibold w-28" onclick="exit()"
                        name="submit">Exit</button>
                </div>
            </div>
        </div>
        <!-- ======================================================================================================== -->


        </form>

        </div>


        <script>
        function clearForm() {
        document.getElementById("goodRecivePage").reset();
        }
        function exit() {
        window.location.href = "index.php";
        }

        function updateCompanyName() {
        var selectElement = document.getElementById("supplier");
        var companyNameInput = document.getElementById("companyName");
        var hiddenSupCode = document.getElementById("hdnSupCode");
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        companyNameInput.value = selectedOption.value;
        hiddenSupCode.value = selectedOption.getAttribute("data-id");
        }

        function updateItemDetails() {
        var selectElement = document.getElementById("itemCode");
        var companyNameInput = document.getElementById("description");
        var hiddenItemCode = document.getElementById("hdnItemCode");
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        companyNameInput.value = selectedOption.value;            
        hiddenItemCode.value = selectedOption.getAttribute("data-id");           
        }


        var dataArray = [];
        function saveGrnRow() {
        var code = document.getElementById("hdnItemCode").value;
        var qty = document.getElementById("Qty").value;
        var disc = document.getElementById("discountRs").value;
        var price = document.getElementById("price").value;
        var amount = document.getElementById("amount").value;
        var desc = document.getElementById("description").value;

        var rowData = {
        code: code,
        qty: qty,
        disc: disc,
        price: price,
        amount: amount,
        desc: desc
        };

        dataArray.push(rowData);

        document.getElementById("dataArrayInput").value = JSON.stringify(dataArray);
        updateTable();

        }


        function updateTable() {
        var tableBody = document.getElementById("tbl");

        // Clear the table body first
        tableBody.innerHTML = "";

        // Loop through the data array and create table rows
        dataArray.forEach(function(data, index) {
        var newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${index + 1}</td>
            <td>${data.code}</td>
            <td>${data.desc}</td>
            <td>Size</td>
            <td>${data.qty}</td>
            <td>${data.disc}</td>
            <td>${data.price}</td>
            <td>${data.amount}</td>
        `;
        tableBody.appendChild(newRow);
        });
        }

        // Function to clear input fields after adding the data
        // function clearInputFields() {
        //     document.getElementById("itemCode").value = "";
        //     document.getElementById("Qty").value = "";
        //     document.getElementById("discountRs").value = "";
        //     document.getElementById("price").value = "";
        //     document.getElementById("amount").value = "";
        //     document.getElementById("description").value = "";
        // }



        </script>

        </body>

</html>