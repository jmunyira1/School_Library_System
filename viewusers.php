<?php
include 'conn.php';
include_once 'top.php';
?>

                <div class="table responsive">
                <table id="myTable" class="table table-hover table-bordered border-primary">
                <?php
                 $q="SELECT * from users";
                $query=mysqli_query($con,$q);
                ?>
                <tr class="table-secondary"><th colspan="7" class="text-center">Users</th></tr>
                <tr class="table-secondary">
                    <th>ID</th>
					<th>Username</th>
                    <th>Names</th>
                    
                </tr>
                <?php 
                while($res=mysqli_fetch_array($query)) {
               ?>
                
             
                <tr>
                    <td><?php echo $res['id']; ?></td>
                    <td><?php echo $res['email']; ?></td>
                    <td><?php echo $res['names']; ?></td>
                    <?php }?>
                    
               
                </tr>
					</table>
                </div>
<?php
include_once 'bottom.php';
?>