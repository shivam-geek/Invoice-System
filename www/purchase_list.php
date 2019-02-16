<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<?php
if(isset($_GET['delete'])) {
  $p_del = ORM::for_table('purchase_has_product')->where("purchase_id", $_GET['delete'])->find_many();
  foreach($p_del as $d) {
  	  $d->delete();
    }

  $delete = ORM::for_table('purchase')->where("id", $_GET['delete'])->find_one();
  $delete->delete();
  $success = "Product deleted Successfully";
  //header("refresh:0.5;purchase_list.php");
}
?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>PURCHASE REPORT</h2>
    </div>
    <table id="myTable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Purchase No</th>
          <th>Order NO</th>
          <th>Date</th>
          <th>Company Name</th>
          <th>GST NO</th>
          <th>Address</th>
          <th>Amount</th>
          <th>Edit / Delete</th>
        </tr>
      </thead>
      <tbody>
<?php
      $purchase = ORM::for_table('purchase')->find_array();
      foreach($purchase as $row) {
?>
          <tr>
            <td>
              <a href="purchase_report.php?id=<?php echo $row['id'];?>"><?php echo $row['id'];?>
            </td>
            <td>
            <a href="purchase_report.php?id=<?php echo $row['id'];?>"><?php echo $row['order_id'];?>
            </td>
            <td>
              <?php echo $row['date'];?>
            </td>
            <td>
              <a href="purchase_report.php?id=<?php echo $row['id'];?>"><?php echo $row['name'];?></a>
            </td>
            <td>
              <?php echo $row['gst'];?>
            </td>
            <td>
              <?php echo $row['address'];?>
            </td>
            <td>
              <?php echo $row['amount'];?>
            </td>
            <td>
              <a href="purchase_edit.php?edit=<?php echo $row['id'] ?>"><div class="btn btn-warning"><i class="fa fa-pencil"></i></div></a>
              <a href="?delete=<?php echo $row['id'] ?>"><div class="btn btn-danger"><i class="fa fa-trash-o"></i></div></a>
            </td>
          </tr>
          <?php } ?>
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