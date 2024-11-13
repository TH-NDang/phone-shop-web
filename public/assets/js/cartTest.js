const CartManager = {
  // Key để lưu giỏ hàng trong localStorage
  CART_STORAGE_KEY: "shopping_cart",

  initCart() {
    const cart = this.getCart();
    this.updateCartUI(cart);
  },

  // Lấy giỏ hàng từ localStorage
  getCart() {
    const cartData = localStorage.getItem(this.CART_STORAGE_KEY);
    return cartData ? JSON.parse(cartData) : [];
  },

  saveCart(cart) {
    localStorage.setItem(this.CART_STORAGE_KEY, JSON.stringify(cart));
    this.updateCartUI(cart);
  },

  addToCart(productId) {
    fetch(`/api/products/detail/${productId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((result) => {
        if (result.status === "success" && result.data) {
          const product = result.data;
          const cart = this.getCart();

          const existingProduct = cart.find(
            (item) => item.product_id === parseInt(productId)
          );

          if (existingProduct) {
            existingProduct.quantity += 1;
          } else {
            cart.push({
              product_id: parseInt(productId),
              name: product.name,
              price: parseFloat(product.price),
              image: product.image,
              quantity: 1,
            });
          }

          this.saveCart(cart);
          this.showNotification("Đã thêm sản phẩm vào giỏ hàng!");
        } else {
          throw new Error(result.message || "Không thể lấy thông tin sản phẩm");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        this.showNotification(
          "Có lỗi xảy ra khi thêm sản phẩm: " + error.message,
          "error"
        );
      });
  },

  updateQuantity(productId, newQuantity) {
    const cart = this.getCart();
    const product = cart.find((item) => item.product_id === productId);

    if (product) {
      if (newQuantity > 0) {
        product.quantity = newQuantity;
      } else {
        const index = cart.indexOf(product);
        cart.splice(index, 1);
      }
      this.saveCart(cart);
      this.updateCartUI(cart);
    }
  },

  removeFromCart(productId) {
    const cart = this.getCart();
    const updatedCart = cart.filter((item) => item.product_id !== productId);
    this.saveCart(updatedCart);
    this.showNotification("Đã xóa sản phẩm khỏi giỏ hàng!");
  },

  calculateTotal(cart) {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
  },

  updateCartUI(cart) {
    const cartNumber = document.querySelector(".cart-number");
    if (cartNumber) {
      const totalItems = cart.reduce(
        (total, item) => total + parseInt(item.quantity),
        0
      );
      cartNumber.textContent = totalItems;
    }

    const cartItems = document.getElementById("cart-items");
    if (cartItems) {
      if (cart.length === 0) {
        const emptyCartMessage = document.getElementById("empty-cart-message");
        const cartTable = cartItems.closest("table");
        if (emptyCartMessage) emptyCartMessage.style.display = "block";
        if (cartTable) cartTable.style.display = "none";
      } else {
        const emptyCartMessage = document.getElementById("empty-cart-message");
        const cartTable = cartItems.closest("table");
        if (emptyCartMessage) emptyCartMessage.style.display = "none";
        if (cartTable) cartTable.style.display = "table";

        cartItems.innerHTML = cart.map((item) => `
          <tr>
              <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">
                  <div style="display: flex; align-items: center;">
                      <img src="${item.image}" alt="${item.name}" style="width: 80px; margin-right: 15px;">
                      <p style="margin: 0;">${item.name}</p>
                  </div>
              </td>
              <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">
                  ${new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                  }).format(item.price)}
              </td>
              <td style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6;">
                  <input type="number" value="${item.quantity}" min="1" 
                      style="width: 60px; padding: 5px; text-align: center;"
                      onchange="CartManager.updateQuantity(${item.product_id}, parseInt(this.value))">
              </td>
              <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">
                  ${new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                  }).format(item.price * item.quantity)}
              </td>
              <td style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6;">
                  <button onclick="CartManager.removeFromCart(${item.product_id})"
                      style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                      Xóa
                  </button>
              </td>
          </tr>
        `).join("");
      }

      const totalElement = document.getElementById("cart-total");
      if (totalElement) {
        const total = this.calculateTotal(cart);
        totalElement.textContent = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(total);
      }
    }
  },

  showNotification(message, type = "success") {
    const alert = document.getElementById("alert");
    if (alert) {
      alert.textContent = message;
      alert.style.backgroundColor = type === "success" ? "#4CAF50" : "#f44336";
      alert.style.display = "block";
      alert.style.opacity = "1";
      alert.style.transform = "translateY(0)";

      setTimeout(() => {
        alert.style.opacity = "0";
        alert.style.transform = "translateY(20px)";
        setTimeout(() => {
          alert.style.display = "none";
        }, 300);
      }, 2000);
    }
  },

  clearCart() {
    localStorage.removeItem(this.CART_STORAGE_KEY);
    this.updateCartUI([]);
  },
};

document.addEventListener("DOMContentLoaded", () => {
  CartManager.initCart();
});

function themVaoGioHang(productId) {
  CartManager.addToCart(productId);
}

function updateCartCount() {
  const cart = this.getCart();
  const totalItems = cart.reduce(
    (total, item) => total + parseInt(item.quantity),
    0
  );
  const cartNumber = document.querySelector(".cart-number");
  if (cartNumber) {
    cartNumber.textContent = totalItems;
  }
}
