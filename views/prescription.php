<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Prescription</title>





</head>

<body>
    <div class="border-2 border-gray-200 p-1 mb-3">

    <?php 

    session_start();

    require_once '../controllers/db.php';
    require_once '../controllers/prescriptionController.php';
    $jobNo = getLastJobNumber($conn);


    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $date = $_POST["date"];
            $jobNo = $jobNo;
            $rightVA = $_POST["rightVA"];
            $rightPH = $_POST["rightPH"];
            $rightHM = $_POST["rightHM"];
            $rightIOL = $_POST["rightIOL"];
            $rightsub = $_POST["rightsub"];
            $leftVA = $_POST["leftVA"];
            $leftPH = $_POST["leftPH"];
            $leftHM = $_POST["leftHM"];
            $leftIOL = $_POST["leftIOL"];
            $leftsub = $_POST["leftsub"];
            $note = $_POST["note"];

            $rightDista = $_POST["rightDista"];
            $rightAdd = $_POST["rightAdd"];
            $prescriptionRightVA = $_POST["prescriptionRightVA"];
            $NPD = $_POST["NPD"];
            $rightMPD = $_POST["rightMPD"];
            $rightCyl = $_POST["rightCyl"];
            $rightAxis = $_POST["rightAxis"];
            $leftDista = $_POST["leftDista"];
            $leftAdd = $_POST["leftAdd"];
            $prescriptionLeftVa = $_POST["prescriptionLeftVa"];
            $leftDpd = $_POST["leftDpd"];
            $leftMpd = $_POST["leftMpd"];
            $leftCyl = $_POST["leftCyl"];
            $leftAxis = $_POST["leftAxis"];
            $prescriptionSh = $_POST["prescriptionSh"];
            $tested = $_POST["tested"];
            $nextvisit = $_POST["nextvisit"];
            $dueDate = $_POST["dueDate"];
            
            require_once '../controllers/db.php';

            $savedAssesment = saveAssessment($conn, $date, $jobNo, $rightVA, $rightPH, $rightHM, $rightIOL, $rightsub, $leftVA, $leftPH, $leftHM, $leftIOL, $leftsub, $note);

            $savedprescription = savePrescription($conn, $jobNo, $rightDista, $rightAdd, $prescriptionRightVA, $NPD, $rightMPD, $rightCyl, $rightAxis, $leftDista, $leftAdd, $prescriptionLeftVa, $leftDpd, $leftMpd, $leftCyl, $leftAxis, $prescriptionSh, $tested, $nextvisit, $dueDate);  

            if($savedprescription && $savedAssesment){
                echo '<script>alert("Saved Successfullly..!..!")</script>';
            }else{
                echo '<script>alert("something Went wrong..!")</script>';
            }

        }else if(isset($_POST['createJob'])){

            //$officer = $_SESSION['officer'];
            $officer = "sanaka";
            $date = $_POST["date"];
            $cusRegNo = $_POST["abc"];

            if(empty($date) || empty($cusRegNo)){
                echo '<script>alert("Date and Customer Register Number Required..!")</script>';
            }else{
                require_once '../controllers/db.php';
                $jobNo = createJobNumber($conn, $date, $cusRegNo, $officer);
            }

        }else if(isset($_POST['clear'])){
            $_SESSION['customerResult'] = null;
            $_SESSION['assesmentData'] = null;
            $_SESSION['prescriptionData'] = null;
        }
  

    }


    $_SESSION['job_number'] = $jobNo;
    
    ?>
        <h3 class="text-lg font-bold">Prescription</h3>
        <form id="prescriptionForm" action="prescription.php" method="post">
            <div class="grid grid-cols-12 gap-2 ">
                <!-- First row -->
                <div class="col-span-12  p-1 ">

                <input type="hidden" id="abc" name="abc" value="">

                <?php 

                $regNum; 
                    if (isset($_SESSION['search_result'])) {
                        $regNum = $_SESSION['search_result'];
                    
                    }

                    echo '<script>';
                    echo 'document.getElementById("abc").value="'.$regNum.'"';
                    echo '</script>';
                    
                ?>



                    <div class="grid grid-cols-12 gap-2 ">
                        <div class=" flex col-span-2 gap-2">
                            <label for="date" class="form-label text-xs font-medium text-center mt-2">Pres Date:</label>
                            <input type="date" class="form-control h-10 " id="date" name="date">
                        </div>

                        <div class="  col-span-2 gap-2">

                            <div class="flex mb-0">

                                <label for="jobNo" class="form-label text-xs font-medium text-center mt-2">Job
                                    No:</label>
                                <div class="border-2 border-gray-200 h-10 w-full">
                                    <label
                                        class="form-label text-sm flex justify-center font-bold text-center mt-2 text-black" name="jobNo" id="jobNo">
                                    <?php
                                        echo '<script>';
                                        echo 'document.getElementById("jobNo").textContent ="'.$jobNo.'"';
                                        echo '</script>';
                                    ?>
                                    </label>


                                </div>
                            </div>
                            <div class="text-center">
                                <label class="form-label text-xs text-red-600 font-medium text-center mt-0">Don't Change
                                    Manually</label>
                            </div>


                        </div>

                        <div class=" flex col-span-2 ">
                            <button
                                class="shadow-lg bg-gray-300 text-black font-semibold p-2 h-10 rounded-md w-full hover:bg-gray-200" name="createJob">Create
                                Job No</button>
                        </div>

                        <div class=" flex col-span-2 ">
                            <button
                                class="shadow-lg bg-gray-300 text-black font-semibold p-2  rounded-md w-full text-sm h-10 hover:bg-gray-200">Find
                                Missing Job No</button>
                        </div>

                    </div>
                </div>

                <!-- Second row -->
                <div class="col-span-12  p-1 ">
                    <div class="grid grid-cols-12 gap-4 mt-1">

                        <div class="  col-span-6 ">
                            <div class="bg-black text-white font-semibold">
                                <h1 class=" text-sm text-center">Assesments</h1>
                            </div>

                            <div class="grid grid-cols-12 gap-3">

                                <!-- right eye -->
                                <div class="col-span-6">
                                    <label class="text-xs text-green-700 font-bold">Right Eye</label>

                                    <div class="flex mt-2 gap-1 ">
                                        <label for="VA" class="font-semibold text-xs">VA:</label>
                                        <input type="text" class="form-control h-6" id="rightVA" name="rightVA">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="PH" class="font-semibold text-xs">P/H:</label>
                                        <input type="text" class="form-control h-6" id="rightPH" name="rightPH">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="HM" class="font-semibold text-xs">H/M:</label>
                                        <input type="text" class="form-control h-6" id="rightHM" name="rightHM">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="IOL" class="font-semibold text-xs">IOL:</label>
                                        <input type="text" class="form-control h-6" id="rightIOL" name="rightIOL">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="sub" class="font-semibold text-xs">Sub:</label>
                                        <input type="text" class="form-control h-6" id="rightsub" name="rightsub">

                                    </div>
                                    


                                </div>

                                

                                   


                                <!-- left eye -->
                                <div class="col-span-6">
                                    <label class="text-xs text-green-700 font-bold">Left Eye</label>

                                    <div class="flex mt-2 gap-1 ">
                                        <input type="text" class="form-control h-6" id="leftVA" name="leftVA">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <input type="text" class="form-control h-6" id="leftPH" name="leftPH">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <input type="text" class="form-control h-6" id="leftHM" name="leftHM">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <input type="text" class="form-control h-6" id="leftIOL" name="leftIOL">

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <input type="text" class="form-control h-6" id="leftsub" name="leftsub">

                                    </div>

                                </div>

                                
                            </div>
                        </div>

                        <div class="  col-span-6 gap-2">
                            <label for="note" class="form-label text-xs font-medium text-center">Notes <span
                                    class="font-semibold">(Press Shift+Enter Keys For Line Breaks)</span></label>
                            <textarea
                                class="form-control  w-full h-40 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-md"
                                id="note" name="note"></textarea>
                        </div>

                        <?php

                                    if (isset($_SESSION['assesmentData'])) {
                                        $data = $_SESSION['assesmentData'];

                                    if($data != null){
                                    foreach ($data as $assessment) {
                                        echo '<script>';
                                        echo 'document.getElementById("rightVA").value = "' . $assessment['rightVa'] . '";';
                                        echo 'document.getElementById("rightPH").value = "' . $assessment['rightPh'] . '";';
                                        echo 'document.getElementById("rightHM").value = "' . $assessment['rightHm'] . '";';
                                        echo 'document.getElementById("rightIOL").value = "' . $assessment['rightIol'] . '";';
                                        echo 'document.getElementById("rightsub").value = "' . $assessment['rightSub'] . '";';
                                        echo 'document.getElementById("leftVA").value = "' . $assessment['leftVa'] . '";';
                                        echo 'document.getElementById("leftPH").value = "' . $assessment['leftPh'] . '";';
                                        echo 'document.getElementById("leftHM").value = "' . $assessment['leftHm'] . '";';
                                        echo 'document.getElementById("leftIOL").value = "' . $assessment['leftIol'] . '";';
                                        echo 'document.getElementById("leftsub").value = "' . $assessment['leftSub'] . '";';
                                        echo 'document.getElementById("note").text = "' . $assessment['note'] . '";';
                                        echo '</script>';
                                    }
                                }
                                }
                       ?>



                    </div>
                </div>

                <!-- Third row -->
                <div class="col-span-12  p-1 mt-2">


                    <div class="grid grid-cols-12 gap-4 mt-1">



                        <div class="  col-span-8 ">
                            <div class="bg-black text-white font-semibold">
                                <h1 class=" text-sm text-center">Prescription</h1>
                            </div>

                            <div class="grid grid-cols-12 gap-3">
                                <!-- right eye -->
                                <div class="col-span-2">
                                    <label class="text-xs text-green-700 font-bold">RE Sph</label>

                                    <div class="flex mt-2 gap-1 ">
                                        <label for="Dista" class="font-semibold text-xs">Dista:</label>
                                        <select class="form-select h-6" name="rightDista" id="rightDista" >
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        </select>
                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="add" class="font-semibold text-xs">Add:</label>
                                        <select class="form-select h-6" name="rightAdd" id="rightAdd">
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        </select>
                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="VA" class="font-semibold text-xs">VA:</label>
                                        <input type="text" class="form-control h-6" id="prescriptionRightVA" name="prescriptionRightVA" >

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="NPD" class="font-semibold text-xs">N.PD:</label>
                                        <input type="text" class="form-control h-6" id="NPD" name="NPD" >

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="MPD" class="font-semibold text-xs">M.PD:</label>
                                        <input type="text" class="form-control h-6" id="rightMPD" name="rightMPD" >

                                    </div>


                                </div>

                                <div class="col-span-2">
                                    <label class="text-xs text-green-700 font-bold">Cyl</label>
                                    <select class="form-select h-6" name="rightCyl" id="rightCyl">
                                    <option value="100">100</option>
                                    <option value="100">100</option>
                                    <option value="100">100</option>
                                    </select>

                                </div>

                                <div class="col-span-2">
                                    <label class="text-xs text-green-700 font-bold">Axis</label>

                                    <input type="text" class="form-control h-6" id="rightAxis" name="rightAxis" >

                                </div>


                                <!-- left eye -->
                                <div class="col-span-2">
                                    <label class="text-xs text-green-700 font-bold">LE Sph</label>

                                    <div class=" mt-2 gap-1 ">
                                        <select class="form-select h-6" name="leftDista" id="leftDista">
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        </select>

                                    </div>

                                    <div class=" mt-2 gap-1">
                                        <select class="form-select h-6" name="leftAdd" id="leftAdd" >
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                        </select>

                                    </div>

                                    <div class=" mt-2 gap-1">
                                        <input type="text" class="form-control h-6" id="prescriptionLeftVa" name="prescriptionLeftVa" >

                                    </div>

                                    <div class="flex mt-2 gap-1">
                                        <label for="DPD" class="font-semibold text-xs">D.PD:</label>
                                        <input type="text" class="form-control h-6" id="leftDpd" name="leftDpd" >

                                    </div>

                                    <div class=" mt-2 gap-1">
                                        <input type="text" class="form-control h-6" id="leftMpd" name="leftMpd" >

                                    </div>

                                </div>

                                <div class="col-span-2">
                                    <label class="text-xs text-green-700 font-bold">Cyl</label>


                                    <select class="form-select h-6" name="leftCyl" id="leftCyl" >
                                    <option value="100">100</option>
                                        <option value="100">100</option>
                                        <option value="100">100</option>
                                    </select>

                                </div>

                                <div class="col-span-2">
                                    <label class="text-xs text-green-700 font-bold">Axis</label>


                                    <input type="text" class="form-control h-6" id="leftAxis" name="leftAxis" >

                                    <div class="flex gap-1 mt-6">
                                        <label class="text-xs  font-semibold">SH</label>


                                        <input type="text" class="form-control h-6" id="sh" name="prescriptionSh" >
                                    </div>

                                </div>


                            </div>
                        </div>


                        <!-- tested by -->
                        <div class="  col-span-4 gap-2">
                            <div>
                                <label for="tested" class="form-label text-xs font-medium text-center">Tested By
                                </label>
                                <select class="form-select h-6" id="tested" name="tested" >
                                <option value="100">100</option>
                                <option value="100">100</option>
                                <option value="100">100</option>
                                </select>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <div>
                                    <label for="nextvisit" class="form-label text-xs font-medium text-center">Next Visit
                                    </label>
                                    <input type="date" class="form-control h-6 " id="nextvisit" name="nextvisit">
                                </div>

                                <div>
                                    <label for="dueDate" class="form-label text-xs font-medium text-center">Due Date
                                    </label>
                                    <input type="date" class="form-control h-6 " id="dueDate" name="dueDate">
                                </div>

                            </div>


                        </div>

                        <?php

                        if (isset($_SESSION['prescriptionData'])) {
                            $data = $_SESSION['prescriptionData'];

                        if($data != null){

                        foreach ($data as $prescription) {
                            echo '<script>';
                            // echo 'document.getElementById("rightDista").option[0].value = "' . $prescription['rightDista'] . '";';
                            // echo 'document.getElementById("rightAdd").option[0].value = "' . $prescription['rightAdd'] . '";';
                            // echo 'document.getElementById("rightCyl").option[0].value = "' . $prescription['rightCyl'] . '";';
                            // echo 'document.getElementById("leftDista").option[0].value = "' . $prescription['leftDista'] . '";';
                            // echo 'document.getElementById("leftAdd").option[0].value = "' . $prescription['leftAdd'] . '";';
                            // echo 'document.getElementById("leftCyl").option[0].value = "' . $prescription['leftCyl'] . '";';
                            // echo 'document.getElementById("tested").option[0].value = "' . $prescription['testedBy'] . '";';
                            echo 'document.getElementById("prescriptionRightVA").value = "' . $prescription['rightVa'] . '";';
                            echo 'document.getElementById("NPD").value = "' . $prescription['rightNPd'] . '";';
                            echo 'document.getElementById("rightMPD").value = "' . $prescription['rightMPd'] . '";';
                            echo 'document.getElementById("rightAxis").value = "' . $prescription['rightAxis'] . '";';
                            echo 'document.getElementById("prescriptionLeftVa").value = "' . $prescription['leftVa'] . '";';
                            echo 'document.getElementById("leftDpd").value = "' . $prescription['leftDdp'] . '";';
                            echo 'document.getElementById("leftMpd").value = "' . $prescription['leftMdp'] . '";';
                            echo 'document.getElementById("leftAxis").value = "' . $prescription['leftAxis'] . '";';
                            echo 'document.getElementById("sh").value = "' . $prescription['sh'] . '";';
                            echo 'document.getElementById("nextvisit").value = "' . $prescription['nextVisit'] . '";';
                            echo 'document.getElementById("dueDate").value = "' . $prescription['dueDate'] . '";';
                           
                            echo '</script>';
                        }
                    }
                }

                    ?>


                    </div>
                    
                </div>


            </div>

            <div class="grid grid-cols-12 gap-2 mt-5">
                <div class="col-span-4">
                  
                </div>
                <div class="col-span-8 text-end justify-self-end">
                    <div class="mb-3 gap-3">
                        <label for="submit" class="form-label"></label>
                        <button type="submit" class="bg-blue-600 text-white p-2 font-semibold w-32 text-sm"
                            name="submit">Patient Register</button>
                        <button type="submit" class="bg-green-600 text-white p-2 font-semibold w-32"
                            name="save">Save</button>
                        <button type="submit" class="bg-black text-white p-2 font-semibold w-32" name="submit">View
                            PDF</button>
                        <button type="submit" class="bg-yellow-500 text-white p-2 font-semibold w-32"
                            onclick="clearForm()" name="clear">Clear</button>
                        <button type="submit" class="bg-red-500 text-white p-2 font-semibold w-32"
                            name="submit">Delete</button>
                    </div>
                </div>
            </div>

        </form>
    </div>



    <script>

      

    function clearForm() {
        document.getElementById("prescriptionForm").reset();
    }

    function exit() {
        window.location.href = "index.php";
    }
    </script>
</body>

</html>