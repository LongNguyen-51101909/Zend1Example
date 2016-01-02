<?php 
    echo $this->headMeta();
    echo $this->headLink();

    $data= new My_Data();

    $loaikho = new Model_Loaikho();
    $opmoc = $data->getOpKhoMoc();

    foreach ($opmoc as $key=> $item)
    {
        //echo "<div class= 'mar'>";
        echo '<h1 class="title">'.$item.'</h1>';
        //echo "</div>";
        $title = array("Loại Vải","Số Cây Mộc", "Tổng Số Mét");
        $query = $data->createTable($title, $data->getkhomocInfo($key), "400px");
        echo $query;
    }
    
    //chon kho moc de hien thi --- xem xet bo
    
//     $form = new Form_Formmoi_Xemkhomoc();
//     $formchon = new Form_Formmoi_Khomoc();
//     if($this->param->isPost())
//     {
//         $param = $this->param->getPost();
        
//         $num =new Zend_Validate_Digits();
//         foreach ($param as $key=> $item)
//         {
//             if($num->isValid($key) && $item == 1)
//             {
//                 if(!$data->isExitInArray($mysession->checked,$key))
//                     $mysession->checked[] = $key;
//             }
//         }
//         $form->populate($param);
//         echo $form;
        
//         $makho = $this->param->getParam("mykhohang");
        
//         $data = new My_Data();
//         $title = array("Loại Vải","Số Cây Mộc", "Tổng Số Mét");
//         $query = $data->createTable($title, $data->getkhomocInfo($makho), "400px");
//         echo $query;

//     }
//     else{
//         echo $form;
//     }
    
    
?>
