<?php 
    echo $this->headMeta();
    echo $this->headLink();

    $caymoc =new Model_Caymoc();
    
    $makhoisoi = $this->param->getParam("makhoisoi");
    $khosoi = new Model_Khosoi();
    $khosoirow = $khosoi->getWhere($makhoisoi);

    $form = new Form_Formmoi_Caymoc(); //sua lai
    $form->createForm($makhoisoi);
    
    if($this->param->isPost())
    {   
        $param = $this->param->getPost();

        if(!array_key_exists('1', $param))
        {
            $check = new Form_Valid_Caymoc($param,$khosoirow['SoTanSoi']); 
            if($check->valid($param)){
                
                $form->populate($param);
                echo $form;
                $socaymoc = $this->param->getParam("socaymoc");
                $mavai =  $this->param->getParam("mavai");
                $sotansoi =  $this->param->getParam("sotansoi");
                $tongsomet=  $this->param->getParam("tongsometvai");
                
                $formmoc = new Form_Formmoi_Caymoc();
                $formmoc->createCayMoc($socaymoc,$mavai,$sotansoi,$tongsomet,$param);
                echo $formmoc;
            }
            else
            {
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
        else 
        {
            echo "<pre>";
            print_r($param);
            echo "</pre>";
            
            $data = new My_Data();
            $valid = $data->isValidCaymoc($param);
            
            $change = false;
            $malo = $caymoc->getMaxMaLo() + 1;

            if(!is_array($valid))
            {
                echo "nhập đúng";                
            }
            else 
            {
                echo "<div class='message'> ";
                echo $valid[0];
                echo "</div>";
            }
                
            
//             if($valid=='123')
//             foreach ($param as $key=>$item)
//             {
//                 if($item!=null&& $key!='them' && $key !='mavai' && $key !='sotan')
//                 {
//                     $change = true;
//                     $data = array(
//                         "MaMoc"=>null,
//                         "MaVai"=>$this->param->getParam("mavai"),
//                         "SoMetVai"=>$item,
//                         "MaKhoSoi"=>$khosoirow['MaKhoSoi'],
//                         "MaLo"=>$malo,
//                     );
//                     echo 123;
//                     $caymoc->insert_caymoc($data);
//                     echo "<pre>";
//                     print_r($khosoirow);
//                     echo "</pre>";
//                 }
//             }
//             if($change)
//             {
//                 $update = array("SoTanSoi"=>($khosoirow['SoTanSoi'] - $param['sotan']));
//                 $khosoi->update_data($khosoirow['MaKhoSoi'], $update);
//             }
//             $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
//             $_redirector->gotoUrl(HOST_PROJECT."/index/xem/caymoc/true");
            
        }
        
    }
    else{
        echo $form;
    }
?>
