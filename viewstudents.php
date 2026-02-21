<?php
include 'conn.php';
include_once 'top.php';

?>
   

            <!-- Blank Start -->
            <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Issued Books</h6>
                           
                            <div class="table-responsive">
                                <?php include 'searchtable.php';?>
                            <table id="myTable" class="table table-hover table-bordered border-primary">
                                    <thead>
                                    <tr class="table-secondary">
                    <th>Admission No</th>
                    <th>Names</th>
                    <th>Form</th>
                    <th>Stream</th>
                    <th>Gender</th>
                    <th></th>

                </tr>
                                    </thead>
                                    <tbody>
                                    <?php
					
                                            $q="SELECT DISTINCT bookrecords.possesor, student.names, student.form, student.stream, student.gender
                                            FROM student INNER JOIN bookrecords ON student.adm = bookrecords.possesor
                                            where possesor<>0 and form<>0 ORDER BY form ASC";                                                
                                            $query=mysqli_query($con,$q);
                                            
                                            while($res=mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                        <form method="POST" action="viewstudentbook.php">
                            <td><?php echo $res['possesor']; ?></td>
                            <td><?php echo $res['names']; ?></td>
                            <td><?php
                            
                            if ($res['form'] > 4) {
                                echo 'Class of ' . (2024 - ($res['form']-4));
                            } else {
                                echo $res['form']; 
                            }
                            

                             ?></td>
                            <td><?php echo $res['stream']; ?></td>
                            <td><?php echo $res['gender']; ?></td>
                            <td class="m-0 p-0"><button type="submit" name="submit" value=<?php echo $res['possesor']; ?> class="btn btn-outline-success m-1 p-1">View</button></td>
                        <?php } ?>

                        </form>
                    </tr>
                                    </tbody>
                                </table>
                                            </div>
                                            
                            </div>
                        </div>
                    
            <!-- Blank End -->
<?php
include_once 'bottom.php';
?>