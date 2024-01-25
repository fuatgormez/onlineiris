(function ($) {
  "use strict";

  //url formatla https://fg.de/
  var base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  // $("#order_number").focus(function () {
  //   $("#customer_email").val("");
  //   $("#post_code").val("");
  // });
  // $(document).on("focus", "#customer_email", "#post_code", function () {
  //   $("#order_number").val("");
  // });

  // $('input[name="payment_method"]:checked').val();

  $(document).on("click", 'input[name="payment_method"]', function () {
    $(".selected_payment_method").html($(this).val());
  });

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

  $(document).on("change", ".select_box_product", function () {
    let productID = $(this).val();
    console.log(productID);

    $.ajax({
      type: "GET",
      url: base_url + "api/product/get_single/" + productID,
      dataType: "json",
      success(res) {
        if (res.status === 200) {
          $("#select_box_product" + res.category_id).html(res.price);
          return;
        }
      },
    });
  });

  $(document).on("click", ".confirm_order_button", function () {
    var order_number = $("#order_number").text();
    var comment = $("#commentMessage").val();
    var confirm_order = $("[name=confirm_order]:checked").val();

    if (confirm_order == 0) {
      if (comment.length <= 0) {
        alert("Bitte schreibe Deine Feedback!");
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
          alert("No Records Found!");
          return;
        }

        if (res.data.freigabe_date != null && res.data.freigabe_date != "") {
          alert("No Records Found!");
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
      alert("Please enter a valid telephone number!");
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
          window.location.href = base_url + "shop/cart";
        }
      },
      error: function (xhr, status, res) {
        // window.location.reload();
      },
    }); //end ajax

    return false;
  });

  // PWA Modal
  var handlePWAModal = function () {
    if (!window.matchMedia("(display-mode: standalone)").matches) {
      setTimeout(function () {
        jQuery("#offcanvasBottom3").addClass("show");
        jQuery(".pwa-offcanvas").addClass("show");
        jQuery(".pwa-backdrop").addClass("fade show");
      }, 2000);
      jQuery(".pwa-backdrop, .pwa-close, .pwa-btn").on("click", function () {
        jQuery(".pwa-offcanvas").slideUp(500, function () {
          jQuery(this).removeClass("show");
        });
        setTimeout(function () {
          jQuery(".pwa-backdrop").removeClass("show");
        }, 500);
      });
    }
  };

  /* Add item */
  $(document).on("click", ".add-to-basket-button", function (e) {
    e.preventDefault();

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");
    let form_name = button.parents("form").attr("name");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
        $("#cartModal").modal("show");
        $("#offcanvasAlert").addClass("show");
      },
      success: function (res) {
        let res_data = JSON.parse(JSON.stringify(res));

        if (res_data.statusCode == 200) {
          $(".cart_list_contents").html("");
          var li = "";
          // console.log(res.cart_contents);
          $.each(res.cart_contents, function (i, item) {
            li +=
              `<li>
                  <div class="item-content">
                      <div class="item-media media media-60">
                          <img src="` +
              base_url +
              `/public/uploads/product_photos/thumbnail/` +
              item.image +
              `">
                      </div>
                      <div class="item-inner">
                          <div class="item-title-row">
                              <h6 class="item-title"><a href="` +
              base_url +
              `mobile/shop/product-detail/` +
              item.id +
              `">` +
              item.name +
              `</a></h6>
                          </div>
                          <div class="item-footer">
                              <div class="d-flex align-items-center">
                                  <h6 class="me-3">€ ` +
              item.price +
              `</h6>
                              </div>
                              <div class="d-flex align-items-center">
                                  <div class="dz-stepper border-1 ">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                      <span class="input-group-btn input-group-prepend">
                                        <button class="subtruct_itm_qty btn btn-primary bootstrap-touchspin-down" type="button" data-action="0" data-product-id="` +
              item.id +
              `" data-rowid="` +
              item.rowid +
              `">-</button>
                                      </span>
                                      <input class="stepper qty form-control" type="text" name="quantity" value="` +
              item.qty +
              `">
                                      <span class="input-group-btn input-group-append">
                                        <button class="add_itm_qty btn btn-primary bootstrap-touchspin-up" type="button" data-action="1" data-product-id="` +
              item.id +
              `" data-rowid="` +
              item.rowid +
              `">+</button>
                                      </span>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </li>`;
          });
          $(".cart_list_contents").empty().append(li);

          $(".total_items").html(res_data.cart_item_amounts);
        }
        if (res_data.statusCode == 404) {
          alert("Product not found");
        }

        // window.location.href = base_url + '/shop/cart';
      },
      complete: function () {
        // $("#offcanvasAlert").removeClass("show").delay(3000);
        window.setTimeout(function () {
          $("#offcanvasAlert").removeClass("show");
        }, 1000);
      },
      error: function (xhr, status, res) {
        alert("error");
        // window.location.reload();
      },
    }); //end ajax

    return false;
  });

  /** Notfiy Cart */
  $(document).on("click", ".notify-cart", function (e) {
    e.preventDefault();

    $.ajax({
      type: "GET",
      url: base_url + "mobile/cart/cart_contents",
      dataType: "json",
      beforeSend: function (xhr, settings) {
        // $("#preloader").fadeIn(100);
        $("#cartModal").modal("hide");
      },
      success: function (res) {
        let res_data = JSON.parse(JSON.stringify(res));

        if (res_data.statusCode == 200) {
          $(".cart_list_contents").html("");
          var li = "";
          console.log(res.cart_contents);
          $.each(res.cart_contents, function (i, item) {
            li +=
              `<li>
                  <div class="item-content">
                      <div class="item-media media media-60">
                          <img src="` +
              base_url +
              `/public/uploads/product_photos/thumbnail/` +
              item.image +
              `">
                      </div>
                      <div class="item-inner">
                          <div class="item-title-row">
                              <h6 class="item-title"><a href="` +
              base_url +
              `mobile/shop/product-detail/` +
              item.id +
              `">` +
              item.name +
              `</a></h6>
                          </div>
                          <div class="item-footer">
                              <div class="d-flex align-items-center">
                                  <h6 class="me-3">€ ` +
              item.price +
              `</h6>
                              </div>
                              <div class="d-flex align-items-center">
                                  <div class="dz-stepper border-1 ">
                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                      <span class="input-group-btn input-group-prepend">
                                        <button class="subtruct_itm_qty btn btn-primary bootstrap-touchspin-down" type="button" data-action="0" data-product-id="` +
              item.id +
              `" data-rowid="` +
              item.rowid +
              `">-</button>
                                      </span>
                                      <input class="stepper form-control" id="` +
              item.rowid +
              `" type="text" name="quantity" value="` +
              item.qty +
              `">
                                      <span class="input-group-btn input-group-append">
                                        <button class="add_itm_qty btn btn-primary bootstrap-touchspin-up" type="button" data-action="1" data-product-id="` +
              item.id +
              `" data-rowid="` +
              item.rowid +
              `">+</button>
                                      </span>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </li>`;
          });
          $(".cart_list_contents").empty().append(li);
          $("#cart_total").html("€ " + res_data.cart_total);
        }
        if (res_data.statusCode == 404) {
          alert("Product not found");
        }

        // window.location.href = base_url + '/shop/cart';
      },
      complete: function () {
        $("#preloader").fadeOut(100);
      },
      error: function (xhr, status, res) {
        alert("error");
        // window.location.reload();
      },
    }); //end ajax

    return false;
  });

  /* Change item quantity - ADD & SUBTRUCT */
  $(document).on("click", ".add_itm_qty, .subtruct_itm_qty", function (e) {
    e.preventDefault();

    let form_name = "updateCart";
    let rowid = $(this).data("rowid");
    let product_id = $(this).data("product-id");
    // let csrf_fg = $("input[name=csrf_fg]").val();
    let action = $(this).data("action");
    let qty = $("#" + rowid).val();

    if (action === 1) {
      qty = ++qty;
    }
    if (action === 0) {
      qty = --qty;
    }

    if (qty < 1) {
      qty = 0;
      let button = $(e.target);
      button.parents("li").remove();
    }

    $("#" + rowid).val(qty);

    $.ajax({
      type: "POST",
      url: base_url + "mobile/cart/update",
      data: { product_id, rowid, qty, form_name, action },
      dataType: "json",

      success: function (res) {
        // var res_data = JSON.parse(JSON.stringify(res));
        console.log("Success " + res);

        if (res.statusCode == 200) {
          $("#cart_total").html("€ " + res.cart_total);
          $(".total_items").html(res.cart_item_amounts);
        }
      },
      complete: function (res) {
        console.log("Complete " + res);
      },
      error: function (xhr, status, res) {
        alert("error");
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
          alert(res.responseMessage);
          console.log("100");
          return false;
        } else if (res.statusCode == 101) {
          alert(res.responseMessage);
          console.log("101");
          return false;
        } else if (res.statusCode == 102) {
          alert(res.responseMessage);
          console.log("102");
          return false;
        } else if (res.statusCode == 200) {
          $("#cart_subtotal").html(res.cart_subtotal);
          $("#cart_total").html(res.cart_total);
          $("#cart_proportion").html(res.cart_proportion);
          $("#cart_coupon").html(res.cart_coupon);
          $("#cart_discount").html(res.cart_discount);
          $("#shipping_total").html(res.shipping_total);

          alert(res.responseMessage);
          console.log("200 Success");
          return false;
        } else {
          alert(res.responseMessage);
          console.log("404");
          return false;
        }
      },
      complete: function (res, status) {},
      error: function (x, y, z) {},
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
          $(".total_items").html(res_data.cart_item_amounts);
          $(".totalprice-" + res_data.product.rowid).html(
            res_data.product.product_total
          );

          alert(res_data.responseMessage);
        }
      },
      error: function (xhr, status, res) {
        alert("error");
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

      $(".product_link" + category_id).attr("href", base_url + url);
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
