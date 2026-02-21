<?php
include 'conn.php';
include_once 'top.php';
if(isset($_POST['chosenbook']))
{
    $bookisbn=$_POST['chosenbook'];
    $_SESSION['bookisbn']=$bookisbn;
}
if(isset($_POST['form']))
{
    $form=$_POST['form'];
    $_SESSION['form']=$form;
}
if(isset($_POST['stream']))
{
    $stream=$_POST['stream'];
    $_SESSION['stream']=$stream;
}

/*Set variables if sessions exist*/

if(isset($_SESSION['bookisbn'])){
    $bookisbn=$_SESSION['bookisbn'];}
    if(isset($_SESSION['form'])){
        $form=$_SESSION['form'];}
        if(isset($_SESSION['stream'])){
            $stream=$_SESSION['stream'];}
            ?>
            <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="pt-2 px-3">
            <h3 class="card-title"><?php echo rtrim($page, ".php"); ?></h3>
            </li>
            <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Recieve</a>
            </li>

            
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
            <!-------------------pill 1------------->
            
            <div class="form-row">
            <div class="col">
            <form id="formform" method=post>
            <select name="form" class="form-control" onchange="document.getElementById('formform').submit();">
            
            <option value="" <?php if($form===''){echo ' selected';}?>>Select Form...</option>
            <option value="1" <?php if($form==='1'){echo ' selected';}?>>Form 1</option>
            <option value="2" <?php if($form==='2'){echo ' selected';}?>>Form 2</option>
            <option value="3" <?php if($form==='3'){echo ' selected';}?>>Form 3</option>
            <option value="4" <?php if($form==='4'){echo ' selected';}?>>Form 4</option>
            </select>
            </form>
            </div>
            <div class="col">
            <form method="post" id="formstream">
            <select name="stream" class="form-control" onchange="document.getElementById('formstream').submit();">
            <option value="all" selected>Select Stream...</option>
            
            <?php
            
            
            $sql = "SELECT DISTINCT stream
            FROM student
            WHERE stream<>'0' AND stream<>'Teacher'
            ORDER by stream;";
            
            $result = mysqli_query($con, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    
                    if (isset($stream)) {
                        if ($stream===$row['stream']) {
                            echo "<option value=\"".$row['stream']."\" selected>".$row['stream']."</option>";
                        }
                        else{
                            echo "<option value=\"".$row['stream']."\">".$row['stream']."</option>";}
                        }
                        else{
                            echo "<option value=\"".$row['stream']."\">".$row['stream']."</option>";}
                            
                        }
                    }
                    
                    ?>
                    </select>
                    </form>
                    </div>
                    </div>
                    <form method="post">
                    <div class="form-group">
                    <label>Select Book</label>
                    <select name="chosenbook" class="form-control select2" style="width: 100%;"  onchange="this.form.submit()">
                    <option>Please Select a book</option>
                    
                    <?php
                    
                    
                    $sql = "SELECT DISTINCT books.title, books.publisher,books.form,books.isbn
                    FROM books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn
                    WHERE bookrecords.possesor<>0
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
                        
                        <br>
                        </div></form>
                        <button class="btn btn-outline-dark" onclick="jQuery.print('#print')">
                            <i class="fas fa-print"></i> Print
                </button>
                        <?php include 'searchtable.php'?>
                        <div class="table-responsive" id="print">
                        
                        <table id="myTable" class="table table-hover table-bordered border-primary ">
                        <thead>
                        
                        <th class="text-center" colspan="<?php
                        $q=4;
                        if (isset($stream)) {
                                    if($stream==='all'){
                                        $q=5;}}echo $q;?>"><?php if($stream==='all'){echo "Form ".$form;}else{echo "Form ".$form." ".$stream;}?></th></tr>
                        <th class="text-center" colspan="<?php echo $q;?>"><?php $q="SELECT title,publisher,form FROM books WHERE isbn='$bookisbn'"; $query= mysqli_query($con,$q);while($row = mysqli_fetch_array($query)){if($row['form']==0){
                            $r="";
                        }
                        else{
                            $r=" Form ".$row['form'];
                        }echo $row["title"].$r;} ?></th></tr>
                        
                        <tr class="table-secondary">
                            <th></th>
                        <th>Adm</th>
                        
                        <th>Names</th>
                        <?php
                        $q=1;
                        if (isset($stream)) {
                                    if($stream==='all'){
                                        $q=2;?>
                            <th>Stream</th>
                            <?php }} ?>
                        <th colspan="<?php echo $q;?>">Serial</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($stream)) {
                            if($stream<>'all'){
                                $q="SELECT bookrecords.serial, student.adm, student.names, student.form, student.stream, bookrecords.isbn
                                FROM student INNER JOIN (books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn) ON student.adm = bookrecords.possesor
                                
                                WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0 and student.form='$form' and student.stream='$stream'
                                ORDER BY adm;";
                            }
                            else {
                                $q="SELECT bookrecords.serial, student.adm, student.names, student.form, student.stream, bookrecords.isbn
                                FROM student INNER JOIN (books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn) ON student.adm = bookrecords.possesor
                                WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0 and student.form='$form'
                                ORDER BY stream,adm ASC;";
                            }
                            
                        }
                        else {
                            $q="SELECT bookrecords.serial, student.adm, student.names, student.form, student.stream, bookrecords.isbn
                            FROM student INNER JOIN (books INNER JOIN bookrecords ON books.isbn = bookrecords.isbn) ON student.adm = bookrecords.possesor
                            
                            WHERE bookrecords.isbn='$bookisbn' AND bookrecords.possesor <> 0 and student.form='$form'
                            ORDER BY stream,adm ASC;";
                        }
                        
                        
                        
                        
                        $query=mysqli_query($con,$q);
                        $i=0;
                        while($res=mysqli_fetch_array($query)) {
                            $i++?>
                            
                            <tr>
                            <td style="width:5px"><?php echo $i;?></td>
                            <td><?php echo $res['adm']; ?></td>
                            <td><?php echo $res['names']; ?></td>
                            <?php
                                if (isset($stream)) {
                                    if($stream==='all'){?>
                            <td><?php echo $res['stream']; ?></td>
                            <?php }} ?>
                            <td><?php echo $res['serial']; ?></td>
                            <?php }?>
                            </tr>
                            
                            </tbody>
                            </table>
                            
                            </div>
                            
                            <!----------------end of pill 1-------------------->
                            
                            
                            </div>

                            </div>
                            </div>
                            </div>
                            <!-- /.card -->
                            </div>
                            <?php
                            include_once 'bottom.php';
                            ?>