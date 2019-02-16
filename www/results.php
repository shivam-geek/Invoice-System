<?php

require 'include/orm.php';
require 'include/date_compare.php';


$today = date('d/m/Y');
$today_parse = date_parse($today);

$sold = ORM::for_table('invoice')->find_many();
$purchase = ORM::for_table('purchase')->find_many();

if(isset($_GET['filter'])) {
    $filter = $_GET['filter'];
} else if(isset($_POST['submit'])) {
    $filter_start = $_POST['start_date'];
    $filter_end = $_POST['end_date'];
} else {
    $error = "There is a Problem, Please try Again";
}

$date_sell = [];
$date_purchase = [];

if(isset($filter)) {
    if($filter == "today") {
        foreach ($sold as $s) {
            $date_temp = $s->date;
            if($today == $date_temp) {
                array_push($date_sell, $date_temp);
            }
        }
        foreach ($purchase as $p) {
            $date_temp = $p->date;
            if($today == $date_temp) {
                array_push($date_purchase, $date_temp);
            }
        }
    } else if($filter == "month") {
        foreach ($sold as $s) {
            $date_temp = date_parse($s->date);
            if($date_temp['day'] == $today_parse['day']) {
                array_push($date_sell, $s->date);
            }
        }
        foreach ($purchase as $p) {
            $date_temp = date_parse($p->date);
            if($date_temp['day'] == $today_parse['day']) {
                array_push($date_purchase, $p->date);
            }
        }
    } else if($filter == "year") {
        foreach ($sold as $s) {
            $date_temp = date_parse($s->date);
            if($date_temp['year'] == $today_parse['year']) {
                array_push($date_sell, $s->date);
            }
        }
        foreach ($purchase as $p) {
            $date_temp = date_parse($p->date);
            if($date_temp['year'] == $today_parse['year']) {
                array_push($date_purchase, $p->date);
            }
        }
    } else {
        $error = "There is a Problem, Please try again";
    }
} else {

  // $filter_start_parse = date_parse($filter_start);
  // $filter_end_parse = date_parse($filter_end);
  foreach ($purchase as $p) {
    $date_temp = $p->date;
    if(date_compare($date_temp, $filter_start) && date_compare($filter_end, $date_temp)) {
      array_push($date_purchase, $p->date);
    }
  }
  foreach ($sold as $s) {
    $date_temp = $s->date;
    if(date_compare($date_temp, $filter_start) && date_compare($filter_end, $date_temp)) {
      array_push($date_sell, $s->date);
    }
}


}
?>


<?php include 'include/header.php' ?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>Profit-Loss Report</h2>
      <br>
      <h4 class="text-info">
        <?php
          if(!isset($filter)) {
            echo 'From: '.$filter_start.' To: '.$filter_end;
          } else {
            if($filter == 'today') {
              echo 'Report for Today: '.$today;
            } else if($filter == 'month') {
              echo 'Report For Current Month';
            } else if($filter == 'year') {
              echo 'Report For Current Year';
            }
          }
        ?>
      </h4>
      <div class="clearfix" style="margin-bottom: 15px;"></div>
    </div>
    <div class="col-md-6">
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Bill NO</th>
          <th>Customer Name</th>
          <th>Product Sold</th>
          <th>Balance Amount</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
<?php
    $counter = 0;
    $sold_amount_real = 0;
    $sold_amount_virtual = 0;
    $product_sold = 0;
    $date_sell = array_unique($date_sell);
      foreach($date_sell as $ds) {
          foreach($sold as $row) {
            if($row->date == $ds) {
              $product_count = 0;
                $product = ORM::for_table('invoice_has_product')->where("invoice_id",$row->id)->find_many();
                foreach ($product as $prd) {
                  $product_count = $product_count + $prd->product_quantity;
                }
                $product_sold = $product_sold + $product_count;
                $customer = ORM::for_table('customer')->where("id", $row->customer_id)->find_one();
                $counter++;
                $sold_amount_real = $sold_amount_real + $row->paid_amount;
                $sold_amount_virtual = $sold_amount_virtual + $row->amount;
?>
          <tr>
            <td>
              <?php echo $counter;?>
            </td>
            <td>
              <?php echo $row->id;?>
            </td>
            <td>
            <a href="bill_report.php?id=<?php echo $row->id;?>"><?php echo $customer->name;?></a>
            </td>
            <td>
              <?php echo $product_count;?>
            </td>
            <td class="danger">
              <?php echo $row->balance_amount;?>
            </td>
            <td class="info">
              <?php echo $row->amount;?>
            </td>
          </tr>
          <?php
          unset($customer);
          unset($product_count);
            }
          }
      }
?>
      </tbody>
    </table>
    </div>
    <div class="col-md-6">
    <table id="myTable1" class="table table-striped">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Bill NO</th>
          <th>Customer Name</th>
          <th>Product Purchased</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
<?php
    $counter = 0;
    $purchase_amount = 0;
    $product_purchased = 0;
    $date_purchased = array_unique($date_purchase);
      foreach($date_purchase as $dp) {
          foreach($purchase as $row) {
            if($row->date == $dp) {
              $product_count = 0;
                $product = ORM::for_table('purchase_has_product')->where("purchase_id",$row->id)->find_many();
                foreach ($product as $prd) {
                  $product_count = $product_count + $prd->product_quantity;
                }
                $product_purchased = $product_purchased + $product_count;
                $counter++;
                $purchase_amount = $purchase_amount + $row->amount;;
               // $product_purchased = $product_purchased + $row->product_quantity;
?>
          <tr>
            <td>
              <?php echo $counter;?>
            </td>
            <td>
              <?php echo $row->id;?>
            </td>
            <td>
            <a href="purchase_report.php?id=<?php echo $row->id;?>"><?php echo $row->name;?></a>
            </td>
            <td>
              <?php echo $product_count;?>
            </td>
            <td class="info">
              <?php echo $row->amount;?>
            </td>
          </tr>
          <?php
            }
          }
      }
?>
      </tbody>
    </table>

    </div>
    <hr>
  <div class="col-md-12 profit_loss_box">
    <?php

    if($purchase_amount != 0 && $sold_amount_virtual != 0) {
      if($sold_amount_virtual > $purchase_amount) {
        $profit_amount = $sold_amount_virtual - $purchase_amount;
        $profit_amount_percent = ( 100 * $profit_amount ) / $purchase_amount;
        $result = true;
      } else {
        $loss_amount = $purchase_amount - $sold_amount_virtual;
        $loss_amount_percent = ( 100 * $loss_amount ) / $purchase_amount;
        $result = false;
      }
      $trigger = true;
    } else {
      $trigger = false;
      echo "<div class='alert alert-warning'> Sorry, Profit loss can't be declared </div>";
    }
    ?>
  </div>
  <hr>
  <?php if($trigger == true) { ?>
  <div class="row">
        <div class="col-md-12 order-md-1">
            <h4 class="mb-4">Result: </h4>
            <div class="row">
            <div class="col-md-4">
                  <p><strong>Total Product Sold: </strong><?php echo $product_sold; ?></p>
                  <p><strong>Total Sell Amount: </strong><?php echo $sold_amount_virtual; ?></p>
              </div>
              <div class="col-md-4">
                  <p><strong>Total Product Purchased: </strong> <?php echo $product_purchased; ?></p>
                  <p><strong>Total Purchase Amount: </strong> <?php echo $purchase_amount; ?></p>
              </div>
              <div class="col-md-4">
                  <p><strong>Status: </strong><?php if($result == true ) { echo 'Profit - <b>'.$profit_amount.'/-</b>';} else { echo 'Loss - <b>'.$loss_amount.'/-</b>';} ?></p>
              </div>
          </div>
        <hr>
  </div>
</div>
<?php } ?>
  </div>
</div>
<!-- /#page-content-wrapper -->
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
  $(document).ready(function () {
    $('#myTable1').DataTable();
  });
</script>

<?php include 'include/footer.php' ?>