<?php
    Zend_Session::start();
    $mysession = new Zend_Session_Namespace('XuLyDonHang');

    $param = $this->param->getParams();
    
    $madonhang = $param['madonhang'];
    $num = new Zend_Validate_Digits();
    
    if($mysession->checktp != null)
    {
        if($mysession->checktp['madonhang'] != $madonhang)
        {
            unset($mysession->checktp);
            $mysession->checktp['madonhang'] = $madonhang;
        }    
    }
    else 
    {
        $mysession->checktp['madonhang'] = $madonhang;
    }
    
    if(array_key_exists('chon', $param))
    {
        // them cac phan tu chon vao mysession
        foreach ($param as $key=>$item)
        {
            if($num->isValid($key) && $item==1 && !in_array($key, $mysession->checktp))
            {
                $mysession->checktp[] = $key;
            }
        }
    }
    else if(array_key_exists('bochon', $param))
    {
        // them cac phan tu chon vao mysession
        foreach ($param as $key=>$item)
        {
            if($num->isValid($key) && $item==1 && in_array($key, $mysession->checktp))
            {
                foreach ($mysession->checktp as $skey => $sitem)
                {
                    if($key== $sitem)
                        unset($mysession->checktp[$skey]);
                }
            }
        }
    }
    
//     echo "<pre>";
//     print_r($mysession->checktp);
//     echo "</pre>";
    
    $dh= new Model_Donhang();
    $donhang = $dh->getWhere($madonhang);
    $loaivai = new Model_Loaivai();
    $mau = new Model_Mau();
    $kh = new Model_Khachhang();
    $data = new My_Data();
    
    
    // thong tin don hang
    $title = array("Mã Đơn Hàng","Loại Vải","Màu Vải","Số Mét Vải","Ngày Đặt","Tiền Đặt Hàng","Khách Hàng");
    $loaivairow = $loaivai->getWhere($donhang['MaVai']);
    $maurow = $mau->getWhereIdMau($donhang['MaMau']);
    $khachhang = $kh->getWhere($donhang['MaKhachHang']);
    $mydate = Zend_Locale_Format::getDate($donhang['NgayDat'],array("date_format"=>"yyyy.MM.dd"));
    $date_str =  $mydate['day']."/".$mydate['month']."/".$mydate['year'] ;
    $tien = $data->convertCurrency($donhang['TienDatHang']);
    $content = array(
        $donhang['MaDonHang'],$loaivairow['TenLoaiVai'],$maurow['TenMau'],$donhang['SoMetVai'],
        $date_str,$tien,
        $khachhang['TenKhachHang']
    );
    
    $query = $data->createTable($title, $content, '750');
    echo $query;
    
    
    
    $form = new Form_Formmoi_Chonkhotp();
    if($this->param->isPost())
    {
        $param = $this->param->getPost();
        $form->populate($param);
        echo $form;
    
        $makho = $this->param->getParam("mykhohang");
    
//         echo "<pre>";
//         print_r($param);
//         echo "</pre>";
    
        $ctp= new Model_Caythanhpham();
        $loaivai = new Model_Loaivai();
        $lonhuom = new Model_Lonhuom();
        $mau = new Model_Mau();
        $caymoc = new Model_Caymoc();
        $khohang = new Model_Khohang();
    
        
    
?>

<div class="main">
            <div style='float: left'>
            <?php 
                $formctp = new Form_Formmoi_Choncaytp();
                $formctp->createForm($makho,$madonhang);
                echo $formctp;
            ?>
            </div>
            
            <div class = "right">
            <?php 
            
                if(count($mysession->checktp)>1)
                {
                    $formsession = new Form_Formmoi_Ctpsession();
                    $formsession->createForm($makho);
                    echo $formsession;
                }
            ?>
            </div>
</div>
<?php 
    }
    else{
        echo $form;
    }
?>
