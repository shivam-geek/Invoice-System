<?php include 'include/orm.php' ?>

<?php
$amount_calc = 0;
$date = date("d/m/Y");

if(isset($_POST['submit'])) {
  //product Information
  $product_id = $_POST['productName'];
  $product_quantity = $_POST['quantity'];
  $product_amount = $_POST['purchase_amount'];
  $product_size = sizeof($product_id);

  //Company Information
  $name= $_POST['name'];
  $order_id = $_POST['order_id'];
  $gst = $_POST['gst'];
  $address = $_POST['address'];

  if(!empty($_POST['date'])) {
    $date = $_POST['date'];
  }

  if(!isset($error)) {

    $company = ORM::for_table('purchase')->create();

    $company->name = $name;
    $company->order_id = $order_id;
    $company->gst = $gst;
    $company->address = $address;
    $company->date = $date;
    $company->save();
    unset($company);

    $p = ORM::for_table('purchase')->raw_query('SELECT * FROM purchase ORDER BY id DESC')->find_one();
    $p_id = $p->id;

    for($i=0;$i<$product_size;$i++) {
      if($product_id[$i] > 0) {
        $product = ORM::for_table('product')->where("id",$product_id[$i])->find_one();
        $updated_quantity = $product->quantity + $product_quantity[$i];
        $product->quantity = $updated_quantity;
        $product->save();
        $price = $product_amount[$i];
        $priceQ = $price * (int)$product_quantity[$i];
        $amount_calc += $priceQ;
      }
      $p_purchase = ORM::for_table('purchase_has_product')->create();
      $p_purchase->purchase_id = $p_id;
      $p_purchase->product_name = $product->name;
      $p_purchase->product_hsn = $product->hsn;
      $p_purchase->product_price = $product_amount[$i];
      $p_purchase->product_quantity = $product_quantity[$i];
      $p_purchase->save();
      unset($product);
      unset($p_purchase);

      $p->amount = $amount_calc;
      $p->save();

      $success = "purchased Successfully";
    }
  }
}


?>



  <?php include "include/header.php" ?>
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="text-center text-primary">
        <h2>PURCHASE</h2>
      </div>
      <?php if(isset($error)) {
        echo '<div class="alert alert-danger" role="alert">
          <strong>'.$error.'</strong>}
          </div>';
      } else if(isset($success)) {
        echo '<div class="alert alert-success" role="alert">
          <strong>'.$success.'</strong>
          </div>';
      }
      ?>
      <div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Company Information</h4>
          <form method="post" id="purchase">
            <div class="company">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-8">
                  <label for="product_name">Company Name</label>
                  <input type="text" class="form-control"  name="name" value="" required>
                  </div>
                    <div class="col-md-4">
                  <label for="order_id">Order No</label>
                  <input type="text" class="form-control"  name="order_id" value="" required>
                  </div>
                  </div>
                  <div class="row">
                      <div class="col-md-8">
                          <label for="price">GST NO</label>
                          <input type="text" class="form-control" placeholder="Enter GST NO" name="gst" value="">
                        </div>
                        <div class="col-md-4">
                          <label for="price">Date</label>
                          <input type="text" id="date" class="form-control" placeholder="Select date" name="date" value="">
                        </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address">Company Address</label>
                    <textarea class="form-control"  rows="4" name="address" required></textarea>
                  </div>
                </div>
              </div>
              <hr class="mb-4">
            </div>
            <h4 class="mb-3">Product Information</h4>
              <div class="row product">
                <div class="col-md-1">
                  <label for="srno">Sr. No.</label>
                  <input type="text" class="form-control" id="srno" required="" value="1" disabled>
                </div>
                <div class="col-md-7">
                  <label for="productName">Product Name</label>
                  <select class="form-control" name="productName[]" id="productName" onchange="getPrice()">
                    <option value="0" selected>Select Product Name</option>
                    <?php
                      $product = ORM::for_table('product')->find_array();
                      foreach($product as $p) {
                        echo '<option value="'.$p['id'].'">'.$p['name'].'</option>';
                      }
                    ?>
                  </select>
                  <small id="q-status" class="form-text "></small>
                </div>
                <div class="col-md-1">
                  <label for="quantity">Quantity</label>
                  <input type="text" class="form-control" id="quantity" name="quantity[]" required="" maxlength="2" onkeypress="return isNumberKey(event)" value="">
                </div>
                <div class="col-md-2">
                  <label for="productAmount">Product Amount</label>
                  <input type="number" class="form-control amount" id="purchase_amount" name="purchase_amount[]" value="" >
                </div>
                <div class="col-md-1">
                <label for="NA">Close</label>
                  <input type="button" class="form-control" style="font-weight:900;" id="close" disabled onclick="remove()" value="X">
                </div>
              </div>
              <div style="margin-top:10px;"></div>
              <button class="btn btn-outline-primary btn-lg" style="margin-left: 45%" type="button" onclick="addProduct1()">Add More</button>
            </div>
                    </div>
            <div style="margin-top:30px;"></div>
            <button class="btn btn-outline-primary btn-lg btn-block" style="margin-bottom: 30px;" name="submit" type="submit">Make Purchase</button>
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