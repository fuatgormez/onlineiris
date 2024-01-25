$(function () {
  "use strict";

  const base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  $("document").ready(function () {
    $("#devicelist").DataTable({
      processing: true,
      serverSide: true,
      serverMethod: "post",
      ajax: {
        url: base_url + "backend/machine_tracking/device/list/",
      },
      columns: [
        { data: "kiosk_id" },
        { data: "id" },
        { data: "location_name" },
        { data: "request" },
        { className: "my_class"+"id", data: "version" }
      ],
    });
  });
  setTimeout(function () {
    window.location.reload(1);
  }, 6666666660000);

  $(document).on("change", ".device_action", function (e) {
    e.preventDefault();

    let device_id = $(this).data('id');
    let device_val = $(this).val();
    let device_mode = $(this).data('mode');


    console.log( device_val +" - "+ device_mode +" - "+ device_id);

    $.ajax({
      type: "POST",
      url: base_url + "backend/machine_tracking/device/action",
      data: { device_id, device_val, device_mode },
      dataType: "json",

      beforeSend: function () {
        $(".loadermodern").removeClass("hidden");
      },

      success: function (response) {
        if (response.status === "success") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Update has been successfully!",
            showConfirmButton: false,
            timer: 1000,
            backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
          });
          return;
        }
        if (response.status === "error") {
          Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Update has been not successfully!",
            showConfirmButton: false,
            timer: 1000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          return;
        }
      },
      complete: function () {
        $('.loadermodern').addClass('hidden');
      },
      error: function () {},
    });
  });
});
