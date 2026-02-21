<?php
include 'conn.php';
include_once 'top.php';
if(isset($_POST['bookisbn'])){
    $bookisbn=$_POST['bookisbn'];
    $_SESSION['bookisbn']=$bookisbn;
}
$bookisbn=$_SESSION['bookisbn'];
if(isset($_POST['recieve'])){
    $recieve=$_POST['recieve'];
    $bookisbn=$_POST['bookisbn'];
    $q="DELETE FROM bookrecords
    WHERE isbn = '$bookisbn' AND serial = '$recieve'; ";
    mysqli_query($con,$q);
}

?>
<form method="post">
<label>Print Labels</label>
<select name="bookisbn" class="form-control select2" style="width: 100%;"  onchange="this.form.submit()">
<option>All books</option>

<?php


$sql = "SELECT DISTINCT books.title, books.publisher,books.form,books.isbn
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
    </form>
    <br>                                         
    <?php include 'searchtable.php'?>
    <div class="table responsive">
    <table id="myTable" class="table table-hover table-bordered border-primary">
    <tr class="table-secondary"><th colspan="3" class="text-center">Delete</th></tr>
    <tr class="table-secondary">
    <th>Book</th>
    <th>Serial</th>
    <th></th>
    
    </tr>
    
    <?php 
    $q="SELECT bookrecords.isbn,bookrecords.serial, books.title,books.form
    FROM bookrecords INNER JOIN books ON bookrecords.isbn = books.isbn
    WHERE bookrecords.isbn='$bookisbn'
    ORDER BY books.title;";
    $query=mysqli_query($con,$q);
    while($res=mysqli_fetch_array($query)) {?>
        <tr>
        <form method="post">
        <td><?php if($res['form']==0){echo $res['title'];}else {echo $res['title']." Form ".$res['form'];} ?></td>
        <td><?php echo $res['serial']; ?></td>
        <td><input type="hidden" name="bookisbn" value="<?php echo $res['isbn'];?>"><button name="recieve" type="submit" value="<?php echo $res['serial'];?>" class="btn btn-outline-danger">Delete!</button></td>
        
        </form>
        </tr><?php }?>
        
        
        </table>
        </div>
         
        <?php
        include_once 'bottom.php';
        ?>