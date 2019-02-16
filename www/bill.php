<?php

session_start();

require 'include/session_msg.php';
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
  $payment_mode = $_POST['paymentMode'];
  $discount = (int)$_POST['discount'];
  $amount_paid = (int)$_POST['amountPaid'];


  //Calculation
  $amount_calc = NULL;
  for($i=0;$i<$product_size;$i++) {
      if($product_id[$i] > 0) {
        $product = ORM::for_table('product')->where('id',$product_id[$i])->find_one();
        $price = $product->price;
        $priceQ = $price * (int)$product_quantity[$i];
        $amount_calc += $priceQ;
      }
  }

    // Tax Calculation
    $cgst_amount = ($cgst * $amount_calc) / 100;
    $sgst_amount = ($sgst * $amount_calc) / 100;
    $igst_amount = ($igst * $amount_calc) / 100;

    $total_gst = $cgst_amount + $sgst_amount + $igst_amount;

  $amount_calc = $amount_calc + $o_amount;

  $total_calc = $amount_calc - $discount + $total_gst;

  $total_calc_list = number_format($total_calc,2);
  $total_calc_list = str_replace(",", "", $total_calc_list);

   list($rupees, $paise) = explode('.', $total_calc_list);

   $rupees = (int) $rupees;
   $paise = (int) $paise;

     require_once 'include/currency_converter.php';

    if($total_calc == 0) {
        $total_calc_word = "Zero Rupees";
    } else {

        $total_calc_rupees = currencyConvert($rupees);
        if($paise == 0) {
            $total_calc_pasie = NULL;
        } else {
            $total_calc_pasie = "and ".currencyConvert($paise)." Paise ";
        }
        $total_calc_word = $total_calc_rupees." Rupees ".$total_calc_pasie."only";
    }

  // Fetching Serial Number From DataBase
  $inv = ORM::for_table('sqlite_sequence')->where("name", "invoice")->find_one();
  $inv_count = $inv['seq'];
  $sr = (int) $inv_count + 1;


  // FINANCIAL DATE Generated

  $d = date_parse($date);

 $year_current = str_replace("20","",$d['year']);

if($d["day"] > 3) {
    $year_previous = $year_current;
    $year_next = $year_current+ 1;
} else {
    $year_previous = $year_current - 1;
    $year_next = $year_current;
}

if($year_previous > 18) {
    header('refresh:0.5;expire.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/jquery.js"></script>
    <!-- <script src="js/custom.js"></script> -->
    <title>Bill Generated</title>
</head>

<style>
    body {
        /* background-image: url("img/bill_color.png"); */
        /* background-repeat: no-repeat; */
        background-size: 210mm 297mm;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    p {
        font-size: 18px;
        font-weight: 600;
    }
    span {
        font-size: 18px;
        font-weight: 600;
	    width: 5px;
    }

    .name {
        top: 168px;
        left: 228px;
        position: absolute;    }
    .address {
		left: 82px;
	    top: 196px;
	    position: absolute;
	    max-width: 430px;
	    text-indent: 73px;
	    line-height: 28px;   
	}
    .gst {
        top: 255px;
        left: 230px;
        position: absolute;    }
    .date {
		top: 244px;
	    left: 603px;
	    position: absolute;
    }
    .sr {
        top: 166px;
        left: 622px;
        font-size: 20px;
        position: absolute;
    }
    .product-section {
		top: 350px;
	    left: 35px;
	    position: relative;
	    width: 730px;
        min-height: 100px;
}
    .product {
		max-width: 260px;
	    left: 35px;
	    position: absolute;
	    width: 256px;
	    float: left;
	}
    .hsn {
		 left: 306px;
	    position: absolute;
	    text-align: center;
	    width: 111px;
    }
    .quantity {
	    left: 433px;
	    position: absolute;
	    width: 50px;
	    text-align: center;
    }
    .rate {
	    left: 498px;
	    position: absolute;
	    text-align: right;
	    width: 94px;
    }
    .value {
	    left: 607px;
	    position: absolute;
	    text-align: right;
	    width: 120px;
    }
    .amount {
        left: 635px;
        top: 798px;
        line-height: 8px;
        position: absolute;
        text-align: right;
        width: 130px;
    }
    .tax {
        left: 540px;
        top: 825px;
        line-height: 8px;
        position: absolute;
        text-align: right;
        width: 75px;
    }
    .amount_word {
        left: 46px;
        top: 957px;
        position: absolute;
        max-width: 425px;
        text-indent: 143px;
        line-height: 32px;
        text-transform: capitalize;
    }
    #final_print {
        position:absolute;
    }
</style>
<body>
    <img src="img/bill.png" style="position: absolute; ma width:210mm; height:297mm;" alt="">
    <div id="final_print">
    <?php // Hidden from TO HOLD DATA ?>
    <form method="post" action="invoice_save.php" onSubmit="return final_print();">
            <input type="submit" value="Final Submit &amp; Print" name="submit">
            <input type="hidden" value="<?php echo $cust_name; ?>" name="cust_name">
            <input type="hidden" value="<?php echo $cust_gst; ?>" name="gstno">
            <input type="hidden" value="<?php echo $cust_address; ?>" name="address">
            <input type="hidden" value="<?php echo $cust_email; ?>" name="email">
            <input type="hidden" value="<?php echo $cust_mobile; ?>" name="mobile">
            <input type="hidden" value="<?php echo $date; ?>" name="date">
            <?php for($i=0;$i<$product_size;$i++) {  ?>
            <input type="hidden" value="<?php echo $product_id[$i]; ?>" name="productName[]">
            <input type="hidden" value="<?php echo $product_quantity[$i]; ?>" name="quantity[]">
            <input type="hidden" value="<?php echo $product_serial[$i]; ?>" name="serial[]">

          <?php  } ?>
            <input type="hidden" value="<?php echo $o_details; ?>" name="o_details">
            <input type="hidden" value="<?php echo $o_amount; ?>" name="o_amount">
            <input type="hidden" value="<?php echo $cgst; ?>" name="cgst">
            <input type="hidden" value="<?php echo $sgst; ?>" name="sgst">
            <input type="hidden" value="<?php echo $igst; ?>" name="igst">
            <input type="hidden" value="<?php echo $total_gst; ?>" name="total_gst">
            <input type="hidden" value="<?php echo $payment_mode; ?>" name="paymentMode">
            <input type="hidden" value="<?php echo $discount; ?>" name="discount">
            <input type="hidden" value="<?php echo $amount_paid; ?>" name="amountPaid">
            <input type="hidden" value="<?php echo $total_calc; ?>" name="totalAmount">
        </form>
        <button type="button" class="btn btn-outline-primary" onclick="window.history.back()">back</button>
    </div>
    <div id="bill-model">
        <p class="name"><?php echo $cust_name; ?></p>
        <p class="address"><?php echo $cust_address; ?></p>
        <p class="gst"><?php echo $cust_gst; ?></p>
        <p class="date"><?php echo $date; ?></p>
        <p class="sr"><?php echo "KS/".$year_previous."-".$year_next."/".sprintf("%03d", $sr); ?></p>
        <?php
            $item_count = 0;
            for($i=0;$i<$product_size;$i++) {
                $item = ORM::for_table('product')->where('id',$product_id[$i])->find_one();
                $item_count++;
        ?>
        <div class="product-section">
            <span class="serial"><?php echo $item_count; ?></span>
            <span class="product"><?php echo $item['name']."<br>Sr NO. ".$product_serial[$i]; ?></span>
            <span class="hsn"><?php echo $item['hsn'] ?></span>
            <span class="quantity"><?php echo $product_quantity[$i] ?></span>
            <span class="rate"><?php echo number_format($item['price'],2); ?></span>
            <span class="value"><?php echo number_format($item['price'] * $product_quantity[$i],2); ?></span>
        </div>
<?php } ?>
<?php if(!empty($o_details) && !empty($o_amount)) { ?>
        <div class="product-section">
            <span class="serial">&nbsp;&nbsp;</span>
            <span class="product"><?php echo $o_details; ?></span>
            <span class="hsn"> - </span>
            <span class="quantity"> - </span>
            <span class="rate"> <?php echo $o_amount.".00"; ?> </span>
            <span class="value"><?php echo $o_amount.".00"; ?></span>
        </div>
<?php } ?>
        <div class="amount">
            <p><?php echo number_format($amount_calc,2); ?></p>
            <p><?php echo number_format($cgst_amount,2); ?></p>
            <p><?php echo number_format($sgst_amount,2); ?></p>
            <p><?php echo number_format($igst_amount,2); ?></p>
            <p><?php echo number_format($discount,2); ?></p>
            <p><?php echo number_format($total_calc,2); ?></p>
        </div>
        <div class="tax">
            <p><?php echo $cgst."%" ?></p>
            <p><?php echo $sgst."%" ?></p>
            <p><?php echo $igst."%" ?></p>
        </div>
        <p class="amount_word"><?php echo $total_calc_word; ?></p>
        </div>
        <script>
        function final_print() {
            $("#final_print").css("display","none");
            window.print();
            $("#final_print").css("display","block");
            return true;
        }
        </script>


</body>

</html>
