<?php
  require_once('dbconn.php');
  $product_name = '';
  $price        = 0;
  $category     = '';
  $flag         = 0;
  if(isset($_POST['btn'])){
      $product_name = $_POST['product_name'];
      $price        = $_POST['price'];
      $category     = $_POST['category'];

      if(!$product_name || !$price || !$category){
        $flag = 5;
      }else{
          $insRec       = new MongoDB\Driver\BulkWrite;
          $insRec->insert(['product_name' =>$product_name, 'price'=>$price, 'category'=>$category]);
          $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
          $result       = $manager->executeBulkWrite('onlinestore.products', $insRec, $writeConcern);

          if($result->getInsertedCount()){
            $flag = 3;
          }else{
            $flag = 2;
          }
      }
  }
  header("Location: index.php?flag=$flag");
  exit;
