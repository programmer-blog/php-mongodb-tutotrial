<?php
ini_set('display_errors','true');
error_reporting(E_ALL);

$messages = array(
	1=>'Record deleted successfully',
	2=>'Error occured. Please try again.', 
	3=>'Record saved successfully.',
    4=>'Record updated successfully.', 
    5=>'All fields are required.' );


$mongoDbname  =  'onlinestore';
$mongoTblName =  'products';
$manager     =   new MongoDB\Driver\Manager("mongodb://localhost:27017");