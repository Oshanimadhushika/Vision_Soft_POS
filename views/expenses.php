<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Expenses</title>


</head>

<body class="p-4 overflow-y-hidden ">
    <div class="container mx-auto bg-white p-3 shadow-xl">

        <div class="row mb-2 mt-3">

            <div class="col-md-6">
                <h3>Expenditure <span class="text-warning">Expenses</span></h3>
            </div>

            <div class="col-md-6">
                <div class="flex items-center">
                    <input type="text" class="form-control rounded-full shadow-xl p-2" id="search"
                        placeholder="Search Expenditure">
                    <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700">
                        <i class="fa-solid fa-notes-medical"></i>
                    </button>
                </div>
            </div>
        </div>

        <?php

        require_once '../controllers/db.php';
        require_once '../controllers/deductionController.php';
        $lastDedId = getLastId($conn);
        $nextId = $lastDedId+1;



            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['save'])){
                    $date = $_POST['date'];
                    $deduction = $_POST['deduction'];
                    $description = $_POST['description'];
                    $amount = $_POST['amount'];

                    require_once '../controllers/db.php';
                    require_once '../controllers/deductionController.php';

                    $saved = saveDeduction($conn, $date, $deduction, $description, $amount);
                }
            }
        
        ?>

        <!-- ======================================================================================================== -->
        <form id="expensesForm" action="expenses.php" method="post" class="p-2">
            <!-- 1st row -->
            <div class="col-span-12 gap-4">
                <div class="grid grid-cols-12 gap-4 p-2">
                    <div class="col-span-5">
                        <label for="date" class="form-label text-xs font-medium text-center mt-2">Date:</label>
                        <input type="date" class="form-control h-10" id="date" name="date">
                    </div>

                    <div class="col-span-3">
                        <label for="idexpanse" class="form-label mt-2"> ID:</label>
                        <input type="text" class="form-control h-10" id="idexpanse" name="idexpanse" required>
                        <?php
                        echo '<script>';
                        echo 'document.getElementById("idexpanse").value="'.$nextId.'"';
                        echo '</script>';                        
                ?>
                    </div>
                </div>
            </div>


            <!-- 2nd row -->
            <div class="col-span-12 gap-4">
                <div class="grid grid-cols-12 gap-4 p-2">
                    <div class="col-span-8">
                        <label for="deduction"
                            class="form-label text-xs font-medium text-center mt-2">Deduction:</label>
                        <select class="form-select h-10 ml-1" name="deduction" required>
                            <option value="Tea">Tea</option>
                            <option value="foods">Food</option>
                            <option value="other">Other</option>
                        </select>
                    </div>


                </div>
            </div>


              <!-- 3rd row -->
              <div class="col-span-12 gap-4">
                <div class="grid grid-cols-12 gap-4 p-2">
                    <div class="col-span-5">
                        <label for="description" class="form-label text-xs font-medium text-center mt-2">Description:</label>
                        <input type="text" class="form-control h-10" id="description" name="description">
                    </div>

                    <div class="col-span-3">
                        <label for="amount" class="form-label mt-2"> Amount:</label>
                        <input type="text" class="form-control h-10" id="amount" name="amount" required>
                    </div>
                </div>
            </div>

            <!-- ================================================================================================================== -->
            <div class="row mt-4">
                <div class="col-span-12">
                    <div class="mb-3 d-flex justify-content-end gap-3">
                        <label for="submit" class="form-label"></label>
                        <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-32"
                            name="save">Submit</button>
                        <button type="button" class="bg-yellow-500 text-white p-2 font-semibold w-32"
                            onclick="clearForm()">Clear</button>
                        <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-32"
                            name="submit">Delete</button>
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
        document.getElementById("expensesForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>