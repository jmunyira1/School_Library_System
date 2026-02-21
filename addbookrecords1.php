<?php
include_once 'conn.php';

if(isset($_POST['chosenbook'])){
    if($_POST['chosenbook']=="addbook"){
        header('Location:addbooktype.php');
    }
    else{
$chosenisbn = $_POST['chosenbook'];
$_SESSION['chosenbook']=$chosenisbn;}
}
if(isset($_SESSION['chosenbook'])){
$chosenisbn =$_SESSION['chosenbook'];}
?>
<?php
include_once 'top.php'; ?>
<!-- 404 Start -->



<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="pt-2 px-3">
                <h3 class="card-title"><?php echo rtrim($page, ".php"); ?></h3>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Add Book Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Upload Spreadsheet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Auto</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                <!-- pill 1 -->
                <form method=post>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Select Book</label>
                            <select name="chosenbook" class="form-control select2" style="width: 100%;" onchange="this.form.submit()">
                                <option>Select book...</option>
                                <?php

                                $sql = "SELECT title,isbn,form,publisher,type
                                                FROM books
                                                ORDER BY title,form ASC";

                                $result = mysqli_query($con, $sql);

                                if (mysqli_num_rows($result) > 0) {

                                    while($row = mysqli_fetch_assoc($result)) {
                                        if($row['form']==0){
                                            $r="";
                                        }
                                        else{
                                            $r=" Form ".$row['form'];
                                        }
                                        if($row['type']=='teachers book'){
                                            $r=$r." Teacher's Guide ";
                                        }                            if (isset($chosenisbn)) {
                                            if ($chosenisbn===$row['isbn']) {
                                                echo "<option value=\"".$row['isbn']."\"selected>".$row['title'].$r." by ".$row['publisher']."</option>";
                                            }
                                            else{
                                                echo "<option value=\"".$row['isbn']."\">".$row['title'].$r." by ".$row['publisher']."</option>";}
                                            }
                                            else{
                                                
                                                echo "<option value=\"".$row['isbn']."\">".$row['title'].$r." by ".$row['publisher']."</option>";
                                            }
                                        
                                    }
                                
                                }

                                ?>
                                 <option value="addbook">Don't See Your Book? Click Here to add it</option>
                            </select>
                        </div>
                    </div>

                </form>

                <br>
           
                <h2><?php if (isset($chosenisbn)) {
                        $q = "SELECT title, form,publisher,type FROM books WHERE isbn='$chosenisbn'";
                        $query = mysqli_query($con, $q);
                        while ($row = mysqli_fetch_array($query)) {
                            
                            
                            if ($row['form'] == "0") {

                                $r="";
                            } else {
                                $r=" Form ".$row['form'];
                            }
                            if($row['type']=='teachers book'){
                                $r=$r." Teacher's Guide ";
                            } 
                        
                        echo $row['title'].$r." by ".$row['publisher'];}
                    } else {
                        echo "Please choose book to be added";
                    } ?></h2>
                <br>


                <script type="text/JavaScript">
                    function createNewElement() {
    // First create a DIV element.
	var txtNewInputBox = document.createElement('div');

    // Then add the content (a new input box) of the element.
	txtNewInputBox.innerHTML = "<input type='text'  name='serial[]' class='form-control m-2'>";

    // Finally put it where it is supposed to appear.
	document.getElementById("newElementId").appendChild(txtNewInputBox);
}
</script>
                <form method="POST" action="qr.php">


                    <input type="hidden" name="isbn" value="<?php echo $chosenisbn; ?>">
                    <input type="hidden" name="single" value="y">
                    <td><input name="serial[]" type="text" class='form-control m-2'></td>
                    <div id="newElementId"></div>
                    <div id="dynamicCheck">
                        <input type="button" value="Add Book Serial" class="btn btn-outline-success" onclick="createNewElement();" />
                    </div>

                    <br>
                    <button type="submit" name="add" class="btn btn-success">Submit</button>

                </form>
            </div>

            <!---end of pill 1--->

            <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                <!------------------Pill 2------------------>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fileToUpload" class="form-label" name="fileToUpload"><a href="templates/addbookrecords.xlsx">Download </a>and fill the template then upload it below. (Please leave the column headers intact) <br>Select Spreadsheet</label>
                        <input class="form-control" type="file" name="the_file" id="fileToUpload">
                    </div>
                    <button type="submit" name="submit" value="Start Upload" class="btn btn-outline-success m-2">Upload</button>
                </form>

                <br>
                <?php
                if (file_exists('uploads/file.xlsx')) {
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
                        foreach ($cellIterator as $cell) {
                            echo "<td>" . $cell->getValue() . "</td>";
                        }
                        echo "</tr>";
                    }

                    echo '</table>
                                        <br>
                                        
                                        <form action="code/coderecords.php" method="POST" enctype="multipart/form-data">

                                        
                                        <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
            
                                        </form>';
                }
                ?>
                <!--------------------End of Pill 2--------------------->
            </div>
            <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                <!--------------------Pill 3--------------------->
                <form method="post" action="qr.php">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Book Details</h6>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="isbn" name="isbn" placeholder="ISBN Number" required>
                            <label for="isbn">ISBN Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="serial" name="serial[]" placeholder="Book serial" required>
                            <label for="serial">Book serial</label>
                        </div>
                        

                        <button type="submit" name="done" class="btn btn-outline-success m-2">Add Book</button>

                    </div>
                </form>
                <!--------------------End of Pill 3--------------------->

            </div>

        </div>
    </div>







</div>
<?php
include_once 'bottom.php';
?>