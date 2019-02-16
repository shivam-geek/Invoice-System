<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<?php

// Rendering Process
$inv = ORM::for_table('invoice')->where("id",$_GET['id'])->find_one();
    $customer = ORM::for_table('customer')->where("id",$inv['customer_id'])->find_one();


// Updating Balance
if(isset($_GET['update'])) {
    $balance = (int) $_GET['balance'];
    if($balance > $inv['balance_amount']) {
        $error = "Updated Balance cannot be Higher than Net Balance!";
    } else {
        $updated_balance = $inv->balance_amount - $balance;
        $updated_paid_amount = $inv->paid_amount + $balance;
        $inv->balance_amount = $updated_balance;
        $inv->paid_amount = $updated_paid_amount;
        $inv->save();
        $b = ORM::for_table('invoice_has_balance_update')->create();
        $b->invoice_id = $inv['id'];
        $b->balance_update = $balance;
        $b->date = date("d/m/y");
        $b->save();
        $success = "Balance Updated Successfully";
        header("refresh:0.5;bill_report.php?id=".$inv['id']."");
    }
}


?>
<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>BILL NO: <?php echo $inv['id']; ?></h2>
    </div>
    <?php if(isset($error)) {
        echo '<div class="alert alert-danger" role="alert"><strong>'.$error .'</strong></div>';
        } else if(isset($success)) {
        echo '<div class="alert alert-success" role="alert"><strong>'.$success .'</strong></div>';
        }
     ?>
    <div class="row">
        <div class="col-md-12 order-md-1">
            <h4 class="mb-4">Customer Information</h4>
            <div class="row">
            <div class="col-md-6">

                <p><strong>Name: </strong> <?php echo $customer['name']; ?></p>
                <p><strong>Email: </strong> <?php echo $customer['email']; ?></p>
                <p><strong>Mobile: </strong> <?php echo $customer['mobile']; ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Address: </strong><?php echo $customer['address']; ?></p>
                <p><strong>GST NO: </strong><?php echo $customer['gst']; ?></p>
            </div>
        </div>
        <hr>
        <h4 class="mb-4">Billing Information &amp; Balance Update</h4>
        <div class="row">
            <div class="col-md-4">
                <p><strong>BIll No: </strong> <?php echo $inv['id']; ?></p>
                <p><strong>Date: </strong> <?php echo $inv['date']; ?></p>
                <p><strong>Payment Mode: </strong> <?php echo $inv['payment_mode']; ?></p>
                <p><strong>Other Charges Info: </strong> <?php echo $inv['o_details']; ?></p>
            </div>
            <div class="col-md-2">
                <p><strong>Total Amount: </strong><?php echo $inv['amount']; ?></p>
                <p><strong>Other Charges: </strong><?php echo $inv['o_amount']; ?></p>
                <p><strong>Discount: </strong><?php echo $inv['discount']; ?></p>
                <p><strong>Paid Amount: </strong><?php echo $inv['paid_amount']; ?></p>
                <p><strong>Net Balance: </strong><?php echo $inv['balance_amount']; ?></p>
            </div>
            <div class="col-md-2">
                <p><strong>CGST: </strong><?php echo $inv['cgst']."%"; ?></p>
                <p><strong>SGST: </strong><?php echo $inv['sgst']."%"; ?></p>
                <p><strong>IGST: </strong><?php echo $inv['igst']."%"; ?></p>
                <p><strong>Total GST Amount: </strong><?php echo $inv['total_gst']; ?></p>
            </div>
            <div class="col-md-2">
            <p><strong>Balance Update</strong></p>
                    <?php
                $bd = ORM::for_table('invoice_has_balance_update')->where("invoice_id",$inv['id'])->find_array();
                foreach($bd as $b_row) {
                    ?>
                    <p><?php echo $b_row['date']; ?> : <strong><?php echo $b_row['balance_update']; ?></strong></p>
                <?php } ?>
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
          <th>Product Sr No.</th>
          <th>HSN Code</th>
          <th>Quantity</th>
          <th>Rate</th>
        </tr>
      </thead>
      <tbody>
<?php
      $product = ORM::for_table('invoice_has_product')->where("invoice_id",$inv['id'])->find_array();
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
              <?php echo $p['product_serial'];?>
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
    <hr>
    <div class="row">
        <div class="col-md-6">
        <h4 class="mb-4">Update Balance Information</h4>
        <form class="form-inline" method="get">
            <label class="sr-only" for="balance_update">Balance Amount</label>
            <input type="hidden" name="id" value="<?php echo $inv['id'];?>">
            <input type="text" class="form-control mb-2 mr-sm-2" name="balance" placeholder="Enter Balance">
            <button type="submit" class="btn btn-primary mb-2" name="update">Update Balance</button>
        </form>
        </div>
        <div class="col-md-3">
        <h4 class="mb-4">Print Bill </h4>
        <form method="post" action="bill_print.php">
            <input type="submit" class="btn btn-primary" value="Bill Print" name="submit">
            <input type="hidden" value="<?php echo $customer['name']; ?>" name="cust_name">
            <input type="hidden" value="<?php echo $customer['gst']; ?>" name="gstno">
            <input type="hidden" value="<?php echo $customer['address']; ?>" name="address">
            <input type="hidden" value="<?php echo $customer['email']; ?>" name="email">
            <input type="hidden" value="<?php echo $customer['mobile']; ?>" name="mobile">
            <input type="hidden" value="<?php echo $inv['date']; ?>" name="date">
			<input type="hidden" value="<?php echo $inv['id']; ?>" name="inv_id">

            <?php
                $t = ORM::for_table('invoice_has_product')->where("invoice_id",$inv['id'])->find_array();
                foreach($t as $pr) {  ?>
                    <input type="hidden" value="<?php echo $pr['invoice_id']; ?>" name="productName[]">
                    <input type="hidden" value="<?php echo $pr['product_quantity']; ?>" name="quantity[]">
                    <input type="hidden" value="<?php echo $pr['product_serial']; ?>" name="serial[]">
              <?php  }?>
            <input type="hidden" value="<?php echo $inv['o_details']; ?>" name="o_details">
            <input type="hidden" value="<?php echo $inv['o_amount']; ?>" name="o_amount">
            <input type="hidden" value="<?php echo $inv['cgst']; ?>" name="cgst">
            <input type="hidden" value="<?php echo $inv['sgst']; ?>" name="sgst">
            <input type="hidden" value="<?php echo $inv['igst']; ?>" name="igst">
            <input type="hidden" value="<?php echo $inv['total_gst']; ?>" name="total_gst">
            <input type="hidden" value="<?php echo $inv['discount'];; ?>" name="discount">
            <input type="hidden" value="<?php echo $inv['amount'];; ?>" name="totalAmount">
        </form>
        </div>
        <div class="col-md-3">
        <h4 class="mb-4">Edit Bill </h4>
            <a class="btn btn-primary" href="invoice_edit.php?edit=<?php echo $inv['id']; ?>">Edit Bill</a>
        </div>
    </div>
  </div>
</div>
<!-- /#page-content-wrapper -->
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>

<?php include 'include/footer.php' ?>