<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <title>item master</title>

   
</head>

<body>
    <div class="container bg-white p-4 w-full">

    <?php
        
        require_once "../controllers/db.php";
        require_once "../controllers/categoryController.php";
        require_once "../controllers/departmentController.php";
        require_once "../controllers/supplierController.php";
        require_once '../controllers/itemController.php';

        $departmentList = getAllDepartment($conn);
        $categoryList = getAllCategory($conn);
        $supplierList = getAllSupplier($conn);

        $lastItemCode = getLastItemCode($conn);
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["save"])) {
                saveItem($conn);
            }else if(isset($_POST["search"])){
                searchItem($conn);
            }else if(isset($_POST["update"])){
                updateItem($conn);
            }else if(isset($_POST["delete"])){
                deleteItem($conn);
            }
        } 


        function saveItem($conn){
            
            $itemCode = $_POST["itemCode"];
            $barcode = $_POST["barcode"];
            $description = $_POST["description"];
            $department = $_POST["department"];
            $category = $_POST["category"];
            $supplier = $_POST["supplier"];
            $cost = $_POST["cost"];
            $profit = $_POST["profit"];
            $salesPrice = $_POST["salesPrice"];
            $discountRs = $_POST["discountRs"];
            $wholesale = $_POST["wholesale"];
            $location = $_POST["location"];
            $maxStockQty = $_POST["maxStockQty"];
            $minStockQty = $_POST["minStockQty"];


            require_once '../controllers/itemController.php';

            if (empty($itemCode) || empty($description) || empty($department) || empty($cost) || empty($salesPrice) || empty($category) || empty($supplier) || empty($profit) || empty($discountRs) || empty($wholesale) || empty($location) || empty($maxStockQty) || empty($minStockQty)) {
                echo '<script>alert("All fields required..!");</script>';
            }else{
                $saved = saveItemData($conn, $itemCode, $barcode, $description, $department, $category, $supplier, $cost, $profit, $salesPrice, $discountRs, $wholesale, $location, $maxStockQty, $minStockQty);

                if ($saved === true) {
                    echo '<script>alert("Item added successfully..!");</script>';
                } else {
                    echo '<script>alert("Something went wrong..!");</script>';
                }
            }
        }


        function searchItem($conn){
            $keyword = $_POST["keyword"];

            require_once '../controllers/itemController.php';

             $result = searchItemByKeyword($conn, $keyword);

             if($result === 'emptyResult'){
                echo '<script>alert("Empty Result..!");</script>';
             }else{
                echo '<div class="row mb-2">';
                echo '<table class="table table-bordered custom-table" id="categoryTable">';
                echo '<tr><th>Code</th><th>BarCode</th><th>Description</th><th>Department</th><th>Category</th><th>Supplier</th><th>Cost</th><th>Profit</th><th>Sales Price</th><th>Discount</th><th>Wholesale</th><th>Location</th><th>Max Qty</th><th>Min Qty</th></tr>';
                foreach ($result as $row) {
                    echo '<tr onclick="getRowData(this)">';
                    echo '<td>' . $row['code'] . '</td>';
                    echo '<td>' . $row['barcode'] . '</td>';
                    echo '<td>' . $row['description'] . '</td>';
                    echo '<td>' . $row['department'] . '</td>';
                    echo '<td>' . $row['category'] . '</td>';
                    echo '<td>' . $row['supplier'] . '</td>';
                    echo '<td>' . $row['cost'] . '</td>';
                    echo '<td>' . $row['profit'] . '</td>';
                    echo '<td>' . $row['salePrice'] . '</td>';
                    echo '<td>' . $row['discount'] . '</td>';
                    echo '<td>' . $row['wholesale'] . '</td>';
                    echo '<td>' . $row['location'] . '</td>';
                    echo '<td>' . $row['maxStockQty'] . '</td>';
                    echo '<td>' . $row['minStockQty'] . '</td>';
                    echo '</tr>';
                }
                
                echo '</table>';
                echo '</div>';
             }

        }


        function updateItem($conn){
            $itemCode = $_POST["itemCode"];
            $barcode = $_POST["barcode"];
            $description = $_POST["description"];
            $department = $_POST["department"];
            $category = $_POST["category"];
            $supplier = $_POST["supplier"];
            $cost = $_POST["cost"];
            $profit = $_POST["profit"];
            $salesPrice = $_POST["salesPrice"];
            $discountRs = $_POST["discountRs"];
            $wholesale = $_POST["wholesale"];
            $location = $_POST["location"];
            $maxStockQty = $_POST["maxStockQty"];
            $minStockQty = $_POST["minStockQty"];


            require_once '../controllers/itemController.php';

            if (empty($itemCode) || empty($description) || empty($department) || empty($cost) || empty($salesPrice) || empty($category) || empty($supplier) || empty($profit) || empty($discountRs) || empty($wholesale) || empty($location) || empty($maxStockQty) || empty($minStockQty)) {
                echo '<script>alert("All fields required..!");</script>';
            }else{
                $updated = updateItemData($conn, $itemCode, $barcode, $description, $department, $category, $supplier, $cost, $profit, $salesPrice, $discountRs, $wholesale, $location, $maxStockQty, $minStockQty);

                if ($updated === true) {
                    echo '<script>alert("Item Updated successfully..!");</script>';
                } else {
                    echo '<script>alert("Something went wrong..!");</script>';
                }
            }
        }

        function deleteItem($conn){
            $itemCode = $_POST["itemCode"];

            if(empty($itemCode)){
                echo '<script>alert("Please Select a Item..!");</script>';
            }else{
                require_once '../controllers/itemController.php';

                $deleted = deleteItemData($conn,$itemCode);

                if ($deleted === true) {
                    echo '<script>alert("Item Delete successfully..!");</script>';
                } else {
                    echo '<script>alert("Something went wrong..!");</script>';
                }
            }
        }
        
        
        
        
        ?>

        <div class="row mb-2">

            <div class="col-md-6">
                <h3>Item <span class="text-warning">Master</span></h3>
            </div>

            <div class="col-md-6">
            <form id="searchitemForm" action="itemMaster.php" method="post">
                <div class="flex items-center ">
                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="keyword" name="keyword"
                        placeholder="Search...">
                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" type="submit" name="search">
                        <i class="fa-solid fa-notes-medical"></i> </button>
                </div>
                </form>


            </div>
        </div>

        <!-- ======================================================================================================== -->
        <form id="itemMasterForm" action="itemMaster.php" method="post" class="p-1">
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="itemCode" class="form-label text-sm font-medium">Item Code:</label>
                        <input type="text" class="form-control" id="itemCode" name="itemCode" required>
                        <?php
                         echo '<script>';
                         echo 'document.getElementById("itemCode").value="'.$lastItemCode.'"';
                         echo '</script>'; 
                        ?>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="barcode" class="form-label text-sm font-medium">Barcode:</label>
                        <input type="text" class="form-control" id="barcode" name="barcode">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="description" class="form-label text-sm font-medium">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                </div>



            </div>

            <div class="row mt-2">

                <div class="col-md-4">

                    <div class="mb-3">
                        <label for="department" class="form-label text-sm font-medium">Department:</label>
                        <select class="form-control rounded-md border-2 border-gray-200 p-2 w-full" name="department" id="department">
                                <option value="" disabled selected>Select department:</option>
                                <?php
                                foreach ($departmentList as $department) {
                                    echo '<option value="' . $department['name'] . '">' . $department['name'] . '</option>';
                                }
                                ?>
                            </select>
                    </div>

                </div>



                <div class="col-md-4">



                    <div class="mb-3">
                        <label for="category" class="form-label text-sm font-medium">Category:</label>
                        <select class="form-control rounded-md border-2 border-gray-200 p-2 w-full" name="category" id="category">
                                <option value="" disabled selected>Select category:</option>
                                <?php
                                foreach ($categoryList as $category) {
                                    echo '<option value="' . $category['name'] . '">' . $category['name'] . '</option>';
                                }
                                ?>
                            </select>
                    </div>






                </div>

                <div class="col-md-4">

                    <div class="mb-3">
                        <label for="supplier" class="form-label text-sm font-medium">Supplier:</label>
                        <select class="form-control rounded-md border-2 border-gray-200 p-2 w-full" name="supplier" id="supplier">
                                <option value="" disabled selected>Select supplier:</option>
                                <?php
                                foreach ($supplierList as $supplier) {
                                    echo '<option value="' . $supplier['name'] . '">' . $supplier['name'] . '</option>';
                                }
                                ?>
                            </select>
                    </div>

                </div>


            </div>

            <div class="row mt-2">





                <div class="col-md-3">
                    <div class="mb-3 w-full ">
                        <label for="cost" class="form-label text-sm font-medium">Cost:</label>
                        <input type="number" class="form-control w-full " id="cost" name="cost">
                    </div>



                </div>

                <div class="col-md-3">
                    <div class="mb-3 w-full">
                        <label for="profit" class="form-label text-sm font-medium">Profit:</label>
                        <input type="number" class="form-control w-full" id="profit" name="profit">
                    </div>

                </div>

                <!-- ======================================================== -->
                <div class="col-md-3">
                    <div class="mb-3 w-full">
                        <label for="salesPrice" class="form-label text-sm font-medium">Sales Price (Cash):</label>
                        <input type="text" class="form-control w-full" id="salesPrice" name="salesPrice">
                    </div>

                </div>

                <!-- ================================================================== -->
                <div class="col-md-3">
                    <div class="mb-3 w-full">
                        <label for="discountRs" class="form-label text-sm font-medium">Discount Rs:</label>
                        <input type="text" class="form-control w-full" id="discountRs" name="discountRs">
                    </div>

                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-3">
                    <div class="mb-3 w-full">
                        <label for="wholesale" class="form-label text-sm font-medium">Wholesale:</label>
                        <input type="text" class="form-control w-full" id="wholesale" name="wholesale">
                    </div>


                </div>

                <div class="col-md-3">
                    <div class="mb-3 w-full">
                        <label for="location" class="form-label text-sm font-medium">Location:</label>
                        <input type="text" class="form-control w-full" id="location" name="location">
                    </div>



                </div>

                <div class="col-md-3">
                    <div class="mb-3 w-full">
                        <label for="maxStockQty" class="form-label text-sm font-medium">Maximum Stock Quantity:</label>
                        <input type="text" class="form-control w-full" id="maxStockQty" name="maxStockQty">
                    </div>


                </div>

                <div class="col-md-3">

                    <div class="mb-3 w-full">
                        <label for="minStockQty" class="form-label text-sm font-medium">Minimum Stock Quantity:</label>
                        <input type="text" class="form-control w-full" id="minStockQty" name="minStockQty">
                    </div>
                </div>
            </div>




            <div class="row mt-2">
                <div class="col-md-12">
                <div class="mb-3 d-flex justify-content-end gap-3">
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
        <!-- ======================================================================================================== -->


    </div>

    <script>
    function clearForm() {
        document.getElementById("itemMasterForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }

    function getRowData(row) {
        var code = row.cells[0].innerText;
        var barcode = row.cells[1].innerText;
        var description = row.cells[2].innerText;
        var department = row.cells[3].innerText;
        var category = row.cells[4].innerText;
        var supplier = row.cells[5].innerText;
        var cost = row.cells[6].innerText;
        var profit = row.cells[7].innerText;
        var salePrice = row.cells[8].innerText;
        var discount = row.cells[9].innerText;
        var wholesale = row.cells[10].innerText;
        var location = row.cells[11].innerText;
        var maxQty = row.cells[12].innerText;
        var minQty = row.cells[13].innerText;
        
        document.getElementById("itemCode").value = code;
        document.getElementById("barcode").value = barcode;
        document.getElementById("description").value = description;
        document.getElementById("department").value = department;
        document.getElementById("category").value = category;
        document.getElementById("supplier").value = supplier;
        document.getElementById("cost").value = cost;
        document.getElementById("profit").value = profit;
        document.getElementById("salesPrice").value = salePrice;
        document.getElementById("discountRs").value = discount;
        document.getElementById("wholesale").value = wholesale;
        document.getElementById("location").value = location;
        document.getElementById("maxStockQty").value = maxQty;
        document.getElementById("minStockQty").value = minQty;



    }

    </script>

</body>

</html>