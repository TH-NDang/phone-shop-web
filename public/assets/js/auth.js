$(document).ready(function () {
  // Xử lý chuyển tab
  $(".tab a").on("click", function (e) {
    e.preventDefault();
    $(this).parent().addClass("active").siblings().removeClass("active");

    const target = $(this).attr("href");
    $(".tab-content > div").hide();
    $(target).fadeIn(600);

    // Reset form khi chuyển tab
    $(".tab-content form").trigger("reset");
    $(".field-wrap label").removeClass("active highlight");
  });

  // Xử lý label animation
  $(".field-wrap input, .field-wrap textarea")
    .on("focusin", function () {
      $(this).siblings("label").addClass("active highlight");
    })
    .on("focusout", function () {
      if (!$(this).val()) {
        $(this).siblings("label").removeClass("active highlight");
      } else {
        $(this).siblings("label").removeClass("highlight");
      }
    })
    .on("input", function () {
      if ($(this).val()) {
        $(this).siblings("label").addClass("active");
      }
    });

  // Đóng form popup
  $(".close, .containTaikhoan").on("click", function (e) {
    if (e.target === this) {
      closeLoginForm();
    }
  });
  $(".taikhoan").on("click", function (e) {
    e.stopPropagation();
  });

  // Xử lý form đăng nhập
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();
    const formData = {
      email: $(this).find('input[name="email"]').val(),
      password: $(this).find('input[name="password"]').val(),
    };

    $.ajax({
      url: "/api/auth/login",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(formData),
      success: function (response) {
        if (response.status === "success") {
          showNotification("Đăng nhập thành công!", "success");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showNotification(response.message || "Đăng nhập thất bại!", "error");
        }
      },
      error: function (xhr) {
        showNotification("Có lỗi xảy ra khi đăng nhập!", "error");
      },
    });
  });

  // Xử lý form đăng ký
  $("#signupForm").on("submit", function (e) {
    e.preventDefault();
    const formData = {
      username: $(this).find('input[name="username"]').val(),
      email: $(this).find('input[name="email"]').val(),
      password: $(this).find('input[name="password"]').val(),
      first_name: $(this).find('input[name="first_name"]').val(),
      last_name: $(this).find('input[name="last_name"]').val(),
      tel: $(this).find('input[name="tel"]').val(),
      address: $(this).find('textarea[name="address"]').val(),
    };

    $.ajax({
      url: "/api/auth/register",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(formData),
      success: function (response) {
        if (response.status === "success") {
          showNotification("Đăng ký thành công! Vui lòng đăng nhập.", "success");
          // Chuyển sang tab đăng nhập
          $(".tab:first-child a").click();
        } else {
          showNotification(response.message || "Đăng ký thất bại!", "error");
        }
      },
      error: function (xhr) {
        showNotification("Có lỗi xảy ra khi đăng ký!", "error");
      },
    });
  });

  // Xử lý đăng xuất
  $(".logout-btn").on("click", function (e) {
    e.preventDefault();
    if (!confirm("Bạn có chắc muốn đăng xuất?")) return;

    $.ajax({
      url: "/api/auth/logout",
      type: "POST",
      success: function (response) {
        if (response.status === "success") {
          // Xóa giỏ hàng trong localStorage
          localStorage.removeItem("shopping_cart");
          showNotification("Đăng xuất thành công!", "success");
          setTimeout(() => {
            window.location.href = "/";
          }, 1000);
        }
      },
      error: function () {
        showNotification("Có lỗi xảy ra khi đăng xuất!", "error");
      },
    });
  });
});

// Hàm tiện ích
function showLoginForm() {
  $(".containTaikhoan").css("transform", "scale(1)");
  // Reset form và chuyển về tab đăng nhập
  $(".tab:first-child a").click();
  $(".tab-content form").trigger("reset");
  $(".field-wrap label").removeClass("active highlight");
}

function closeLoginForm() {
  $(".containTaikhoan").css("transform", "scale(0)");
}

function showNotification(message, type = "success") {
  const $alert = $("#alert");
  if ($alert.length) {
    $alert.text(message).css({
      backgroundColor: type === "success" ? "#4CAF50" : "#f44336",
      display: "block",
      opacity: "1",
    });

    setTimeout(() => {
      $alert.css("opacity", "0");
      setTimeout(() => {
        $alert.css("display", "none");
      }, 300);
    }, 2000);
  }
}

function checkLogin() {
  showLoginForm();
}
