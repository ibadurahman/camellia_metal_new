<?php 

$databases = ['camelliametal'];
$user       = 'root';
$pass       = '';
$host       = '127.0.0.1';

date_default_timezone_set('Asia/Jakarta');

if(!file_exists("F:\Backup Data")){
    mkdir("F:\Backup Data");
}

foreach($databases as $database){
    if(!file_exists("F:\Backup Data\\".$database)){
        mkdir("F:\Backup Data\\".$database);
    }

    $filename = $database."_".date("Ymd");
    $folder     = "F:\Backup Data\\".$database."\\".$filename.".sql";

    $return_var = NULL;
    $output = null;
    
    try {
        exec("C:\xampp\mysql\bin\mysqldump -uroot -p -h127.0.0.1 camelliametal > ".$folder,$output,$return_var);
    } catch (\Throwable $th) {
        throw $th;
    }
    
}

var_dump($return_var);
var_dump($output);
?>