<?php
    echo $this->headMeta();
    echo $this->headLink();

    $loaivai = new Model_Loaivai();
    $mau = new Model_Mau();
    $dh= new Model_Donhang();
    $donhang = $dh->getAll();

    $data = new My_Data();
    if($donhang){
    
        $title = array("Mã Đơn Hàng","Loại Vải","Màu Vải","Số Mét Vải","Ngày Đặt","Tiền Đặt Hàng","Khách Hàng","Tùy Chỉnh","Giao Hàng");
        $content = array();
    
        foreach($donhang as $item)
        {
            
            $mydate = Zend_Locale_Format::getDate($item['NgayDat'],array("date_format"=>"yyyy.MM.dd"));
            $date_str =  $mydate['day']."/".$mydate['month']."/".$mydate['year'] ;
            $tien = $data->convertCurrency($item['TienDatHang']);
            $kh = new Model_Khachhang();
            $khachhang = $kh->getWhere($item['MaKhachHang']);
            $loaivairow = $loaivai->getWhere($item['MaVai']);
            $maurow = $mau->getWhereIdMau($item['MaMau']);
            $chinhsua = '<a href="'.HOST_PROJECT."/index/chinhsua/donhang/true/makhachhang/".$item['MaKhachHang']."/madonhang/".$item['MaDonHang'].'/option/donhang">Sửa</a>&nbsp|&nbsp'.'<a href="'.HOST_PROJECT."/index/xoa/donhang/true/makhachhang/".$item['MaKhachHang']."/madonhang/".$item["MaDonHang"].'/option/xem/" onclick="return confirm('."'bạn có chắc muốn xóa ?'".')">Xóa</a>';
            $giaohang = '<div class="giaohang"><a href="'.HOST_PROJECT."/index/xem/donhang/true/madonhang/".$item['MaDonHang'].'">Giao Hàng</a></div>';
            
            $subcontent = array(
                $item['MaDonHang'],$loaivairow['TenLoaiVai'],$maurow['TenMau'],$item['SoMetVai'],
                $date_str,$tien,$khachhang['TenKhachHang'],$chinhsua,$giaohang
            );
            $content[] = $subcontent;
        }
        $data = new My_Data();
        $table = $data->createTable($title,$content,"1100px");
        echo $table;
    }
    else
    {
        echo "<div class='message'>";
        echo "Chưa tồn tại đơn hàng";
        echo "</div>";
    }
    
?>