<?php
session_start();
include('../conn.php');

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if(isset($_POST['save_excel_data']))
{
    $fileName = "file.xlsx";
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
    
    $allowed_ext = ['xls','csv','xlsx'];
    
    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = "../uploads/file.xlsx";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();
        
        $count = "0";
        
        foreach($data as $row)
        {
            if($count > 0)
            {
                $adm = mysqli_real_escape_string($con,stripslashes($row['0']));
                $names = mysqli_real_escape_string($con,stripslashes($row['1']));
                $gender = mysqli_real_escape_string($con,stripslashes($row['2']));
                $form = mysqli_real_escape_string($con,stripslashes($row['3']));
                $stream = mysqli_real_escape_string($con,stripslashes($row['4']));
                
                
                $studentQuery = "INSERT IGNORE INTO student (adm,names,gender,form,stream) VALUES ('$adm','$names','$gender','$form','$stream')";
                $result = mysqli_query($con, $studentQuery);
                $msg = true;
            }
            else
            {
                $count = "1";
            }
        }
        
        header('Location: index.php');
        
        
        
    }
    
}
?>