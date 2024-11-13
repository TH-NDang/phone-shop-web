const CartManager = {
  CART_STORAGE_KEY: "shopping_cart",

  isLoggedIn() {
    return sessionStorage.getItem("user") !== null;
  },

  initCart() {
    const cart = this.getCart();
    this.updateCartUI(cart);
  },

  getCart() {
    const cartData = localStorage.getItem(this.CART_STORAGE_KEY);
    return cartData ? JSON.parse(cartData) : [];
  },

  async saveCart(cart) {
    localStorage.setItem(this.CART_STORAGE_KEY, JSON.stringify(cart));
    this.updateCartUI(cart);

    // Nếu đã đăng nhập, đồng bộ với server
    if (this.isLoggedIn()) {
      try {
        const response = await fetch("/api/cart/sync", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ cart: cart }),
        });
        const result = await response.json();
        if (result.status !== "success") {
          console.error("Lỗi đồng bộ giỏ hàng:", result.message);
        }
      } catch (error) {
        console.error("Lỗi khi đồng bộ giỏ hàng:", error);
      }
    }
  },

  async addToCart(productId) {
    try {
      const response = await fetch(`/api/products/detail/${productId}`);
      if (!response.ok) throw new Error("Lỗi lấy thông tin sản phẩm");

      const result = await response.json();
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

        await this.saveCart(cart);
        this.showNotification("Đã thêm sản phẩm vào giỏ hàng!");
      }
    } catch (error) {
      console.error("Error:", error);
      this.showNotification("Có lỗi xảy ra khi thêm sản phẩm!", "error");
    }
  },

  async updateQuantity(productId, newQuantity) {
    const cart = this.getCart();
    const product = cart.find((item) => item.product_id === parseInt(productId));

    if (product) {
      if (newQuantity > 0) {
        product.quantity = parseInt(newQuantity);
        await this.saveCart(cart);
      } else {
        await this.removeFromCart(productId);
      }
    }
  },

  async removeFromCart(productId) {
    const cart = this.getCart();
    const updatedCart = cart.filter(
      (item) => item.product_id !== parseInt(productId)
    );
    await this.saveCart(updatedCart);
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
        if (emptyCartMessage) emptyCartMessage.style.display = "block";
        cartItems.closest("table").style.display = "none";
      } else {
        cartItems.innerHTML = cart
          .map(
            (item) => `
                    <tr>
                        <td>
                            <img src="${item.image}" alt="${
              item.name
            }" style="width: 100px;">
                            <p>${item.name}</p>
                        </td>
                        <td>${new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(item.price)}</td>
                        <td>
                            <input type="number" value="${
                              item.quantity
                            }" min="1" 
                                onchange="CartManager.updateQuantity(${
                                  item.product_id
                                }, this.value)">
                        </td>
                        <td>${new Intl.NumberFormat("vi-VN", {
                          style: "currency",
                          currency: "VND",
                        }).format(item.price * item.quantity)}</td>
                        <td>
                            <button onclick="CartManager.removeFromCart(${
                              item.product_id
                            })" 
                                    style="color: white; background-color: #dc3545; border: none; padding: 5px 10px; border-radius: 3px;">
                                Xóa
                            </button>
                        </td>
                    </tr>
                `
          )
          .join("");

        const totalElement = document.getElementById("cart-total");
        if (totalElement) {
          const total = this.calculateTotal(cart);
          totalElement.textContent = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
          }).format(total);
        }
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

      setTimeout(() => {
        alert.style.opacity = "0";
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
