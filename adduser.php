<?php
include 'conn.php';
include 'top.php';
if(isset($_POST['done']))
{
 $id=$_POST['id'];
 $names=$_POST['names'];
 $email=$_POST['email'];
 $password=$_POST['password'];
 $password= password_hash(md5(mysqli_real_escape_string($con,$password)),PASSWORD_DEFAULT);

 $q="INSERT INTO users(id,names, email, password)
		VALUES ( '$id','$names','$email','$password');";
 mysqli_query($con,$q);
 header('Location:index.php');
}
?>
    <form method="post">
        <div class="input-group mb-3">
            <span class="input-group-text">Id.:</span>
            <input type="text" name="id" class="form-control" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Names:</span>
            <input type="text" name="names" class="form-control" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">username:</span>
            <input type="text" name="email" class="form-control" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Password</span>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        
        <button type="submit" name="done" class="btn btn-success">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>

        </form>
        <?php
   include_once 'bottom.php';
   ?>