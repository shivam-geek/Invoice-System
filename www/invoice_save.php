<?php

require 'include/orm.php';

$date = date("d/m/Y");
  //Customer Information
  $cust_name = $_POST['cust_name'];
  $cust_gst = $_POST['gstno'];
  $cust_address = $_POST['address'];
  $cust_email = $_POST['email'];
  $cust_mobile = $_POST['mobile'];
  if(!empty($_POST['date'])) {
    $date = $_POST['date'];
  }

  //Product Information
  $product_id = $_POST['productName'];
  $product_quantity = $_POST['quantity'];
  $product_serial = $_POST['serial'];
  $product_size = sizeof($product_id);

  //Payment Information
  $o_details = $_POST['o_details'];
  $o_amount = (int)$_POST['o_amount'];
  $cgst = (int)$_POST['cgst'];
  $sgst = (int)$_POST['sgst'];
  $igst = (int)$_POST['igst'];
  $total_gst = $_POST['total_gst'];
  $payment_mode = $_POST['paymentMode'];
  $discount = (int)$_POST['discount'];
  $amount_paid = (int)$_POST['amountPaid'];
  $total_amount = $_POST['totalAmount'];

  // Calculation
  $balance_amount = $total_amount - $amount_paid;

  // Inserting Data Into Customer Table
  $customer = ORM::for_table('customer')->create();
  $customer->name = $cust_name;
  $customer->address = $cust_address;
  $customer->gst = $cust_gst;
  $customer->email = $cust_email;
  $customer->mobile = $cust_mobile;
  $customer->save();
  unset($customer);

  // Fetching last customer id for next process
  $cust = ORM::for_table('customer')->raw_query('SELECT * FROM customer ORDER BY id DESC')->find_one();
  $cust_id = $cust->id;

  // Inserting Data Into Invoice Table with Customer_id
  $invoice = ORM::for_table('invoice')->create();
  $invoice->date = $date;
  $invoice->amount = $total_amount;
  $invoice->o_details = $o_details;
  $invoice->o_amount = $o_amount;
  $invoice->cgst = $cgst;
  $invoice->sgst = $sgst;
  $invoice->igst = $igst;
  $invoice->total_gst = $total_gst;
  $invoice->discount = $discount;
  $invoice->paid_amount = $amount_paid;
  $invoice->payment_mode = $payment_mode;
  $invoice->balance_amount = $balance_amount;
  $invoice->customer_id =$cust_id;
  $invoice->save();
  unset($invoice);

  // Fetching Last Invoice_id for Next Process
  $inv = ORM::for_table('invoice')->raw_query('SELECT * FROM invoice ORDER BY id DESC')->find_one();
  $inv_id = $inv->id;

  // Inserting Multiple Data Iteration in invoice_has_product Table with Invoice ID
  // Updating Stock quantity per Product
  for($i=0;$i<$product_size;$i++) {
      if($product_id[$i] > 0) {
        $product = ORM::for_table('product')->where("id",$product_id[$i])->find_one();
        $updated_quantity = $product->quantity - $product_quantity[$i];
        $product->quantity = $updated_quantity;
        $product->save();
      }
      $inv_has_prd = ORM::for_table('invoice_has_product')->create();
      $inv_has_prd->invoice_id = $inv_id;
      $inv_has_prd->product_quantity = $product_quantity[$i];
      $inv_has_prd->product_name = $product->name;
      $inv_has_prd->product_serial = $product_serial[$i];
      $inv_has_prd->product_hsn = $product->hsn;
      $inv_has_prd->product_price = $product->price;
      $inv_has_prd->save();
      unset($product);
      unset($inv_has_prd);
  }

  $file = NULL;
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
    <div class="jumbotron">
        <h1 class="display-4">Success</h1>
        <p class="lead">Invoice has Been Successfully Generated and Saved!</p>
        <a class="btn btn-primary btn-lg" href="bill_report.php?id=<?php echo $inv_id; ?>" role="button">Check out Bill Report Report!</a>
        <hr class="my-4">
        <p>For Next Invoice Click Below</p>
        <a class="btn btn-primary btn-lg" href="invoice.php" role="button">New Invoice</a>
    </div>
	</div>
</body>
</html>