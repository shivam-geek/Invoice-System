
//
// ────────────────────────────────────────────────────────────────────────────────────── I ──────────
//   :::::: I N V O I C E   G E N E R A T E   M O D U L E : :  :   :    :     :        :          :
// ────────────────────────────────────────────────────────────────────────────────────────────────
//

// Globals

var counter = 1;

var amount1 = 0;
var amount2 = 0;
var amount3 = 0;

var q1 = 0;
var q2 = 0;
var q3 = 0;

var t_quantity1 =0;
var t_quantity2 =0;
var t_quantity3 =0;






 //
 // ─── SAVING AND VALIDATING FORM INFORMATION ─────────────────────────────────────────
 //

function billGenerate() {
    // Customer Information
    name = $("input#cust_name").val();
    gst = $("input#gst").val();
    email = $("input#email").val();
    mobile = $("input#mobile").val();
    address = $("textarea#address").val();
    date = $("input#date").val();
    discount = $("input#discount").val();
    o_amount = $("input#otherChargesAmount").val();
    amountPaid = $("input#amountPaid").val();

    if(typeof discount === 'undefined' || !discount) {
      discount = 0;
    }
    if(typeof o_amount === 'undefined' || !o_amount) {
      o_amount = 0;
    }
    if(typeof amountPaid === 'undefined' || !amountPaid) {
      amountPaid = 0;
    }
    total = getTotal();
    grandTotal = total + parseInt(o_amount) - parseInt(discount);
    if(q1 > t_quantity1 || q2 > t_quantity2 || q3 > t_quantity3) {
      error = "Product quantity can not be Higher than Stock Quantity";
      dangerAlert(error);
      return false;
    } else if(parseInt(discount) > total * 0.7) {
      error = "Discount Can Not Be So higher for this Amount";
      dangerAlert(error);
      return false;
    } else if(parseInt(amountPaid) > grandTotal) {
      error = "Paid Amount cannot be higher than Net Amount";
      dangerAlert(error);
      return false;
    } else {
      success = "Generating Bill";
      successAlert(success);
      return true;
    }
}

function dangerAlert(message) {
  $("#alert").addClass("alert-danger");
  $("#alert > strong").html(message);
  $(window).scrollTop(0);
}
function successAlert(message) {
  $("#alert").addClass("alert-success");
  $("#alert > strong").html(message);
  $(window).scrollTop(0);
}
function warningAlert(message) {
  $("#alert").addClass("alert-warning");
  $("#alert > strong").html(message);
  $(window).scrollTop(0);
}

// ────────────────────────────────────────────────────────────────────────────────


 function getPrice() {
    product_id = $("#productName").val();
    if(product_id == 0) {
      $("#productAmount").val(0);
    } else {
      $.ajax({
        type: "POST",
        url: 'ajaxhandler.php',
        dataType: 'json',
        data: {"product": product_id},
        success: function(data){
          $("#productAmount").val(data['price']);
          if(data['quantity'] < 1 ) {
            msg = "out of stock";
            c = "text-danger";
          } else if(data['quantity'] < 3) {
            msg = "only" + data['quantity'] + " product are available in stock.";
            c = "text-warning";
          } else {
            msg = "looks good," + data['quantity'] + " products are available in stock";
            c = "text-success";
          }
          $("#q-status").addClass(c);
          $("#q-status").html(msg);
          amount1 = data['price'];
          t_quantity1 = data['quantity'];
        }
      });
    }
 }
 function getPrice2() {
    product_id = $("#productName2").val();
    if(product_id == 0) {
      $("#productAmount2").removeAttr('value');
    } else {
      $.ajax({
        type: "POST",
        url: 'ajaxhandler.php',
        dataType: 'json',
        data: {"product": product_id},
        success: function(data){
          $("#productAmount2").val(data['price']);
          if(data['quantity'] < 1 ) {
            msg = "out of stock";
            c = "text-danger";
          } else if(data['quantity'] < 3) {
            msg = "only" + data['quantity'] + " product are available in stock.";
            c = "text-warning";
          } else {
            msg = "looks good," + data['quantity'] + " products are available in stock";
            c = "text-success";
          }
          $("#q-status2").addClass(c);
          $("#q-status2").html(msg);
          amount2 = data['price'];
          t_quantity2 = data['quantity'];
        }
      });
    }
 }
 function getPrice3() {
    product_id = $("#productName3").val();
    if(product_id == 0) {
      $("#productAmount3").removeAttr('value');
    } else {
      $.ajax({
        type: "POST",
        url: 'ajaxhandler.php',
        dataType: 'json',
        data: {"product": product_id},
        success: function(data){
          $("#productAmount3").val(data['price']);
          if(data['quantity'] < 1 ) {
            msg = "out of stock";
            c = "text-danger";
          } else if(data['quantity'] < 3) {
            msg = "only" + data['quantity'] + " product are available in stock.";
            c = "text-warning";
          } else {
            msg = "looks good," + data['quantity'] + " products are available in stock";
            c = "text-success";
          }
          $("#q-status3").addClass(c);
          $("#q-status3").html(msg);
          amount3 = data['price'];
          t_quantity3 = data['quantity'];
        }
      });
    }
 }

 function getTotal() {
   q1 = $("#quantity").val();
   q2 = $("#quantity2").val();
   q3 = $("#quantity3").val();
   if(typeof q1 === 'undefined' || !q1) {
     q1 = 0;
   }
   if(typeof q2 === 'undefined' || !q2) {
     q2 = 0;
   }
   if(typeof q3 === 'undefined' || !q3) {
     q3 = 0;
   }
   if(!(typeof amount1 === 'undefined' || amount1 == 0)) {
    amount1 = $("#productAmount").val();
    amount1 = parseInt(amount1);
  }
   q1 = parseInt(q1);
   q2 = parseInt(q2);
   q3 = parseInt(q3);
   totalAmount = (amount1 * q1) + (amount2 * q2) + (amount3 *q3);
   return totalAmount;
 }


 function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode
  if ((charCode > 31 && (charCode < 48 || charCode > 57)) || charCode > 189)
      return false;
  return true;
}






//
// ─── ADDING PRODUCT SECTION ─────────────────────────────────────────────────────
//

function addProduct() {
    if(counter < 3) {
      counter++;
      var product = $(".product").last();
      $.ajax({
        type: "POST",
        url: 'ajaxhandler.php',
        dataType: 'json',
        data: {"data":"check"},
        success: function(data){
        var productData1 = '<div style="margin-bottom:10px"></div><div class="row product"> <div class="col-md-1"> <input type="text" class="form-control" id="srno" required="" value="'+ counter +'" disabled> </div><div class="col-md-5"> <select class="form-control" name="productName[]" id="productName'+counter+'" name="" onchange="getPrice'+counter+'()"> <option value="0" selected>Select Product Name</option>';
        var arrayData = [];
        for (i=0; i < data.length; i++) {
          arrayData.push('<option value="' + data[i]['id'] + '">'+ data[i]['name'] +'</option>');
        }
        productData2 = '</select><small id="q-status'+ counter +'" class="form-text "></small> </div><div class="col-md-2"><input type="text" class="form-control" id="serial" name="serial[]" value=""></div><div class="col-md-1"> <input type="text" class="form-control" id="quantity'+counter+'" name="quantity[]" required="" maxlength="1" onkeypress="return isNumberKey(event)" value=""> </div><div class="col-md-2"> <input type="text" class="form-control amount" id="productAmount'+counter+'" required="" value="" disabled> </div><div class="col-md-1"> <input type="button" class="form-control btn btn-primary" style="font-weight:900;" id="close" onclick="remove'+counter+'()" value="X"> </div></div>';
        product.after( productData1 + arrayData.toString() + productData2 );
        }
     });
    } else {
      alert('Max Product Limit is 3 only');
    }
  }
function addProduct1() {
    if(counter < 3) {
      counter++;
      var product = $(".product").last();
      $.ajax({
        type: "POST",
        url: 'ajaxhandler.php',
        dataType: 'json',
        data: {"data":"check"},
        success: function(data){
        var productData1 = '<div style="margin-bottom:10px"></div><div class="row product"> <div class="col-md-1"> <input type="text" class="form-control" id="srno" required="" value="'+ counter +'" disabled> </div><div class="col-md-7"> <select class="form-control" name="productName[]" id="productName'+counter+'" name="" onchange="getPrice'+counter+'()"> <option value="0" selected>Select Product Name</option>';
        var arrayData = [];
        for (i=0; i < data.length; i++) {
          arrayData.push('<option value="' + data[i]['id'] + '">'+ data[i]['name'] +'</option>');
        }
        productData2 = '</select><small id="q-status'+ counter +'" class="form-text "></small> </div><div class="col-md-1"> <input type="text" class="form-control" id="quantity'+counter+'" name="quantity[]" required="" maxlength="1" onkeypress="return isNumberKey(event)" value=""> </div><div class="col-md-2"> <input type="text" class="form-control amount" id="purchase_amount'+counter+'" name="purchase_amount[]" required="" value="" > </div><div class="col-md-1"> <input type="button" class="form-control btn btn-primary" style="font-weight:900;" id="close" onclick="remove'+counter+'()" value="X"> </div></div>';
        product.after( productData1 + arrayData.toString() + productData2 );
        }
     });
    } else {
      alert('Max Product Limit is 3 only');
    }
  }


  function remove2() {
    var removeSection = $("#productName2").parents(".product");
    removeSection.remove();
    counter--;
    q2 = 0;
  }



  function remove3() {
    var removeSection = $("#productName3").parents(".product");
    removeSection.remove();
    counter--;
    q3 = 0;
  }

  // ────────────────────────────────────────────────────────────────────────────────
