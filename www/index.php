<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice DashBoard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
</head>
<style>
    body {
        width: 100%;
        height: auto;
        margin: 0 auto;
    }

    .title {
        text-align: center;
        margin-top: 3%;
        color: #E91E63;
        text-shadow: 0px 1px 1px black;
        font-size: 50px;

        font-family: 'Times New Roman', Times, serif;
    }

    a {
        color: white;
    }

    p {
        text-align: center;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        margin-bottom: 1%;
    }

    .fa {
        font-size: 170%;
    }

    #developer-foot-note {
        position: fixed;
        bottom: 0;
        margin-top: 10px;
        background-color: #17a2b8;
        color: white;
        text-align: center !important;
        width: 100%;
    }

    #developer-foot-note p {
        margin-bottom: 0;
    }
</style>

<body>
    <div class="container" style="margin-bottom: 20px;">
        <h1 class="title">KRISHNA SPEECH AND HEARING AID CENTRE</h1>
        <p>111-A/222, ASHOK NAGAR, KANPUR</p>
        <div class="text-center">
            <img src="img/567.png" title="hearing Ads" class="img-fluid">
        </div>
        <div class="row text-center align-center">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-2">
                <a href="invoice.php">
                    <button style="width: 100%; height: 200px;" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-ticket"></i>
                        <br>New
                        <br> Invoice</button>
                </a>
            </div>
            <div class="col-md-2">
                <a href="customer.php">
                    <button style="width: 100%; height: 95px; margin-bottom: 10px" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-user"></i>
                        <br>Customer</button>
                </a>
                <a href="stock.php">
                    <button style="width: 100%; height: 95px; " type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-shopping-cart"></i>
                        <br>Stock</button>
                </a>
            </div>
            <div class="col-md-2">
                <a href="product.php">
                    <button style="width: 100%; height: 95px; margin-bottom: 10px" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-gift"></i>
                        <br>Product</button>
                </a>
                <a href="sell.php">
                    <button style="width: 100%; height: 95px; margin-bottom: 10px" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-bar-chart-o"></i>
                        <br>Sell Report</button>
                </a>
            </div>
            <div class="col-md-2">
                <a href="purchase.php">
                    <button style="width: 100%; height: 95px; margin-bottom: 10px" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-credit-card"></i>
                        <br>Purchase</button>
                </a>
                <a href="purchase_list.php">
                    <button style="width: 100%; height: 95px; margin-bottom: 10px" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-paperclip"></i>
                        <br>
                        <span style="font-size: 15px; line-height: 10px;">Purchase Report</span>
                    </button>
                </a>
            </div>
            <div class="col-md-2">
                <a href="backup_restore.php">
                    <button style="width: 100%; height: 95px; margin-bottom: 10px" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-save"></i>
                        <br>
                        <span style="font-size: 15px; line-height: 10px;">Backup/Restore</span>
                    </button>
                </a>
                <a href="support.php">
                    <button style="width: 100%; height: 95px;" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-question"></i>
                        <br>Support</button>
                </a>
            </div>
            <div class="col-md-2">
                <a href="profit_loss.php">
                    <button style="width: 100%; height: 200px;" type="button" class="btn btn-info btn-lg">
                        <i class="fa fa-book"></i>
                        <br> Report</button>
                </a>
            </div>
        </div>
    </div>
    <div class="text-center" id="developer-foot-note">
        <p>Design And Developed By: <a href="http://experttechs.in"> Expert Technologies</a></p> 
    </div>
</body>

</html>