<?php
class Form_Formmoi_Ctpsession extends Zend_Form{
    public function init(){
       
    }
    
    public function createForm($makhohang)
    {    
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
                array('ViewScript', array('viewScript' =>'formmoi/ctpsession.phtml')),
                'Form'
        ));
    
        Zend_Session::start();
        $mysession = new Zend_Session_Namespace('XuLyDonHang');
        $num = new Zend_Validate_Digits();

        if($mysession->checktp!=null)
        {
            foreach ($mysession->checktp as $item)
            {
                if($num->isValid($item))
                {
                    $them =  $this->createElement('checkbox', ''.$item, array('decorators' => array('ViewHelper')));
                    $them->setAttrib('class', 'checkbox');
                    $this->addElement($them);
                }
            }
        }
        
        $khohang = $this->createElement('hidden', 'mykhohang', array('decorators' => array('ViewHelper'),));
        $khohang->setAttrib('class', 'formEdit')->setValue($makhohang);
        $this->addElement($khohang);
        
        $giaohang = $this->createElement('submit', 'giaohang', array('decorators' => array('ViewHelper'),'label'=>'Giao Hàng'));
        $giaohang->setAttrib('class', 'btn btn-primary');
        $this->addElement($giaohang);
        
        $bochon =  $this->createElement('submit', 'bochon', array('decorators' => array('ViewHelper'),'label'=>'Bỏ Chọn'));
        $bochon->setAttrib('class', 'btn btn-primary');
        $this->addElement($bochon);
    }
    
}
