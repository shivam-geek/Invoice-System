<?php

include 'include/orm.php';

if (isset($_GET['edit'])) {
    $product = ORM::for_table('product')->where("id", $_GET['edit'])->find_one();
} else {
    header("refresh:0.5;stock.php");
}
if(isset($_POST['submit'])) {
    $product->name = $_POST['p_name'];
    $product->des = $_POST['p_des'];
    $product->price = $_POST['p_price'];
    $product->hsn = $_POST['p_hsn'];
    $product->quantity = $_POST['p_quantity'];
    $product->save();
    $success = "Product Added Successfully";
    header("refresh:0.3;stock.php");
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
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" required name="p_name" id="p_name" value="<?php echo $product->name; ?>">
                                    <div class="row">
                                    <div class="col-md-6">
                                            <label for="price">HSN Code</label>
                                            <input type="text" class="form-control" placeholder="Enter HSN Code" name="p_hsn" value="<?php echo $product->hsn; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price">Price</label>
                                            <input type="number" min="0" step="1" class="form-control" placeholder="Enter Product Price" name="p_price" value="<?php echo $product->price; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price">Quantity</label>
                                            <input type="number" min="0" step="1" class="form-control" placeholder="Enter Product Price" name="p_quantity" max="100" value="<?php echo $product->quantity; ?>">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Product Description</label>
                                        <textarea class="form-control" id="p_des" rows="4" name="p_des"><?php echo $product->des; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:10px;"></div>
                        <button class="btn btn-outline-primary btn-lg btn-block" style="margin-bottom: 30px;" name="submit" type="submit">Update Product</button>
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