<?php
include 'conn.php';
$_SESSION["page"] = basename($_SERVER['PHP_SELF']);
if(isset($_POST['done']))
{
$isbn=mysqli_real_escape_string($con,stripslashes($_POST['isbn']));
$title=mysqli_real_escape_string($con,stripslashes($_POST['title']));
$author=mysqli_real_escape_string($con,stripslashes($_POST['author']));
$publisher=mysqli_real_escape_string($con,stripslashes($_POST['publisher']));
$type=mysqli_real_escape_string($con,stripslashes($_POST['type']));
$form=mysqli_real_escape_string($con,stripslashes($_POST['form']));
$category=mysqli_real_escape_string($con,stripslashes($_POST['category']));
if($isbn!=""){
$q="INSERT INTO books(isbn,title,author,publisher, type , form,category)
        VALUES ( '$isbn','$title','$author','$publisher','$type','$form','$category');";
mysqli_query($con,$q);
header('Location:index.php');}
}
include_once 'top.php';
?>
   
            <!-- 404 Start -->
            
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Book Types</h6>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Add Book Details</button>
                                </li>

                               
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <!-- 404 Start -->
            <form method=POST>
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Book Details</h6>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="isbn" name="isbn"
                                    placeholder="ISBN Number" required>
                                <label for="isbn">ISBN Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Book Title" required>
                                <label for="title">Book Title</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="author" name="author"
                                    placeholder="author(s)" required>
                                <label for="author">Author(s)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="publisher" name="publisher"
                                    placeholder="Publisher" required>
                                <label for="publisher">Publisher</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="category"
                                    aria-label="category" name="category">
                                    <option selected>Select the book subject</option>
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="Computer">Computer</option>
                                    <option value="English">English</option>
                                    <option value="Kiswahili">Kiswahili</option>
                                    <option value="Chemistry">Chemistry</option>
                                    <option value="Physics">Physics</option>
                                    <option value="French">French</option>
                                    <option value="Geography">Geography</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Christian Religious Education">Christian Religious Education</option>
                                    <option value="History">History</option>
                                    <option value="Home science">Home Science</option>
                                    <option value="Biology">Biology</option>
                                    <option value="Business">Business</option>
                                    </select>


                                <label for="category">Book Category</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="type"
                                    aria-label="type" name="type">
                                    <option selected>Select the book type</option>
                                    <option value="set book">Set Book</option>
                                    <option value="students book">Students' Book</option>
                                    <option value="teachers book">Teacher' books</option>
                                    <option value="revision book">Revision books</option>
                                </select>
                                <label for="type">Book Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="form"
                                    aria-label="form" name="form">
                                    <option selected>Select form</option>
                                    <option value="General">General</option>
                                    <option value="1">Form 1</option>
                                    <option value="2">Form 2</option>
                                    <option value="3">Form 3</option>
                                    <option value="4">Form 4</option>
                                </select>
                                <label for="form">Form</label>
                            </div>
                            <button type="submit" name="done" class="btn btn-outline-success m-2">Add Book</button>
                            
                        </div>
                    </form>
            <!-- 404 End -->

                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="fileToUpload" class="form-label" name="fileToUpload"><a href="templates/addbbooktype.xlsx">Download </a>and fill the template then upload it below. (Please leave the column headers intact) <br>Select Spreadsheet</label>
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
                                        
                                        <form action="code.php" method="POST" enctype="multipart/form-data">

                                        
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