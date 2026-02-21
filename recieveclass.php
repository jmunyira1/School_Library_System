<?php
include 'conn.php';
include_once 'top.php';
if(isset($_POST['chosenbook']))
{
    $bookisbn=$_POST['chosenbook'];
    $_SESSION['bookisbn']=$bookisbn;
}
if(isset($_POST['form']))
{
    $form=$_POST['form'];
    $_SESSION['form']=$form;
}
if(isset($_POST['stream']))
{
    $stream=$_POST['stream'];
    $_SESSION['stream']=$stream;
}

/*Set variables if sessions exist*/

if(isset($_SESSION['bookisbn'])){
    $bookisbn=$_SESSION['bookisbn'];}
    if(isset($_SESSION['form'])){
        $form=$_SESSION['form'];}
        if(isset($_SESSION['stream'])){
            $stream=$_SESSION['stream'];}
            
            if(isset($_POST['recieve'])){
                $recieve=$_POST['recieve'];
                $q="UPDATE bookrecords
                SET possesor = 0
                WHERE isbn = $bookisbn AND serial = '$recieve'; ";
                mysqli_query($con,$q);
            }
            
            ?>
            <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="pt-2 px-3">
            <h3 class="card-title"><?php echo rtrim($page, ".php"); ?></h3>
            </li>
            <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Recieve</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Upload Spread sheet</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Auto</a>
            </li>
            
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
            <!-------------------pill 1------------->
            
            <div class="form-row">
            <div class="col">
            <form id="formform" method=post>
            <select name="form" class="form-control" onchange="document.getElementById('formform').submit();"> 
            <option value="" <?php if($form===''){echo ' selected';}?>>Select Form...</option>
            <option value="1" <?php if($form==='1'){echo ' selected';}?>>Form 1</option>
            <option value="2" <?php if($form==='2'){echo ' selected';}?>>Form 2</option>
            <option value="3" <?php if($form==='3'){echo ' selected';}?>>Form 3</option>
            <option value="4" <?php if($form==='4'){echo ' selected';}?>>Form 4</option>
            </select>
            </form>
            </div>
            <div class="col">
            <form method="post" id="formstream">
            <select name="stream" class="form-control" onchange="document.getElementById('formstream').submit();">
            <option value="all" selected>Select Stream...</option>
            
            <?php
            
            
            $sql = "SELECT DISTINCT stream
            FROM student
            WHERE stream<>'0' AND stream<>'Teacher'
            ORDER by stream;";
            
            $result = mysqli_query($con, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    
                    if (isset($stream)) {
                        if ($stream===$row['stream']) {
                            echo "<option value=\"".$row['stream']."\" selected>".$row['stream']."</option>";
                        }
                        else{
                            echo "<option value=\"".$row['stream']."\">".$row['stream']."</option>";}
                        }
                        else{
                            echo "<option value=\"".$row['stream']."\">".$row['stream']."</option>";}
                            
                        }
                    }
                    
                    ?>
                    </select>
                    </form>
                    </div>
                    </div>
                    <form method="post">
                    <div class="form-group">
                    <label>Select Book</label>
                    <select name="chosenbook" class="form-control select2" style="width: 100%;"  onchange="this.form.submit()">
                    <option>Please Select a book</option>
                    
                    <?php
                    
                    
                    $sql = "SELECT DISTINCT books.title, books.publisher,books.form,books.isbn
                    FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
                    WHERE bookrecords.possesor<>0
                    ORDER by books.title;";
                    
                    $result = mysqli_query($con, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            if($row['form']==0){
                                $r="";
                            }
                            else{
                                $r=" Form ".$row['form'];
                            }
                            if (isset($bookisbn)) {
                                if ($bookisbn===$row['isbn']) {
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
                        </select>
                        
                        <br>
                        </div></form>
                        <?php include 'searchtable.php'?>
                        <div class="table-responsive" id="print">
                        
                        <table id="myTable" class="table table-hover table-bordered border-primary ">
                        <thead>
                        
                        <th class="text-center" colspan="<?php
                        $q=4;
                        if (isset($stream)) {
                                    if($stream==='all'){
                                        $q=5;}}echo $q;?>"><?php if($stream==='all'){echo "Form ".$form;}else{echo "Form ".$form." ".$stream;}?></th></tr>
                        <th class="text-center" colspan="<?php echo $q;?>"><?php $q="SELECT title,publisher,form FROM books WHERE isbn='$bookisbn'"; $query= mysqli_query($con,$q);while($row = mysqli_fetch_array($query)){if($row['form']==0){
                            $r="";
                        }
                        else{
                            $r=" Form ".$row['form'];
                        }echo $row["title"].$r;} ?></th></tr>
                        
                        <tr class="table-secondary">
                        <th>Adm</th>
                        
                        <th>Names</th>
                        <?php
                        $q=2;
                        if (isset($stream)) {
                                    if($stream==='all'){
                                        $q=3;?>
                            <th>Stream</th>
                            <?php }} ?>
                        <th colspan="<?php echo $q;?>">Serial</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($stream)) {
                            if($stream<>'all'){
                                $q="SELECT bookrecords.serial, student.adm, student.names, student.form, student.stream, bookrecords.isbn
                                FROM student INNER JOIN (books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn) ON student.adm = bookrecords.possesor
                                
                                WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0 and student.form='$form' and student.stream='$stream'
                                ORDER BY adm;";
                            }
                            else {
                                $q="SELECT bookrecords.serial, student.adm, student.names, student.form, student.stream, bookrecords.isbn
                                FROM student INNER JOIN (books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn) ON student.adm = bookrecords.possesor
                                WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0 and student.form='$form'
                                ORDER BY stream,adm ASC;";
                            }
                            
                        }
                        else {
                            $q="SELECT bookrecords.serial, student.adm, student.names, student.form, student.stream, bookrecords.isbn
                            FROM student INNER JOIN (books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn) ON student.adm = bookrecords.possesor
                            
                            WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0 and student.form='$form'
                            ORDER BY stream,adm ASC;";
                        }
                        
                        
                        
                        
                        $query=mysqli_query($con,$q);
                        while($res=mysqli_fetch_array($query)) {
                            ?>
                            
                            <tr>
                            <form method="POST">
                            <td><?php echo $res['adm']; ?></td>
                            <td><?php echo $res['names']; ?></td>
                            <?php
                                if (isset($stream)) {
                                    if($stream==='all'){?>
                            <td><?php echo $res['stream']; ?></td>
                            <?php }} ?>
                            <td><?php echo $res['serial']; ?></td>
                            <td><button name="recieve" type="submit" value="<?php echo $res['serial'];?>" class="btn btn-outline-success">Recieve</button></td>
                            <?php }?>
                            
                            </form>
                            </tr>
                            
                            </tbody>
                            </table>
                            
                            </div>
                            
                            <!----------------end of pill 1-------------------->
                            
                            
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                            <!----------------------Pill 2-------------------->
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                            <label for="fileToUpload" class="form-label" name="fileToUpload"><a href="templates/recievebooks.xlsx">Download </a>and fill the template then upload it below. (Please leave the column headers intact) <br>Select Spreadsheet</label>
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
                                
                                <form action="code/coderecievebooks.php" method="POST" enctype="multipart/form-data">
                                
                                
                                <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
                                
                                </form>';
                            }
                            ?>
                            
                            
                            
                            
                            <!----------------------End of Pill 2-------------------->
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                            Coming soon
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                            <!------------------------Pill 3------------------------->
                            </div>
                            </div>
                            </div>
                            <!-- /.card -->
                            </div>
                            <?php
                            include_once 'bottom.php';
                            ?>