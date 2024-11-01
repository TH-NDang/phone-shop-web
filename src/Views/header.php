<section class="header">
    <div class="header group">
        <div class="logo">
            <a href="/">
                <img src="assets/store/logo.jpg" alt="Trang chủ Smartphone Store"
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
                            window.location.href = "{% url 'search' %}?keyword=" + encodeURIComponent(keyword);
                        });
                    </script>

                </form> <!-- End Form search -->
                <div class="tags">
                    <strong>Từ khóa: </strong>
                    <a href="{% url 'search' %}?keyword=Samsung">Samsung</a>
                    <a href="{% url 'search' %}?keyword=Iphone">iPhone</a>
                    <a href="{% url 'search' %}?keyword=Vivo" >Vivo</a>
                    <a href="{% url 'search' %}?keyword=Oppo" >Oppo</a>
                    <a href="{% url 'search' %}?keyword=Masstel" >Masstel</a>
                </div>
            </div> <!-- End Search header -->
            <div class="tools-member" >
            <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true): ?>
                <div class="member" onmouseover="showPopup()" onmouseout="hidePopup()">
                    <a>
                        <i class="fas fa-user"></i>

                    </a>
                    <script>
                        fetch('/api/get_username/')
                            .then(response => response.json())
                            .then(data => {
                                document.querySelector('.member a').innerHTML = `<i class="fas fa-user"></i> ${data.username}`;
                            });
                    </script>
                    
                    <div class="popup hide" id="userOptionsPopup">
                        <a href="/customer/">Tài khoản của tôi</a>
                        <a href="/cart/">Giỏ hàng</a>
                        <a onclick="if(window.confirm('Xác nhận đăng xuất ?')) logOut();">Đăng xuất</a>
                    </div>

                </div> <!-- End Member -->
                <?php else: ?>
                <div class="containTaikhoan" style="transform: scale(0);">
                    <span class="close" onclick="closePopup();">×</span>
                    <div class="taikhoan">

                        <ul class="tab-group">
                            <li class="tab active"><a href="#login">Đăng nhập</a></li>
                            <li class="tab"><a href="#signup">Đăng kí</a></li>
                        </ul> <!-- /tab group -->

                        <div class="tab-content">
                            <div id="login">
                                <h1>Chào mừng bạn trở lại!</h1>

                                <form action="/api/login/" method="post" id="loginForm">
                                    <div class="field-wrap">
                                        <label>
                                            Email đăng nhập<span class="req">*</span>
                                        </label>
                                        <input id="email" name="email" type="text" required autocomplete="off">
                                    </div> <!-- /user name -->
                                
                                    <div class="field-wrap">
                                        <label>
                                            Mật khẩu<span class="req">*</span>
                                        </label>
                                        <input id="password" name="password" type="password" required autocomplete="off">
                                    </div> <!-- pass -->
                                    <button class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                                        <i class="fab fa-google me-2"></i> <a href="{% url 'social:begin' 'google-oauth2' %}" >Đăng nhập với tài khoản Google</a> 
                                    </button>
                                    <p class="forgot"><a href="/password_reset/">Quên mật khẩu?</a></p>
                                
                                    <button type="submit" class="button button-block">Tiếp tục</button>
                                </form> <!-- /form -->
                                    
                                

                            </div> <!-- /log in -->

                            <div id="signup">
                                <h1>Đăng kí miễn phí</h1>

                                <form>

                                    <div class="top-row">
                                        <div class="field-wrap">
                                            <label class="">
                                                Họ<span class="req">*</span>
                                            </label>
                                            <input name="ho" type="text" required="" autocomplete="off">
                                        </div>
            
                                        <div class="field-wrap">
                                            <label>
                                                Tên<span class="req">*</span>
                                            </label>
                                            <input name="ten" type="text" required="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="field-wrap">
                                        <label>
                                            Địa chỉ Email<span class="req">*</span>
                                        </label>
                                        <input name="email" type="email" required="" autocomplete="off">
                                    </div> <!-- /email -->
                                    <div class="field-wrap">
                                        <label>
                                            Số điện thoại<span class="req">*</span>
                                        </label>
                                        <input name="soDienThoai" type="tel" required="" autocomplete="off">
                                    </div> <!-- /phone number -->


                                    <div class="field-wrap">
                                        <label>
                                            Mật khẩu<span class="req">*</span>
                                        </label>
                                        <input name="newPass" type="password" required="" autocomplete="off">
                                    </div> <!-- /pass -->

                                    <button type="submit" class="button button-block">Tạo tài khoản</button>

                                </form> <!-- /form -->

                            </div> <!-- /sign up -->
                        </div><!-- tab-content -->

                    </div> <!-- /taikhoan -->
                </div>
                <div class="member">
                    <a onclick="checkLogin()">
                        <i class="fas fa-user"></i>
                        Tài khoản
                    </a>
                    <div class="menuMember hide">
                        <a href="nguoidung.html">Trang người dùng</a>
                        <a onclick="if(window.confirm('Xác nhận đăng xuất ?')) logOut();">Đăng xuất</a>
                    </div>

                </div> <!-- End Member -->
                <?php endif; ?>


                <div class="cart">
                    <a href="/cart/">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                        <script>
                            updateCartCount()
                        </script>
                        <span class="cart-number"></span>
                    </a>
                </div> <!-- End Cart -->

                <!--<div class="check-order">
                        <a>
                            <i class="fa fa-truck"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </div> -->
            </div><!-- End Tools Member -->

        </div> <!-- End Content -->
    </div>
</section>