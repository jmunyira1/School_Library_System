<?php

include 'conn.php';
include_once 'top.php';


if (isset($_POST['qrvalue'])) {
    $qrvalue = $_POST['qrvalue'];
    $_SESSION['qrvalue']=$qrvalue ;
}
$qrvalue = $_SESSION['qrvalue'];


      

if(isset($_POST['recieve'])){
        }
        
?>
<form method="POST">

<input type="text" name="qrvalue" class='form-control' autofocus>

</form>
<?php
if (isset($qrvalue)) {
    $separator = '@';
    if (strpos($qrvalue, '@')) {
        $separator = '@';
    } elseif (strpos($qrvalue, '"')) {
        $separator = '"';
    } elseif (strpos($qrvalue, '#')) {
        $separator = '#';
    }
    if (strpos($qrvalue, '~')) {
        $separator = '~';
    }
    
    $qrvalue = explode($separator, $qrvalue);
    $isbn = $qrvalue[0];
    $serial = $qrvalue[1];
    
    $q = "SELECT books.title, books.publisher,books.form,books.isbn,bookrecords.possesor,bookrecords.serial
    FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
    WHERE books.isbn=$isbn AND bookrecords.serial='$serial';";
    $query = mysqli_query($con, $q);
}

?>
<form method="post" action="codescan.php">
    <input type="hidden" name="status" value="delete">
    <input type="hidden" name="isbn" value="<?php echo $row["isbn"]; ?>">
    <input type="hidden" name="serial" value="<?php echo $row["serial"]; ?>">
<div class="table-responsive" id="print"><br>


<table id="myTable" class="table table-hover table-bordered border-primary">
<?php
while($row = mysqli_fetch_array($query)){

    ?>
    <tr>
        <td>ISBN</td>
    <td><?php echo $row["isbn"]; ?></td>
    </tr>
    <tr>
        <td>Title</td>
    <td><?php if($row["title"]==0){echo $row["title"];}else {
        echo $row["title"]." Form ".$row["form"];
    } ?></td>
    </tr>
    <tr>
        <td>Serial</td>
    <td><?php echo $row["serial"]; ?></td>
    </tr>
    <tr>
</tr>

</table>

<div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

                <div class="card-body">
                 
                  <div class="form-group">
                    <label for="exampleInputPassword1">Issue to : </label>
                    <input type="number" name="possesor" class="form-control" id="exampleInputPassword1" placeholder="Enter Admission or StaffID">
                  </div>
 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="issue" value="issue" class="btn btn-outline-danger">Delete</button>
                </div>
      
            </div>
      </form>

<?php }
include_once 'bottom.php';
?>