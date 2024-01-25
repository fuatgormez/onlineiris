(function ($) {
  "use strict";

  /*---------- 18. Quantity Added ----------*/
  $(".quantity-plus").each(function () {
    $(this).on("click", function () {
      var $qty = $(this).siblings(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal)) {
        $qty.val(currentVal + 1);
      }
    });
  });

  $(".quantity-minus").each(function () {
    $(this).on("click", function () {
      var $qty = $(this).siblings(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(currentVal - 1);
      }
    });
  });

  $(document).keydown(function (e) {
    if (
      !$("input").is(":focus") &&
      !$("textarea").is(":focus") &&
      e.keyCode == 27
    ) {
      $(".all-store").show(1000);
      $(".left-sidebar-store").animate({ opacity: "0" }, 500);
    }
  });

  $(document).on("click", ".reset-all-store", function (e) {
    $.getJSON(
      "select_land/generate_csrf", // url // data
      function (result) {
        console.log(result.csrf_fg);
        $(".csrf").attr("data-csrf", result.csrf_fg);
      }
    );

    // $('.left-sidebar-store').fadeOut(1000).hide();
    // $('.all-store').fadeIn(1000).hide().css('display','');
    $(".all-store").show(1000);
    $(".left-sidebar-store").animate({ opacity: "0" }, 500);
  });

  $(document).on("click", ".select_land", function (e) {
    e.stopPropagation();
    e.stopImmediatePropagation();

    let csrf_fg = $(".csrf").data("csrf");
    let land_name = $(this).data("land-name");

    $.ajax({
      url: "select_land/find",
      type: "post",
      dataType: "json",
      data: {
        term: land_name,
        csrf_fg: csrf_fg,
      },
      beforeSend: function () {
        $(".resultsCity").empty();
      },
      success: function (data, textStatus, jqXHR) {
        let new_csrf_code = data[0].csrf_fg;

        if (data.length > 0) {
          $("#resultsCity").removeClass("invisible");

          $.each(data, function (index, value) {
            $(
              ".resultsCity"
            ).append(`<a href="language/select_store/${value.store_id}" class="list-group-item list-group-item-action flex-column align-items-start" data-store-id="${value.store_id}">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">${value.store_name}</h5>
                <small>${value.store_address}</small>
            </div>
            </a>`);
          });
        } else {
          $(".store-list").addClass("invisible");
        }

        $(".csrf").attr("data-csrf", data[0].csrf_fg);
      },

      error: function (jqXHR, textStatus, errorThrown) {
        window.location.reload();
        console.log("hata: " + jqXHR + " " + textStatus + " " + errorThrown);
      },
    }); //end ajax

    $(".all-store").hide(500);
    $(".left-sidebar-store").animate({ opacity: "1" }, 1000);
  });

  $(document).on("keyup", "#filter1111", function () {
    $(".resultsCity").attr("style", "display:none; background:#ff0000;");
    var txt = $(this).val();
    $(".resultsCity").each(function () {
      if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1) {
        $(this).show();
      }
    });
  });

  $("#filter12343123123123123").keyup(function () {
    // Retrieve the input field text and reset the count to zero
    var filter = $(this).val(),
      count = 0;
    if (!filter) {
      // hide is no text
      $(".resultsCity div").hide();
      return;
    }

    var regex = new RegExp(filter, "i"); // Create a regex variable outside the loop statement

    // Loop through the comment list
    $(".resultsCity div").each(function () {
      // If the list item does not contain the text phrase fade it out
      if ($(this).text().search(regex) < 0) {
        // use the variable here
        $(this).hide();

        // Show the list item if the phrase matches and increase the count by 1
      } else {
        $(this).show();
        count++;
      }
    });

    // Update the count
    var numberItems = count;
    $("#filter-count").text("Number of Comments = " + count);
  });

  // $(document).on("click", ".select_store", function (e) {
  //   e.stopPropagation();
  //   e.stopImmediatePropagation();

  //   let csrf_fg = $(".csrf").data("csrf");
  //   let store_id = $(this).data("store-id");

  //   $.ajax({
  //     type: "POST",
  //     url: "language/select_store",
  //     data: { csrf_fg: csrf_fg, store_id: store_id },
  //     dataType: "json",

  //     success: function (res) {
  //       let res_data = JSON.parse(JSON.stringify(res));

  //       if (res_data.statusCode == 200) {
  //         window.location.href = "home";
  //       }

  //       if (res_data.statusCode == 404) {
  //         $(".csrf, #filterCity").attr("data-csrf", res_data.csrf_fg);
  //         //   window.location.reload();
  //       }
  //     },
  //     error: function (xhr, status, res) {
  //       // window.location.reload();
  //     },
  //   }); //end ajax
  // });

  $(".store_search").autocomplete({
    minLength: 2,

    source: function (request, response) {
      let csrf_fg = $(this).data("csrf");
      // Fetch data
      $.ajax({
        url: "select_land/find",
        type: "post",
        dataType: "json",
        data: {
          term: request.term,
          csrf_fg: csrf_fg,
        },
        beforeSend: function () {
          $(".result_store").empty();
          if (request.term.length > 2) {
            $(".fetchAll_store").attr("style", "display:none");
          } else {
            $(".fetchAll_store").removeAttr("style");
          }
        },
        success: function (data) {
          console.log(data);
          if (data.length > 0) {
            $(".store-list").removeClass("invisible");

            $(".result_store").empty();

            $.each(data, function (index, value) {
              $(".result_store").append(`<div class="col-md-12 mb-5 hide">
              <img src="public/uploads/store_photos/${value.photo}" />
                </div>
                <div class="col-md-12 mb-2">
                    <a href="language/select_store/${value.store_id}" class="list-group-item list-group-item-action flex-column align-items-start" data-store-id="${value.id}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">${value.store_name}</h5>
                            <small>${value.store_address}</small>
                        </div>
                    </a>
                </div>`);
            });
          } else {
            
            $(".result_store").empty();
            // $(".fetchAll_store").removeAttr("style");

            $(".result_store").append(`
                <div class="col-md-12 mb-2">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">No result</h5>
                    </div>
                </div>`);
          }
        },
      });
    },
  });

  
})(jQuery);
