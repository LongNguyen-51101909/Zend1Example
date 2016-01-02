<?php 
    echo $this->headMeta();
    echo $this->headLink();

    $caymoc =new Model_Caymoc();
    
    $makhoisoi = $this->param->getParam("makhoisoi");
    $khosoi = new Model_Khosoi();
    $khosoirow = $khosoi->getWhere($makhoisoi);

    $form = new Form_Formmoi_Caymoc(); //sua lai
    $form->createForm($makhoisoi);
    
    $formmoc = new Form_Formmoi_Caymoc();
    
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
                $tongsomet =  $this->param->getParam("tongsometvai");
                $khomoc = $this->param->getParam("khomoc");
                $formmoc->createCayMoc($socaymoc,$mavai,$sotansoi,$tongsomet,$khomoc);
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
            
            $socaymoc = $param["soluong"];
            $mavai =  $param["mavai"];
            $sotansoi =  $param["sotan"];
            $tongsomet =  $param["tongsomet"];
            $khomoc =  $param["khomoc"];
            
            $thongso = array('sotansoi'=>$sotansoi,'mavai'=>$mavai,
                             'socaymoc'=>$socaymoc,'tongsometvai'=>$tongsomet,
                             'khomoc'=>$khomoc
                            );
            $form->populate($thongso);
            echo $form;
            
            $formmoc->createCayMoc($socaymoc,$mavai,$sotansoi,$tongsomet,$khomoc);
            
            $data = new My_Data();
            $valid = $data->isValidCaymoc($param);
            
            $change = false;
            $malo = $caymoc->getMaxMaLo() + 1;
            $num = new Zend_Validate_Digits();
            
            if(!is_array($valid))
            {
                foreach ($param as $key=>$item)
                {
                    if($num->isValid($key))
                    {
                        $change = true;
                        $data = array(
                            "MaMoc"=>null,
                            "MaVai"=>$mavai,
                            "SoMetVai"=>$item,
                            "MaKhoSoi"=>$khosoirow['MaKhoSoi'],
                            "MaLo"=>$malo,
                            'MaKhoMoc'=>$khomoc
                        );
                        $caymoc->insert_caymoc($data);
                    }
                }
                if($change)
                {
                    $update = array("SoTanSoi"=>($khosoirow['SoTanSoi'] - $param['sotan']));
                    $khosoi->update_data($khosoirow['MaKhoSoi'], $update);
                }
                $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                $_redirector->gotoUrl(HOST_PROJECT."/index/xem/caymoc/true");               
            }
            else 
            {
                
                $formmoc->populate($param);
                echo $formmoc;
                echo "<div class='small_message'> ";
                echo $valid[0];
                echo "</div>";
            }
                
        }
        
    }
    else{
        echo $form;
    }
?>
