<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>sale return</title>
</head>

<body>
    <div class="container bg-white p-2 w-full ">

        <div class="row ">

            <div class="col-md-6">
                <h3 class="text-md">Sale <span class="text-warning">Return</span></h3>
            </div>


        </div>

        <!-- ======================================================================================================== -->


        <form id="saleReturnForm">
            <div class="grid grid-cols-12 gap-2">
                <!-- First row -->
                <div class="col-span-12  p-2 border-2 border-gray-200">

                    <label class="form-label text-sm font-bold"> Item</label>

                    <!-- 1st row 1st div -->
                    <div class="grid grid-cols-12 gap-4 ">


                        <div class="  col-span-2 ">
                            <label for="creditNoteVal" class="form-label text-xs font-semibold text-center ">Credit
                                Note No</label>
                            <input type="text" class="form-control h-8 " id="creditNoteVal" name="creditNoteVal">
                        </div>


                        <div class="  col-span-1 ">
                            <label for="ourNo" class="form-label text-xs font-medium">Our No:</label>
                            <input type="text" class="form-control h-8" id="ourNo" name="ourNo" required>
                        </div>


                        <div class="  col-span-2 ">
                            <label for="date" class="form-label text-xs font-medium text-center ">Date:</label>
                            <input type="date" class="form-control h-8 " id="date" name="date">
                        </div>

                        <div class="  col-span-1 ">
                            <label for="invoiceNo" class="form-label text-xs font-medium">Invoice No:</label>
                            <input type="text" class="form-control h-8" id="invoiceNo" name="invoiceNo" required>
                        </div>





                        <div class="  col-span-4 gap-1 ">
                            <label for="customer" class="form-label text-xs font-medium">Customer :</label>
                            <div class="flex gap-2">
                                <input type="text" class="form-control h-8" id="customer" name="customer" required>
                                <input type="text" class="form-control h-8" id="customer" name="customer" required>
                            </div>


                        </div>

                        <div class="  col-span-2 ">
                            <label for="netInvoVal" class="form-label text-xs font-medium">Net Invoice Value:</label>
                            <input type="text" class="form-control h-8" id="netInvoVal" name="netInvoVal" required>
                        </div>


                    </div>

                    <hr class="text-black font-bold">
                    <!-- 2nd row 1st div -->
                    <div class="grid grid-cols-12 gap-4 ">


                        <div class="  col-span-2 ">
                            <label for="itemNo" class="form-label text-xs font-medium">Item No</label>
                            <input type="text" class="form-control h-8" id="itemNo" name="itemNo" required>
                        </div>


                        <div class="  col-span-2 ">
                            <label for="description" class="form-label text-xs font-medium">Description</label>
                            <input type="text" class="form-control h-8" id="description" name="description" required>
                        </div>


                        <div class="  col-span-1 ">
                            <label for="qty" class="form-label text-xs font-medium ">Qty</label>
                            <input type="text" class="form-control h-8 " id="qty" name="qty">
                        </div>

                        <div class="  col-span-1 ">
                            <label for="discount" class="form-label text-xs font-medium">Disc </label>
                            <input type="text" class="form-control h-8" id="discount" name="discount">
                        </div>





                        <div class="  col-span-2 gap-1 ">
                            <label for="price" class="form-label text-xs font-medium"> Price</label>
                            <input type="text" class="form-control  h-8" id="price" name="price">

                        </div>

                        <div class="  col-span-2 ">
                            <label for="discount" class="form-label  text-xs font-medium">Discount</label>
                            <input type="text" class="form-control  h-8" id="discount" name="discount">
                        </div>

                        <div class="  col-span-2 ">
                            <label for="amount" class="form-label text-xs font-medium">Amount</label>
                            <input type="text" class="form-control h-8" id="amount" name="amount" required>
                        </div>


                    </div>



                </div>





                <!-- 2nd row -->

                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-3 ">



                        <div class="col-span-9 w-full">
                            <label class="form-label text-sm font-bold"> Credit Note</label>

                            <div class="max-h-32 overflow-y-auto">
                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Name</th>
                                            <th> No</th>
                                            <th>Qty</th>
                                            <th>%</th>

                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th></th>


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

                        <div class="col-span-3 w-full">
                            <label for="creditNoteVal" class="form-label text-xs font-semibold text-center mt-2">Credit
                                Note Value</label>
                            <input type="text" class="form-control h-8 " id="creditNoteVal" name="creditNoteVal">
                        </div>
                    </div>
                </div>


                <!-- 4th row -->
                <div class="col-span-12  p-1 border-2 border-gray-200">
                    <div class="grid grid-cols-12 gap-1 ">



                        <div class="col-span-12 w-full">
                            <label class="form-label text-sm font-bold"> Current Invoice</label>

                            <div class="max-h-32 overflow-y-auto">
                                <table class="table table-bordered custom-table">
                                    <thead class="text-xs">
                                        <tr>
                                            <th>Name</th>
                                            <th> No</th>
                                            <th>Qty</th>
                                            <th>Discount</th>

                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th></th>


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
        document.getElementById("saleReturnForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>