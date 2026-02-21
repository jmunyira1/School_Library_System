<?php
include 'conn.php';
include_once 'top.php';
if(isset($_POST['submit'])){
  $possesor=$_POST['submit'];
  $_SESSION['possesor']=$possesor;
}
$possesor=$_SESSION['possesor'];


if(isset($_POST['recieve'])){
  $recieve=$_POST['recieve'];
  $bookisbn=$_POST['bookisbn'];
  $q="UPDATE bookrecords
  SET possesor = 0
  WHERE isbn = '$bookisbn' AND serial = '$recieve'; ";
  mysqli_query($con,$q);
}

?>
<button class="btn btn-outline-dark" onclick="jQuery.print('#print').print({noPrintSelector: '.btn'})">
    <i class="fas fa-print"></i> Print
</button>
<div id="print">
    <div class="container p-4">
        <div class="row">
            <div class="col-auto p-0 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width=70% height=auto fill="currentColor"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>

            </div>
            <div class="col-auto p-0 m-0">
                <div class="text-start">

                    <?php 
$sql = "SELECT * FROM student where adm=$possesor";

if ($result = mysqli_query($con, $sql)) {
  while ($row = mysqli_fetch_row($result)) {
    if ($row[2]==0) {?>
                    <h3>StoresID : <?php echo $row[0];?></h3>
                    <h3>NAMES : <?php echo $row[1];?></h3>

                    <?php
    }
    else {  
      ?>
                    <h3>ADM : <?php echo $row[0];?></h3>
                    <h3>NAMES : <?php echo $row[1];?></h3>
                    <h3>CLASS : <?php   
                            if ($row[2] > 4) {
                                echo 'Class of ' . (2024 - ($row[2]-4)).'('.$row[3].')';
                            } else {
                              echo $row[2]." ".$row[3];
                            }
                            ?></h3>
                    <?php    
    }}
    mysqli_free_result($result);
  }
  
  
  ?>


                </div>

            </div>

        </div>
    </div>


    <div class="table responsive">
        <table class="table table-hover table-bordered border-primary">
            <tr class="table-secondary">
                <th colspan="4" class="text-center">Unreturned Books</th>
            </tr>
            <tr class="table-secondary">
                <th>#</th>
                <th>Book</th>
                <th>Serial</th>
                <th></th>

            </tr>

            <?php 
  $q="SELECT bookrecords.isbn,bookrecords.serial, books.title,books.form,books.type
  FROM bookrecords INNER JOIN books ON bookrecords.isbn = books.isbn
  WHERE bookrecords.possesor='$possesor'
  ORDER BY books.title;";
  $query=mysqli_query($con,$q);
  $x=1;
  while($res=mysqli_fetch_array($query)) {?>
            <tr>
                <form method="post">
                    <td style="width: 10px;"><?php echo $x; $x++;?></td>
                    <td><?php
    if($res['form']==0){
      $r="";
    }
    else{
      $r=" Form ".$res['form'];
    }
    if($res['type']=='teachers book'){
      $r=$r." Teacher's Guide ";
    }  
    echo $res['title'].$r; ?></td>
                    <td><?php echo $res['serial']; ?></td>
                    <td><input type="hidden" name="bookisbn" value="<?php echo $res['isbn'];?>"><button name="recieve"
                            type="submit" value="<?php echo $res['serial'];?>"
                            class="btn btn-outline-success">Recieve</button></td>

                </form>
            </tr><?php }?>
        </table>
    </div>
</div>
<?php
    include_once 'bottom.php';
    ?>