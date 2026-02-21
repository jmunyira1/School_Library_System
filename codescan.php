<?php
include_once 'conn.php';
session_start();
if($_POST['status']=='issue'){
    $isbn=$_POST['isbn'];
    $serial=$_POST['serial'];
    $possesor=mysqli_real_escape_string($con,stripslashes($_POST['possesor']));
    $sql = "SELECT adm FROM student WHERE adm='$possesor' AND adm<>0;";
    $sql=mysqli_query($con,$sql);
    if(mysqli_num_rows($sql) > 0) {
    $sql = "UPDATE bookrecords
        SET possesor='$possesor'
        WHERE isbn='$isbn' AND serial='$serial'";
        if(mysqli_query($con,$sql)){
        $_SESSION['success'] = 'The book has been issued successfully';
        }}
        else{
            $_SESSION['fail'] = 'Student not registered in the system';
        }
        header('Location:scanlabel.php');
        }

        elseif($_POST['status']=='recieve'){
            $isbn=$_POST['isbn'];
            $serial=$_POST['serial'];
            $possesor=0;

        $sql = "UPDATE bookrecords
                SET possesor='$possesor'
                WHERE isbn='$isbn' AND serial='$serial'";
                if(mysqli_query($con,$sql)){
                    $_SESSION['success'] = 'The book has been successfully recieved';
                }
                header('Location:scanlabel.php');}
        ?>
        