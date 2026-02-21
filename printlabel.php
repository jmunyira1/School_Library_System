<?php
include 'conn.php';
include_once 'top.php';
if(isset($_POST['chosenbook']))
{
    $bookisbn=$_POST['chosenbook'];
    $_SESSION['bookisbn']=$bookisbn;
}
$bookisbn=$_SESSION['bookisbn'];


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


$sql = "SELECT DISTINCT books.title, books.publisher,books.form,books.isbn, books.type
FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
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
        if($row['type']=='teachers book'){
            $r=$r." Teacher's Guide ";
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


<tr><th class="text-center" colspan=4><tr><th class="text-center" colspan=4><?php $q="SELECT title FROM books WHERE isbn='$bookisbn'"; $query= mysqli_query($con,$q);while($row = mysqli_fetch_array($query)){echo $row["title"];} ?></th></tr>

        <tr class="table-secondary">
            <th>Serial</th>
            <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            
            $q="SELECT bookrecords.serial,bookrecords.isbn
            FROM bookrecords INNER JOIN student ON bookrecords.possesor = student.adm
            WHERE bookrecords.isbn='$bookisbn'
            ORDER BY student.adm;";
                
                
                $query=mysqli_query($con,$q);
                while($res=mysqli_fetch_array($query)) {
                    ?>
                    
                    <tr>
                    <form method="POST" action="qr.php">
                    
                    <td><?php echo $res['serial']; ?></td>
                    <td><input type="hidden" name="isbn" value="<?php echo $res['isbn'];?>">
                    <input type="hidden" name="serial" value="<?php echo $res['serial'];?>">
                    <button type="submit" name="single" value="x" class="btn btn-outline-success">Print</button></td>
                    </form>
                    <?php }?>
                    
                    
                    </tr>
                    
                    </tbody>
                    </table>
                    
                    
                    </div>
                    
                    <!----------------end of pill 1-------------------->
                    
                    
                    </div>

                    </div>
                    </div>
                    <!-- /.card -->
                    </div>
                    <?php
                    include_once 'bottom.php';
                    ?>