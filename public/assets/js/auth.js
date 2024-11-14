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
          sessionStorage.setItem("user", JSON.stringify(response.data));

          showNotification("Đăng nhập thành công!", "success");
          updateUserUI(response.data);
          closeLoginForm();
          syncCartAfterLogin();
        } else {
          showNotification(response.message || "Đăng nhập thất bại!", "error");
        }
      },
      error: function (xhr) {
        showNotification("Có lỗi xảy ra khi đăng nhập!", "error");
      },
    });
  });

  $(document).on("click", ".logout-btn", function (e) {
    e.preventDefault();
    handleLogout();
  });

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

function checkLoginStatus() {
  $.ajax({
    url: "/api/auth/status",
    type: "GET",
    success: function (response) {
      if (response.status === "success" && response.data) {
        updateUserUI(response.data);
      }
    },
    error: function () {
      sessionStorage.removeItem("user");
    },
  });
}

function handleLogout() {
  if (!confirm("Bạn có chắc muốn đăng xuất?")) return;

  $.ajax({
    url: "/api/auth/logout",
    type: "POST",
    success: function (response) {
      if (response.status === "success") {
        sessionStorage.removeItem("user");

        localStorage.removeItem("shopping_cart");
        showNotification("Đăng xuất thành công!", "success");
        const defaultMemberHtml = `
                    <div class="member">
                        <a href="javascript:void(0);" onclick="checkLogin()">
                            <i class="fas fa-user"></i>
                            Tài khoản
                        </a>
                    </div>
                `;
        $(".tools-member .member").replaceWith(defaultMemberHtml);

        $(".cart-number").text("0");
        setTimeout(() => {
          window.location.href = "/";
        }, 1000);
      }
    },
    error: function () {
      showNotification("Có lỗi xảy ra khi đăng xuất!", "error");
    },
  });
}

function updateUserUI(userData) {
  const memberHtml = `
        <div class="member">
            <a href="javascript:void(0);">
                <i class="fas fa-user"></i>
                ${userData.username || userData.email}
            </a>
            <div class="menuMember">
                <a href="/profile">Trang cá nhân</a>
                <a href="javascript:void(0)" class="logout-btn">Đăng xuất</a>
            </div>
        </div>
    `;

  $(".tools-member .member").replaceWith(memberHtml);
}

function syncCartAfterLogin() {
  // Lấy giỏ hàng từ localStorage
  const localCart = JSON.parse(localStorage.getItem("shopping_cart") || "[]");

  // Lấy giỏ hàng từ server
  $.ajax({
    url: "/api/cart/get",
    type: "GET",
    success: function (response) {
      if (response.status === "success") {
        const serverCart = response.data || [];

        // Merge giỏ hàng local với server
        const mergedCart = mergeCart(localCart, serverCart);

        // Cập nhật giỏ hàng đã merge lên server
        $.ajax({
          url: "/api/cart/sync",
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({ cart: mergedCart }),
          success: function (syncResponse) {
            if (syncResponse.status === "success") {
              // Cập nhật localStorage với giỏ hàng đã merge
              localStorage.setItem("shopping_cart", JSON.stringify(mergedCart));

              // Cập nhật UI giỏ hàng
              updateCartNumber(mergedCart);
            }
          },
        });
      }
    },
  });
}

function mergeCart(localCart, serverCart) {
  const mergedCart = [...serverCart];

  localCart.forEach((localItem) => {
    const serverItem = mergedCart.find(
      (item) => item.product_id === localItem.product_id
    );
    if (serverItem) {
      // Nếu sản phẩm đã có trong giỏ hàng server, cộng số lượng
      serverItem.quantity += localItem.quantity;
    } else {
      // Nếu chưa có, thêm mới
      mergedCart.push(localItem);
    }
  });

  return mergedCart;
}

function updateCartNumber(cart) {
  const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 0), 0);
  $(".cart-number").text(totalItems);
}
