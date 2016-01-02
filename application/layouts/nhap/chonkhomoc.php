<?php 
    echo $this->headMeta();
    echo $this->headLink();
    
    $form = new Form_Formmoi_Chonkhomoc();
    if($this->param->isPost())
    {
        $param = $this->param->getPost();

        // makhohang la ma cua kho moc se nhap 
        $makhohang = $this->param->getParam("mykhohang");
        
        //ma moc la ma cay moc
        $mamoc = $this->param->getParam("mamoc");
        
        $caymoc = new Model_Caymoc();
        $caymocrow = $caymoc->getWhere($mamoc);
        
        
        $khosoi = new Model_Khosoi();
        $khosoirow = $khosoi->getWhere($caymocrow['MaKhoSoi']);
        

            
        // update kho moc cho cay moc
        $update = array("MaKhoMoc"=>$makhohang);
        $caymoc->update_data($mamoc, $update);
        
        $khomoc= new Model_KhoMoc();
        $khomocrow = $khomoc->getWhere_khohang($makhohang);
        if($khomocrow)
        {
            $makhomoc = "";
            foreach ($khomocrow as $item)
            {
                if($item['MaVai'] == $caymocrow['MaVai'])
                    $makhomoc = $item['MaKhoMoc'];
            }
            if($makhomoc != "")
            {
                $updatemoc = array("SoCayMoc"=>($khomocrow['SoCayMoc']+1),
                                   "TongSoMet"=>($khomocrow['TongSoMet']+$caymocrow['SoMetVai']),
                );
                $khomoc->update_data($makhomoc, $updatemoc);
                echo "<script>window.location.href='".HOST_PROJECT."/index/xem/caymoc/true';</script>";
            }
        }
        
        // neu khong co loai vai trong kho moc thi them moi
        
        $data = array(
                        "MaKhoMoc"=>null,
                        "MaVai"=>$caymocrow['MaVai'],
                        "SoCayMoc"=>1,
                        "TongSoMet"=>$caymocrow['SoMetVai'],
                        "MaKho"=>$makhohang
                    );
        $khomoc->insert_kho($data);
        echo "<script>window.location.href='".HOST_PROJECT."/index/xem/caymoc/true';</script>";
    
        
    }
    else{
        echo $form;
    }
    ?>
