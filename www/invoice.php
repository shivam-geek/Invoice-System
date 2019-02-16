
<?php include "include/header.php" ?>
<?php include "include/orm.php" ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="text-center text-primary">
                  <h2>INVOICE</h2>
                </div>
                <div class="alert" id="alert" role="alert">
                  <strong></strong>
                </div>
                <div class="row">
                  <div class="col-md-12 order-md-1">
                    <h4 class="mb-3">Customer Information</h4>
                    <form method="post" id="invoice" action="bill.php" onSubmit="return billGenerate()">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="name">Customer Name</label>
                          <input type="text" class="form-control" id="cust_name" name="cust_name" value="" required="">
                          <label for="GSThNO">GSTIN No. of Purchaser</label>
                          <input type="text" class="form-control" id="gst" name="gstno" value="">
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required="" rows="3"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="mobile">Email</label>
                          <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="col-md-3">
                          <label for="mobile">Mobile</label>
                          <input type="text" class="form-control" id="mobile" name="mobile" value="" onkeypress="return isNumberKey(event)" maxlength="11">
                        </div>
                        <div class="col-md-3">
                          <label for="date">Date</label>
                          <input type="text" class="form-control" id="date" name="date" value="">
                        </div>
                      </div>
                      <hr class="mb-4">
                      <h4 class="mb-3">Product Selection</h4>
                      <div class="row product">
                        <div class="col-md-1">
                          <label for="srno">Sr. No.</label>
                          <input type="text" class="form-control" id="srno" required="" value="1" disabled>
                        </div>
                        <div class="col-md-5">
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
                        <div class="col-md-2">
                          <label for="quantity">Serial NO.</label>
                          <input type="text" class="form-control" id="serial" name="serial[]" value="">
                        </div>
                        <div class="col-md-1">
                          <label for="quantity">Quantity</label>
                          <input type="text" class="form-control" id="quantity" name="quantity[]" required="" maxlength="1" onkeypress="return isNumberKey(event)" value="">
                        </div>
                        <div class="col-md-2">
                          <label for="productAmount">Product Amount</label>
                          <input type="text" class="form-control amount" id="productAmount" value="" disabled>
                        </div>
                        <div class="col-md-1">
                        <label for="NA">Close</label>
                          <input type="button" class="form-control" style="font-weight:900;" id="close" disabled onclick="remove()" value="X">
                        </div>
                      </div>
                      <div style="margin-top:10px;"></div>
                      <button class="btn btn-outline-primary btn-lg" style="margin-left: 45%" type="button" onclick="addProduct()">Add More</button>
                      <hr class="mb-4">
                      <h4 class="mb-3">Amount</h4>
                      <div class="row">
                        <div class="col-md-4">
                          <label for="otherChargesDetails">Other Charges Details</label>
                          <input type="text" class="form-control" id="otherChargesDetails" maxlength="100" name="o_details">
                        </div>
                        <div class="col-md-2">
                          <label for="otherChargesAmount">Other Charges Amount</label>
                          <input type="text" class="form-control" id="otherChargesAmount" maxlength="6" value="" name="o_amount" maxlength="6" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-2">
                          <label for="cgst">CGST</label>
                          <input type="number" class="form-control" id="cgst" maxlength="2" value="" name="cgst" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-2">
                          <label for="sgst">SGST</label>
                          <input type="number" class="form-control" id="cgst" maxlength="2" value="" name="sgst" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-2">
                          <label for="igst">IGST</label>
                          <input type="number" class="form-control" id="igst" maxlength="2" value="" name="igst" onkeypress="return isNumberKey(event)">
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
                          <input type="text" class="form-control" id="discount" maxlength="5" name="discount" value="" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-6">
                          <label for="amountPaid">Amount Paid</label>
                          <input type="text" class="form-control" maxlength="6" id="amountPaid" name="amountPaid" onkeypress="return isNumberKey(event)">
                        </div>
                      </div>
                      <div style="margin-top:10px;"></div>
                      <input class="btn btn-outline-primary btn-lg btn-block"  style="margin-bottom: 30px;" type="submit" name="submit" value="Generate Bill">
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