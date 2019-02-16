
<?php include "include/header.php" ?>
<?php include "include/orm.php" ?>

<?php


$data = ORM::for_table('invoice')->where("id", $_GET['edit'])->find_one();
$cust = ORM::for_table('customer')->where("id", $data->customer_id)->find_one();
$p = ORM::for_table('invoice_has_product')->where("invoice_id", $data->id)->find_many();

if(isset($_POST['submit'])) {
  $cust_name = $_POST['cust_name'];
  $cust_gst = $_POST['gstno'];
  $cust_address = $_POST['address'];
  $cust_email = $_POST['email'];
  $cust_mobile = $_POST['mobile'];
  $date = $_POST['date'];

  //Product Information
  $product_quantity = $_POST['quantity'];
  $product_serial = $_POST['serial'];
  $product_size = sizeof($product_quantity);

  //Payment Information
  $o_details = $_POST['o_details'];
  $o_amount = (int)$_POST['o_amount'];
  $cgst = (int)$_POST['cgst'];
  $sgst = (int)$_POST['sgst'];
  $igst = (int)$_POST['igst'];
  $payment_mode = $_POST['paymentMode'];
  $discount = (int)$_POST['discount'];
  $amount_paid = (int)$_POST['amountPaid'];

//Updating Invoice Info
$i = 0;
$amount_calc = NULL;
foreach($p as $product) {
      $price = $product->product_price;
      $priceQ = $price * (int)$product_quantity[$i];
      $amount_calc += $priceQ;
      $i++;
}

    // Tax Calculation
    $cgst_amount = ($cgst * $amount_calc) / 100;
    $sgst_amount = ($sgst * $amount_calc) / 100;
    $igst_amount = ($igst * $amount_calc) / 100;

    $total_gst = $cgst_amount + $sgst_amount + $igst_amount;

  $amount_calc = $amount_calc + $o_amount;

  $total_calc = $amount_calc - $discount + $total_gst;

  $balance_amount = $total_calc - $amount_paid;


  $data->date = $date;
  $data->o_details = $o_details;
  $data->o_amount = $o_amount;
  $data->cgst = $sgst;
  $data->sgst = $cgst;
  $data->igst = $igst;
  $data->payment_mode = $payment_mode;
  $data->discount = $discount;
  $data->amount = $total_calc;
  $data->total_gst = $total_gst;
  $data->paid_amount = $amount_paid;
  $data->balance_amount = $balance_amount;
  $data->save();

  $cust->name = $cust_name;
  $cust->gst = $cust_gst;
  $cust->address = $cust_address;
  $cust->mobile = $cust_mobile;
  $cust->email = $cust_email;
  $cust->save();
    $i = 0;
  foreach($p as $prd) {
      $prd->product_serial = $product_serial[$i];
      $prd->product_quantity = $product_quantity[$i];
      $prd->save();
  }

  $success = "updated successfully!";
  header('refresh:0.3;sell.php');

}





// var_dump($data);



?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="text-center text-primary">
                  <h2>Edit Invoice - <?php echo $_GET['edit']; ?></h2>
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
                          <label for="name">Customer Name</label>
                          <input type="text" class="form-control" id="cust_name" name="cust_name" value="<?php echo $cust->name; ?>" required="">
                          <label for="GSThNO">GSTIN No. of Purchaser</label>
                          <input type="text" class="form-control" id="gst" name="gstno" value="<?php echo $cust->gst; ?>">
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required="" rows="3"><?php echo $cust->address; ?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="mobile">Email</label>
                          <input type="email" class="form-control" name="email" id="email" value="<?php echo $cust->email; ?>">
                        </div>
                        <div class="col-md-3">
                          <label for="mobile">Mobile</label>
                          <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $cust->mobile; ?>" onkeypress="return isNumberKey(event)" maxlength="11">
                        </div>
                        <div class="col-md-3">
                          <label for="date">Date</label>
                          <input type="text" class="form-control" id="date" name="date" value="<?php echo $data->date; ?>">
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
                        <div class="col-md-4">
                          <label for="productName">Product Name</label>
                          <input type="text" class="form-control" id="serial" name="productName[]" value="<?php echo $product->product_name; ?>" disabled>
                          <small id="q-status" class="form-text "></small>
                        </div>
                        <div class="col-md-2">
                          <label for="productName">Product HSN</label>
                          <input type="text" class="form-control" id="serial" name="productHsn[]" value="<?php echo $product->product_hsn; ?>" disabled>
                          <small id="q-status" class="form-text "></small>
                        </div>
                        <div class="col-md-2">
                          <label for="quantity">Serial NO.</label>
                          <input type="text" class="form-control" id="serial" name="serial[]" value="<?php echo $product->product_serial; ?>">
                        </div>
                        <div class="col-md-1">
                          <label for="quantity">Quantity</label>
                          <input type="text" class="form-control" id="quantity" name="quantity[]" required="" disabled maxlength="1" onkeypress="return isNumberKey(event)" value="<?php echo $product->product_quantity; ?>">
                        </div>
                        <div class="col-md-2">
                          <label for="productAmount">Product Amount</label>
                          <input type="text" class="form-control amount" id="productAmount" value="<?php echo $product->product_price; ?>" disabled>
                        </div>
                      </div>
                            <?php } ?>
                      <div style="margin-top:10px;"></div>
                      <hr class="mb-4">
                      <h4 class="mb-3">Amount</h4>
                      <div class="row">
                        <div class="col-md-4">
                          <label for="otherChargesDetails">Other Charges Details</label>
                          <input type="text" class="form-control" id="otherChargesDetails" maxlength="100" value="<?php echo $data->o_details; ?>" name="o_details">
                        </div>
                        <div class="col-md-2">
                          <label for="otherChargesAmount">Other Charges Amount</label>
                          <input type="text" class="form-control" id="otherChargesAmount" maxlength="6" name="o_amount" value="<?php echo $data->o_amount; ?>" maxlength="6" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-2">
                          <label for="cgst">CGST</label>
                          <input type="number" class="form-control" id="cgst" maxlength="2" value="<?php echo $data->cgst; ?>" name="cgst" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-2">
                          <label for="sgst">SGST</label>
                          <input type="number" class="form-control" id="cgst" maxlength="2" value="<?php echo $data->sgst; ?>" name="sgst" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-2">
                          <label for="igst">IGST</label>
                          <input type="number" class="form-control" id="igst" maxlength="2" value="<?php echo $data->igst; ?>" name="igst" onkeypress="return isNumberKey(event)">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <label for="paymentMode">Payment Mode</label>
                          <select class="form-control" name="paymentMode" id="paymentMode">
                            <option value="Cash" selected>Cash</option>
                            <option value="Credit">Credit/Debit</option>
                            <option value="check">By Check</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label for="discount">Discount</label>
                          <input type="text" class="form-control" id="discount" maxlength="5" name="discount" value="<?php echo $data->discount; ?>" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-6">
                          <label for="amountPaid">Amount Paid</label>
                          <input type="text" class="form-control" maxlength="6" disabled id="amountPaid" name="amountPaid" value="<?php echo $data->paid_amount; ?>" onkeypress="return isNumberKey(event)">
                        </div>
                      </div>
                      <div style="margin-top:10px;"></div>
                      <input class="btn btn-outline-primary btn-lg btn-block"  style="margin-bottom: 30px;" type="submit" name="submit" value="Update Invoice">
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