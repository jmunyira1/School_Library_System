<?php
include 'conn.php';
include_once 'top.php';

?>
   

            <!-- Blank Start -->
            <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Issued Books</h6><button class="btn btn-outline-dark" onclick="jQuery.print('#print')">
                            <i class="fas fa-print"></i> Print
                </button>
                            <form method="post" action="viewissuedbook.php">
                            <div class="table-responsive" id="print">
                                <?php include 'searchtable.php';?>
                            <table id="myTable" class="table table-hover table-bordered border-primary">
                                    <thead>
                                        <tr class="table-secondary">
                                        
                                            
                                            <th scope="col">Title</th>
                                            <th scope="col">Publisher</th>
                                            <th scope="col">Total Books</th> 
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
					
                                            $q="SELECT DISTINCT books.title, books.publisher,books.form,books.isbn
                                                FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
                                                WHERE bookrecords.possesor<>0
                                                ORDER by books.title;";                                                
                                            $query=mysqli_query($con,$q);
                                            
                                            while($res=mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                            
                                            <td><?php if($res['form']==0){echo $res['title'];}else {echo $res['title']." Form ".$res['form'];} ?></td>
                                            <td><?php echo $res['publisher']; ?></td>
                                            
                                            <td><?php $x=$res['isbn'];$y=mysqli_query($con, "SELECT * FROM bookrecords WHERE possesor<>0 AND isbn = $x");echo mysqli_num_rows($y); ?></td>
                                            <td class="m-0 p-0"><button type="submit" name="submit" value=<?php echo $res['isbn'];?> class="btn btn-outline-success m-1 p-1">View</button></td>
                                            <?php }?>
                                        </tr>
                                        <tr class="table-success">
                                            <td colspan="3" class="text-end">TOTAL</td>
                                            <td colspan="2"><?php $y=mysqli_query($con, "SELECT * FROM bookrecords WHERE possesor<>0");echo mysqli_num_rows($y);?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                            </div>
                                            </form>
                            </div>
                        </div>
                    
            <!-- Blank End -->
<?php
include_once 'bottom.php';
?>