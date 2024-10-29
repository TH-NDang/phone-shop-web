<section class="header">
    <div class="contain-products">
        <h2>Tất cả sản phẩm</h2>
        <ul id="products" class="homeproduct group flexContain">
            <!-- Initial products will be loaded here -->
        </ul>
        <button id="loadMore" class="xemTatCa">Xem thêm</button>

        <script>
            // Load initial products when page loads
            document.addEventListener('DOMContentLoaded', function () {
                loadMoreProducts('/api/products/1');
            });

            // Handle load more button
            let currentPage = 1;
            document.getElementById('loadMore').addEventListener('click', function () {
                currentPage++;
                loadMoreProducts('/api/products/' + currentPage);
            });

            // Function to create product HTML
            function createProductHTML(product) {
                // Add checks for required fields
                if (!product.name || !product.price || !product.image) {
                    console.error('Missing required product fields:', product);
                    return '';
                }

                return `
                    <li class="sanPham">
                        <a href="/product-detail/${product.product_id}">
                            <img src="${product.image}" alt="${product.name}" onerror="this.src='/assets/store/products/default.jpg'">
                            <h3>${product.name}</h3>
                            <div class="price">
                                <strong>${new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(product.price)}</strong>
                            </div>
                            <div class="ratingresult">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>đánh giá</span>
                            </div>
                            <label class="tragop">Trả góp 0%</label>
                            <div class="tooltip">
                                <button class="themvaogio" onclick="themVaoGioHang(${product.product_id}); return false;">
                                    <span class="tooltiptext">Thêm vào giỏ</span>
                                    +
                                </button>
                            </div>
                        </a>
                    </li>
                `;
            }

            // Function to display products by brand
            async function displayProducts(brandName) {
                try {
                    const response = await fetch(`/api/search?brand=${encodeURIComponent(brandName)}`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const result = await response.json();
                    const products = result.data || [];

                    const productsContainer = document.getElementById('products');
                    productsContainer.innerHTML = '';

                    // Hide load more button when filtering by brand
                    document.getElementById('loadMore').style.display = 'none';

                    if (products.length === 0) {
                        productsContainer.innerHTML = `
                            <p style="font-size: 20px; color: red; font-weight: bold; text-align: center;">
                                Không có sản phẩm nào của hãng ${brandName}!
                            </p>
                        `;
                        return;
                    }

                    // Display filtered products
                    products.forEach(product => {
                        productsContainer.innerHTML += createProductHTML(product);
                    });

                } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi tải sản phẩm!');
                }
            }

            // Function to load more products
            async function loadMoreProducts(url) {
                try {
                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const result = await response.json();
                    console.log('API Response:', result); // Debug log

                    if (result.status === 'error') {
                        console.error('API Error:', result.message);
                        alert('Có lỗi khi tải sản phẩm: ' + result.message);
                        return;
                    }

                    const products = result.data;
                    if (!Array.isArray(products)) {
                        console.error('Products data is not an array:', products);
                        return;
                    }

                    // Hide load more button if no more products
                    if (products.length === 0) {
                        document.getElementById('loadMore').style.display = 'none';
                        return;
                    }

                    const productsContainer = document.getElementById('products');

                    // Append new products
                    products.forEach(product => {
                        if (!product || !product.product_id) {
                            console.error('Invalid product data:', product);
                            return;
                        }

                        productsContainer.innerHTML += createProductHTML(product);
                    });

                } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi tải sản phẩm!');
                }
            }

        </script>
    </div>
</section>
