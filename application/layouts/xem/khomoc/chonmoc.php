<?php 
    use Zend\Http\Client;
    echo $this->headMeta();
    echo $this->headLink();
    echo $this->headScript();
    
    Zend_Session::start();
    $mysession = new Zend_Session_Namespace('Zend_Auth');
    $router = Zend_Controller_Front::getInstance()->getRouter();
    $num = new Zend_Validate_Digits();
    
    $data= new My_Data();
    $caymoc = new Model_Caymoc();
    $loaivai = new Model_Loaivai();
    
//     echo "<pre>";
//     print_r($mysession->checked);
//     echo "</pre>";
    $form = new Form_Formmoi_Xemkhomoc();
    $formchon = new Form_Formmoi_Khomoc();
    $makho = $this->param->getParam("mykhohang");
    
    if($this->param->isPost())
    {
        $param = $this->param->getPost();

//         echo "<pre>";
//         print_r($param);
//         echo "</pre>";
        // truong hop bo chon session
        if($mysession->checked != null && array_key_exists("bochon", $param))
        {
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
        else if(array_key_exists("them", $param)) 
        {
            foreach ($param as $key=> $item)
            {
                if($num->isValid($key) && $item == 1)
                {
                    if(!$data->isExitInArray($mysession->checked,$key))
                        $mysession->checked[] = $key;
                }
            }
        }
        else if(array_key_exists("chonlonhuom", $param))
        {
            //echo "<script>window.location.href='".HOST_PROJECT."/index/xem/khomoc/true/chonlonhuom/true';</script>";
            $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $_redirector->gotoUrl(HOST_PROJECT."/index/xem/khomoc/true/chonnhuom/true/mykhohang/".$makho);
        }
            

        //form trên cùng
        $form->populate($param);
        echo $form;
        
        
        ?>
        <div class="main">
            <div style='float: left'>
            <?php 
                echo '<h1 class="title">Chọn Cây Mộc</h1>';
                $formchon->createForm($makho);
                
                echo $formchon;
            ?>
            </div>
            
            <div class = "right">
            <?php 
                
                if($mysession->checked!=null){
                    $formsesion = new Form_Formmoi_Subsession();
                    $formsesion->createForm($makho);
                    echo $formsesion;
                }
            ?>
            </div>
        </div>
        <?php 
        // form session
        
        
        // form chọn
        
        
    }
    else{
        echo $form;
    }
    
    
?>
