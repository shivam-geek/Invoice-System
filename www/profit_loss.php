<?php require 'include/orm.php' ?>
<?php include 'include/header.php' ?>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>Profit-Loss Finder</h2>
      <hr>
    </div>

    <style>
  a .btn {
    font-size: 34px !important;
  }
</style>

    <div style="margin-top: 5%"></div>
    <div class="row text-center align-center">
      <div class="col-md-1"></div>
      <div class="col-md-3">
        <a href="results.php?filter=today">
          <button style="width: 100%; height: 200px;" type="button" class="btn btn-primary btn-lg">
            <i class="fa fa-tags"></i>
            <br>Today</button>
        </a>
      </div>
      <div class="col-md-4">
        <a href="results.php?filter=month">
          <button style="width: 100%; height: 200px;" type="button" class="btn btn-primary btn-lg">
            <i class="fa fa-tasks"></i>
            <br>This Month</button>
        </a>
      </div>
      <div class="col-md-3">
        <a href="results.php?filter=year">
          <button style="width: 100%; height: 200px;" type="button" class="btn btn-primary btn-block btn-lg">
            <i class="fa fa-sitemap"></i>
            <br>This Year</button>
        </a>
      </div>
      </div>
      <div style="margin-top: 5%"></div>
      <hr>
      <div style="margin-top: 5%"></div>

    <div class="row">
    <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="row">
              <form method="post" action="results.php">
                  <div class="col-md-5 form-group">
                      <label for="exampleInputName2">Start Date</label>
                      <input type="text" class="form-control" name="start_date" id="date-start" placeholder="Start Date">
                  </div>
                  <div class="col-md-5 form-group">
                      <label for="exampleInputEmail2">End Date</label>
                      <input type="text" class="form-control" name="end_date" id="date-end" placeholder="End Date">
                  </div>
                  <div class="col-md-2 form-group">
                      <label for="exampleInputEmail2">Find</label><br>
                      <button type="submit" name="submit" class=" form-group btn btn-primary btn-block">Search</button>
                  </div>
              </form>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- /#page-content-wrapper -->
<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });
$('#date-start').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'dd/mm/yyyy'
});
$('#date-end').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'dd/mm/yyyy'
});
</script>

<?php include 'include/footer.php' ?>