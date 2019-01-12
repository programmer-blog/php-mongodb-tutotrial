<?php
  require_once('dbconn.php');
  $id   = $_GET['id'];
  $flag = 0;
  if($id){
    $delRec = new MongoDB\Driver\BulkWrite;
    $delRec->delete(['_id' =>new MongoDB\BSON\ObjectID($id)], ['limit' => 1]);
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
    $result       = $manager->executeBulkWrite('onlinestore.products', $delRec, $writeConcern);
    if($result->getDeletedCount()){
      $flag = 1;
    }else{
      $flag = 2;
    }
    header("Location: index.php?flag=$flag");
    exit;

  }
