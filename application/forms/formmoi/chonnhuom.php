<?php
class Form_Formmoi_Chonnhuom extends Zend_Form{
    public function init(){
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' =>'formmoi/chonlonhuom.phtml')),
            'Form'
        ));
        
        $ln= new Model_Lonhuom();
        $lonhuomall = $ln->getWhere_trangthai();
        
        foreach ($lonhuomall as $key=>$item)
        {
            $them =  $this->createElement('submit', ''.$item['MaLoNhuom'], array('decorators' => array('ViewHelper'),'label'=>'Chọn'));
            $them->setAttrib('class', 'btn btn-primary');
            $this->addElement($them);
        }
    }
    
    public function createForm()
    {
        
    }
    
}
