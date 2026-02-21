<?php
include 'conn.php';
include_once 'top.php';
if(isset($_POST['chosenbook']))
{
    $bookisbn=$_POST['chosenbook'];
    $_SESSION['bookisbn']=$bookisbn;
}
$bookisbn=$_SESSION['bookisbn'];

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
<form method=post>
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
        }                            if (isset($bookisbn)) {
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


<tr><th class="text-center" colspan=4><tr><th class="text-center" colspan=4><?php $q="SELECT title FROM books WHERE isbn='$bookisbn'"; $query= mysqli_query($con,$q);while($row = mysqli_fetch_array($query)){echo $row["title"];} ?></th></tr>
<?php
if(isset($_SESSION['form'])){
    if(isset($_SESSION['stream'])){
        echo "<tr><th class=\"text-center\" colspan=4>Form ".$_SESSION['form']." ".$_SESSION['stream']."</th></tr>";
    }else{
        echo "<tr><th class=\"text-center\" colspan=4>Form ".$_SESSION['form']."</th></tr>";}}?>
        <tr class="table-secondary">
            <th>Adm</th>
            <th>Names</th>
            <th colspan="2">Serial</th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            $q="SELECT bookrecords.serial, student.adm, student.names,student.form,student.stream
            FROM bookrecords INNER JOIN student ON bookrecords.possesor = student.adm
            WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0
            ORDER BY student.adm;";
                
                
                $query=mysqli_query($con,$q);
                while($res=mysqli_fetch_array($query)) {
                    ?>
                    
                    <tr>
                    <form method="POST">
                    <td><?php echo $res['adm']; ?></td>
                    <td><?php echo $res['names']; ?></td>
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