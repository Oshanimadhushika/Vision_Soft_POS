<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    .container {
       
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

    }

    .contentFrameCol {

        height: 560px;
    }
    </style>
</head>

<body class="">
    <div class="container bg-white p-4   w-full">
        <div class="row mb-1">

            <div class="col-md-6">
                <h3>Setting <span class="text-warning">Page</span></h3>
            </div>


        </div>

        <div class="grid grid-cols-12 gap-3 mt-3">
            <!-- First row -->
            <div class="col-span-4">
                <input type="radio" id="supplierRadio" name="settingItem" value="user" class="mr-2 font-semibold "
                    checked>
                <label for="supplierRadio" class="font-semibold text-lg">Supplier</label>
            </div>
            <div class="col-span-4">
                <input type="radio" id="departmentRadio" name="settingItem" value="branch" class="mr-2 font-semibold">
                <label for="departmentRadio" class="font-semibold text-lg">Department</label>
            </div>
            <div class="col-span-4">
                <input type="radio" id="categoryRadio" name="settingItem" value="branch" class="mr-2 font-semibold">
                <label for="categoryRadio" class="font-semibold text-lg">Category</label>
            </div>

            <!-- Second row -->
            <div class="col-span-12  contentFrameCol   ">
                <iframe id="contentFrame" src="supplier.php" class=" w-full  h-full">

                </iframe>
            </div>
        </div>
    </div>

    <script>
    const supplierRadio = document.getElementById('supplierRadio');
    const departmentRadio = document.getElementById('departmentRadio');
    const categoryRadio = document.getElementById('categoryRadio');

    const contentFrame = document.getElementById('contentFrame');

    supplierRadio.addEventListener('change', () => {
        if (supplierRadio.checked) {
            contentFrame.src = 'supplier.php';
        }
    });

    departmentRadio.addEventListener('change', () => {
        if (departmentRadio.checked) {
            contentFrame.src = 'department.php';
        }
    });

    categoryRadio.addEventListener('change', () => {
        if (categoryRadio.checked) {
            contentFrame.src = 'category.php';
        }
    });
    </script>
</body>

</html>