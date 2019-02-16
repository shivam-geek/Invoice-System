<?php
 include 'include/orm.php';


if(isset($_POST['submit'])) {
  //product Information
  $p_name = $_POST['p_name'];
  $p_des = $_POST['p_des'];
  $p_price = $_POST['p_price'];
  $p_hsn = $_POST['p_hsn'];

  if(!isset($error)) {

    $product = ORM::for_table('product')->create();

    $product->name = $p_name;
    $product->des = $p_des;
    $product->price = $p_price;
    $product->quantity = 0;
    $product->hsn = $p_hsn;
    $product->save();
    $success = "Product Added Successfully";
  }
}
?>

    <?php include 'include/header.php' ?>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="text-center text-primary">
                <h2>PRODUCT</h2>
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
            <div class="row">
                <div class="col-md-12 order-md-1">
                    <h4 class="mb-3">Add Product</h4>
                    <form method="post" id="purchase">
                        <div class="product">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product_name">Add New Product</label>
                                    <input type="text" class="form-control" placeholder="Add New Product.." required name="p_name" id="p_name" value="">
                                    <div class="row">
                                    <div class="col-md-6">
                                            <label for="price">HSN Code</label>
                                            <input type="text" class="form-control" placeholder="Enter HSN Code" name="p_hsn" value="" maxlength="12">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="price">Price</label>
                                            <input type="text" class="form-control" placeholder="Enter Product Price" maxlength="6" onkeypress="return isNumberKey(event)" name="p_price" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Product Description</label>
                                        <textarea class="form-control" id="p_des" rows="4" name="p_des"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:10px;"></div>
                        <button class="btn btn-outline-primary btn-lg btn-block" style="margin-bottom: 30px;" name="submit" type="submit">Add Product</button>
                    </form>
                    <script>
                        $('#date').datepicker({
                            uiLibrary: 'bootstrap4'
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    <?php include 'include/footer.php' ?>