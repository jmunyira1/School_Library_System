<?php
include 'conn.php';
$_SESSION["page"] = basename($_SERVER['PHP_SELF']);
if(isset($_POST['done']))
{
    $adm=mysqli_real_escape_string($con,stripslashes($_POST['adm']));
    $names=mysqli_real_escape_string($con,stripslashes($_POST['names']));
    $gender=mysqli_real_escape_string($con,stripslashes($_POST['gender']));
    $form=0;
    $stream="Teacher";
if($adm!=""){
$q="INSERT INTO student(adm,names,gender,form,stream)
        VALUES ( '$adm','$names','$gender','$form','$stream');";
mysqli_query($con,$q);
header('Location:viewstaff.php');}
}
include_once 'top.php';
?>
   
            <!-- 404 Start -->
            
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Add Staff</h6>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Add Staff Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Upload Spreadsheet</button>
                                </li>
                               
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <!-- 404 Start -->
            <form method=POST>
            <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Staff Details</h6>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="adm" name="adm"
                                    placeholder="Library Number" required>
                                <label for="adm">Library Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="names" name="names"
                                    placeholder="Names" required>
                                <label for="names">Names</label>
                            </div>
                                                   
                            <div class="form-floating mb-3">
                                <select class="form-select" id="gender"
                                    aria-label="gender" name="gender">
                                    <option selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    </select>


                                <label for="gender">Gender</label>
                            </div>

                            
                            
                            <button type="submit" name="done" class="btn btn-outline-success m-2">Add Student</button>
                            
                        </div>
                    </form>
            <!-- 404 End -->

                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="fileToUpload" class="form-label" name="fileToUpload"><a href="templates/addstaff.xlsx">Download </a>and fill the template then upload it below. (Please leave the column headers intact) <br>Select Spreadsheet</label>
                                                <input class="form-control" type="file" name="the_file" id="fileToUpload">
                                            </div>
                                            <button type="submit" name="submit" value="Start Upload" class="btn btn-outline-success m-2">Upload</button>
                                        </form>

                                        <br>
                                        <?php
                                        if(file_exists('uploads/file.xlsx')){
                                        echo "<table class=\"table table-hover table-bordered border-primary\">";
                                
                                        
                                        // (A) PHPSPREADSHEET TO LOAD EXCEL FILE
                                        require "vendor/autoload.php";
                                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                                        $spreadsheet = $reader->load("uploads/file.xlsx");
                                        $worksheet = $spreadsheet->getActiveSheet();
                                        

                                        // (B) LOOP THROUGH ROWS OF CURRENT WORKSHEET
                                        foreach ($worksheet->getRowIterator() as $row) {
                                        // (B1) READ CELLS
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false);

                                        // (B2) OUTPUT HTML
                                        echo "<tr>";
                                        foreach ($cellIterator as $cell) { echo "<td>". $cell->getValue() ."</td>"; }
                                        echo "</tr>";
                                        }
                                        
                                        echo '</table>
                                        <br>
                                        
                                        <form action="codestaff.php" method="POST" enctype="multipart/form-data">

                                        
                                        <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
            
                                        </form>';
                                    }
                                        ?>

                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    
                                </div>
                            </div>
                        </div>
                    
                    <!-- 404 Start -->
                    

   <?php
   include_once 'bottom.php';
   ?>