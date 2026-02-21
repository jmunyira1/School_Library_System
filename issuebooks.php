<?php
include 'conn.php';

if(isset($_POST['submit'])){
    $isbn=mysqli_real_escape_string($con,stripslashes($_POST['isbn']));
    $serial=$_POST['serial'];
    $possesor=$_POST['possesor'];
    for ($i=0; $i < count($possesor); $i++) {
        if($possesor[$i]==""){$possesor[$i]=0;} 
        $sql = "UPDATE bookrecords
        SET possesor=$possesor[$i]
        WHERE isbn='$isbn' AND serial='$serial[$i]'";
        mysqli_query($con,$sql);
    }
    header('Location:../index.php');
}
$chosenisbn=$_POST['chosenbook'];
include_once 'top.php';
?>


<div class="card card-primary card-tabs">
<div class="card-header p-0 pt-1">
<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
<li class="pt-2 px-3">
<h3 class="card-title"><?php echo rtrim($page, ".php"); ?></h3>
</li>
<li class="nav-item">
<a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Issue Book(s)</a>
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
<select name="chosenbook" class="form-control select2" style="width: 100%;"  onchange="this.form.submit()">
<option>Please Select a book</option>
<?php
$sql = "SELECT DISTINCT books.title,books.isbn,books.form,books.publisher
FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
WHERE bookrecords.possesor=0
ORDER BY books.title";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    
    while($row = mysqli_fetch_assoc($result)) {
        if($row['form']==0){
            $r="";
        }
        else{
            $r=" Form ".$row['form'];
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
</select>
</div>
</div>
</form>


<form method="POST">
<div class="table-responsive" id="print"><br>
<?php include 'searchtable.php';?>
<table id="myTable" class="table table-hover table-bordered border-primary">
<tr><th class="text-center" colspan=4><?php $q="SELECT title, form FROM books WHERE isbn='$chosenisbn'"; $query= mysqli_query($con,$q);while($row = mysqli_fetch_array($query)){if($row['form']==0){echo $row['title'];}else{echo $row['title']." Form ".$row['form'];}} ?></th>

<tr class="table-secondary">
<th>Serial</th>
<th>Issue to</th>

</tr>

<?php
$q="SELECT serial
FROM bookrecords
WHERE possesor=0 AND isbn='$chosenisbn'";
$query= mysqli_query($con,$q);
while($row = mysqli_fetch_array($query)){
    ?>
    <tr>
    <td><?php echo $row["serial"]; ?></td>
    <td><input name="possesor[]" type="number" >
    </td>
    <?php echo "</tr>";
    echo "<input type=\"hidden\" name=\"serial[]\" value=\"".$row["serial"]."\">";}
    ?>
    </table>
    <br>
    <input type="hidden" value="<?php echo $chosenisbn;?>" name="isbn">
    <button type="submit" name="submit" class="btn btn-success">Submit</button>
    
    </form>
    </div>
    
    
    
    
    
    <!-- End of Pill 1 Content -->
    </div>
    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
    <!------------------Pill 2------------------>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
    <label for="fileToUpload" class="form-label" name="fileToUpload"><a href="templates/issuebooks.xlsx">Download </a>and fill the template then upload it below. (Please leave the column headers intact) <br>Select Spreadsheet</label>
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
        
        <form action="code/codeissues.php" method="POST" enctype="multipart/form-data">
        
        
        <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
        
        </form>';
    }
    ?>
    <!--------------------End of Pill 2--------------------->
    </div>
    <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
    <!--------------------Pill 3--------------------->
    Coming Soon
    <!--------------------End of Pill 3--------------------->  
    
    </div>
    
    </div>
    </div>
    
    
    <!-- 404 Start -->
    <?php
    include_once 'bottom.php';
    ?>