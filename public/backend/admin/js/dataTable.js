$(function () {
  "use strict";

  //url formatla http://irispicture/
  const base_url = window.location.origin+"/"+ window.location.pathname.split("/")[0]+"";

  $("#couponlist").DataTable({
    processing: true,
    serverSide: true,
    serverMethod: "post",
    ajax: {
      url: base_url + "backend/shop/coupon/list",
    },
    columns: [
      { data: "id" },
      { data: "code" },
      { data: "amount" },
      { data: "percent" },
      { data: "discount_type" },
      { data: "valid_date" },
      { data: "limit" },
      { data: "status" },
      { className: "my_class", data: "action" },
    ],
  });
  
  $("#orderlist").DataTable({
    processing: true,
    serverSide: true,
    serverMethod: "post",
    ajax: {
      url: base_url + "backend/shop/order/list",
    },
    columns: [
      { data: "order_id" },
      { data: "order_type" },
      { data: "order_number" },
      { data: "billing_firstname" },
      { data: "billing_email" },
      { data: "total" },
      { data: "paid" },
      { className: "my_class", data: "action" },
    ],
  });

});
