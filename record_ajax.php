<?php
require_once('dbconn.php');
$id    = $_GET['id'];
$result = array();
if($id){
  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
  $options = [
   'projection' => ['_id' => 0],
];
  $query = new MongoDB\Driver\Query($filter,$options);
  $cursor = $manager->executeQuery('onlinestore.products', $query);
  foreach($cursor as $row){
    $result ['product_name'] = $row->product_name;
    $result ['price']        = $row->price;
    $result ['category']     = $row->category;
    $result ['id']           = $id;
  }
  echo json_encode($result);
}
