<!-- kế thừ html layout -->
<?php
$title = 'Thế giới điện thoại - Trung tâm bảo hành';
ob_start();
?>
<!-- nội dung trong thẻ body -->
<!-- thêm topnav -->
<?php include 'top_nav.php'; ?>
    <!-- thêm header -->
<?php include 'header.php'; ?>
 <section class="header">
    <section style="min-height: 85vh">

        <table>
            <tr>
                <td colspan="4" class="header-table">
                    <marquee behavior="scroll" direction=left>Các trung tâm bảo hành của Smartphone Store</marquee>
                </td>
            </tr>
            <tr>
                <th class="col1">STT</th>
                <th class="col2">Địa chỉ</th>
                <th class="col3">Điện thoại</th>
                <th class="col4">Thời gian làm việc</th>
            </tr>
    
            <script>
                var trungtam = [
                    ["10F2, Hồ Trung Thành, P7 – Tp. Cà Mau, Tỉnh Cà Mau"       , "(0780)-2212 158" , "8h00 - 17h00"],
                    ["14A2 Trần Nguyên Hãn, P.Mỹ Long, Long Xuyên, An Giang"    , "076.3841649"     , "8h00 - 17h00"],
                    ["114 Tô Hiệu, Quận Lê Chân, Tp. Hải Phòng"                 , "(031)-384 7689"  , "8h00 - 17h00"],
                    ["32 Lương Khánh Thiện, Tp. Hải phòng"                      , "0924713257"      , "8h00 - 17h00"],
                    ["123 Nam Kỳ Khởi Nghĩa, Tp. Vũng Tàu, Tỉnh BRVT"           , "(064)-3531 248"  , "8h00 - 17h00"],
                    ["157 Ngô Gia Tự, Phường Ngô Quyền, TP Bắc Giang"           , "(0240)-3820 349" , "8h00 - 17h00"],
                    ["32 Lương Khánh Thiện, Tp. Hải phòng"                      , "(0781)-3827 676" , "8h00 - 17h00"],
                    ["139 Nguyễn Văn Cừ, Tp. Bắc Ninh, Tỉnh Bắc Ninh"           , "(0241)-3812767"  , "8h00 - 17h00"],
                    ["39 Nguyễn Đình Chiểu, P 1, Tx. Bến Tre, Tỉnh Bến Tre"     , "(075)-3814 701"  , "8h00 - 17h00"],
                    ["10A, Lý Thường Kiệt, Tp. Quy Nhơn, Tỉnh Bình Định"        , "(056)-3821 788"  , "8h00 - 17h00"],
                    ["42 Phố 11 Vân Giang, P. Vân Giang, Tp. Ninh Bình"         , "(030)-389 3408"  , "8h00 - 17h00"],
                    ["283 Cách Mạng Tháng Tám, TX.Thủ Dầu Một, Tỉnh Bình Dương" , "0650.3831528"    , "8h00 - 17h00"],
                    ["47 Khu 2, P. Phước Bình, Tx. Phước Long, Bình Phước"      , "(0651)-3774 789" , "8h00 - 17h00"],
                    ["20 Nguyễn Hội P.Phú Trinh Tp.Phan Thiết, Tỉnh Bình Thuận" , "062.382853"      , "8h00 - 17h00"],
                    ["76 Nguyễn Đình Chiểu, P 2, Tp. Cao Lãnh, Đồng Tháp"       , "(067)-3874 686"  , "8h00 - 17h00"]
                ]
    
                for (var i = 0; i < trungtam.length; i++) {
                    var link = 'https://maps.google.com/maps?q=' + trungtam[i][0];
                    document.write(`
                        <tr>
                            <td class="col1">` + (i + 1) + `</td>
                            <td class="col2"> 
                                <a href="`+link+`" target="_blank" title="Xem bản đồ">
                                    ` + trungtam[i][0] +`
                                </a>
                            </td>
                            <td class="col3">` + trungtam[i][1] +`</td>
                            <td class="col4">` + trungtam[i][2] +`</td>
                        </tr>
                    `)
                }
            </script>
        </table>
    
    </section>
 </section>
 <!-- thêm footer -->
<?php include 'footer.php'; ?>
<!-- kết thừa lay -->
<?php
$content = ob_get_clean();
include 'base.php';
?>