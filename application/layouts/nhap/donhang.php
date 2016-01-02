<?php 
    echo $this->headMeta();
    echo $this->headLink();

    $form = new Form_Formmoi_Donhang(); 
    if($this->param->isPost())
    {
        $param = $this->param->getPost();

        $check = new Form_Valid_Donhang($param); 
        if($check->valid($param)){
            $mydate = Zend_Locale_Format::getDate($this->param->getParam("ngaydathang"),array("date_format"=>"dd.MM.yyyy"));
            $date_str =  $mydate['year']."-". $mydate['month']."-". $mydate['day']; 

            $mavai = $this->param->getParam("mavai");
            $sometvai = $this->param->getParam("sometvai");
            $vai = new Model_Loaivai();
            $loaivai = $vai->getWhere($mavai);
            $tongtien = $sometvai * $loaivai['Gia'];
            $data = array(
                "MaDonHang"=>null,
                "MaVai"=>$mavai,
                "MaMau"=>$this->param->getParam("mamau"),
                "NgayDat"=>$date_str,
                "TienDatHang"=>$tongtien,
                "SoMetVai"=>$sometvai,
                "MaKhachHang"=>$this->param->getParam("makhachhang"),
            );
            $dh = new Model_Donhang();
            $dh->insert_donhang($data);

            $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $_redirector->gotoUrl(HOST_PROJECT."/index/xem/donhang/true");
            
            
//             if(array_key_exists('congty',$this->param->getParams()))
//             {
//                 $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
//                 $_redirector->gotoUrl(HOST_PROJECT."/index/main/congty/true");
//             }
//             else if(!array_key_exists('option',$this->param->getParams()))
//             {
//                 $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
//                 $_redirector->gotoUrl(HOST_PROJECT."/index/main/khachhang_detail/true/makhachhang/".$this->param->getParam("makhachhang"));
//             }
//             else
//             {
//                 $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
//                 $_redirector->gotoUrl(HOST_PROJECT."/index/xem/donhang/true");
//             }
            
        }
        else{
            $form->populate($param);
            echo $form;
            echo "<div class='message'>";
            foreach($check->messages as $item)
            {
                echo $item."<br/>";
            }
            echo "</div>";
        }
    }
    else{
        echo $form;
    }
?>
