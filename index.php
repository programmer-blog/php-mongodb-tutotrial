<?php
require_once('dbconn.php');

$flag    = isset($_GET['flag'])?intval($_GET['flag']):0;
$message ='';
if($flag){
  $message = $messages[$flag];
}
//$filter = ['x' => ['$gt' => 1]];
$filter = [];
$options = [
    'sort' => ['_id' => -1],
];

$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('onlinestore.products', $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php mongodb tutorial - view insert update delete records</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo">
                <h3>
                  PHP mongoDB Tutorial - View, insert update, delete records
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="mini-layout">
                   <form id="form1" name='form1' action="record_add.php" method="post">
                   <input type='hidden' name='id' id='id' value="" />
                    <table>
                      <tr>
                        <td><input type='text' name='product_name' id='product_name' placeholder="Product Name" /></td>
                        <td><input type='text' name='price' id='price' placeholder="Price" /></td>
                        <td><input type='text' name='category' id='category' placeholder="Category" /></td>
                        <td><input class='btn' type='submit' name='btn' id='btn' value="Add Records" /></td>
                      </tr>
                    </table>
                   </form>
                    <h3>Products Listing</h3>
                    <p>
                      <?php if($flag == 2 || $flag == 5){ ?>
                        <div class="error"><?php echo $message; ?></div>
                      <?php  } elseif($flag && $flag != 2 ){ ?>
                        <div class="success"><?php echo $message; ?></div>
                      <?php  } ?>
                    </p>
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Prodcut</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Action</th>
                        </tr>
                     </thead>
                    <?php 
                    $i =1; 
                    foreach ($cursor as $document) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $document->product_name;  ?></td>
                        <td><?php echo $document->price;  ?></td>
                        <td><?php echo $document->category;  ?></td>
                        <td><a class='editlink' data-id=<?php echo $document->_id; ?> href='javascript:void(0)'>Edit</a> |
                          <a onClick ='return confirm("Do you want to remove this record?");' href='record_delete.php?id=<?php echo $document->_id; ?>'>Delete</td>
                      </tr>
                   <?php $i++;  
                    } 
                  ?>
                    </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(function(){
  $('.editlink').on('click', function(){
    var id = $(this).data('id');
    if(id){
      $.ajax({
          method: "GET",
          url: "record_ajax.php",
          data: { id: id}
        })
        .done(function( result ) {
          result = $.parseJSON(result);
          $('#product_name').val(result['product_name']);
          $('#price').val(result['price']);
          $('#category').val(result['category']);
          $('#id').val(result['id']);
          $('#btn').val('Update Records');
          $('#form1').attr('action', 'record_edit.php');
        });
      }
    });
});

</script>
</body>
</html>
