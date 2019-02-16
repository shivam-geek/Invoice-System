<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<?php

// Rendering Process
$purchase = ORM::for_table('purchase')->where("id",$_GET['id'])->find_one();

?>
<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>PURCHASE NO: <?php echo $purchase['id']; ?> dsvds sdv dsvdsv sdvsdvsd v</h2>
    </div>
    <?php if(isset($error)) {
        echo '<div class="alert alert-danger" role="alert"><strong>'.$error .'</strong></div>';
        } else if(isset($success)) {
        echo '<div class="alert alert-success" role="alert"><strong>'.$success .'</strong></div>';
        }
     ?>
    <div class="row">
        <div class="col-md-12 order-md-1">
            <h4 class="mb-4">Company Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <strong>Name: </strong>
                        <?php echo $purchase['name']; ?>
                    </p>
                    <p>
                        <strong>GST NO: </strong>
                        <?php echo $purchase['gst']; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Address: </strong>
                        <?php echo $purchase['address']; ?>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 order-md-1">
            <h4 class="mb-4">Amount Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <strong>Purchase No: </strong>
                        <?php echo $purchase['id']; ?>
                    </p>
                    <p>
                        <strong>Order No: </strong>
                        <?php echo $purchase['order_id']; ?>
                    </p>
                    <p>
                        <strong>Date: </strong>
                        <?php echo $purchase['date']; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Total Amount: </strong>
                        <?php echo $purchase['amount']; ?>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <h4 class="mb-4">Product Information</h4>
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Name</th>
          <th>HSN Code</th>
          <th>Quantity</th>
          <th>Rate</th>
        </tr>
      </thead>
      <tbody>
<?php
      $product = ORM::for_table('purchase_has_product')->where("purchase_id",$purchase['id'])->find_array();
      $count = 1;
      foreach($product as $p) {
?>
          <tr>
            <td>
              <?php echo $count;?>
            </td>
            <td>
              <?php echo $p['product_name'];?>
            </td>
            <td>
              <?php echo $p['product_hsn'];?>
            </td>
            <td>
              <?php echo $p['product_quantity'];?>
            </td>
            <td>
              <?php echo $p['product_price'];?>
            </td>
          </tr>
          <?php $count++; } ?>
      </tbody>
    </table>
    <div class="m-4"></div>
  </div>
</div>
<!-- /#page-content-wrapper -->
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>

<?php include 'include/footer.php' ?>