<?php
include 'include/orm.php';

if(isset($_POST['data']) && $_POST['data'] == 'check'){

    $data = ORM::for_table('product')->find_array();
    $response = json_encode($data);
    echo $response;
 }

if(isset($_POST['product'])) {
    $product = ORM::for_table('product')->where("id",$_POST['product'])->find_one();
    $price = $product->price;
    $quantity = $product->quantity;
    $data = json_encode(array("price"=>$price, "quantity"=>$quantity));
    echo $data;
}




?>