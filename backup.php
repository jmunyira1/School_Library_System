<?php
// Set database credentials
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'inventory';

// Set backup directory and filename
$backupDir = 'backup/';
$backupFile = $backupDir.$dbName.'_'.date('Y-m-d_H-i-s').'.sql';

// Connect to database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all tables
$tables = array();
$result = $conn->query('SHOW TABLES');
while($row = $result->fetch_array(MYSQLI_NUM)) {
    $tables[] = $row[0];
}

// Create backup file and write headers
$fileHandler = fopen($backupFile, 'w');
fwrite($fileHandler, '-- Database backup created on '.date('Y-m-d H:i:s').PHP_EOL);
fwrite($fileHandler, '-- MySQL Server version: '.$conn->server_info.PHP_EOL);
fwrite($fileHandler, '-- PHP version: '.phpversion().PHP_EOL);
fwrite($fileHandler, PHP_EOL);

// Iterate through each table and write contents to backup file
foreach($tables as $table) {
    $result = $conn->query('SELECT * FROM '.$table);
    $numColumns = $result->field_count;

    // Write CREATE TABLE statement to backup file
    $createTable = $conn->query('SHOW CREATE TABLE '.$table);
    $row = $createTable->fetch_array(MYSQLI_NUM);
    fwrite($fileHandler, '-- Table structure for table `'.$table.'`'.PHP_EOL);
    fwrite($fileHandler, $row[1].';'.PHP_EOL.PHP_EOL);

    // Write INSERT statements to backup file
    fwrite($fileHandler, '-- Dumping data for table `'.$table.'`'.PHP_EOL);
    while($row = $result->fetch_array(MYSQLI_NUM)) {
        fwrite($fileHandler, 'INSERT INTO `'.$table.'` VALUES(');
        for($i = 0; $i < $numColumns; $i++) {
            if(isset($row[$i])) {
                $row[$i] = str_replace("\n","\\n", addslashes($row[$i]));
                fwrite($fileHandler, '"'.$row[$i].'"');
            } else {
                fwrite($fileHandler, 'NULL');
            }

            if($i < ($numColumns-1)) {
                fwrite($fileHandler, ',');
            }
        }
        fwrite($fileHandler, ');'.PHP_EOL);
    }
    fwrite($fileHandler, PHP_EOL);
}

// Close backup file
fclose($fileHandler);

// Close database connection
$conn->close();

// Output message to user
echo 'Database backup created successfully!';
?>
