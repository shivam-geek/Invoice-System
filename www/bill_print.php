<?php


require 'include/session_msg.php';
require 'include/orm.php';

  //Customer Information
  $cust_name = $_POST['cust_name'];
  $cust_gst = $_POST['gstno'];
  $cust_address = $_POST['address'];
  $cust_email = $_POST['email'];
  $cust_mobile = $_POST['mobile'];
  $date = $_POST['date'];

  //Product Information
  $product_id = $_POST['productName'];
  $product_size = sizeof($product_id);

  //Payment Information
  $o_details = $_POST['o_details'];
  $o_amount = (int)$_POST['o_amount'];
  $cgst = (int) $_POST['cgst'];
  $sgst = (int) $_POST['sgst'];
  $igst = (int) $_POST['igst'];
  $total_gst = $_POST['total_gst'];
  $discount = (int)$_POST['discount'];
  $Total_amount = $_POST['totalAmount'];
  $inv_id = $_POST['inv_id'];

  //Calculation
    $amount_calc = $Total_amount - $total_gst + $discount;

  $cgst_amount = ($cgst * $amount_calc) / 100;
  $sgst_amount = ($sgst * $amount_calc) / 100;
  $igst_amount = ($igst * $amount_calc) / 100;

  $total_calc = $Total_amount;


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
        $total_calc_word = $total_calc_rupees." Rupees ".$total_calc_pasie."only";    }


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
        position: absolute
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
        left: 45px;
        top: 960px;
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
        <button type="button" class="btn btn-outline-primary" onclick="billPrint()">Bill Print</button>
        <button type="button" class="btn btn-outline-primary" onclick="window.history.back()">back</button>
    </div>
    <script>
        function billPrint() {
            $("#final_print").hide();
            window.print();
            $("#final_print").show();
        }
    </script>
    <div id="bill-model">
        <p class="name"><?php echo $cust_name; ?></p>
        <p class="address"><?php echo $cust_address; ?></p>
        <p class="gst"><?php echo $cust_gst; ?></p>
        <p class="date"><?php echo $date; ?></p>
        <p class="sr"><?php echo "KS/".$year_previous."-".$year_next."/".sprintf("%03d", $inv_id); ?></p>
        <?php
            $item_count = 0;
            for($i=0;$i<$product_size;$i++) {
                $item = ORM::for_table('invoice_has_product')->where('invoice_id',$product_id[$i])->find_one();
                $item_count++;
        ?>
        <div class="product-section">
            <span class="serial"><?php echo $item_count; ?></span>
            <span class="product"><?php echo $item['product_name']."<br>Sr NO. ".$item['product_serial']; ?></span>
            <span class="hsn"><?php echo $item['product_hsn'] ?></span>
            <span class="quantity"><?php echo $item['product_quantity'] ?></span>
            <span class="rate"><?php echo number_format($item['product_price'],2);?></span>
            <span class="value"><?php echo number_format(($item['product_price'] * $item['product_quantity']),2); ?></span>
        </div>
<?php } ?>
        <?php if(!empty($o_details) && (!empty($o_amount) || $o_amount != 0)) { ?>
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

</body>

</html>
