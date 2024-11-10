//hàm này dùng để hiển thị sản phẩm tìm được
async function displayProducts(keyword) {
    if (keyword == 'Apple') {
        keyword = 'iphone';
    }
    try {
        const response = await fetch('/api/search?keyword=' + encodeURIComponent(keyword));
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const result = await response.json();
        
        // Ghi lại phản hồi từ máy chủ trong console
        console.log('Server response:', result);

        // Lấy danh sách sản phẩm từ phản hồi
        const products = result.products || [];

        // Kiểm tra xem products có phải là một mảng hay không
        if (!Array.isArray(products)) {
            throw new TypeError('Expected an array of products');
        }

        // Lấy phần tử HTML để hiển thị danh sách sản phẩm
        const productsContainer = document.getElementById('products');
        if (!productsContainer) {
            throw new Error('Element with ID "products" not found');
        }
        productsContainer.innerHTML = '';

        if (result.error === 'NoMoreProduct') {
            const loadMoreButton = document.getElementById('loadMore');
            if (loadMoreButton) {
                loadMoreButton.style.display = 'none';
            }
        } else if (products.length === 0) {
            productsContainer.innerHTML = `
            <p style="font-size: 20px; color: red; font-weight: bold; text-align: center;">
              Không có sản phẩm nào! <span style="color: blue;"><a href="/">Quay lại trang chủ</a></span>
            </p>
            `;
        } else {
            // Hiển thị các sản phẩm
            products.forEach(product => {
                const productElement = document.createElement('li');
                productElement.className = 'sanPham';
                productElement.innerHTML = `
                    <a href="/product-detail/${product.name}">
                    <img src="${product.image}" alt="">
                    <h3>${product.name}</h3>
                    <div class="price">
                        <strong>${Math.floor(product.price).toLocaleString('vi-VN')}₫</strong>
                    </div>
                    <div class="ratingresult">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><span>đánh giá</span>
                    </div>
                    <label class="tragop">
                        Trả góp 0%
                    </label>
                    <div class="tooltip">
                        <button class="themvaogio" onclick="themVaoGioHang('${product.name}'); return false;">
                            <span class="tooltiptext" style="font-size: 15px;">Thêm vào giỏ</span>
                            +
                        </button>
                    </div>
                </a>
                `;
                productsContainer.appendChild(productElement);
            });
        }

        const loadMoreButton = document.getElementById('loadMore');
        if (loadMoreButton) {
            loadMoreButton.style.display = 'none';
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Hàm này dùng để tìm kiếm
async function search(keyword) {
    try {
        // Thực hiện yêu cầu API để tìm kiếm sản phẩm theo từ khóa
        const response = await fetch('/api/search?keyword=' + encodeURIComponent(keyword));
        
        // Chuyển đổi phản hồi từ máy chủ sang định dạng JSON
        const result = await response.json();
        
        // Ghi lại phản hồi từ máy chủ trong console
        console.log('Server response:', result);

        // Lấy danh sách sản phẩm từ phản hồi
        const products = result.products || [];

        // Kiểm tra xem products có phải là một mảng hay không
        if (!Array.isArray(products)) {
            throw new TypeError('Expected an array of products');
        }

        // Lấy phần tử HTML để hiển thị danh sách gợi ý tự động
        const searchBoxAutocompleteList = document.getElementById('search-boxautocomplete-list');
        searchBoxAutocompleteList.innerHTML = '';

        // Kiểm tra từ khóa
        if (!keyword) {
            searchBoxAutocompleteList.innerHTML = '';
            return;
        }

        // Hiển thị danh sách gợi ý tự động
        products.forEach(product => {
            searchBoxAutocompleteList.innerHTML += `
                <div>
                    <a href="/product-detail/${product.product_id}">
                        ${product.name.replace(new RegExp(`(${keyword})`, 'gi'), '<strong>$1</strong>')}
                    </a>
                </div>
            `;
        });

        // Ẩn nút "Load More"
        document.getElementById('loadMore').style.display = 'none';
    } catch (error) {
        // Ghi lại lỗi trong console
        console.error('Error:', error);
    }
}
//hàm này dùng để input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search-box').addEventListener('input', function() {
        const keyword = this.value;
        search(keyword);
    });
});

//tạo hàm để lọc sản phẩm
