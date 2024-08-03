<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Category master</title>


</head>

<body class="p-4 overflow-y-hidden">
    <div class="container mx-auto bg-white p-3 shadow-xl">

    <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['search'])) {
                $searchWord = $_POST["keyword"];
                searchCategory($searchWord);
            }elseif(isset($_POST['save'])){
                saveCategory();
            }elseif(isset($_POST['update'])){
                updateCategory();
            }elseif(isset($_POST['delete'])){
                deleteCategory();
            }
        }

        function searchCategory($searchWord){
            if(empty($searchWord)){
                echo '<script>alert("Keyword should not be Empty..!")</script>';
            }else{
                require_once '../controllers/db.php';
                require_once '../controllers/categoryController.php';

                $result = searchCategoryByCode($conn, $searchWord);
                if ($result === 'emptyResult') {
                    echo '<script>alert("No results found..!")</script>';
                } else {
                    // Display the result in a table
                    echo '<table class="table table-bordered custom-table" id="categoryTable">';
                    echo '<tr><th>Code</th><th>Name</th></tr>';
                    foreach ($result as $row) {
                        echo '<tr onclick="getRowData(this)">';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '</tr>';
                    }
                    
                    echo '</table>';
                }
            }
        }

        function saveCategory(){
            $id = $_POST["categoryCode"];
            $name = $_POST["category"];
            if(empty($id) || empty($name)){
                echo '<script>alert("Input Should not be Empty..!")</script>';
            }else{
                require_once '../controllers/db.php';
                require_once '../controllers/categoryController.php';

                $saved = saveCategoryData($conn, $id, $name);

                if($saved){
                    echo '<script>alert("Category Saved Successfully..!")</script>';
                }else{
                    echo '<script>alert("Something went wrong..!")</script>';
                }

            }
        }

        function updateCategory(){
            $id = $_POST["categoryCode"];
            $name = $_POST["category"];
            if(empty($id) || empty($name)){
                echo '<script>alert("Input Should not be Empty..!")</script>';
            }else{
                require_once '../controllers/db.php';
                require_once '../controllers/categoryController.php';

                $updated = updateCategoryData($conn, $id, $name);

                if($updated){
                    echo '<script>alert("Category Updated Successfully..!")</script>';
                }else{
                    echo '<script>alert("Something went wrong..!")</script>';
                }

            }

        }

        function deleteCategory(){
            require_once '../controllers/db.php';
            require_once '../controllers/categoryController.php';

            $id = $_POST["categoryCode"];

            if(empty($id)){
                echo '<script>alert("Code should not be Empty..!")</script>';
            }else{
                $deleted = deleteCategoryData($conn, $id);

                if($deleted){
                    echo '<script>alert("Category Deleted Successfully..!")</script>';
                }else{
                    echo '<script>alert("Something went wrong..!")</script>';
                }
            }
        }

    ?>

        <div class="row mb-2">

            <div class="col-md-6">
                <h3>Category <span class="text-warning">Master</span></h3>
            </div>

            <div class="col-md-6">
            <form id="categorySearch" action="category.php" method="post">
                <div class="flex items-center">
                    <input type="text" class="form-control rounded-full shadow-xl p-2" id="keyword" name="keyword"
                        placeholder="Search...">
                    <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700" id="search" name="search">
                        <i class="fa-solid fa-notes-medical"></i>
                    </button>
                </div>
                </form>
            </div>
        </div>

        <!-- ======================================================================================================== -->
        <form id="categoryForm" action="category.php" method="post">
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="categoryCode" class="form-label text-sm font-bold"> Code:</label>
                        <input type="text" class="form-control" id="categoryCode" name="categoryCode" required>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="category" class="form-label text-sm font-bold"> Category:</label>
                        <input type="text" class="form-control" id="category" name="category" required>


                        </select>
                    </div>

                </div>

            </div>


            <div class="row mt-2">
                <div class="col-md-12">
                <div class="mb-3 d-flex justify-content-end gap-1">
                        <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-28"
                            name="submit">Submit</button>
                        <button type="button" class="bg-yellow-500 text-white p-2 font-semibold w-28"
                            onclick="clearForm()">Clear</button>
                        <button type="submit" class="bg-green-600 text-white p-2 font-semibold w-28"
                            name="submit">Update</button>
                        <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-28"
                            name="submit">Delete</button>
                        <button type="submit" class="bg-black text-white p-2 font-semibold w-28" onclick="exit()"
                            name="submit">Exit</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- ======================================================================================================== -->


        <div class="max-h-44 overflow-y-auto">

            <!-- <table class="table table-bordered custom-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Category</th>

                         <th>Update</th>
                    <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table> -->
        </div>








    </div>

    <script>
    function clearForm() {
        document.getElementById("categoryForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }

    function getRowData(row) {
        var id = row.cells[0].innerText;
        var name = row.cells[1].innerText;
        
        document.getElementById("categoryCode").value = id;
        document.getElementById("category").value = name;

    }
    </script>

</body>

</html>