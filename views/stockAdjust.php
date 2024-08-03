<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>stock adjust</title>
</head>

<body>
    <div class="container bg-white p-2 w-full ">

        <div class="row ">

            <div class="col-md-6">
                <h3 class="text-md">Stock <span class="text-warning">Adjusment</span></h3>
            </div>


        </div>

        <?php

        session_start();

        require_once "../controllers/db.php";
        require_once "../controllers/ajustmentController.php";
        $lastId = getLatId($conn);
        $nextId = $lastId+1;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["itemNo"])) {
                $itemCode = $_POST["itemNo"];

                require_once "../controllers/db.php";
                require_once "../controllers/itemController.php";

                $searchItemResult = searchItemById($conn, $itemCode);

                $itemResult = '';
                if($searchItemResult){
                    foreach($searchItemResult as $item){
                        $itemResult = $item;
                    }
                }

               // echo var_dump($itemResult);
            }elseif (isset($_POST["save"])) {
                // Validate and sanitize inputs
                $itemCode = isset($_POST["itemNo"]) ? $_POST["itemNo"] : '';
                $adjustQty = isset($_POST["adjust"]) ? $_POST["adjust"] : 0;
                $remark = isset($_POST["remark"]) ? $_POST["remark"] : '';
                $qty = isset($_POST["available"]) ? $_POST["available"] : 0;
                $after = 0;
                $reason = isset($_POST["reason"]) ? $_POST["reason"] : '';
            
                // Convert string values to numeric values if possible
                if (is_numeric($qty) && is_numeric($adjustQty)) {
                    // Perform adjustment calculations
                    if ($reason === "Over Stock") {
                        $after = $qty - $adjustQty;
                    } elseif ($reason === "Less Stock") {
                        $after = $qty + $adjustQty;
                    }
                } else {
                    // Handle non-numeric values or unexpected data types
                    echo "Error: Quantity or adjustment value is not numeric.";
                }
            
            
                // Create adjustment data row
                $rowData = array(
                    "itemCode" => $itemCode,
                    "qty" => $qty,
                    "adjusted" => $adjustQty,
                    "after" => $after,
                    "reason" => $reason,
                    "remark" => $remark
                );
            
                // Store adjustment data in session
                if(!empty($_SESSION['adjustedData'])){
                    $data = $_SESSION['adjustedData'];
                } else {
                    $data = array();
                }
                $data[] = $rowData;

                $_SESSION['adjustedData'] = $data;
            
               // echo var_dump($_SESSION['adjustedData']);

               require_once "../controllers/db.php";
                require_once "../controllers/ajustmentController.php";

                $saved = saveAdjustedData($conn, $_SESSION['adjustedData']);

                if ($saved) {
                    echo "Adjusted data saved successfully.";
                } else {
                    echo "Error: Failed to save adjusted data.";
                }
            }
            


            }
        

        
        ?>

        <!-- ======================================================================================================== -->


        <form id="stockAdjustForm" action="stockAdjust.php" method="post">
            <div class="grid grid-cols-12 gap-2">
                <!-- First row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">

                    <label class="form-label text-sm font-bold"> Item</label>

                    <!-- 1st row 1st div -->
                    <div class="grid grid-cols-12 gap-4 ">


                        <div class="  col-span-3  ">
                            <label for="date" class="form-label text-xs font-semibold text-center mt-2">Date:</label>
                            <input type="date" class="form-control h-8 " id="date" name="date">
                        </div>



                        <div class="  col-span-3 ">
                            <label for="itemNo" class="form-label text-xs font-semibold">Item No:</label>
                            <input type="text" class="form-control h-8" id="itemNo" name="itemNo" >
                           
                        </div>

                        <div class="  col-span-3 ">
                            <label for="itemName" class="form-label text-xs font-semibold">Item Name:</label>
                            <input type="text" class="form-control h-8" id="itemName" name="itemName" >

                            <?php
                         echo '<script>';
                         echo 'document.getElementById("itemName").value="'.$itemResult['description'].'"';
                         echo '</script>'; 
                        ?>
                        </div>

                        <div class="  col-span-3 ">
                            <label for="available"
                                class="form-label text-xs font-semibold text-center mt-2">Available:</label>
                            <input type="text" class="form-control h-8 " id="available" name="available">
                            <?php
                         echo '<script>';
                         echo 'document.getElementById("available").value="'.$itemResult['maxStockQty'].'"';
                         echo '</script>'; 
                        ?>
                        </div>

                    </div>

                    <!-- 2nd row 1st div -->
                    <div class="grid grid-cols-12 gap-4 ">


                        <div class="  col-span-3  ">
                            <label for="noteNo" class="form-label text-xs font-semibold text-center mt-2">Adjustment
                                Note
                                No :</label>
                            <input type="text" class="form-control h-8 " id="noteNo" name="noteNo">
                            <?php
                         echo '<script>';
                         echo 'document.getElementById("noteNo").value="'.$nextId.'"';
                         echo '</script>'; 
                        ?>
                        </div>



                        <div class="  col-span-3 ">
                            <label for="reason" class="form-label text-xs font-semibold">Reason:</label>
                            <select class="form-select" id="reason" name="reason" class="h-8">
                                <option value="Over Stock">Over Stock</option>
                                <option value="Less Stock">Less Stock</option>
                            </select>
                        </div>

                        <div class="  col-span-3 ">
                            <label for="adjust" class="form-label text-xs font-semibold">Adjust:</label>
                            <input type="text" class="form-control h-8" id="adjust" name="adjust" >
                        </div>

                        <div class="  col-span-3 ">
                            <label for="newStock" class="form-label text-xs font-semibold text-center mt-2">New
                                Stock:</label>
                            <input type="text" class="form-control h-8 " id="newStock" name="newStock">
                        </div>

                    </div>

                    <!-- 3rd row 1st div -->

                    <div class="grid grid-cols-12 gap-1 ">
                        <div class="col-span-11 ">
                            <label for="remark"
                                class="form-label text-xs font-semibold text-center mt-2">Remark:</label>
                            <textarea type="text" class="form-control h-8 " id="remark" name="remark"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2nd row -->

                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-1 ">



                        <div class="col-span-12 w-full">
                            <label class="form-label text-sm font-bold"> Item Register</label>

                            <div class="max-h-32 overflow-y-auto">
                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Name</th>
                                            <th>Item No</th>
                                            <th>Pack Size</th>
                                            <th>Qty</th>

                                            <th>Cost</th>
                                            <th>Wholesale</th>
                                            <th>Profit</th>


                                        </tr>
                                    </thead>
                                    <tbody class="text-xs">
                                    <?php
    

                                if(isset($searchItemResult)){
                                if($searchItemResult !== null){
                                    foreach($searchItemResult as $index => $row) {
                                        // Output a table row for each row of data
                                        echo "<tr>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['code'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";         
                                        echo "<td>" . $row['maxStockQty'] . "</td>";
                                        echo "<td>" . $row['cost'] . "</td>";
                                        echo "<td>" . $row['wholesale'] . "</td>";
                                        echo "<td>" . $row['profit'] . "</td>";
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


                <!-- 4th row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-1 ">



                        <div class="col-span-12 w-full">
                            <label class="form-label text-sm font-bold"> Item Register</label>

                            <div class="max-h-32 overflow-y-auto">
                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Name</th>
                                            <th>Item No</th>
                                            <th>Qty</th>
                                            <th>Adjusted</th>

                                            <th>After</th>
                                            <th>Reason</th>
                                            
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

                <!-- 5th row -->
                <div class="col-span-12  p-1 ">
                    <div class="grid grid-cols-12 gap-1 ">


                        <div class="col-span-9  ">


                        </div>

                        <div class="col-span-3 w-full   text-end justify-self-end">
                            <div class="flex justify-start gap-2">
  
                                <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-28"
                                    name="save">Save</button>
                                <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-28"
                                    name="submit">Delete</button>
                                <button type="button" class="bg-yellow-500 text-white p-2 font-semibold w-28"
                                    onclick="clearForm()">Clear</button>
                                <button type="submit" class="bg-black text-white p-2 font-semibold w-28"
                                    onclick="exit()" name="submit">Exit</button>
                            </div>





                        </div>

                    </div>
                </div>


            </div>


        </form>

    </div>

    <script>
    function clearForm() {
        document.getElementById("stockAdjustForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>