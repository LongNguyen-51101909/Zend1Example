<?php
class Form_Valid_Donhang{
    
    public $messages;
    
    public function __construct($data){
        
        $val = new Zend_Validate_NotEmpty();
        $num =new Zend_Validate_Digits();
        $date = new Zend_Validate_Date(array('format' => 'dd/MM/yyyy'));
        
        if($val->isValid($data['sometvai'])==false)
            $this->messages[] = "Số mét vải Không được trống";
        else if($num->isValid($data['sometvai']) == false)
            $this->messages[] = "Số mét vải phải là số";
        
        if($date->isValid($data['ngaydathang'])==false)
            $this->messages[] = "Ngày đặt hàng không đúng";
        
        if(array_key_exists('tiendathang',$data))
        {
        if($val->isValid($data['tiendathang'])==false)
            $this->messages[] = "Tiền đặt hàng không được trống";
        else if($num->isValid($data['tiendathang']) == false) 
            $this->messages[] = "Tiền đặt hàng phải là số";
        }
        if(array_key_exists('makhachhang',$data))
        {
            if($val->isValid($data['makhachhang'])==false)
                $this->messages[] = "Mã khách hàng không được trống";
            else if($num->isValid($data['makhachhang']) == false)
                $this->messages[] = "Mã khách hàng phải là số";
        }
    }
    
    public function valid(){
        if($this->messages != "")
            return false;
        else 
            return true;
    }
}