<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="p-4 overflow-y-hidden">
    <div class="container mx-auto bg-white p-3 shadow-xl">


        <div class="row mb-2">
            <div class="col-md-8">
                <h3>Visitors <span class="text-warning">Details</span></h3>
            </div>
            <div class="col-md-4">
            <form id="visitorForm" action="supplier.php" method="post">
                <div class="flex items-center">
                    <input type="text" class="form-control rounded-full shadow-xl p-2" id="word" name="word"
                        placeholder="Search...">
                    <button class="text-yellow-500 text-xl ml-4 hover:text-blue-700"type="submit" name="search">
                        <i class="fa-solid fa-notes-medical"></i>
                    </button>
                </div>
                </form>
            </div>
        </div>

        <form id="visitorsForm" action="supplier.php" method="post">
            <div class="row mt-4 gap-2">
                <div class="col-md-2">
                    <div class="mb-2 ">
                        <label for="date" class="form-label text-sm font-bold">Date:</label>
                        <input type="date" class="form-control h-7 w-full" id="date" name="date" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label for="regNo" class="form-label text-sm font-bold">Reg No:</label>
                        <input type="text" class="form-control h-7 w-full" id="regNo" name="regNo" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-2">
                        <label for="name" class="form-label text-sm font-bold">Name:</label>
                        <input type="text" class="form-control h-7 w-full" id="name" name="name" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-2">
                        <label for="teleMobile" class="form-label text-sm font-bold">Telephone (Mobile):</label>
                        <div class="flex gap-1">
                            <input type="tel" class="form-control h-7" id="teleMobile" name="teleMobile" required>
                            <input type="tel" class="form-control h-7" id="teleMobile" name="teleMobile" required>

                        </div>
                    </div>
                </div>
            </div>




            <div class="col-span-12  mb-2">
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3">
                        <div class="mb-2">
                            <div class="text-red-500">පැමිණීමේ අරමුණ?</div>

                            <label for="purpose" class="form-label text-sm font-bold">Purpose:</label>
                            <select class="form-select h-8 " id="purpose" name="purpose">
                                <option value="0">0</option>
                                <option value="0">0</option>
                                <option value="0">0</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-3">
                        <div class="mb-2">

                            <div class="text-red-500">පැවසු දෙය?</div>

                            <label for="visitor-comment" class="form-label text-sm font-bold">Visitor's Comment:</label>
                            <select class="form-select h-8" id="visitor-comment" name="visitor-comment">
                                <option value="0">0</option>
                                <option value="0">0</option>
                                <option value="0">0</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-span-12 ">
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3">
                        <div class="mb-2">
                            <div class="text-red-500">ඔබ ඔබේ ඇස් පරීක්ෂා කළාද?</div>

                            <label for="purpose" class="form-label text-sm font-bold">Have you checked your eyes?
                                :</label>
                            <select class="form-select h-8 " id="purpose" name="purpose">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-8">
                        <div class="mb-2">
                            <div class="text-red-500">ඔවුන් නැවත පැමිණෙනු ඇතැයි ඔබ අපේක්ෂා කරන්නේ දින කීයකින්ද ?</div>

                            <label for="visitor-comment" class="form-label text-sm font-bold">In how many days do you
                                expect them to return?</label>
                            <div class="flex gap-2">
                                <select class="form-select h-8 w-3" id="visitor-comment" name="visitor-comment">
                                    <option value="0">0</option>
                                    <option value="0">0</option>
                                    <option value="0">0</option>
                                </select>

                                <input type="date" class="form-control h-7 w-full" id="date" name="date" required>

                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <div class="col-span-12  mb-2">
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3">
                        <div class="mb-2">
                            <div class="text-red-500">ඔවුන් සමඟ කතා කරන අයගේ නම</div>

                            <label for="purpose" class="form-label text-sm font-bold">Staff Member:</label>
                            <select class="form-select h-8 " id="purpose" name="purpose">
                                <option value="0">0</option>
                                <option value="0">0</option>
                                <option value="0">0</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-5">
                        <div class="mb-2">

                            <div class="text-red-500">පැමිණි අය පිළිබද නිගමනය ?</div>

                            <label for="visitor-comment" class="form-label text-sm font-bold">Conclusion about those who
                                came:</label>
                            <select class="form-select h-8" id="visitor-comment" name="visitor-comment">
                                <option value="0">0</option>
                                <option value="0">0</option>
                                <option value="0">0</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-span-12  mb-2">
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-7">
                        <div class="mb-2">
                            <div class="text-red-500">විස්තරය</div>
                            <label for="vision-details" class="form-label text-sm font-bold">Vision details and
                                others:</label>
                            <textarea class="h-20 w-full border border-gray-300 p-2 rounded" id="vision-details"
                                name="vision-details"></textarea>
                        </div>

                    </div>

                    <!-- <div class="col-span-3">
                        <div class="mb-2 flex justify-center">

                            <form id="searchvisitor" action="itemMaster.php" method="post">
                                <div class="flex items-center ">
                                    <input type="text" class="form-control bg-white rounded-full shadow-xl" id="keyword"
                                        name="keyword" placeholder="Search...">
                                    <button class="ml-4 text-yellow-500 text-xl hover:text-blue-700" type="submit"
                                        name="search">
                                        <i class="fa-solid fa-notes-medical"></i> </button>
                                </div>
                            </form>


                        </div>
                    </div> -->
                </div>


                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="mb-3 d-flex justify-content-end gap-1">
                            <label for="submit" class="form-label"></label>
                            <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-28"
                                name="submit">Submit</button>
                            <button type="submit" class="bg-yellow-500 text-white p-2 font-semibold w-28"
                                onclick="clearForm()">Clear</button>
                                <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-32" name="submit">Delete</button>

                            <button type="submit" class="bg-black text-white p-2 font-semibold w-28" onclick="exit()"
                                name="submit">Exit</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <script>
    function clearForm() {
        document.getElementById("visitorsForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>

</body>

</html>