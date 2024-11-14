<section class="header">
    <div class="header group">
        <div class="logo">
            <a href="/">
                <img src="/assets/store/logo.jpg" alt="Trang chủ Smartphone Store"
                    title="Trang chủ Smartphone Store">
            </a>
        </div> <!-- End Logo -->

        <div class="content">
            <div class="search-header" id="searchHeader" style="position: relative; left: 162px; top: 1px;">
                <form class="input-search">
                    <div class="autocomplete">
                        <input id="search-box" name="search" autocomplete="off" type="text"
                            placeholder="Nhập từ khóa tìm kiếm...">
                        <button id="search-button" type="submit" title="Tìm kiếm">
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <div id="search-boxautocomplete-list" class="autocomplete-items">

                        </div>
                    </div>
                    <script>
                        document.getElementById('search-button').addEventListener('click', function (event) {
                            event.preventDefault();
                            const keyword = document.getElementById('search-box').value;
                            window.location.href = "/search?keyword=" + encodeURIComponent(keyword);
                        });
                    </script>

                </form> <!-- End Form search -->
                <div class="tags">
                    <strong>Từ khóa: </strong>
                    <a href="/search?keyword=Samsung">Samsung</a>
                    <a href="/search?keyword=Iphone">iPhone</a>
                    <a href="/search?keyword=Vivo" >Vivo</a>
                    <a href="/search?keyword=Oppo" >Oppo</a>
                    <a href="/search?keyword=Masstel" >Masstel</a>
                </div>
            </div> <!-- End Search header -->

            <div class="tools-member">
                <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']): ?>
                    <div class="member">
                        <a href="javascript:void(0);">
                            <i class="fas fa-user"></i>
                            <?php echo htmlspecialchars($_SESSION['customer_email'] ?? 'Tài khoản'); ?>
                        </a>
                        <div class="menuMember">
                            <a href="index.php?action=profile">Trang cá nhân</a>
                            <a href="javascript:void(0)" class="logout-btn">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="member">
                        <a href="javascript:void(0);" onclick="checkLogin()">
                            <i class="fas fa-user"></i>
                            Tài khoản
                        </a>
                    </div>
                <?php endif; ?>

                <div class="cart">
                    <a href="index.php?action=cart">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                        <span class="cart-number"></span>
                    </a>
                </div>
            </div>

<!-- Kiểm tra xem người dùng đã đăng nhập hay chưa -->
        <?php if (!isset($_SESSION['customer_id'])): ?>
        <!-- Form đăng nhập/đăng ký -->
        <div class="containTaikhoan">
            <div class="taikhoan">
                <span class="close">&times;</span>

                <ul class="tab-group">
                    <li class="tab active"><a href="#login">Đăng nhập</a></li>
                    <li class="tab"><a href="#signup">Đăng ký</a></li>
                </ul>

                <div class="tab-content">
                    <div id="login">
                        <h1>Chào mừng trở lại!</h1>
                        <form id="loginForm">
                            <div class="field-wrap">
                                <label>Email<span class="req">*</span></label>
                                <input type="email" name="email" required />
                            </div>

                            <div class="field-wrap">
                                <label>Mật khẩu<span class="req">*</span></label>
                                <input type="password" name="password" required />
                            </div>

                            <p class="forgot"><a href="index.php?action=forgot_password">Quên mật khẩu?</a></p>

                            <button type="submit" class="button button-block">Đăng nhập</button>
                        </form>
                    </div>

                    <div id="signup">
                        <h1>Đăng ký tài khoản</h1>
                        <form id="signupForm">
                            <div class="top-row">
                                <div class="field-wrap">
                                    <label>Họ<span class="req">*</span></label>
                                    <input type="text" name="first_name" required />
                                </div>
                                <div class="field-wrap">
                                    <label>Tên<span class="req">*</span></label>
                                    <input type="text" name="last_name" required />
                                </div>
                            </div>

                            <div class="field-wrap">
                                <label>Tên đăng nhập<span class="req">*</span></label>
                                <input type="text" name="username" required />
                            </div>

                            <div class="field-wrap">
                                <label>Email<span class="req">*</span></label>
                                <input type="email" name="email" required />
                            </div>

                            <div class="field-wrap">
                                <label>Mật khẩu<span class="req">*</span></label>
                                <input type="password" name="password" required />
                            </div>

                            <div class="field-wrap">
                                <label>Số điện thoại</label>
                                <input type="tel" name="tel" pattern="[0-9]{10}" />
                            </div>

                            <div class="field-wrap">
                                <label>Địa chỉ</label>
                                <textarea name="address" rows="3"></textarea>
                            </div>

                            <button type="submit" class="button button-block">Tạo tài khoản</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

            <div id="alert" style="display: none;"></div>
        </div><!-- End Tools Member -->

    </div> <!-- End Content -->
    </div>
</section>

<!-- Thêm script cho form đăng nhập/đăng ký -->
<script>
    $(document).ready(function () {
        // Xử lý chuyển tab
        $('.tab a').on('click', function (e) {
            e.preventDefault();

            // Loại bỏ active class từ tất cả các tab
            $('.tab').removeClass('active');
            // Thêm active class vào tab được click
            $(this).parent().addClass('active');

            // Ẩn tất cả các tab content
            $('.tab-content > div').hide();
            // Hiển thị tab content tương ứng
            $($(this).attr('href')).fadeIn(600);
        });

        // Hiệu ứng cho label
        $('.field-wrap input, .field-wrap textarea').on('focusin', function () {
            $(this).siblings('label').addClass('active highlight');
        }).on('focusout', function () {
            if ($(this).val().length === 0) {
                $(this).siblings('label').removeClass('active highlight');
            }
        });
    });
</script>
