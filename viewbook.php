<?php
$bookisbn=$_POST['submit'];
if(isset($_POST['store'])){$store=$_POST['store'];}
include 'conn.php';
include_once 'top.php';
?>
   

            <!-- Blank Start -->
            <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Books</h6>
                            <button class="btn btn-outline-dark" onclick="jQuery.print('#print')">
                            <i class="fas fa-print"></i> Print
                </button>
<div id="print">
                            <div class="table-responsive" id="myTable">
                            <?php include 'searchtable.php';?>
                                <table id="myTable" class="table table-hover table-bordered border-primary ">
                                <?php
					
                    $q="SELECT books.title, books.form, books.publisher, bookrecords.isbn,bookrecords.serial
                    FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
                    WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor = 0
                    ORDER BY bookrecords.serial;";                                                
                    $query=mysqli_query($con,$q);
                    if(mysqli_num_rows($query)>0){
                        echo "<thead>
                        <tr><th class=\"text-center\" colspan=4>Books In Store</th>
                        <tr class=\"table-secondary\">
                            
                            <th scope=\"col\">Title</th>
                            <th scope=\"col\">Publisher</th>
                            <th scope=\"col\">Serial</th>
                            
                        </tr>
                    </thead>";
                    while($res=mysqli_fetch_array($query)) {
                    ?>
                                    
                                    <tbody>
                                  
                                            <tr>
                                                
                                                <td><?php if($res['form']==0){echo $res['title'];}else {echo $res['title']." Form ".$res['form'];} ?></td>
                                                <td><?php echo $res['publisher']; ?></td>
                                                <td><?php echo $res['serial'];} }?></td>
                                                
                                            </tr>
                                            <?php

                                            $q="SELECT books.title, books.form, books.publisher, bookrecords.isbn,bookrecords.serial
                                            FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
                                            WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0
                                            ORDER BY books.title;";                                                
                                            $query=mysqli_query($con,$q);
                                            if(mysqli_num_rows($query)>0&&$store!='store'){
                                                echo "<tr><td colspan=4></td></tr>
                                                <tr><th class=\"text-center\" colspan=4>Issued Books</th>
                                                <tr class=\"table-secondary\">
                                                    
                                                    <th scope=\"col\">Title</th>
                                                    <th scope=\"col\">Publisher</th>
                                                    <th scope=\"col\">Serial</th>
                                                    
                                                </tr>";


                                                while($res=mysqli_fetch_array($query)) {
                                                    
                                                    echo "<tr>";
                                                        echo "<td>";if($res['form']==0){echo $res['title']."</td>";}else {echo $res['title']." Form ".$res['form']."</td>";}
                                                        echo "<td>".$res['publisher']."</td>";
                                                        echo "<td>".$res['serial']."</td>";} 
                                                        
                                                    echo "</tr>";

                                            }  
                                            
                                            ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
            <!-- Blank End -->
<?php
include_once 'bottom.php';
?>