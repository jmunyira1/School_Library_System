<?php
session_start();
include('../conn.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if(isset($_POST['save_excel_data']))
{
    $fileName = "uploads/file.xlsx";
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = "uploads/file.xlsx";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        
        foreach($data as $row)
        {
            if($count > 0)
            {
                $isbn = mysqli_real_escape_string($con,stripslashes($row['0']));
                $title = mysqli_real_escape_string($con,stripslashes($row['1']));
                $author = mysqli_real_escape_string($con,stripslashes($row['2']));
                $publisher = mysqli_real_escape_string($con,stripslashes($row['3']));
                $type = mysqli_real_escape_string($con,stripslashes($row['4']));
                $form = mysqli_real_escape_string($con,stripslashes($row['5']));
                

                $studentQuery = "INSERT INTO books (isbn,title,author,publisher,type,form) VALUES ('$isbn','$title','$author','$publisher','$type','$form')";
                $result = mysqli_query($con, $studentQuery);
                $msg = true;
            }
            else
            {
                $count = "1";
            }
        }
        
        header('Location: home.php');
            
            
        
    }
    
}
?>