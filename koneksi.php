<?php

$host="localhost";
$user="root";
$pass="";
$database="uas";

//Proses Koneksi
$query = mysqli_connect($host, $user, $pass, $database);
$koneksi= mysqli_connect($host, $user, $pass, $database);
if (!$koneksi){
    die("koneksi gagal: ".mysqli_connect_error());
}

?>