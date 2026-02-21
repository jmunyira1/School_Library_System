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
        $inputFileNamePath = "uploads/file.xlsx";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        
        foreach($data as $row)
        {
            if($count > 0)
            {
                $isbn=mysqli_real_escape_string($con,stripslashes($row['0']));
                $serial=mysqli_real_escape_string($con,stripslashes($row['1']));
                $possesor="0";
                $date=date("Y-m-d");
                $q="UPDATE 'bookrecords'
                SET 'possesor' = '$possesor', 'date'='$date'
                WHERE 'bookrecords'.'isbn' = '$isbn' AND 'bookrecords'.'serial' = '$serial'; ";
                mysqli_query($con, $q);
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