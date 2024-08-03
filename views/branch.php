<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <style>
    

    .container {
        /* width: 80%; */
        margin: 0 auto;
        /* padding: 25px; */
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

   
    </style>
</head>

<body class=" p-3">
    <div class="container bg-white mx-auto p-2 w-full">
    <?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        searchDepartment();
    }
}


function searchDepartment(){
    $code = $_POST["branchCode"];
    $name= $_POST["branchName"];

    
        if(empty($code) || empty($name)){
            echo '<script>alert("Inputs should not be Empty..!")</script>';
        }else{
            require_once '../controllers/db.php';
            require_once '../controllers/branchController.php';

            $saved = saveBranchData($conn, $code, $name);

            if($saved){
                echo '<script>alert("Branch Saved Sccessfully..!")</script>'; 
            }
        }
    }
?>

        <div class="grid grid-cols-2 gap-4 p-8">
            <div class="flex items-center">
                <img src="../asserts/loginImg2.jpg" alt="Image" class="w-full ">
            </div>

            <div class="text-center pt-5">
                <form action="branch.php" method="post">
                    <div class="mb-4">
                        <input type="text" class="form-input rounded-md border-2 border-gray-200 p-2 w-full" name="branchCode" placeholder="Branch Code">
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-input rounded-md border-2 border-gray-200 p-2 w-full" name="branchName" placeholder="Branch Name">
                    </div>

                    <div>
                        <input class="bg-purple-500 hover:bg-blue-500 text-black font-semibold w-full p-3 rounded-md" type="Submit" name="save">
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</body>

</html>
