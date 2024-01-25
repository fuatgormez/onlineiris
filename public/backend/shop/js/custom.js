$(function () {
  "use strict";

  //url formatla http://irispicture/
  const base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "";


  $(".status_process").on("click", function (e) {
      e.preventDefault();
      alert();
  });

  $(".confirm_paid,.confirm_paid_update").on("click", function (e) {
      e.preventDefault();
    // $("#confirm_paid").modal("show");

    let paid = $(this).data("paid");
    let amount = $(this).data("amount");
    let order_number = $(this).data("order-number");


    if (confirm("Are you sure you want to mark it as paid?")) {
      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/process_paid",
        data: { order_number, paid , amount},
        dataType: "json",

        success: function (res) {
            if(res.status == 200){
                window.location.reload();
            }
        },
        error: function () {},
      });
    }
  });

  $(".delete_allow_product").on("click", function (e) {
    e.preventDefault();
    let product_id = $(this).data("product-id");
    let product_allow = $(this).data("product-allow");
    let unique_row_id = $(this).data("row-id");

    $.ajax({
      type: "POST",
      url: "../delete_allow_product",
      data: { product_id, product_allow },

      success: function (res) {
        $("." + unique_row_id).remove();
      },
      error: function () {},
    });
  });

  $(".ajax_request").on("click", function (e) {
    e.preventDefault();

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");
    let form_name = button.parents("form").attr("name");

    let button_id = button.attr("id");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
      },
      success: function (res) {
        //ajax post redirect url
        if (res[0].url !== undefined) {
          window.location.href = res[0].url;
          return false;
        }

        let new_csrf_code = res[0].csrf_fg;

        $('input[name="csrf_fg"]').val(new_csrf_code);
      },
      complete: function (res) {
        //sweetalert start
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: res.responseJSON[0].responseMessage,
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        //sweetalert end
      },
      error: function (xhr, status, res) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "error",
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
        });
      },
    }); //end ajax

    return false;
  });

  $(".ajax_request_row").on("click", function (e) {
    e.preventDefault();
    alert();
    return;

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
      },
      success: function (res) {
        //ajax post redirect url
        if (res[0].url !== undefined) {
          window.location.href = res[0].url;
          return false;
        }

        let new_csrf_code = res[0].csrf_fg;

        $('input[name="csrf_fg"]').val(new_csrf_code);
      },
      complete: function (res) {
        //sweetalert start
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: res.responseJSON[0].responseMessage,
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        //sweetalert end
      },
      error: function (xhr, status, res) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "error",
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
        });
      },
    }); //end ajax

    return false;
  });
});
