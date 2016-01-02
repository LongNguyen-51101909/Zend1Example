<?php
class Form_Valid_Caymoc{
    
    public $messages;
    
    public function __construct($data, $sotan){
        
        $val = new Zend_Validate_NotEmpty();
        $num =new Zend_Validate_Digits();
      //  $kh = new Model_Khachhang();
        
        if($val->isValid($data['sotansoi'])==false)
            $this->messages[] = "Số tấn sợi phải không được trống";
//         else if($num->isValid($data['sotansoi'])==false)
//             $this->messages[] = "Số tấn sợi phải là số";
        else if(!Zend_Locale_Format::isFloat($data['sotansoi'], array('locale' => 'en')))
            $this->messages[] = "Số tấn sợi phải là số";        
        else if($data['sotansoi']> $sotan)
            $this->messages[] = "Trong kho chỉ còn ".($sotan)." tấn sợi.";
        
        
        
        if($val->isValid($data['socaymoc'])==false)
            $this->messages[] = "Số cây mộc không được trống";
        else if($num->isValid($data['socaymoc'])==false)
            $this->messages[] = "Số cây mộc phải là số";
        
    }
    
    public function valid(){
        if($this->messages != "")
            return false;
        else 
            return true;
    }
}