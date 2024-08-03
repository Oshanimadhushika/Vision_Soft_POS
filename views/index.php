<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>


</head>

<body class="bg-cover bg-center bg-gray-300" style="background-image: url('../asserts/bg.png');">

    <div class="grid grid-cols-12  ">

    <?php
    session_start();


    $_SESSION['logedUser'] = '';
    $_SESSION['itemOne'] = '';
    $_SESSION['itemTwo'] = '';
    $_SESSION['itemThree'] = '';
    $_SESSION['ajustedData'] = '';

    ?>

        <div class=" side-bar xl:col-span-3 lg:col-span-4 p-1 mb-2 pt-2">

            <div class="menu grid grid-cols-2 xl:gap-2 lg:gap-1 ">
                <!-- Row user -->
                <div
                    class="col-span-2 w-full p-2 bg-gray-200  text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 ">
                    <div href="itemMaster.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-user-tie mr-2 text-black"></i>
                        <label class="text-black ">Current User: <span
                                class="text-md font-extrabold font-sans text-red-700 ">Admin</span></label>
                    </div>
                </div>

                <!-- Row 1 -->
                <!-- 1st col -->

                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1 ">
                    <a href="dashboard.php" class="decoration-none flex items-center no-underline ">
                        <i class="fa-solid fa-house mr-2 text-blue-700 "></i>
                        <label class="text-black">Dashboard</label></a>
                </div>

                <!-- 2nd col -->
                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="admin.php" class="decoration-none flex items-center no-underline ">
                        <i class="fa-solid fa-user mr-5 text-blue-700"></i>
                        <label class="text-black">Admin</label></a>
                </div>



                <!-- Row 1 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-2 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="itemMaster.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-glasses mr-2 text-blue-700 "></i>
                        <label class="text-black">Item Master</label></a>
                </div>
                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-2 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="goodRecive.php" class="decoration-none flex items-center no-underline ">
                        <i class="fa-solid fa-book mr-2 text-blue-700 "></i>
                        <label class="text-black text-sm">Good Received Notes</label></a>
                </div>





                <!-- Row 2 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-1 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="customer_register.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-users ml-4 text-blue-700 "></i>
                        <label class="text-black ">Customer Register</label></a>
                </div>



                <!-- 2nd col -->

                <div
                    class="row-span-1 bg-gray-200 p-1 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="prescriptionInvoice.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-pen-to-square ml-3 text-blue-700 "></i>
                        <label class="text-black ">Prescription Invoice</label></a>
                </div>





                <!-- Row 3 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="balanceBill.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-credit-card  mr-3 text-blue-700 "></i>
                        <label class="text-black ">Balance Bill</label></a>
                </div>


                <!-- 2nd col -->

                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="otherSale.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-prescription-bottle  mr-3 text-blue-700 "></i>
                        <label class="text-black ">Other Sales</label></a>
                </div>





                <!-- Row 4 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="visitors.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-users mr-4 text-blue-700 "></i>
                        <label class="text-black ">Visitors</label></a>
                </div>


                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="jobStatus.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-pen-to-square mr-2 text-blue-700 "></i>
                        <label class="text-black ">Job Status</label></a>
                </div>




                <!-- Row 5 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="stockAdjust.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-microphone-lines mr-1 text-blue-700 "></i>
                        <label class="text-black ">Stock Adjust</label></a>
                </div>

                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="claimBill.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-umbrella mr-2 text-blue-700 "></i>
                        <label class="text-black ">Claim Bills</label></a>
                </div>



                <!-- Row 6 -->

                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="expenses.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-hand-point-up mr-5 text-blue-700 "></i>
                        <label class="text-black ">Expanse</label></a>
                </div>

                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="return.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-scissors mr-5 text-blue-700 "></i>
                        <label class="text-black ">Return</label></a>
                </div>




                <!-- Row 7 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="setting.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-screwdriver-wrench mr-5 text-blue-700 "></i>
                        <label class="text-black ">Setting</label></a>
                </div>

                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-book-open mr-2 text-blue-700 "></i>
                        <label class="text-black ">Reports</label></a>
                </div>





                <!-- Row 8 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-barcode mr-3 text-blue-700 "></i>
                        <label class="text-black ">Bar Code</label></a>
                </div>

                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1" >
                    <a href="" class="decoration-none flex items-center no-underline gap-2">
                        <i class="fa-regular fa-square-caret-right  text-blue-700 "></i>
                        <label class="text-black text-sm ">LESSON Training</label></a>
                </div>



                <!-- Row 9 -->
                <!-- 1st col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-pen-nib mr-2 text-blue-700 "></i>
                        <label class="text-black ">Pen Backup</label></a>
                </div>

                

                <!-- 2nd col -->
                <div
                    class="row-span-1 bg-gray-200 p-3 text-center font-bold flex items-center justify-center rounded-md hover:bg-gray-400 lg:col-span-1">
                    <a href="logout.php" class="decoration-none flex items-center no-underline">
                        <i class="fa-solid fa-circle-xmark mr-9 text-blue-700 "></i>
                        <label class="text-black ">Exit</label></a>
                </div>








            </div>
        </div>





        <section class="load-content xl:col-span-9 lg:col-span-8   p-2">
            <div class="flex justify-center items-center h-full">
                <!-- content load -->
            </div>
        </section>


    </div>



    <script>
    $(document).ready(function() {
        function loadContent(page) {
            $.get(page, function(data) {
                $('.load-content').html(data);
            }).fail(function(xhr, status, error) {
                console.error('Error loading content:', error);
            });
        }

        loadContent('dashboard.php');

        // $('.side-bar .menu  a').click(function(event) {
        //     event.preventDefault();
        //     var page = $(this).attr('href');
        //     loadContent(page);
        // });

    });

    
    </script>






</body>

</html>