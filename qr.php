<?php
include 'conn.php';


if($_POST["single"]==='x'){
    $isbn = $_POST['isbn'];
    $value1 = $_POST['serial'];

    include "phpqrcode/qrlib.php"; 
   
    
    $q="SELECT bookrecords.serial, books.form,books.title,books.publisher,bookrecords.isbn
    FROM bookrecords INNER JOIN books ON bookrecords.isbn = books.isbn
    WHERE bookrecords.isbn='$isbn' AND bookrecords.serial='$value1'";
    $query=mysqli_query($con,$q);
    
      
    while($res=mysqli_fetch_array($query)) {
        
        $value=$res['isbn']."\"".$res['serial'];
        


//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = "uploads/qr/";

//html PNG location prefix
$PNG_WEB_DIR = 'uploads/qr/';

  

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR)){
    mkdir($PNG_TEMP_DIR);}
    
    if(!file_exists($PNG_TEMP_DIR.'qrcode.png')){    
        $filename = $PNG_TEMP_DIR.'qrcode.png';
    }
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode1.png')){    
        $filename = $PNG_TEMP_DIR.'qrcode1.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode2.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode2.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode3.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode3.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode4.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode4.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode5.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode5.png';}
                        
    QRcode::png($value, $filename, 'H', 10, 4);  
$stamp = imagecreatefrompng($filename);
$im = imagecreatefrompng('uploads/qr/1.png');
$marge_right = 1;
$marge_bottom = 1;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));    
if(!file_exists($PNG_TEMP_DIR.'version.png')){    
    $filename2 = $PNG_TEMP_DIR.'version.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version1.png')){    
        $filename2 = $PNG_TEMP_DIR.'version1.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version2.png')){    
            $filename2 = $PNG_TEMP_DIR.'version2.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version3.png')){    
            $filename2 = $PNG_TEMP_DIR.'version3.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version4.png')){    
            $filename2 = $PNG_TEMP_DIR.'version4.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version5.png')){    
            $filename2 = $PNG_TEMP_DIR.'version5.png';}
imagepng($im,$filename2,9); 





$image = imagecreatetruecolor(300, 450);
        
        // Set the background color of image
        
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefill($image,0,0,$background_color);
        
        // Set the text color of image
        $text_color = imagecolorallocate($image,0, 0, 0);
        $font='font.ttf';
        $parts = explode(" ", $res['publisher']);
        $publisher="";
        foreach($parts as $part) {
        $publisher=$publisher.$part[0];
        }
        $publisher=$publisher." publ.";
        if($res['form']==0){
            $filename3=$res['title']." by ".$publisher;
        }else{
            $filename3=$res['title']." Form ".$res['form']." by ".$publisher;}
            $filename4 = str_split($filename3, 20);
        $serial=str_split($res['serial'],17);
        
        // Function to create image which contains string.
        imagettftext($image,30,90, 70, 430, $text_color,$font , $filename4[0]);
        imagettftext($image,30,90, 140, 440, $text_color,$font ,$filename4[1]);
        imagettftext($image,30,90, 210, 440, $text_color,$font , $serial[0]);
        if(isset($serial[1])){
        imagettftext($image,30,90, 280, 440, $text_color,$font , $serial[1]);}
        if(!file_exists($PNG_TEMP_DIR.'side.png')){    
            $filename3 = $PNG_TEMP_DIR.'side.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side1.png')){    
                $filename3 = $PNG_TEMP_DIR.'side1.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side2.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side2.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side3.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side3.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side4.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side4.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side5.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side5.png';}
        imagepng($image,$filename3,9); 
        
        $stamp = imagecreatefrompng($filename3);
        $im = imagecreatefrompng($filename2);
        $marge_left = 1;
        $marge_bottom = 1;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopy($im, $stamp, 0, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        $PNG_TEMP_DIR = "uploads/qr/print/";
        if (!file_exists($PNG_TEMP_DIR)){
            mkdir($PNG_TEMP_DIR);}
            
        $filename4 = $PNG_TEMP_DIR.'complete'.$isbn.time().'.png';
        imagepng($im,$filename4,9);
       
        unlink($filename);
        unlink($filename2);
        unlink($filename3);
        $serial=$res['serial'];
        $q="UPDATE bookrecords
        SET label = 1
        WHERE isbn = $isbn AND serial = '$serial'; ";
        mysqli_query($con,$q);
        
        
            }

    
header('Location: printlabel.php');
     }
     elseif ($_POST["single"]==='negative') {
        $isbn = $_POST['isbn'];
        //$serial = $_POST['serial'];
        $prefix = $_POST['prefix'];
        $suffix = $_POST['suffix'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $possesor = "0";
        $date = date("Y/m/d");
        include "phpqrcode/qrlib.php";
        
        for ($i=$min; $i <= $max; $i++) {
        $value1=$prefix.$i.$suffix;
            $sql = "INSERT IGNORE INTO bookrecords(isbn,serial,possesor,date)
        VALUES('$isbn','$value1','$possesor','$date')";
            mysqli_query($con, $sql);
        
       
        
        $q="SELECT bookrecords.serial, books.form,books.title,books.publisher,bookrecords.label,bookrecords.isbn
        FROM bookrecords INNER JOIN books ON bookrecords.isbn = books.isbn
        WHERE bookrecords.isbn='$isbn' AND bookrecords.serial='$value1';";
        $query=mysqli_query($con,$q);
        
          
        while($res=mysqli_fetch_array($query)) {
            
            $value=$res['isbn']."\"".$res['serial'];
    
    
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = "uploads/qr/";
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'uploads/qr/';
    
      
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);}
        
        if(!file_exists($PNG_TEMP_DIR.'qrcode.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode.png';
        }
        elseif (!file_exists($PNG_TEMP_DIR.'qrcode1.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode1.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'qrcode2.png')){    
                $filename = $PNG_TEMP_DIR.'qrcode2.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'qrcode3.png')){    
                $filename = $PNG_TEMP_DIR.'qrcode3.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'qrcode4.png')){    
                $filename = $PNG_TEMP_DIR.'qrcode4.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'qrcode5.png')){    
                $filename = $PNG_TEMP_DIR.'qrcode5.png';}
                            
        QRcode::png($value, $filename, 'H', 10, 4);  
    $stamp = imagecreatefrompng($filename);
    $im = imagecreatefrompng('uploads/qr/1.png');
    $marge_right = 1;
    $marge_bottom = 1;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));    
    if(!file_exists($PNG_TEMP_DIR.'version.png')){    
        $filename2 = $PNG_TEMP_DIR.'version.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'version1.png')){    
            $filename2 = $PNG_TEMP_DIR.'version1.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'version2.png')){    
                $filename2 = $PNG_TEMP_DIR.'version2.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'version3.png')){    
                $filename2 = $PNG_TEMP_DIR.'version3.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'version4.png')){    
                $filename2 = $PNG_TEMP_DIR.'version4.png';}
        elseif (!file_exists($PNG_TEMP_DIR.'version5.png')){    
                $filename2 = $PNG_TEMP_DIR.'version5.png';}
    imagepng($im,$filename2,9); 
    
    
    
    
    
    $image = imagecreatetruecolor(300, 450);
            
            // Set the background color of image
            
            $background_color = imagecolorallocate($image, 255, 255, 255);
            imagefill($image,0,0,$background_color);
            
            // Set the text color of image
            $text_color = imagecolorallocate($image,0, 0, 0);
            $font='font.ttf';
            $parts = explode(" ", $res['publisher']);
            $publisher="";
            foreach($parts as $part) {
            $publisher=$publisher.$part[0];
            }
            $publisher=$publisher." publ.";
            if($res['form']==0){
                $filename3=$res['title']." by ".$publisher;
            }else{
                $filename3=$res['title']." Form ".$res['form']." by ".$publisher;}
                $filename4 = str_split($filename3, 20);
            $serial=str_split($res['serial'],17);
            
            // Function to create image which contains string.
            imagettftext($image,30,90, 70, 430, $text_color,$font , $filename4[0]);
            imagettftext($image,30,90, 140, 440, $text_color,$font ,$filename4[1]);
            imagettftext($image,30,90, 210, 440, $text_color,$font , $serial[0]);
            if(isset($serial[1])){
            imagettftext($image,30,90, 280, 440, $text_color,$font , $serial[1]);}
            if(!file_exists($PNG_TEMP_DIR.'side.png')){    
                $filename3 = $PNG_TEMP_DIR.'side.png';}
                elseif (!file_exists($PNG_TEMP_DIR.'side1.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side1.png';}
                elseif (!file_exists($PNG_TEMP_DIR.'side2.png')){    
                        $filename3 = $PNG_TEMP_DIR.'side2.png';}
                elseif (!file_exists($PNG_TEMP_DIR.'side3.png')){    
                        $filename3 = $PNG_TEMP_DIR.'side3.png';}
                elseif (!file_exists($PNG_TEMP_DIR.'side4.png')){    
                        $filename3 = $PNG_TEMP_DIR.'side4.png';}
                elseif (!file_exists($PNG_TEMP_DIR.'side5.png')){    
                        $filename3 = $PNG_TEMP_DIR.'side5.png';}
            imagepng($image,$filename3,9); 
            
            $stamp = imagecreatefrompng($filename3);
            $im = imagecreatefrompng($filename2);
            $marge_left = 1;
            $marge_bottom = 1;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);
            imagecopy($im, $stamp, 0, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
            $PNG_TEMP_DIR = "uploads/qr/print/";
            if (!file_exists($PNG_TEMP_DIR)){
                mkdir($PNG_TEMP_DIR);}
            
            $filename4 = $PNG_TEMP_DIR.'complete'.$isbn.$i.time().'.png';
            imagepng($im,$filename4,9);
           
            unlink($filename);
            unlink($filename2);
            unlink($filename3);
            $serial=$res['serial'];
            $q="UPDATE bookrecords
            SET label = 1
            WHERE isbn = $isbn AND serial = '$serial'; ";
            mysqli_query($con,$q);
          
           
                }}
                header('Location: addbookrecords.php');}
else{
    $isbn = $_POST['isbn'];
    $serial = $_POST['serial'];
    $possesor = "0";
    $date = date("Y/m/d");
    include "phpqrcode/qrlib.php";
    $i=0;
    foreach ($serial as $value1) {
        $i++;
        if($value1!=""){
        $sql = "INSERT IGNORE INTO bookrecords(isbn,serial,possesor,date)
    VALUES('$isbn','$value1','$possesor','$date')";
        mysqli_query($con, $sql);
    
   
    
    $q="SELECT bookrecords.serial, books.form,books.title,books.publisher,bookrecords.label,bookrecords.isbn
    FROM bookrecords INNER JOIN books ON bookrecords.isbn = books.isbn
    WHERE bookrecords.isbn='$isbn' AND bookrecords.serial='$value1';";
    $query=mysqli_query($con,$q);}
    
      
    while($res=mysqli_fetch_array($query)) {
        
        $value=$res['isbn']."\"".$res['serial'];



//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = "uploads/qr/";

//html PNG location prefix
$PNG_WEB_DIR = 'uploads/qr/';

  

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR)){
    mkdir($PNG_TEMP_DIR);}
    
    if(!file_exists($PNG_TEMP_DIR.'qrcode.png')){    
        $filename = $PNG_TEMP_DIR.'qrcode.png';
    }
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode1.png')){    
        $filename = $PNG_TEMP_DIR.'qrcode1.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode2.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode2.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode3.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode3.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode4.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode4.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'qrcode5.png')){    
            $filename = $PNG_TEMP_DIR.'qrcode5.png';}
                        
    QRcode::png($value, $filename, 'H', 10, 4);  
$stamp = imagecreatefrompng($filename);
$im = imagecreatefrompng('uploads/qr/1.png');
$marge_right = 1;
$marge_bottom = 1;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));    
if(!file_exists($PNG_TEMP_DIR.'version.png')){    
    $filename2 = $PNG_TEMP_DIR.'version.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version1.png')){    
        $filename2 = $PNG_TEMP_DIR.'version1.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version2.png')){    
            $filename2 = $PNG_TEMP_DIR.'version2.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version3.png')){    
            $filename2 = $PNG_TEMP_DIR.'version3.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version4.png')){    
            $filename2 = $PNG_TEMP_DIR.'version4.png';}
    elseif (!file_exists($PNG_TEMP_DIR.'version5.png')){    
            $filename2 = $PNG_TEMP_DIR.'version5.png';}
imagepng($im,$filename2,9); 





$image = imagecreatetruecolor(300, 450);
        
        // Set the background color of image
        
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefill($image,0,0,$background_color);
        
        // Set the text color of image
        $text_color = imagecolorallocate($image,0, 0, 0);
        $font='font.ttf';
        $parts = explode(" ", $res['publisher']);
        $publisher="";
        foreach($parts as $part) {
        $publisher=$publisher.$part[0];
        }
        $publisher=$publisher." publ.";
        if($res['form']==0){
            $filename3=$res['title']." by ".$publisher;
        }else{
            $filename3=$res['title']." Form ".$res['form']." by ".$publisher;}
            $filename4 = str_split($filename3, 20);
        $serial=str_split($res['serial'],17);
        
        // Function to create image which contains string.
        imagettftext($image,30,90, 70, 430, $text_color,$font , $filename4[0]);
        imagettftext($image,30,90, 140, 440, $text_color,$font ,$filename4[1]);
        imagettftext($image,30,90, 210, 440, $text_color,$font , $serial[0]);
        if(isset($serial[1])){
        imagettftext($image,30,90, 280, 440, $text_color,$font , $serial[1]);}
        if(!file_exists($PNG_TEMP_DIR.'side.png')){    
            $filename3 = $PNG_TEMP_DIR.'side.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side1.png')){    
                $filename3 = $PNG_TEMP_DIR.'side1.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side2.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side2.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side3.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side3.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side4.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side4.png';}
            elseif (!file_exists($PNG_TEMP_DIR.'side5.png')){    
                    $filename3 = $PNG_TEMP_DIR.'side5.png';}
        imagepng($image,$filename3,9); 
        
        $stamp = imagecreatefrompng($filename3);
        $im = imagecreatefrompng($filename2);
        $marge_left = 1;
        $marge_bottom = 1;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopy($im, $stamp, 0, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        $PNG_TEMP_DIR = "uploads/qr/print/";
        if (!file_exists($PNG_TEMP_DIR)){
            mkdir($PNG_TEMP_DIR);}
        
        $filename4 = $PNG_TEMP_DIR.'complete'.$isbn.$i.time().'.png';
        imagepng($im,$filename4,9);
       
        unlink($filename);
        unlink($filename2);
        unlink($filename3);
        $serial=$res['serial'];
        $q="UPDATE bookrecords
        SET label = 1
        WHERE isbn = $isbn AND serial = '$serial'; ";
        mysqli_query($con,$q);
      
       
            }}
            header('Location: addbookrecords.php');}

            
           
            ?>