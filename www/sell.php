<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<?php
if(isset($_GET['delete'])) {
  $p_del = ORM::for_table('invoice_has_product')->where("invoice_id", $_GET['delete'])->find_many();
  foreach($p_del as $d) {
  	  $d->delete();
    }

  $delete = ORM::for_table('invoice')->where("id", $_GET['delete'])->find_one();
  $c_del = ORM::for_table('customer')->where("id",$delete->customer_id)->find_one();
  $c_del->delete();
  $delete->delete();
  $success = "Product deleted Successfully";
  //header("refresh:0.5;sell.php");
}
?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>SELL REPORT</h2>
    </div>
    <table id="myTable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Bill No</th>
          <th>Date</th>
          <th>Customer Name</th>
          <th>Payment Mode</th>
          <th>Other Charges Info</th>
          <th>Other Charges</th>
          <th>Discount</th>
          <th>Total Amount</th>
          <th>Paid Amount</th>
          <th>Balance Amount</th>
          <th>Edit / Delete</th>
        </tr>
      </thead>
      <tbody>
<?php
      $invoice = ORM::for_table('invoice')->find_array();
      foreach($invoice as $row) {
        $customer = ORM::for_table('customer')->where("id",$row['customer_id'])->find_one();
        if($row['balance_amount']*1.5 > $row['amount']) {
          $status = "table-danger";
        } else if($row['balance_amount'] == 0) {
          $status = "table-success";
          $row['balance_amount'] = "Cleared";
        } else {
          $status = "table-warning";
        }
?>
          <tr>
            <td>
              <a href="bill_report.php?id=<?php echo $row['id'];?>"><?php echo $row['id'];?>
            </td>
            <td>
              <?php echo $row['date'];?>
            </td>
            <td>
              <a href="bill_report.php?id=<?php echo $row['id'];?>"><?php echo $customer['name'];?></a>
            </td>
            <td>
              <?php echo $row['payment_mode'];?>
            </td>
            <td>
              <?php echo $row['o_details'];?>
            </td>
            <td>
              <?php echo $row['o_amount'];?>
            </td>
            <td>
              <?php echo $row['discount'];?>
            </td>
            <td>
              <?php echo $row['amount'];?>
            </td>
            <td>
              <?php echo $row['paid_amount'];?>
            </td>
            <td class="<?php echo $status ?>">
              <?php echo $row['balance_amount'];?>
            </td>
            <td>
              <a href="invoice_edit.php?edit=<?php echo $row['id'] ?>"><div class="btn btn-warning"><i class="fa fa-pencil"></i></div></a>
              <a href="?delete=<?php echo $row['id'] ?>"><div class="btn btn-danger"><i class="fa fa-trash-o"></i></div></a>
            </td>
          </tr>
          <?php unset($customer); } ?>
      </tbody>
    </table>

  </div>
</div>
<!-- /#page-content-wrapper -->
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
</script>

<?php include 'include/footer.php' ?>