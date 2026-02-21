<?php
include 'conn.php';
$_SESSION["page"] = basename($_SERVER['PHP_SELF']);
$x="";
if(isset($_POST['done']))
{
    $adm=mysqli_real_escape_string($con,stripslashes($_POST['adm']));
    $names=mysqli_real_escape_string($con,stripslashes($_POST['names']));
    $gender=mysqli_real_escape_string($con,stripslashes($_POST['gender']));
    $form=mysqli_real_escape_string($con,stripslashes($_POST['form1']));
    $stream=mysqli_real_escape_string($con,stripslashes($_POST['stream']));
if($adm!=""){
$q="SELECT adm from student where adm='$adm';";
$q=mysqli_query($con,$q);
if(mysqli_num_rows($q)>0){
 $x='<div id="toastsContainerTopRight" class="toasts-top-right fixed">
                            <div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                            <strong class="mr-auto">Fail</strong>
                                            <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                            </button>
                                    </div>
                                    <div class="toast-body">Admission Already Exists</div>
                            </div>
                    </div>';
                    

}
else{
$q="INSERT INTO student(adm,names,gender,form,stream)
        VALUES ( '$adm','$names','$gender','$form','$stream');";
mysqli_query($con,$q);
header('Location:index.php');}
}
}
include_once 'top.php';
echo $x;
?>
   
            <!-- 404 Start -->
            
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Add Student(s)</h6>
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
<li class="pt-2 px-3">
<h3 class="card-title"><?php echo rtrim($page, ".php"); ?></h3>
</li>
<li class="nav-item">
<a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Add Student</a>
</li>
<li class="nav-item">
<a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Upload Spreadsheet</a>
</li>

</ul>
<div class="card-body">
<div class="tab-content" id="custom-tabs-two-tabContent">
<div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
<!-- pill 1 -->
            <form method=POST>
            <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Student Details</h6>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="adm" name="adm"
                                    placeholder="Admission" required>
                                <label for="adm">Admission Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="names" name="names"
                                    placeholder="Names" required>
                                <label for="names">Names</label>
                            </div>
                                                   
                            <div class="form-floating mb-3">
                                <select class="form-control" id="gender"
                                    aria-label="gender" name="gender">
                                    <option selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    </select>


                                <label for="gender">Gender</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-control" id="form1"
                                    aria-label="form1" name="form1">
                                    <option selected>Select Form</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    </select>


                                <label for="form1">Form</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-control" id="stream"
                                    aria-label="stream" name="stream">
                                    <option selected>Select Stream</option>
                                    <option value="Alpha">Alpha</option>                                    
                                    <option value="Beta">Beta</option>
                                    <option value="Champion">Champion</option>
                                    <option value="Delta">Delta</option>
                                    <option value="Gamma">Gamma</option>
                                    </select>


                                <label for="stream">Stream</label>
                            </div>
                            <button type="submit" name="done" class="btn btn-outline-success m-2">Add Student</button>
                            
                        </div>
                    </form>
            <!-- 404 End -->

                                </div>
    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
    <!------------------Pill 2------------------>
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="fileToUpload" class="form-label" name="fileToUpload"><a href="templates/addstudent.xlsx">Download </a>and fill the template then upload it below. (Please leave the column headers intact) <br>Select Spreadsheet</label>
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
                                        
                                        <form action="code/codestudent.php" method="POST" enctype="multipart/form-data">

                                        
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