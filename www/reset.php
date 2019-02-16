<?php
require 'include/orm.php';

// ORM::raw_execute('DELETE FROM customer');
// ORM::raw_execute('DELETE FROM invoice');
// ORM::raw_execute('DELETE FROM invoice_has_product');
// ORM::raw_execute('DELETE FROM product');
// ORM::raw_execute('DELETE FROM purchase');
// ORM::raw_execute('DELETE FROM invoice_has_balance_update');
// ORM::raw_execute('DELETE FROM purchase_has_product');
// ORM::raw_execute('DELETE FROM sqlite_sequence');
// ORM::raw_execute('VACUUM');

$file = 'include/DB/invoice.db';
$newFile = 'include/invoice.db';
if (!copy($file, $newFile)) {
  $error = "failed to Reset";
}else{
  $success = "Restored Successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Has Been Saved SuccessFully</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container-fluid">
    <?php if(isset($error)) { ?>
        <div class="jumbotron">
            <h1 class="display-4">Failed to Reset!</h1>
            <p class="lead">Please try again!</p>
            <a class="btn btn-primary btn-lg" href="index.php" role="button">Go To DashBoard!</a>
            <hr class="my-4">
            <p>To Reset Again, Hit the button! </p>
            <a class="btn btn-primary btn-lg" href="reset.php" role="button">Reset</a>
        </div>
  <?php  } else { ?>
    <div class="jumbotron">
        <h1 class="display-4">Reset Success</h1>
        <p class="lead">All the configuration and data has been restored to defaults</p>
        <a class="btn btn-primary btn-lg" href="index.php" role="button">Go To DashBoard!</a>
        <hr class="my-4">
        <p>To restore Data From Backup, Click Below!</p>
        <a class="btn btn-primary btn-lg" href="backup_restore.php" role="button">Restore</a>
    </div>
  <?php  }?>
	</div>
</body>
</html>