<?php
include 'conn.php';
include_once 'top.php';
?>
<?php
if(isset($_POST['delete'])){
    $isbn=$_POST['delete'];
    $sql="DELETE FROM books WHERE isbn=$isbn;";
    mysqli_query($con,$sql);
    header('Location:home.php');
}?>
   

            <!-- Blank Start -->
            <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Books</h6>
                            <?php include 'searchtable.php';?>
                            
                            <table id="myTable" class="table table-hover table-bordered border-primary">
                                    <thead>
                                        <tr class="table-secondary">
                                        
                                            
                                            <th scope="col">Title</th>
                                            <th scope="col">Publisher</th>
                                            
                                            <th scope="col">isbn</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    
					
                                            $q="SELECT * FROM books ORDER BY title ASC,form ASC;";                                                
                                            $query=mysqli_query($con,$q);
                                            while($res=mysqli_fetch_array($query)) {
                                                                                      ?>
                                            <tr>
                                            <form method="post">
                                            <td><?php if($res['form']==0){$r="";}else {$r=" Form ".$res['form'];}   if($row['type']=='teachers book'){
                                            $r=$r." Teacher's Guide ";
                                        }echo $res['title'].$r; ?></td>
                                            <td><?php echo $res['publisher']; ?></td>
                                            <td><?php echo $res['isbn']; ?></td>
                                            <td class="m-0 p-0"><button type="submit" name="delete" value=<?php echo $res['isbn'];?> class="btn btn-outline-danger m-1 p-1">Delete</button></td>
                                            <?php }?>
                                            </form>
                                            </tr>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
            <!-- Blank End -->
<?php
include_once 'bottom.php';
?>