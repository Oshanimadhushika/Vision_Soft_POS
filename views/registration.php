<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->

    <style>
    .container {
        /* width: 80%; */
        margin: 0 auto;
        /* padding: 25px; */
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }
    </style>
</head>

<body>
    <div class="container p-3">
    <?php
        require_once "../controllers/db.php";
        require_once "../controllers/branchController.php";

        // Retrieve all branches
        $result = getAllBranche($conn);

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save'])) {
                // Pass $conn to the saveUser function
                saveUser($conn);
            }
        }

        function saveUser($conn){
            require_once "../controllers/userController.php";

            $userName = $_POST["userName"];
            $branch = $_POST["branch"];
            $password = $_POST["password"];
            $repeat = $_POST["repeatPassword"];

            if(empty($userName) || empty($branch) || empty($password) || empty($repeat)){
                echo '<script>alert("Inputs should not be Empty..!")</script>';
            }else{
                if($password === $repeat){
                    // Pass $conn to the saveUserData function
                    $saved = saveUserData($conn, $userName, $branch, $password);
                    if($saved){
                        echo '<script>alert("Registration Seccessfully..!")</script>';
                    }else{
                        echo '<script>alert("Something went wrong..!")</script>';
                    }
                }else{
                    echo '<script>alert("Passwords not matching..!")</script>';
                }
            }
        }
?>

        <div class="form-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="image-column">
                        <img src="../asserts/loginImg2.jpg" alt="Image" class="w-full">
                    </div>
                </div>

                <div class="col-md-6">

                    <!-- <div class="d-flex justify-content-end align-items-end mt-1">
                        <a href="branch.php" class=""><i class="fas fa-plus"></i> Add Branch</a>
                    </div> -->

                    <div class="form-column text-center p-3 ">
                        <form action="registration.php" method="post" class="gap-3">
                            <div class="form-group mb-4">
                                <input type="text" class="form-control rounded-md border-2 border-gray-200 p-2 w-full"
                                    name="userName" placeholder="User Name:">
                            </div>
                            <div class="form-group mb-4">
                                <!-- <label for="branch" class="text-start font-semibold">Branch:</label> -->
                                <select class="form-control rounded-md border-2 border-gray-200 p-2 w-full" name="branch" id="branch">
                                <option value="" disabled selected>Select Branch:</option>
                                <?php
                                foreach ($result as $branch) {
                                    echo '<option value="' . $branch['id'] . '">' . $branch['name'] . '</option>';
                                }
                                ?>
                            </select>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password"
                                    class="form-control rounded-md border-2 border-gray-200 p-2 w-full" name="password"
                                    placeholder="Password:">
                            </div>
                            <div class="form-group mb-4">
                                <input type="password"
                                    class="form-control rounded-md border-2 border-gray-200 p-2 w-full"
                                    name="repeatPassword" placeholder="Repeat Password:">
                            </div>
                            <div class="form-btn">
                                <input type="submit"
                                    class="bg-purple-700 text-white hover:bg-blue-600  font-semibold w-full p-3 rounded-md"
                                    name="save">
                            </div>
                        </form>
                        <!-- <div>
                            <div class="mt-3">
                                <p>Already Registered <a href="login.php">Login Here</a></p>
                            </div>
                        </div> -->
                    </div>


                </div>
            </div>
        </div>



























    </div>
</body>

</html>