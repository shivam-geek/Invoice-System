<?php include 'include/header.php' ?>

<?php

if(isset($_POST['upload'])) {

  $imgFile = $_FILES['db']['name'];
  $tmp_dir = $_FILES['db']['tmp_name'];
  $imgSize = $_FILES['db']['size'];

  if(empty($imgFile)){
    $error = "Please Select Image File.";
  } else {
    $upload_dir = 'temp/'; // upload directory

    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('db'); // valid extensions

    // rename uploading image
    $userPic = "invoice.db";

    // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){
      // Check file size '5MB'
      if($imgSize < 5632000)				{
        move_uploaded_file($tmp_dir,$upload_dir.$userPic);
        $file = 'temp/invoice.db';
        $newFile = 'include/invoice.db';
        if (!copy($file, $newFile)) {
          $error = "failed to restore";
        }else{
          unlink("temp/invoice.db");
          $success = "Restored Successfully";
        }
      }
      else {
        $error = "Sorry, your file is too large.";
      }
    }
    else{
      $error = "Sorry, only db file is allowed.";
    }
  }
}

?>

<style>
  a .btn {
    font-size: 34px !important;
  }
</style>

<!-- Page Content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="text-center text-primary">
      <h2>BACKUP / RESTORE</h2>
    </div>
    <?php if(isset($error)) {
        echo '<div class="alert alert-danger" role="alert">
          <strong>'.$error.'</strong>}
          </div>';
      } else if(isset($success)) {
        echo '<div class="alert alert-success" role="alert">
          <strong>'.$success.'</strong>
          </div>';
      }
      ?>
    <div style="margin-top: 10%"></div>
    <div class="row text-center align-center">
      <div class="col-md-1"></div>
      <div class="col-md-3">
        <a href="include/invoice.db">
          <button style="width: 100%; height: 200px;" type="button" class="btn btn-primary btn-lg">
            <i class="fa fa-download"></i>
            <br>Backup</button>
        </a>
      </div>
      <div class="col-md-4">
        <a data-toggle="modal" data-target="#restore">
          <button style="width: 100%; height: 200px;" type="button" class="btn btn-primary btn-lg">
            <i class="fa fa-refresh"></i>
            <br>Restore</button>
        </a>
      </div>
      <div class="col-md-3">
        <a data-toggle="modal" data-target="#reset">
          <button style="width: 100%; height: 200px;" type="button" class="btn btn-primary btn-lg">
            <i class="fa fa-retweet"></i>
            <br>Reset</button>
        </a>
      </div>
      <!-- Modal -->
      <div class="modal" id="restore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Upload Backup File</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                  <input type="file" class="form-control-file" name="db" id="exampleFormControlFile1">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="upload">Upload</button>
            </div>
          </form>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal" id="reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Reset to Default</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="reset.php" onSubmit="return resetDb()">
            <div class="modal-body">
                <h2><span class="badge badge-primary">Note</span></h2>
            <p class="text-primary"> All the data and configuration will be deleted &amp; system will be reset to initial state.</p>
                <div class="form-group">
                  <label for="reset-input"> Please Enter "RESET" to proceed further.</label>
                  <input type="text" class="form-control" id="reset-input">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Reset</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function resetDb() {
    resetInput = $("#reset-input").val();
    if(resetInput === "RESET") {
      return true;
    } else {
     $("#reset-tip").remove();
    $("#reset-input").before('<p class="text-danger" id="reset-tip">Please Type in Correct Format as shown above.</p>');
    return false;
    }
  }
</script>
<!-- /#page-content-wrapper -->

<?php include 'include/footer.php' ?>