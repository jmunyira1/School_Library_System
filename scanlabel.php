<?php

include 'conn.php';
include_once 'top.php';
$input=0;

if (isset($_POST['qrvalue'])) {
    $qrvalue = $_POST['qrvalue'];
    $_SESSION['qrvalue']=$qrvalue ;
    $input=1;
}
$qrvalue = $_SESSION['qrvalue'];


if(isset($_SESSION['success'])){
    echo '<div id="toastsContainerTopRight" class="toasts-top-right fixed">
              <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                      <strong class="mr-auto">Success</strong>
                      <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="toast-body">' . $_SESSION['success'] . '</div>
              </div>
          </div>';
    unset($_SESSION['success']);

}
if(isset($_SESSION['fail'])){
 echo '<div id="toastsContainerTopRight" class="toasts-top-right fixed">
              <div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                      <strong class="mr-auto">Success</strong>
                      <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="toast-body">' . $_SESSION['fail'] . '</div>
              </div>
          </div>';
    unset($_SESSION['fail']);
    }
?>

<script>
    $(window).on('load', function(){
        setTimeout(function(){
            $('.toast').fadeOut('slow');
        }, 3000);
    });
</script>
<form id="myForm" method="POST">

<input type="text" id="myInput" name="qrvalue" class='form-control' <?php if($input==0){echo "autofocus";}?>>


</form>
<script>
let form = document.getElementById("myForm");
let input = document.getElementById("myInput");

input.addEventListener("input", function() {
  setTimeout(function() {
    form.submit();
  }, 200);
});
</script>
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
<form method="post" id="form" action="codescan.php">
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
    <td>Issued to</td>
    <td><?php if($row["possesor"]==0){
        echo "Not Issued"; }else {

            $possesor=$row["possesor"];
            $sql = "SELECT * FROM student where adm='$possesor'";

            if ($result = mysqli_query($con, $sql)) {
              while ($res = mysqli_fetch_row($result)) {
                echo $res[0]." | ".$res[1];
              }}
            
        }?></td>
    </tr>

</table>

      </div>
      <input type="hidden" value="<?php echo $row["isbn"]; ?>" name="isbn">
      <input type="hidden" value="<?php echo $row["serial"]; ?>" name="serial">
      <br>
      <?php
      if($row["possesor"]==0){         
include_once 'issuescanlabel.php';
}
else {
    include_once 'recievescanlabel.php';

}
?>
      </form>

<?php }

include_once 'bottom.php';
?>