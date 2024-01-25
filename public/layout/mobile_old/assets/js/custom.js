var Foodia = (function () {
  "use strict";

  //url formatla https://fg.de/

  var base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  /* Search Bar ============ */

  var screenWidth = $(window).width();

  var screenHeight = $(window).height();

  // Preloader

  var handlePreloader = function () {
    setTimeout(function () {
      jQuery("#preloader").fadeOut();
    }, 0);
  };

  $(document).on("click", ".showVideo", function () {
    $("#showVideo").modal("show");

    var url = $(this).data("url");

    let video = `<video controls autoplay loop>

        <source src="${url}" type="video/mp4"></source>

    </video>`;

    var iframe = `<iframe class="embed-responsive-item" src="${url}" width="100%" height="100%"></iframe>`;

    $(".ctx").html(iframe);
  });

  $(document).on("click", "#sms_confirm", function (e) {
    e.preventDefault();

    var button = $(e.target);

    var form_data = button.parents("form").serialize();

    var form_url = button.parents("form").attr("action");

    var form_name = button.parents("form").attr("name");

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

        if (res_data.status === "not_match") {
          return alert(res_data.message);
        }

        if (res_data.status === "invalid") {
          return alert(res_data.message);
        }

        if (res_data.status === "valid") {
          return alert(res_data.message);
        }
      },

      error: function (xhr, status, res) {
        // window.location.reload();
      },
    }); //end ajax
  });

  $(".direct-link").on("click", function () {
    $("#offcanvasLoading")
      .addClass("show")

      .css({ display: "show", visibility: "visible" });

    $(this).addClass("active");
  });

  $(".clipboard").on("click", function () {
    copyToClipboard($(this).text());
  });

  function copyToClipboard(text) {
    if (window.clipboardData && window.clipboardData.setData) {
      // Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.

      return window.clipboardData.setData("Text", text);
    } else if (
      document.queryCommandSupported &&
      document.queryCommandSupported("copy")
    ) {
      var textarea = document.createElement("textarea");

      textarea.textContent = text;

      textarea.style.position = "fixed"; // Prevent scrolling to bottom of page in Microsoft Edge.

      document.body.appendChild(textarea);

      textarea.select();

      try {
        alert("Copied ->" + text);

        return document.execCommand("copy"); // Security exception may be thrown by some browsers.
      } catch (ex) {
        console.warn("Copy to clipboard failed.", ex);

        return prompt("Copy to clipboard: Ctrl+C, Enter", text);
      } finally {
        document.body.removeChild(textarea);
      }
    }
  }

  $(".make_payment").on("click", function () {
    $("#make_payment").addClass("show");

    $("#offcanvasLoading")
      .removeClass("show")

      .css({ display: "none", visibility: "disable" });
  });

  $(document).on("click", ".upload_image", function (e) {
    e.preventDefault();

    let btn = this;

    let order_number = $(".order_number").val();

    $(btn).prop("disabled", true);

    $(".upload_image_loader").removeClass("d-none");

    $.ajax({
      url: base_url + "mobile/order/upload",

      type: "POST",

      data: new FormData($("#formWithFiles")[0]), // The form with the file inputs.

      processData: false,

      contentType: false, // Using FormData, no need to process data.

      beforeSend: function () {
        $(".notification-for-upload").html("");
      },

      success: function () {},

      complete: function (res) {
        let res_data = JSON.parse(JSON.stringify(res));

        console.log(btn);

        if (res_data.status == 400) {
          var notification = `<div class="alert alert-warning light alert-dismissible btn-block fade show"><strong>Warning!</strong> An unexpected error has occurred, please try again.</div>`;

          $(".upload_image_loader").html(notification);

          $(btn).prop("disabled", false);

          return;
        }

        if (res.status == 200) {
          var notification = `<div class="alert alert-primary light alert-dismissible btn-block fade show"><strong>Success!</strong> Image has been uploaded successfully.</div>`;

          $(".upload_image_loader").html(notification);

          $("#offcanvasLoading")
            .addClass("show")

            .css({ display: "show", visibility: "visible" });

          window.location.href =
            base_url + "mobile/order/upload-success/" + order_number;
        } else {
          var notification = `<div class="alert alert-primary light alert-dismissible btn-block fade show"><strong>Error!</strong> Please your image.</div>`;

          $(".upload_image_loader").html(notification);
        }
      },

      error: function () {
        console.log("An error occurred, the files couldn't be sent!");
      },
    });

    // $(this).prop("disabled", true);

    // $(".upload_image_loader").removeClass("d-none");

    // $("#offcanvasLoading")

    //   .addClass("show")

    //   .css({ display: "show", visibility: "visible" });

    // // retrieve form element

    // var form = this.form;

    // // prepare data

    // var data = new FormData(form);

    // // get url

    // var url = form.action;

    // const request = new XMLHttpRequest();

    // request.open("POST", url);

    // request.send(new FormData(form));

    // return console.log("post data: " + data);

    // send request

    // $.ajax({

    //   type: "POST",

    //   url: url,

    //   data: data,

    //   processData: false,

    //   contentType: false,

    // });
  });

  $(document).on("click", ".input_upload", function () {
    $(".notification-for-upload").html(
      `<audio autoplay loop> <source src="/public/uploads/notification-for-upload.mp4" type="audio/mp4"> </audio>`
    );
  });

  $(".modal").on("hidden.bs.modal", function () {
    $(".notification-for-upload").html("");

    document.querySelector("video").pause();
  });

  $(".find_order").on("click", function (e) {
    e.preventDefault();

    let order_number = $(".order_number").val();

    $.ajax({
      type: "POST",

      url: base_url + "mobile/upload/image",

      data: { order_number },

      dataType: "json",

      beforeSend: function (xhr, settings) {
        // settings.data += "&" + form_name + "=" + form_name;
      },

      success: function (res) {
        console.log(res);

        $(".modal").modal("show");

        if (res.status === 200) {
          var html = `<i class="fa fa-4x fa-check-circle text-success m-b15"></i>

					<h5 id="_order_number">${res.order.order_number}</h5>

          <p class="m-b0" id="_name">${res.order.billing_firstname}</p>

          <form action="${base_url}mobile/order/upload" name="form_upload" id="formWithFiles" method="post" enctype="multipart/form-data">

          <input type="hidden" name="order_number" value="${res.order.order_number}"/>

          <input type="file" class="form-control m-t20 input_upload" name="photos[]" multiple />

          <div class="me-2 mt-3 mb-2 d-flex align-items-center text-primary d-none upload_image_loader">

            <span class="spinner-border me-3 spinner-border-sm" role="status" aria-hidden="true"></span>

              Uploading your files, please wait for the system to continue...

            </div>

          <button type="submit" class="btn btn-primary btn-block m-t20 direct-link upload_image">Upload</button>

          </form>`;

          // $("#_order_number").html(res.order.order_number);

          // $("#_name").html(res.order.billing_firstname);
        } else {
          var html = `<i class="fa fa-4x fa-check-circle text-error m-b15"></i>

					<h5 id="_order_number">No result</h5>`;
        }

        $(".modal-body").html(html);
      },

      complete: function (res) {
        // console.log(res.responseText);
      },

      error: function (xhr, status, res) {
        console.log("error");
      },
    }); //end ajax

    return false;
  });

  $(".contact_btn").on("click", function (e) {
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
        $(".modal").modal("show");

        if (res.msg === "success") {
          $(".contact_btn").unbind("click");
        }

        //ajax post redirect url

        if (res[0].url !== undefined) {
          window.location.href = res[0].url;

          return false;
        }

        // let new_csrf_code = res[0].csrf_fg;

        // $('input[name="csrf_fg"]').val(new_csrf_code);
      },

      complete: function (res) {
        console.log(res.responseJSON[0].responseMessage);
      },

      error: function (xhr, status, res) {
        console.log("error");
      },
    }); //end ajax

    return false;
  });

  $(document).ready(function () {
    openLanguageVideo("england");
  });

  $(".language-video").on("click", function (e) {
    e.preventDefault();

    let url = $(this).data("url");

    openLanguageVideo(url);
  });

  function openLanguageVideo(url) {
    $(".video-title").html(url);

    $("#video").html(
      `<video src="${base_url}public/uploads/videos/${url}.mp4" width="300" autoplay controls></video>`
    );

    $("#languageVideo").modal("show");
  }

  // Menubar Toggler

  var handleMenubar = function () {
    jQuery(".menu-toggler").on("click", function () {
      jQuery(".sidebar").toggleClass("show");
    });

    jQuery(".menu-toggler").on("click", function () {
      jQuery(".menu-toggler").toggleClass("show");
    });
  };

  // Show Pass

  var handleShowPass = function () {
    jQuery(".show-pass").on("click", function () {
      jQuery(this).toggleClass("active");

      if (jQuery("#dz-password, .dz-password").attr("type") == "password") {
        jQuery("#dz-password, .dz-password").attr("type", "text");
      } else if (jQuery("#dz-password, .dz-password").attr("type") == "text") {
        jQuery("#dz-password, .dz-password").attr("type", "password");
      }
    });
  };

  // Sticky Header

  var handleIsFixed = function () {
    $(window).scroll(function () {
      var scroll = $(window).scrollTop();

      if (scroll >= 50) {
        $(".main-bar").addClass("sticky-header");
      } else {
        $(".main-bar").removeClass("sticky-header");
      }
    });
  };

  // Custom File Input

  var handleCustomFileInput = function () {
    $(".custom-file-input").on("change", function () {
      var fileName = $(this).val().split("\\").pop();

      $(this)
        .siblings(".custom-file-label")

        .addClass("selected")

        .html(fileName);
    });
  };

  // Default Select

  var handleSelectpicker = function () {
    if (jQuery(".default-select").length > 0) {
      jQuery(".default-select").selectpicker();
    }
  };

  // Menubar Nav Active

  var handleMenubarNav = function () {
    $(".menubar-nav .nav-link").on("click", function () {
      $(".menubar-nav .nav-link").removeClass("active");

      $(this).addClass("active");
    });
  };

  // Message Sheet

  var handleMessageHandle = function () {
    $(".message-area .icon-popup").on("click", function () {
      $(".message-icon").slideToggle("slow");
    });

    $(".messagebar-sheet-image").on("change", function () {
      var iconsrc = $(this).attr("data-icon");

      if ($(this).find('input[type="checkbox"]').is(":checked")) {
        $(".append-media").append(
          "<div class='emoji-icon' data-icon=" +
            iconsrc +
            "><img src=" +
            iconsrc +
            "></div>"
        );
      } else {
        var mediaicon = $(
          '.message-area .emoji-icon[data-icon="' + iconsrc + '"]'
        );

        mediaicon.remove();
      }
    });
  };

  // Scroll Top

  var handleScrollTop = function () {
    "use strict";

    jQuery(window).bind("scroll", function () {
      var scroll = jQuery(window).scrollTop();

      if (scroll > 100) {
        jQuery(".btn.scrollTop").fadeIn(500);
      } else {
        jQuery(".btn.scrollTop").fadeOut(500);
      }
    });

    /* page scroll top on click function end*/
  };

  // Chat button

  var handleChatBox = function () {
    $(".btn-chat").on("click", function () {
      var chatInput = $(".message-area .form-control");

      var chatMessageValue = chatInput.val();

      var chatEmojiArea = $(".append-media").html();

      var current = new Date();

      var ampm = current.getHours() >= 12 ? "pm" : "am";

      //alert(current.getMinutes());

      var actualTime =
        (current.getHours() % 12) + ":" + current.getMinutes() + " " + ampm;

      var messageEmojiHtml =
        '<div class="chat-content user">' +
        '<div class="message-item">' +
        '<div class="bubble">' +
        chatEmojiArea +
        "</div>" +
        '<div class="message-time">' +
        actualTime +
        "</div>" +
        "</div>" +
        "</div>";

      if (chatEmojiArea.length > 0) {
        $(".chat-box-area").append(messageEmojiHtml);
      }

      var messageHtml =
        '<div class="chat-content user">' +
        '<div class="message-item">' +
        '<div class="bubble">' +
        chatMessageValue +
        "</div>" +
        '<div class="message-time">' +
        actualTime +
        "</div>" +
        "</div>" +
        "</div>";

      if (chatMessageValue.length > 0) {
        var appendMessage = $(".chat-box-area").append(messageHtml);
      }

      window.scrollTo(0, document.body.scrollHeight);

      var clearChatInput = chatInput.val("");

      var clearChatInputE = $(".append-media").empty();
    });
  };

  // Page back btn

  var handleGoBack = function () {
    $(".back-btn").on("click", function () {
      window.history.go(-1);

      return false;
    });
  };

  // PWA Modal

  var handlePWAModal = function () {
    if (!window.matchMedia("(display-mode: standalone)").matches) {
      setTimeout(function () {
        jQuery(".pwa-offcanvas").addClass("show");

        jQuery(".pwa-backdrop").addClass("fade show");
      }, 3000);

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

  // Recent Search

  var handleSearch = function () {
    $(".search-input .form-control").on("change paste keyup", function () {
      if ($(this).val().length > 0) {
        $(".search-input .btn-close").fadeIn(500);
      } else {
        $(".search-input .btn-close").fadeOut(500);
      }
    });

    $(".search-input .btn-close").on("click", function () {
      $(".search-input .form-control").val(null);

      $(this).fadeOut(0);
    });
  };

  // Theme Version

  var handleThemeVersion = function () {
    jQuery(".theme-btn").on("click", function () {
      jQuery("body").toggleClass("theme-dark");

      jQuery(".theme-btn").toggleClass("active");
    });
  };

  var handleRemoveClass = function () {
    jQuery(".nav-color").on("click", function () {
      jQuery(".sidebar, .menu-toggler").removeClass("show");
    });
  };

  var handleToggleButton = function () {
    jQuery(".dz-treeview-item").on("click", function () {
      jQuery(this).toggleClass("open");
    });
  };

  //Light Gallery ============

  var handleLightgallery = function () {
    if (jQuery("#lightgallery").length > 0) {
      lightGallery(document.getElementById("lightgallery"), {
        plugins: [lgZoom, lgThumbnail],
      });
    }
  };

  //Tab Slide ============

  var handleTabSlide = function () {
    if (jQuery(".tab-slide-effect").length > 0) {
      var a = $(".tab-slide-effect li.active").width();

      var b = $(".tab-slide-effect li.active").position().left;

      $(".tab-active-indicator").css({
        width: a,

        transform: "translateX(" + b + "px)",
      });

      $(".tab-slide-effect li").on("click", function () {
        var tabItem = $(this).parent().find("li");

        $(tabItem).removeClass("active");

        $(this).addClass("active");

        var x = $(this).width();

        var y = $(this).position().left;

        var indicator = $(this).parent().find(".tab-active-indicator");

        $(indicator).css({ width: x, transform: "translateX(" + y + "px)" });
      });
    }
  };

  var handleOtp = function () {
    if (jQuery("#otp").length > 0)
      $(".digit-group")
        .find("input")

        .each(function () {
          $(this).attr("maxlength", 1);

          $(this).on("keyup", function (e) {
            var thisVal = $(this).val();

            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
              var prev = parent.find("input#" + $(this).data("previous"));

              if (prev.length) {
                $(prev).select();
              }
            } else {
              var next = parent.find("input#" + $(this).data("next"));

              if (!$.isNumeric(thisVal)) {
                $(this).val("");

                return false;
              }

              if (next.length) {
                $(next).select();
              } else {
                if (parent.data("autosubmit")) {
                  parent.submit();
                }
              }
            }
          });
        });
  };

  function getCodeBoxElement(index) {
    return document.getElementById("codeBox" + index);
  }

  function onKeyUpEvent(index, event) {
    const eventCode = event.which || event.keyCode;

    if (getCodeBoxElement(index).value.length === 1) {
      if (index !== 4) {
        getCodeBoxElement(index + 1).focus();
      } else {
        getCodeBoxElement(index).blur();

        // Submit code

        console.log("submit code ");
      }
    }

    if (eventCode === 8 && index !== 1) {
      getCodeBoxElement(index - 1).focus();
    }
  }

  function onFocusEvent(index) {
    for (item = 1; item < index; item++) {
      const currentElement = getCodeBoxElement(item);

      if (!currentElement.value) {
        currentElement.focus();

        break;
      }
    }
  }

  var handleActiveStar = function () {
    $(".item-bookmark").on("click", function () {
      $(this).toggleClass("active");
    });
  };

  var handleSearch = function () {
    $("#myInput").on("keyup", function () {
      var value = $(this).val().toLowerCase();

      $(".recent-jobs-list li").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });

      if ($(this).val().length > 0) {
        $(".search-input .btn-close").fadeIn(500);
      } else {
        $(".search-input .btn-close").fadeOut(500);
      }
    });

    $(".search-input .btn-close").on("click", function () {
      $(".recent-jobs-list li").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf("") > -1);
      });

      $(".search-input .form-control").val(null);

      $(this).fadeOut(0);
    });
  };

  var handleImageSelect = function () {
    if (jQuery(".image-select").length > 0) {
      const $_SELECT_PICKER = $(".image-select");

      $_SELECT_PICKER.find("option").each((idx, elem) => {
        const $OPTION = $(elem);

        const IMAGE_URL = $OPTION.attr("data-thumbnail");

        if (IMAGE_URL) {
          $OPTION.attr(
            "data-content",

            "<img src='%i'/> %s"

              .replace(/%i/, IMAGE_URL)

              .replace(/%s/, $OPTION.text())
          );
        }
      });

      $_SELECT_PICKER.selectpicker();
    }
  };

  /* Function ============ */

  return {
    init: function () {
      handleMenubar();

      handleToggleButton();

      handleShowPass();

      handleChatBox();

      // handleMenubarNav();

      handleIsFixed();

      handleScrollTop();

      handleLightgallery();

      handleCustomFileInput();

      handleMessageHandle();

      handleGoBack();

      handlePWAModal();

      handleSearch();

      //handleThemeVersion();

      handleRemoveClass();

      handleActiveStar();

      handleTabSlide();

      handleImageSelect();

      handleOtp();
    },

    load: function () {
      handlePreloader();

      handleSelectpicker();
    },

    resize: function () {
      screenWidth = $(window).width();
    },
  };
})();

/* Document.ready Start */

jQuery(document).ready(function () {
  $('[data-bs-toggle="popover"]').popover();

  ("use strict");

  Foodia.init();

  $(".theme-dark .custom-switch input").prop("checked", true);
});

/* Document.ready END */

/* Window Load START */

jQuery(window).on("load", function () {
  "use strict";

  Foodia.load();

  setTimeout(function () {
    jQuery("#splashscreen").addClass("active");

    jQuery("#splashscreen").fadeOut(1000);
  }, 1000);

  $(".theme-dark .custom-switch input")
    .prop("checked", true)

    .addClass("active");
});

/*  Window Load END */

/* Window Resize START */

jQuery(window).on("resize", function () {
  "use strict";

  Foodia.resize();
});

/*  Window Resize END */
