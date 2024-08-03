<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
   

    .container {
        margin: 0 auto;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

    }

    .contentFrameCol {
      
        height: 500px;
    }

   
    </style>
</head>

<body class=" ">
<div class="container bg-white p-4   w-full">
        <div class="row mb-2">

            <div class="col-md-6">
                <h3>Admin <span class="text-warning">Master</span></h3>
            </div>

           
        </div>

        <div class="grid grid-cols-12 gap-3 mt-4">
            <!-- First row -->
            <div class="col-span-6">
                <input type="radio" id="userRadio" name="userBranch" value="user" class="mr-2 font-semibold " checked>
                <label for="userRadio" class="font-semibold text-lg">Add User</label>
            </div>
            <div class="col-span-6">
                <input type="radio" id="branchRadio" name="userBranch" value="branch" class="mr-2 font-semibold">
                <label for="branchRadio" class="font-semibold text-lg">Add Branch</label>
            </div>

            <!-- Second row -->
            <div class="col-span-12 p-3   contentFrameCol">
                <iframe id="contentFrame" src="registration.php" class=" w-full p-3  h-full">

                </iframe>
            </div>
        </div>
    </div>

    <script>
    const userRadio = document.getElementById('userRadio');
    const branchRadio = document.getElementById('branchRadio');
    const contentFrame = document.getElementById('contentFrame');

    userRadio.addEventListener('change', () => {
        if (userRadio.checked) {
            contentFrame.src = 'registration.php';
        }
    });

    branchRadio.addEventListener('change', () => {
        if (branchRadio.checked) {
            contentFrame.src = 'branch.php';
        }
    });

    </script>
</body>

</html>