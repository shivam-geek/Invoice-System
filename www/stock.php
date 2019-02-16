<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<?php

if(isset($_GET['delete'])) {
  $delete = ORM::for_table('product')->where("id", $_GET['delete'])->find_one();
  $delete->delete();
  $success = "Product deleted Successfully";
  //header("refresh:0.5;stock.php");
}

?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center">
        <h2 class="text-primary">STOCK</h2>
    </div>
    <?php if(isset($error)) {
        echo '<div class="alert alert-danger" role="alert"><strong>'.$error .'</strong></div>';
        } else if(isset($success)) {
        echo '<div class="alert alert-success" role="alert"><strong>'.$success .'</strong></div>';
        }
     ?>
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Name</th>
          <th>Description</th>
          <th>Quantity</th>
          <th>HSN Code</th>
          <th>Rate</th>
          <th>Edit / Delete</th>
        </tr>
      </thead>
      <tbody>
<?php
      $product = ORM::for_table('product')->find_array();
      foreach($product as $row) {
        if($row['quantity'] < 2) {
          $status = "table-danger";
        } else if($row['quantity'] < 3) {
          $status = "table-warning";
        } else {
          $status = "table-success";
        }
?>
          <tr>
            <td>
              <?php echo $row['id'];?>
            </td>
            <td>
              <?php echo $row['name'];?>
            </td>
            <td>
              <?php echo $row['des'];?>
            </td>
            <td class="<?php echo $status; ?>">
              <?php echo $row['quantity'];?>
            </td>
            <td>
              <?php echo $row['hsn'];?>
            </td>
            <td>
              <?php echo $row['price'];?>
            </td>
            <td>
              <a href="edit_stock.php?edit=<?php echo $row['id'] ?>"><div class="btn btn-warning"><i class="fa fa-pencil"></i></div></a>
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