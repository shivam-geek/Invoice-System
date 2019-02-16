<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>CUSTOMER</h2>
    </div>
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Name</th>
          <th>Address</th>
          <th>GST</th>
          <th>Email</th>
          <th>Mobile</th>
        </tr>
      </thead>
      <tbody>
<?php
      $customer = ORM::for_table('customer')->find_array();
      foreach($customer as $row) {
?>
          <tr>
            <td>
              <?php echo $row['id'];?>
            </td>
            <td>
              <?php echo $row['name'];?>
            </td>
            <td>
              <?php echo $row['address'];?>
            </td>
            <td>
              <?php echo $row['gst'];?>
            </td>
            <td>
              <?php echo $row['email'];?>
            </td>
            <td>
              <?php echo $row['mobile'];?>
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