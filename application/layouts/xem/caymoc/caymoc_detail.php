<?php
    echo $this->headMeta();
    echo $this->headLink();

    $mamoc = $this->param->getParam("mamoc");
    
    $cm= new Model_Caymoc();
    $caymoc = $cm->getWhere($mamoc);

    if($caymoc)
    {    
        $maincontent = array();
        $title = array("Mã Mộc","Số Kg Sợi","Loại Vải","Số Mét Vải","Tùy Chỉnh","Nhập Kho",);
        
        $loaivai = new Model_Loaivai();
        
        $data = new My_Data();
        $khohang = new Model_Khohang();
        
        $loaivairow = $loaivai->getWhere($caymoc['MaVai']);
        $chinhsua = '<a href="'.HOST_PROJECT."/index/chinhsua/caymoc/true/mamoc/".$caymoc['MaMoc'].'/option/caymoc/">Sửa</a>&nbsp|&nbsp'.'<a href="'.HOST_PROJECT."/index/xoa/caymoc/true/mamoc/".$caymoc['MaMoc'].'/option/xem/" onclick="return confirm('."'bạn có chắc muốn xóa ?'".')">Xóa</a>';
        //$button= "<a class ='thembutton' href='".HOST_PROJECT."/index/nhaplieu/nhapmoc/true/mamoc/".$caymoc['MaMoc']."'/>Nhập Kho</a>";
        $button= "<a class ='thembutton' href='".HOST_PROJECT."/index/xem/caymoc_detail/true/mamoc/".$caymoc['MaMoc']."'/>Nhập Kho</a>";
        $nhapkho = "";
        if($caymoc['MaKhoMoc'])
                $nhapkho = "&nbspĐã Nhập";
        else
            $nhapkho =  $button;
        //$khohangrow = $khohang->getWhere($caymoc['MaKho'])[0];
        $content = array(
            $caymoc['MaMoc'],$caymoc['SoKgSoi'],$loaivairow['TenLoaiVai'],
            $caymoc['SoMetVai'],$chinhsua,$nhapkho
        );
        $maincontent[] = $content;
    }
    $table = $data->createTable($title, $maincontent,"600px");
    echo $table;

    require_once APPLICATION_PATH.'/layouts/nhap/chonkhomoc.php';
    