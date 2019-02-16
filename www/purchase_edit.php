<?php include "include/header.php" ?>
<?php include "include/orm.php" ?>

<?php


$data = ORM::for_table('purchase')->where("id", $_GET['edit'])->find_one();
$p = ORM::for_table('purchase_has_product')->where("purchase_id", $data->id)->find_many();

if(isset($_POST['submit'])) {
  $name = $_POST['name'];
  $order_id = $_POST['order_id'];
  $gst = $_POST['gst'];
  $address = $_POST['address'];
  $date = $_POST['date'];

  //Product Information
//   $product_quantity = $_POST['quantity'];
  $product_price = $_POST['productPrice'];
//   $product_size = sizeof($product_quantity);


//Updating Invoice Info
$i = 0;
$amount_calc = NULL;
foreach($p as $product) {
      $priceQ = $product_price[$i] * (int) $product->product_quantity;
      $amount_calc += $priceQ;
      $i++;
}

  $data->date = $date;
  $data->name = $name;
  $data->gst = $gst;
  $data->order_id = $order_id;
  $data->address = $address;
  $data->amount = $amount_calc;
  $data->save();

    $i = 0;
  foreach($p as $prd) {
      $prd->product_price = $product_price[$i];
      $prd->save();
  }

  $success = "updated successfully!";
  header('refresh:0.3;purchase_list.php');

}




?>



        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="text-center text-primary">
                  <h2>Edit Purchase No - <?php echo $_GET['edit']; ?></h2>
                </div>
                <?php if(isset($error)) {
        echo '<div class="alert alert-danger" role="alert"><strong>'.$error .'</strong></div>';
        } else if(isset($success)) {
        echo '<div class="alert alert-success" role="alert"><strong>'.$success .'</strong></div>';
        }
     ?>
                <div class="row">
                  <div class="col-md-12 order-md-1">
                    <h4 class="mb-3">Customer Information</h4>
                    <form method="post" id="invoice">
                      <div class="row">
                      <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-8">
                  <label for="product_name">Company Name</label>
                  <input type="text" class="form-control"  name="name" value="<?php echo $data->name; ?>" required>
                  </div>
                    <div class="col-md-4">
                  <label for="order_id">Order No</label>
                  <input type="text" class="form-control"  name="order_id" value="<?php echo $data->order_id; ?>" required>
                  </div>
                  </div>
                  <div class="row">
                      <div class="col-md-8">
                          <label for="price">GST NO</label>
                          <input type="text" class="form-control" placeholder="Enter GST NO" name="gst" value="<?php echo $data->gst; ?>">
                        </div>
                        <div class="col-md-4">
                          <label for="price">Date</label>
                          <input type="text" id="date" class="form-control" placeholder="Select date" name="date" value="<?php echo $data->date; ?>">
                        </div>
                  </div>
                </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required="" rows="3"><?php echo $data->address; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <hr class="mb-4">
                      <h4 class="mb-3">Product Selection</h4>
                      <?php
                            $count = 0;
                            foreach($p as $product) {
                                $count++;
                      ?>
                      <div class="row">
                        <div class="col-md-1">
                          <label for="srno">Sr. No.</label>
                          <input type="text" class="form-control" id="srno" required="" value="<?php echo $count; ?>" disabled>
                        </div>
                        <div class="col-md-7">
                          <label for="productName">Product Name</label>
                          <input type="text" class="form-control" id="serial" name="productName[]" value="<?php echo $product->product_name; ?>" disabled>
                          <small id="q-status" class="form-text "></small>
                        </div>
                        <div class="col-md-2">
                          <label for="quantity">Quantity</label>
                          <input type="text" class="form-control" id="quantity" disabled name="quantity[]"  required="" maxlength="2" onkeypress="return isNumberKey(event)" value="<?php echo $product->product_quantity; ?>">
                        </div>
                        <div class="col-md-2">
                          <label for="productAmount">Product Amount</label>
                          <input type="text" class="form-control amount" id="productAmount" name="productPrice[]" onkeypress="return isNumberKey(event)" value="<?php echo $product->product_price; ?>">
                        </div>
                      </div>
                            <?php } ?>
                      <div style="margin-top:10px;"></div>
                      <input class="btn btn-outline-primary btn-lg btn-block"  style="margin-bottom: 30px;" type="submit" name="submit" value="Update">
                    </form>
                    <script>
                      $('#date').datepicker({
                        uiLibrary: 'bootstrap4',
                        format: 'dd/mm/yyyy'
                      });
                    </script>
                  </div>
                </div>
              </div>
        </div>
        <!-- /#page-content-wrapper -->

<?php include "include/footer.php" ?>