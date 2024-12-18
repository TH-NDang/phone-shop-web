<div class="flexContain">
    <div class="pricesRangeFilter dropdown">
        <button class="dropbtn">Giá tiền</button>
        <div id = "1" class="dropdown-content">
            <a data-price="0-2000000">Dưới 2 triệu</a>
            <a data-price="2000000-4000000">Từ 2 - 4 triệu</a>
            <a data-price="4000000-7000000">Từ 4 - 7 triệu</a>
            <a data-price="7000000-13000000">Từ 7 - 13 triệu</a>
            <a data-price="13000000-20000000">Từ 13 - 20 triệu</a>
            <a data-price="20000000-30000000">Từ 20 - 30 triệu</a>
            <a data-price="30000000-1000000000">Hơn 30 triệu</a>
        </div>
    </div>

    <div class="sortFilter dropdown">
        <button class="dropbtn">Sắp xếp</button>
        <div id = "2" class="dropdown-content">
            <a sort-filter="asc" >Giá tăng dần</a>
            <a sort-filter="desc" >Giá giảm dần</a>
        </div>
    </div>

    <div class="RAMFilter dropdown">
        <button class="dropbtn">Bộ nhớ Ram</button>
        <div id = "3" class="dropdown-content">
            <a ram-filter="2">2 GB</a>
            <a ram-filter="4">4 GB</a>
            <a ram-filter="8">8 GB</a>
            <a ram-filter="16">16 GB</a>
            <a ram-filter="32">32 GB trở lên</a>
        </div>
    </div>
    <div class="ROMFilter dropdown">
        <button class="dropbtn">Bộ nhớ Rom</button>
        <div id = "4" class="dropdown-content">
            <a rom-filter="32">32 GB</a>
            <a rom-filter="64">64 GB</a>
            <a rom-filter="128">128 GB</a>
            <a rom-filter="256">256 GB</a>
            <a rom-filter="512">512 GB trở lên</a>
        </div>
    </div>
</div>
<div class="choosedFilter flexContain">
    
</div>
<style>
    .center-container {
        text-align: center; /* Căn giữa nội dung */
    }
    #filterButton {
        background-color: #4CAF50; /* Màu nền */
        color: white; /* Màu chữ */
        padding: 10px 20px; /* Đệm nhỏ hơn */
        text-align: center; /* Căn lề chữ */
        text-decoration: none; /* Loại bỏ gạch chân */
        display: inline-block;
        font-size: 16px; /* Cỡ chữ */
        margin: 4px 2px; /* Khoảng cách xung quanh */
        cursor: pointer; /* Biến đổi con trỏ khi di chuột qua */
        border-radius: 4px; /* Bo góc */
    }
</style>

<div class="center-container">
    <button id="filterButton"><i class="fas fa-filter button-icon"></i>Lọc sản phẩm</button>
</div>

<script>

</script>

<!-- thực hiện chức năng lọc sản phẩm -->
<script>
    document.getElementById('filterButton').addEventListener('click', function() {
        // Lấy URL hiện tại
        var url = new URL(window.location.href);

        // Lấy phần sau dấu chấm hỏi
        var queryString = url.search;

        console.log(queryString);
        FilterProducts(queryString)
    });
// Định nghĩa hàm FilterProducts
async function FilterProducts(queryString) {
    try {
        const response = await fetch('/api/filter' + queryString);
        // in ra url
        console.log('/api/filter' + queryString);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const text = await response.text();
        console.log('Server response:', text); // Ghi lại phản hồi từ máy chủ
        const result = JSON.parse(text);

        const productsContainer = document.getElementById('products');
        productsContainer.innerHTML = '';
        if (result.status === 'error') {
            console.error('API Error:', result.message);
            alert('Có lỗi khi tải sản phẩm: ' + result.message);
        } else if (result.data.length == 0) {
            productsContainer.innerHTML = `
            <p style="font-size: 20px; color: red; font-weight: bold; text-align: center;">
              Không có sản phẩm nào! <span style="color: blue;"><a href="/">Quay lại trang chủ</a></span>
            </p>
            `;
        } else {
            // Hiển thị các sản phẩm
            result.data.forEach(product => {
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
    } catch (error) {
        console.error('Error:', error);
    }
    document.getElementById('loadMore').style.display = 'none';
}
</script>
