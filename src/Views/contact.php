<!-- kế thừ html layout -->

<!-- thay đổi title -->
<?php
$title = 'Thế giới điện thoại - Liên hệ';
ob_start();
?>
<!-- nội dung trong thẻ body -->
<!-- thêm topnav -->
 <?php include 'top_nav.php'; ?>
    <!-- thêm header -->
 <?php include 'header.php'; ?>
 <div class="body-lienhe">
    <div class="lienhe-header">Liên hệ</div>
    <div class="lienhe-info">
        <div class="info-left">
            <p>
                <h2 style="color: gray">Lập trình web</h2><br />
                <b>Địa chỉ:</b>
                <br />
                Cơ sở 1: Số 2, Đường D3, Phường 25, Quận Bình Thạnh, TP.HCM<br />
                Cơ sở 2: Số 17, Đường Trần Não, Phường Bình An, Quận 2, TP.HCM<br />
                Cơ sở 3: Đường Tô Ký, Phường Tân Chánh Hiệp, Quận 12, TP.HCM<br />
                Cơ sở 4: Số 5/1, Đường Nguyễn Thái Học, Phường 7, Thành phố Vũng Tàu<br /><br />
                <b>Telephone:</b> 123456789<br /><br />
                <b>Hotline:</b> 123456789<br /><br />
                <b>Website:</b> <a href="http://www.ut.edu.vn">ut.edu.vn</a><br /><br />
                <b>E-mail:</b> nnt33@gmail.com<br /><br />
                <b>Mã số thuế:</b> 123456789<br /><br />
                <b>Tài khoản ngân hàng:</b> NGUYEN NGOC TAM<br /><br />
                <b>Số TK:</b> 09096969696666<br /><br />
                <b>Tại Ngân hàng:</b> MB BANK<br /><br /><br /><br />
                <b>Quý khách có thể gửi liên hệ tới chúng tôi bằng cách hoàn tất biểu mẫu dưới đây. Chúng tôi
                    sẽ trả lời thư của quý khách, xin vui lòng khai báo đầy đủ. Hân hạnh phục vụ và chân thành
                    cảm ơn sự quan tâm, đóng góp ý kiến đến Trường Đại học Giao thông Vận tải TP.HCM.</b>
            </p>
            
        </div>
        <div class="info-right">
            <iframe width="100%" height="450" src="https://maps.google.com/maps?width=100%&amp;height=450&amp;hl=en&amp;q=Tr%C6%B0%E1%BB%9Dng%20%C4%90%E1%BA%A1i%20H%E1%BB%8Dc%20Giao%20Th%C3%B4ng%20V%E1%BA%ADn%20T%E1%BA%A3i%20Th%C3%A0nh%20Ph%E1%BB%91%20H%E1%BB%93%20Ch%C3%AD%20Minh%20-%20C%C6%A1%20s%E1%BB%9F%203&amp;ie=UTF8&amp;t=&amp;z=16&amp;iwloc=B&amp;output=embed"
                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/create-google-map/">Embed
                    Google Map
                </a>
            </iframe>
            <br />
        </div>
    </div>
    <div class="lienhe-info">

        <div class="guithongtin">
            <p style="font-size: 22px; color: gray">Gửi thông tin liên lạc cho chúng tôi: </p>
            <hr />
            <form name="formlh" method="post">
                <table cellspacing="10px">
                    <tr>
                        <td>Họ và tên</td>
                        <td><input type="text" name="ht" size="40" maxlength="40" placeholder="Họ tên"
                                autocomplete="off" required></td>
                    </tr>
                    <tr>
                        <td>Điện thoại liên hệ</td>
                        <td><input type="text" name="sdt" size="40" maxlength="11" minlength="10" placeholder="Điện thoại"
                                required></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ Email</td>
                        <td><input type="email" name="em" size="40" placeholder="Email" autocomplete="off"
                                required></td>
                    </tr>
                    <tr>
                        <td>Tiêu đề</td>
                        <td><input type="text" name="tde" size="40" maxlength="100" placeholder="Tiêu đề"
                                required>
                    </tr>
                    <tr>
                        <td>Nội dung</td>
                        <td><textarea name="nd" rows="5" cols="44" maxlength="500" wrap="physical"
                                placeholder="Nội dung liên hệ" required></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit">Gửi thông tin liên hệ</button></td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
</div>
 <!-- thêm footer -->
<?php include 'footer.php'; ?>
<?php
$content = ob_get_clean();
include 'base.php';
?>