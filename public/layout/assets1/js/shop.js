(function ($) {
  "use strict";

  //url formatla https://irispicture/
  var base_url = window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  if (base_url === 'https://www.fuatgormez.tech/') {
      base_url = 'https://www.fuatgormez.tech/irispicture/';
  }

  $(document).keydown(function (event) {
    if ((event.ctrlKey || event.metaKey) && event.altKey && event.which == 83) {
      window.open(base_url + "shop/old_orders");
    }
  });

  // $("#order_number").focus(function () {
  //   $("#customer_email").val("");
  //   $("#post_code").val("");
  // });
  // $(document).on("focus", "#customer_email", "#post_code", function () {
  //   $("#order_number").val("");
  // });

  $(document).on("click", ".mollie-payment-method", function () {
    var method = $(this).data("method");

    $(".mollie-payment-method").removeAttr("style");
    $(".__mollie_select_payment_method").removeAttr("checked");

    $(".mollie-payment-method").find().removeAttr("checked");
    $(this).attr("style", "zoom: 1; filter: alpha(opacity=50);opacity: 0.2;");
    $(".voo-text").attr("style", "display:none");
    $("#__" + method).prop("checked", true);
    // $("#__"+method).attr("checked", "checked");
  });

  $(document).on("click", ".voo", function () {
    $(".voo-text").removeAttr("style");
    $(".__mollie_select_payment_method").removeAttr("checked");
    $("#bankTransfer").prop("checked", true);
    // $("#bankTransfer").attr("checked", "checked");
  });

  $(document).on("click", ".confirm_order_button", function () {
    var order_number = $("#order_number").text();
    var comment = $("#commentMessage").val();
    var confirm_order = $("[name=confirm_order]:checked").val();

    if (confirm_order == 0) {
      if (comment.length <= 0) {
        Swal.fire({
          position: "center",
          icon: "warning",
          text: "Bitte schreibe Deine Feedback!",
          showConfirmButton: true,
          timer: 2000,
        });
        return;
      }
    }

    $.ajax({
      type: "POST",
      url: base_url + "shop/order/confirm",
      data: { order_number, comment, confirm_order },
      dataType: "json",
      success(res) {
        if (res.status === "success") {
          $("#confirm_order_modal").modal("show");
          setTimeout(function () {
            window.location = base_url + "shop";
          }, 5000);
          return;
        }

        // if (res.data == null) {
        //   Swal.fire({
        //     position: "center",
        //     icon: "warning",
        //     text: "No Records Found!",
        //     showConfirmButton: true,
        //     timer: 2000,
        //   });
        //   return;
        // }
      },
    });
  });

  $(document).on("click", ".customer_confirm_process", function () {
    let order_number = $("#order_number").val();

    $.ajax({
      type: "POST",
      url: base_url + "shop/order/check",
      data: { order_number },
      dataType: "json",
      success(res) {
        if (res.data == null) {
          Swal.fire({
            position: "center",
            icon: "warning",
            text: "No Records Found!",
            showConfirmButton: true,
            timer: 2000,
          });

          return;
        }

        if (res.data.freigabe_date != null && res.data.freigabe_date != "") {
          Swal.fire({
            position: "center",
            icon: "warning",
            text: "No Records Found!",
            showConfirmButton: true,
            timer: 2000,
          });
          return;
        }

        if (res.status == 200) {
          window.location.href =
            base_url + "shop/order/confirm/" + res.data.order_number;
        }
      },
    });
  });

  $(".billingPhone, .shippingPhone").keyup(function (e) {
    let number = $(this).val();
    if (/[^0-9\-\+]/.test(number)) {
      e.preventDefault();
      Swal.fire({
        position: "center",
        icon: "warning",
        text: "Please enter a valid telephone number!",
        showConfirmButton: false,
        timer: 1000,
      });
      $(this).val("");
    }
  });

  function checkoutTerms() {
    let checked = true;
    if ($("#checkoutTerms1").is(":checked")) {
      $(".checkoutTerms1").removeAttr("style");
    } else {
      $(".checkoutTerms1").attr("style", "color:#ff0000");
      checked = false;
    }
    if ($("#checkoutTerms2").is(":checked")) {
      $(".checkoutTerms2").removeAttr("style");
    } else {
      $(".checkoutTerms2").attr("style", "color:#ff0000");
      checked = false;
    }
    return checked;
  }

  $(".checkout-submit-check").on({
    mouseenter: function () {
      checkoutTerms();
    },
    mouseleave: function () {
      checkoutTerms();
    },
  });

  $(document).on("click", ".checkout-submit-check", function (e) {
    e.preventDefault();
    if (checkoutTerms()) {
      $("#checkout-submit").submit();
    }
  });

  $("#checkoutTerms1", "#checkoutTerms2").on("click", function () {
    checkoutTerms();
  });

  $(document).on("click", ".updatable_product", function () {
    var product_id = $(this).data("product-id");
    var product_name = $(this).data("product-name");
    var product_price = $(this).data("product-price");

    $.ajax({
      type: "POST",
      url:
        base_url + "shop/order/get_updatable_product/" + product_id + "/16/de",
      //url: base_url + "api/shop/updatable_product/" + product_id + "/16",
      data: { product_id },
      dataType: "json",
      success(res) {
        console.log(res);
        $("#current_item").html(product_name);
        $("#update_product").modal("show");

        var liHTML = "";
        $.each(res, function (i, item) {
          console.log(item);
          liHTML +=
            `
          <form action="` +
            base_url +
            `shop/cart/add" class="form-horizontal" name="basket" method="post" accept-charset="utf-8" data-info="update" data-current-item="` +
            product_id +
            `">
            <li class="vs-comment">
            <div class="vs-post-comment">
                <div class="author-img">
                    <img src="` +
            base_url +
            `public/uploads/product_photos/thumbnail/` +
            item.thumbnail +
            `">
                </div>
                <div class="comment-content">
                    <div class="comment-top">
                        <div class="comment-author">
                            <h5 class="name"> ` +
            item.product_name +
            `  ` +
            (item.product_price - product_price).toFixed(2) +
            ` €</h5>
                        </div>
                        <div class="reply_and_edit">
                          <input type="hidden" name="product_id" value="` +
            item.id +
            `">
                            <button class="btn btn-block btn-primary style4 add-to-basket-button-upgrade">in den Warenkorb</button>
                        </div>
                    </div>
                </div>
            </div>
          </li>
        </form>`;
        });

        $(".res_items").empty().append(liHTML);
      },
    });
  });

  /* Add item for Extra Update */
  $(document).on("click", ".add-to-basket-button-upgrade", function (e) {
    e.preventDefault();

    var button = $(e.target);
    var form_data = button.parents("form").serialize();
    var form_url = button.parents("form").attr("action");
    var form_name = button.parents("form").attr("name");
    var info = button.parents("form").data("info");
    var item_id_old = button.parents("form").data("current-item");
    var order_number = $("#order_number").text();

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data +=
          "&" +
          form_name +
          "=" +
          form_name +
          "&" +
          "info" +
          "=" +
          info +
          "&" +
          "item_id_old" +
          "=" +
          item_id_old +
          "&" +
          "order_number" +
          "=" +
          order_number;
      },
      success: function (res) {
        let res_data = JSON.parse(JSON.stringify(res));
        console.log(res_data);

        // let new_csrf_code = res_data.csrf_fg;
        // $('input[name="csrf_fg"]').val(new_csrf_code);

        if (res_data.statusCode == 200) {
          $("#cart_item_amounts").html(res_data.cart_item_amounts);
          // sweetalert("success", res.responseMessage, 1500, 1);
          window.location.href = base_url + "shop/cart";
        }
      },
      error: function (xhr, status, res) {
        // sweetalert("error", "error", 500, 0);
        // window.location.reload();
      },
    }); //end ajax

    return false;
  });

  /* Add item */
  $(document).on("click", ".add-to-basket-button", function (e) {
    e.preventDefault();

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");
    let form_name = button.parents("form").attr("name");
    let param = button.parents("form").data("param");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
      },
      success: function (res) {
        let res_data = JSON.parse(JSON.stringify(res));

        if (res_data.statusCode == 200) {

          if(param === 'new_year_action'){
            window.location.href = base_url + '/shop/checkout/data';
          }

          $("#responseMessage").html(res_data.responseMessage);
          $("#cart_item_amounts").html(res_data.cart_item_amounts);
          $(".cartProductImage").html(
            '<img class="w-25" src="'+base_url+'public/uploads/product_photos/thumbnail/' +
            res_data.product.image +
            '">'
          );
          $(".cartProductName").html(res_data.product.name);
          $(".cartProductPrice").html(
            res_data.product.price + " " + res_data.product.currency_icon
          );
          $("#cart_details_modal").modal("show");
        }
        if (res_data.statusCode == 404) {
          sweetalert("error", "Product not found", 1500, 0);
        }

        // window.location.href = base_url + '/shop/cart';
      },
      error: function (xhr, status, res) {
        sweetalert("error", "error", 500, 0);
        // window.location.reload();
      },
    }); //end ajax

    return false;
  });

  /* Change item quantity - ADD & SUBTRUCT */
  $(document).on("click", ".add_itm_qty, .subtruct_itm_qty", function (e) {
    e.preventDefault();

    let qty = 0;

    let action = $(this).data("action");

    if (action === 1) {
      qty = $(this).prev().val();
      if (qty < 1) {
        return;
      }
    }
    if (action === 0) {
      qty = $(this).next().val();
      if (qty < 1) {
        return;
      }
    }

    let form_name = "updateCart";
    let rowid = $(this).data("rowid");
    let product_id = $(this).data("product-id");
    // let csrf_fg = $("input[name=csrf_fg]").val();

    $.ajax({
      type: "POST",
      url: base_url + "shop/cart/update",
      data: {
        product_id: product_id,
        rowid: rowid,
        qty: qty,
        form_name: form_name,
      },
      dataType: "json",

      success: function (res) {
        // var res_data = JSON.parse(JSON.stringify(res));
        console.log("Success " + res);

        if (res.statusCode == 200) {
          $("#cart_subtotal").html(res.cart_subtotal);
          $("#cart_total").html(res.cart_total);
          $("#cart_proportion").html(res.cart_proportion);
          $("#cart_coupon").html(res.cart_coupon);
          $("#cart_discount").html(res.cart_discount);
          $("#shipping_total").html(res.shipping_total);
          $("#cart_item_amounts").html(res.cart_item_amounts);
          $(".totalprice-" + res.product.rowid).html(res.product.product_total);

          sweetalert("success", res.responseMessage, 500, 1);
        }
      },
      complete: function (res) {
        // var res_data = JSON.parse(JSON.stringify(res));
        // debugger;
        // console.log("Complete "+res_data);
        // console.log("Complete "+JSON.stringify(res));
        // console.log("Complete "+JSON.stringify(res.responseText));
        console.log("Complete " + res);
      },
      error: function (xhr, status, res) {
        sweetalert("error", "error", 500, 0);
        // window.location.reload();
      },
    }); //end ajax
  });

  /* Check Coupon Code */
  $(document).on("click", ".coupon_button", function (e) {
    e.preventDefault();

    let coupon_code = $(".coupon").val();
    // let csrf_fg = $("input[name=csrf_fg]").val();
    // let statusCode = [100, 101, 102, 103, 104, 404];

    $.ajax({
      type: "POST",
      url: base_url + "shop/cart/coupon",
      data: { coupon_code },
      dataType: "json",
      success: function (res) {
        if (res.statusCode == 100) {
          sweetalert("warning", res.responseMessage, 1500, 1);
          console.log("100");
          return false;
        } else if (res.statusCode == 101) {
          sweetalert("warning", res.responseMessage, 1500, 1);
          console.log("101");
          return false;
        } else if (res.statusCode == 102) {
          sweetalert("warning", res.responseMessage, 1500, 1);
          console.log("102");
          return false;
        } else if (res.statusCode == 200) {
          $("#cart_subtotal").html(res.cart_subtotal);
          $("#cart_total").html(res.cart_total);
          $("#cart_proportion").html(res.cart_proportion);
          $("#cart_coupon").html(res.cart_coupon);
          $("#cart_discount").html(res.cart_discount);
          $("#shipping_total").html(res.shipping_total);

          sweetalert("success", res.responseMessage, 1500, 1);
          console.log("200 Success");
          return false;
        } else {
          sweetalert("error", res.responseMessage, 1500, 1);
          console.log("404");
          return false;
        }
      },
      complete: function (res, status) { },
      error: function (x, y, z) { },
    }); //end ajax
  });

  /* Remove item from cart */
  $(document).on("click", ".remove_item", function (e) {
    e.preventDefault();

    let rowid = $(this).data("rowid");

    let form_name = "removeItem";
    // let csrf_fg = $("input[name=csrf_fg]").val();

    $.ajax({
      type: "POST",
      url: base_url + "shop/cart/remove",
      data: { rowid: rowid, form_name: form_name },
      dataType: "json",

      success: function (res) {
        let res_data = JSON.parse(JSON.stringify(res));
        console.log(res_data);

        // let new_csrf_code = res_data.csrf_fg;
        // $('input[name="csrf_fg"]').val(new_csrf_code);

        if (res_data.statusCode == 200) {
          if (res_data.cart_item_amounts == 0) {
            window.location.reload();
            return;
          }

          $("#" + rowid).remove();

          $("#cart_subtotal").html(res_data.cart_subtotal);
          $("#cart_total").html(res_data.cart_total);
          $("#cart_proportion").html(res_data.cart_proportion);
          $("#cart_coupon").html(res_data.cart_coupon);
          $("#cart_discount").html(res_data.cart_discount);
          $("#shipping_total").html(res_data.shipping_total);
          $("#cart_item_amounts").html(res_data.cart_item_amounts);
          $(".totalprice-" + res_data.product.rowid).html(
            res_data.product.product_total
          );

          sweetalert("success", res_data.responseMessage, 500, 1);
        }
      },
      error: function (xhr, status, res) {
        sweetalert("error", "error", 1500, 0);
        // window.location.reload();
      },
    }); //end ajax
  });

  /* Change product price */
  $("select.select_product_price").change(function () {
    let thumbnail = $(this).find(":selected").data("product-thumbnail");
    let url = $(this).find(":selected").data("url");
    let product_name = $(this).find(":selected").data("product-name");
    let product_id = $(this).find(":selected").data("product-id");
    let category_id = $(this).find(":selected").data("product-category-id");
    let capacityValue = $(this).find(":selected").data("product-price-old");
    let counter = $(this).data("counter");


    if (capacityValue > 1) {
      $("#select_product_price" + counter).html(capacityValue);

      $(".product_link" + category_id).attr(
        "href",
        base_url + url
      );
      $(".product_tooltip" + category_id).attr(
        "data-bs-original-title",
        product_name
      );
    }

    // var big_str = '<div class="owl-item" id="new_append_item_big'+product_id+'" style="width: 403.5px; margin-right: 10px;"> \
    //                   <div> \
    //                       <img class="img-fluid thumbnail_new'+product_id+'" src="'+ base_url +'public/uploads/product_photos/thumbnail/'+ thumbnail +'" data-zoom-image="'+base_url +'public/uploads/product_photos/thumbnail/'+ thumbnail +'"> \
    //                       <div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;height:403.5px;width:403.5px;"> \
    //                           <div class="zoomWindowContainer" style="width: 400px;"> \
    //                               <div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: 0px -151.5px; width: 403.5px; height: 403.5px; float: left; cursor: grab; background-repeat: no-repeat; position: absolute; background-image: url(&quot;'+ base_url +'public/uploads/product_photos/thumbnail/'+ thumbnail +'&quot;); top: 0px; left: 0px; display: none;" class="zoomWindow">&nbsp;</div> \
    //                           </div> \
    //                       </div> \
    //                   </div> \
    //               </div>';

    // var small_str = '<div class="owl-item" id="new_append_item_small'+product_id+'" style="width: 77.75px; margin-right: 15px;"> \
    //                   <div class="cur-pointer"> \
    //                       <img class="img-fluid thumbnail_new'+product_id+'" src="'+base_url +'public/uploads/product_photos/thumbnail/'+ thumbnail +'"> \
    //                   </div> \
    //                 </div>';


    // $('#new_append_item_big'+product_id).remove();
    // $('#new_append_item_small'+product_id).remove();

    // $('#owl-stage-big'+category_id).append(big_str);
    // $('#owl-stage-small'+category_id).append(small_str);

    // var active = $("#owl-demo").find(".owl-item.active");
    // $('.owl-img-small').removeClass('selected');
    // $(".thumbnail" + category_id).parent().parent().addClass('selected');
    // $(".thumbnail" + category_id).attr("src",base_url + "public/uploads/product_photos/thumbnail/" + thumbnail);

    // console.log(capacityValue);
  });
})(jQuery);

function sweetalert(icon, title, time = 1500, bg) {
  let backdrop =
    bg === 1
      ? `rgba(0,80,170,0.4) left top no-repeat`
      : `rgba(244,67,54,0.4) left top no-repeat`;
  Swal.fire({
    position: "top-end",
    icon: icon,
    title: title,
    showConfirmButton: false,
    timer: time,
    backdrop: backdrop,
  });
}
