<?php 
    echo $this->headMeta();
    echo $this->headLink();

    $form = new Form_Formmoi_Chonkhotp(); 
    if($this->param->isPost())
    {
        $param = $this->param->getPost();
//         echo "<pre>";
//         print_r($param);
//         echo "</pre>";
        $form->populate($param);
        echo $form;
        
        $makho = $this->param->getParam("mykhohang");
        
        
        $ctp= new Model_Caythanhpham();
        $loaivai = new Model_Loaivai();
        $lonhuom = new Model_Lonhuom();
        $mau = new Model_Mau();
        $caymoc = new Model_Caymoc();
        $khohang = new Model_Khohang();
        
        $caythanhphamall = $ctp->getWhere_khohang($makho);
        if($caythanhphamall)
        {
            $maincontent = array();
            $title = array("Mã Cây TP","Loại Vải","Màu Vải","Số Mét Vải","Tùy Chỉnh");
        
            $data = new My_Data();
            $khotp = $khohang->getWhere($makho);
        
            echo '<h1 class="title">'.$khotp['TenKho'].'</h1>';
            
            foreach ($caythanhphamall as $caytp)
            {
                $caymocrow = $caymoc->getWhere_ctp($caytp['MaCTP']);
                $loaivairow = $loaivai->getWhere($caymocrow['MaVai']);
                $lonhuomrow = $lonhuom->getWhere($caymocrow['MaLoNhuom']);
                
        
                $maurow = $mau->getWhereIdMau($lonhuomrow['MaMau']);
                $chinhsua = '<a href="'.HOST_PROJECT."/index/chinhsua/caytp/true/mactp/".$caytp['MaCTP'].'/option/caytp/">Sửa</a>&nbsp|&nbsp'.'<a href="'.HOST_PROJECT."/index/xoa/caytp/true/mactp/".$caytp['MaCTP'].'/option/ctp/" onclick="return confirm('."'bạn có chắc muốn xóa ?'".')">Xóa</a>';
                $button= "<a class ='thembutton' href='".HOST_PROJECT."/index/xem/ctp_detail/true/mactp/".$caytp['MaCTP']."'/>Nhập Kho</a>";
                $content = array(
                    $caytp['MaCTP'],$loaivairow['TenLoaiVai'], $maurow['TenMau'], $caytp['SoMetVai'],
                    $chinhsua
                );
                $maincontent[]=$content;
            }
            $table = $data->createTable($title, $maincontent,"550px");
            echo $table;
        }
        else
        {
            echo "<div class='message'>";
            echo "Trong kho hết Cây Thành Phẩm";
            echo "</div>";
        }
    }
    else{
        echo $form;
    }
?>
