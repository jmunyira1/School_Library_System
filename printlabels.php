<?php
include 'conn.php';
include_once 'top.php';

if(isset($_POST['submit'])){
$bookisbn=$_POST['submit'];
$_SESSION['bookisbn']=$bookisbn;}
if(isset($_POST['chosenbook']))
{
    $bookisbn=$_POST['chosenbook'];
    $_SESSION['bookisbn']=$bookisbn;
}
$bookisbn=$_SESSION['bookisbn'];
if(isset($_POST['isbn'])){
$_SESSION['bookisbn']=$_POST['isbn'];}

?>

            <!-- Blank Start -->
            <form method="post">
            <div class="form-group">
<label>Print Labels</label>
<select name="chosenbook" class="form-control select2" style="width: 100%;"  onchange="this.form.submit()">
<option>All books</option>

<?php


$sql = "SELECT DISTINCT books.title, books.publisher,books.form,books.isbn
FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
WHERE label=0
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
</div>
</form>
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Books</h6>
                            <form method="POST" action="qr2.php">
                            <button class="btn btn-outline-dark" name="bookisbn" value="<?php echo $bookisbn;?>" type="submit">
                            <i class="fas fa-print"></i> Print
                </button>
                </form>
                            <?php include 'searchtable.php'?>
                            <div class="table-responsive" id="print">
                                <table id="myTable" class="table table-hover table-bordered border-primary ">
                                    <thead>
                                        
            
                                        <tr><th class="text-center" colspan=4><tr><th class="text-center" colspan=4><?php $q="SELECT title,form FROM books WHERE isbn='$bookisbn'"; $query= mysqli_query($con,$q);while($row = mysqli_fetch_array($query)){if($row['form']==0){
            $r="";
        }
        else{
            $r=" Form ".$row['form'];}echo $row['title'].$r;} ?></th></tr>

                                        <tr class="table-secondary">
                                            <th></th><th>Adm</th>
                                            <th>Names</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                     $q="SELECT bookrecords.serial, books.title,bookrecords.label
                                     FROM bookrecords INNER JOIN books ON bookrecords.isbn = books.isbn
                                     WHERE bookrecords.isbn='$bookisbn' and label=0;";
                                            $query=mysqli_query($con,$q);
                                            $i=0;
                                            while($res=mysqli_fetch_array($query)) {
                                                $i++;?>
                                            <tr>    <td style="width:5px"><?php echo $i;?></td>
                                                <td><?php echo $res['title']; ?></td>
                                                <td><?php echo $res['serial']; ?></td>
                                                <td><?php //echo $res['serial'];
                                            } ?></td>
                                                
                                            </tr>
                                                                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
            <!-- Blank End -->
<?php
include_once 'bottom.php';
?>