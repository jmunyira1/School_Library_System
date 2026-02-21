<?php
error_reporting(0);
    $currentDirectory = getcwd();
    $uploadDirectory = "../uploads/";

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['xlsx','xls']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $fileName="file.".$fileExtension;

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
          session_start();
          $page=$_SESSION["page"];
          if($page==="addbooktype.php"){
          header("Location:addbooktype.php");}
          elseif($page==="addstudent.php"){
          header("Location:addstudent.php");}
          elseif($page==="addbookrecords.php"){
            header("Location:addbookrecords.php");}
          elseif($page==="issuebooks.php"){
            header("Location:issuebooks.php");}
          elseif($page==="recievebooks.php"){
            header("Location:recievebooks.php");}
          }
         



            
         else {
          echo "An error occurred. Please contact the administrator.";
        }
      } 
      else {
        foreach ($errors as $error) {
          echo $error . "These are the errors" . "\n";
        }
      }

    }
  
?>