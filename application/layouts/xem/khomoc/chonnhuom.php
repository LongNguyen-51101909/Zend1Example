<?php
    echo $this->headMeta();
    echo $this->headLink();
    
    Zend_Session::start();
    $mysession = new Zend_Session_Namespace('Zend_Auth');
    $router = Zend_Controller_Front::getInstance()->getRouter();
    $num = new Zend_Validate_Digits();
    
    $data= new My_Data();
    $num = new Zend_Validate_Digits();
    $caymoc = new Model_Caymoc();
    $lonhuom = new Model_Lonhuom();
    $caytp = new Model_Caythanhpham();
    $loaivai = new Model_Loaivai();
    
    $param = $this->param->getPost();
    $formtp = new Form_Formmoi_Taotp();
    
    
    if($this->param->isPost())
    {
        
//         echo "<pre>";
//         print_r($param);
//         echo "</pre>";
    
        if(array_key_exists('bochon', $param))
        {
            // bo chon trong session
            foreach ($param as $key => $item)
            {
                if($item== 1 && $num->isValid($key) && in_array($key, $mysession->checked))
                {
                    foreach ($mysession->checked as $skey =>$sitem)
                    {
                        if($sitem == $key)
                        {
                            unset($mysession->checked[$skey]);
                        }
                    }
    
                }
            }
        }
    }
    
    ?>
            <div class="main">
                <div style='float: left'>
                <?php 
                    $formlonhuom = new Form_Formmoi_Chonnhuom();
                    echo $formlonhuom;
                   
                    if($this->param->isPost())
                    {
                        // chon lo nhuom
                        if(in_array("Chọn", $param))
                        {
                            foreach ($param as $key=>$item)
                            {
                                if($item == "Chọn")
                                {
                                    $lonhuomrow = $lonhuom->getWhere($key);
                                    if($lonhuomrow['SoCayNhuom']<count($mysession->checked))
                                    {
                                        echo "<div class='message'>";
                                        echo "Số cây nhuộm vượt quá số lượng có thể nhuộm";
                                        echo "</div>";
                                    }
                                    else 
                                    {
                                        //echo "xu ly lo nhuom";
                                        
                                        $formtp->createForm($key);
                                        echo $formtp;
                                    }
                                        
                                }
                            }
                        }
                        else if(array_key_exists('them', $param))
                        {
                            // them cay thanh pham
                            
                            $message = '';
                            foreach ($param as $key => $item)
                            {
                                if($num->isValid($key))
                                {
                                    if( $item == null )
                                    {
                                        $message = 'Số Mét Thành Phẩm không được bỏ trống';
                                        break;
                                    }
                                    
                                    if(!$num->isValid($item) || $item == 0)
                                    {
                                        $message = 'Số Mét Thành Phẩm phải là số dương';
                                        break;
                                    }
                                    
                                }
                            }
                            
                            if($message =='')
                            {
                                // them cay tp
                                $malonhuom = $param['malonhuom'];
                                $formtp->createForm($malonhuom);
                                $formtp->populate($param);
                                echo $formtp;
                                echo"nhap dung";
                                
                                
                                foreach ($param as $key=>$item)
                                    if($num->isValid($key))
                                    {
                                        // them vao caytp
                                        $mydata= array('MaCTP'=>null,'SoMetVai'=>$item,
                                                       'MaKhoTP'=>$param['khotp']);
                                        $caytp->insert($mydata);
                                        
                                        //update caymoc
                                        $maxindex = $caytp->getMaxIndex();
                                        $caymocrow = $caymoc->getWhere($key);
                                        $update = array('MaLoNhuom'=>$param['malonhuom'],'MaCTP'=>$maxindex);
                                        $caymoc->update_data($key, $update);
                                        echo "<script>window.location.href='".HOST_PROJECT."/index/xem/caythanhpham/true';</script>";
                                    }
                                    
                                $lonhuom->update_data($param['malonhuom'], array('TrangThai'=>1));
                                unset($mysession->checked);
                            }
                            else 
                            {
                                $malonhuom = $param['malonhuom'];
                                $formtp->createForm($malonhuom);
                                $formtp->populate($param);
                                echo $formtp;
                                
                                echo"<div class='long_message' style='margin:auto !important;width:400px !important;'>";
                                echo $message;
                                echo "</div>";
                            }
                        }
                    
                    
                    }
                    
                ?>
                </div>
                
                <div class = "right">
                <?php 
                    
                    if($mysession->checked!=null){
                        $formsesion = new Form_Formmoi_Subsession();
                        $formsesion->createForm(null);
                        echo $formsesion;
                    }
                ?>
                </div>
            </div>
      