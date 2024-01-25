$(function () {
  "use strict";

  //url formatla http://irispicture/
  // const base_url = window.location.origin + "/" + window.location.pathname.split("/")[0] + "";
  var base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  if (base_url === "https://www.fuatgormez.tech/") {
    base_url = "https://www.fuatgormez.tech/irispicture/";
  }

  $(document).on("click", ".export_order_data_detail", function (e) {
    e.preventDefault();
    var order_number = $(this).data("order-number");

    $.ajax({
      type: "POST",
      url: base_url + "backend/shop/order/export_order_data_detail",
      data: { order_number },
      dataType: "json",

      beforeSend: function () {
        // $('.loader').removeAttr("style");
        $(".modal").modal("show");
      },

      success: function (res) {
        $(".export_order_data_list_detail").html("");
        var html = "";
        $.each(res, function (i, item) {
          if (item.item_name != null) {
            html +=
              "<tr> \
            <td>" +
              item.item_name +
              " (" +
              item.item_product_id +
              ")</td>\
            <td>" +
              item.item_price +
              "</td>\
            </tr>";
          }
        });
        $(".export_order_data_list_detail").append(html);
        // $('.loader').attr("style","display:none");
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax
  });

  $(document).on("click", ".export_order_data", function () {
    var status_id = $(".status_id").val();
    var store_id = $(".store_id").val();
    var item_id = $(".item_id").val();
    var order_start_date = $(".order_start_date").val();
    var order_end_date = $(".order_end_date").val();

    if (order_start_date == "") {
      return alert("Select Start date!");
    }
    if (order_end_date == "") {
      return alert("Select End date!");
    }

    // const formatYmd = date => date.toISOString().slice(0, 10);
    // const now = formatYmd(new Date());

    // console.log('now: '+now);
    // console.log('start: '+order_start_date);
    // console.log('end: '+order_end_date);

    if (order_start_date == "") {
      order_end_date = "";
    } else {
      if (order_end_date < order_start_date) {
        order_end_date = order_start_date;
      }
    }

    $.ajax({
      type: "POST",
      url: base_url + "backend/shop/order/export_order_data",
      data: { store_id, status_id, item_id, order_start_date, order_end_date },
      dataType: "json",

      beforeSend: function () {
        $(".loader").removeAttr("style");
      },

      success: function (res) {
        $(".export_order_data_list").html("");
        var html = "";
        var email = "";
        var valid_email =
          /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        console.log(res);
        if (res.status == true) {
          if (res.getAllOrders) {
            $.each(res.getAllOrders, function (i, item) {
              //  let date_purchased = formatYmd(new Date(item.date_purchased));
              html +=
                '<p class="export_order_data_detail_X" data-order-number="' +
                item.order_number +
                '">' +
                item.billing_email +
                "</p>";
            });
            $(".total").html("Total result: " + res.getAllOrders.length);
            $(".export_order_data_list").html(html);
          }
          if (res.emails) {
            $.each(res.emails, function (i, item) {
              email += '<p class="export_order_data_detail" >' + item + "</p>";
            });
            $(".total").html("Total result: " + res.emails.length);
            $(".export_order_data_list").html(email);
          }

          $(".loader").attr("style", "display:none");
        } else {
          $(".loader").attr("style", "display:none");
          return Swal.fire({
            position: "top-end",
            icon: "error",
            title: res.message,
            showConfirmButton: false,
            timer: 1500,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax
  });

  $(document).on("change", ".store_id, .start_date, .end_date", function () {
    // var store_id = $(this).find(":selected").data("store-id");
    var store_id = $(".store_id").val();
    var start_date = $(".start_date").val();
    var end_date = $(".end_date").val();

    // return console.log(store_id);
    if (store_id == null) {
      return Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Store Sec!",
        showConfirmButton: false,
        timer: 1500,
        backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
      });
    }
    if (start_date > end_date) {
      $(".start_date").val(end_date);
      return Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Start Date cannot be greater than End Date!",
        showConfirmButton: false,
        timer: 1500,
        backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
      });
    }

    $.ajax({
      type: "POST",
      url: base_url + "backend/shop/statistic/sum_order_total",
      data: { store_id, start_date, end_date },
      dataType: "json",

      beforeSend: function () {
        $(".web_total").text("0.00");
        $(".web_total_update").text("0.00");
        $(".kiosk_total").text("0.00");
        $(".kiosk_total_update").text("0.00");
      },

      success: function (res) {
        if (res.result.web) {
          res.result.web.total !== null
            ? $(".web_total").text(res.result.web.total)
            : "0.00";
          res.result.web.total !== null
            ? $(".web_total_update").text(res.result.web.total_update)
            : "0.00";
        }
        if (res.result.kiosk) {
          res.result.kiosk.total !== null
            ? $(".kiosk_total").text(res.result.kiosk.total)
            : "0.00";
          res.result.kiosk.total_update !== null
            ? $(".kiosk_total_update").text(res.result.kiosk.total_update)
            : "0.00";
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax
  });

  $(".ajax_generate_code").on("click", function (e) {
    e.preventDefault();

    let type = $(this).data("type");

    let csrf_fg = $("input[name=csrf_fg]").val();

    let url = (type === "add", type === "edit")
      ? "../generate_code"
      : "./generate_code";

    $.ajax({
      type: "POST",
      url: url,
      data: { csrf_fg: csrf_fg },
      dataType: "json",

      success: function (res) {
        //ajax post redirect url

        $('input[name="csrf_fg"]').val(res.csrf_fg);
        $('input[name="coupon_code"]').val(res.coupon_code);
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax

    return false;
  });

  $(".select_all_data").on("change", function () {
    if ($(this).prop("checked")) {
      $(".toogle_select_data").each(function () {
        $(this).prop("checked", true).trigger("change");
      });
    } else {
      $(".toogle_select_data").each(function () {
        $(this).prop("checked", false).trigger("change");
      });
    }
  });

  $(document).on("change", ".all_store", function () {
    let checkbox = $(this).data("all");

    if ($(this).is(":checked")) {
      $("." + checkbox + " > option").prop("selected", "selected");
      $("." + checkbox)
        .prop("checked", true)
        .trigger("change");
    } else {
      $("." + checkbox + " > option").removeAttr("selected");
      $("." + checkbox)
        .prop("checked", false)
        .trigger("change");
    }
  });

  $(document).on("change", "#discount_type", function () {
    let value = this.value;
    let percent = $("#percent");
    let percent_ = $("#percent_");
    let amount = $("#amount");
    let amount_ = $("#amount_");

    if (value === "fixed_cart") {
      percent_.attr({ style: "display:none" });
      percent.removeAttr("required");
      amount_.removeAttr("style");
      amount.attr("required", true);
    } else if (value === "percentage") {
      amount_.attr({ style: "display:none" });
      amount.removeAttr("required");
      percent_.removeAttr("style");
      percent.attr("required", true);
    } else {
      percent_.attr({ style: "display:none" });
      percent.removeAttr("required");
      amount_.removeAttr("style");
      amount.attr("required", true);
    }
  });

  $(".labelprint1").on("click", function (e) {
    e.preventDefault();

    //   let type = $(this).data('type');
    //   let csrf_fg = $("input[name=csrf_fg]").val();

    let data = "fuat";
    $.ajax({
      type: "POST",
      url: "http://localhost:8888/irisshot_new_shop/v3/backend/printer",
      data: { data: data },
      // dataType: "json",

      success: function (res) {},
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax

    return false;
  });
});
