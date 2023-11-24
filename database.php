<?php
$hostname="localhost";
$dbuser="root";
$dbpass="";
$dbname="basicapp";
$conn= mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
if(!$conn){
    die("Something went wrong");
}