<?php
include 'conn.php';
include_once 'top.php';
?>

                <div class="table responsive">
                <?php include 'searchtable.php';?>
                <table id="myTable" class="table table-hover table-bordered border-primary">
                <?php
                 $q="SELECT * from student where adm<>0 and Form=0 AND Stream='Teacher' ORDER BY CAST(adm AS UNSIGNED) ASC;";
                $query=mysqli_query($con,$q);
                ?>
                <tr class="table-secondary"><th colspan="7" class="text-center">Users</th></tr>
                <tr class="table-secondary">
                    <th>StoresID</th>
					<th>Names</th>
                    <th>Gender</th>
                    <th></th>
                    
                </tr>
                <?php 
                while($res=mysqli_fetch_array($query)) {
               ?>
                
             
                <tr><form method="POST" action="studentbook.php">
                    <td><?php echo $res['adm']; ?></td>
                    <td><?php echo $res['Names']; ?></td>
                    <td><?php echo $res['Gender']; ?></td>
                    <td class="m-0 p-0"><button type="submit" name="submit" value=<?php echo $res['adm'];?> class="btn btn-outline-success m-1 p-1">View</button></td>
                    <?php }?>
                    </form>
                    
               
                </tr>
					</table>
                </div>
<?php
include_once 'bottom.php';
?>