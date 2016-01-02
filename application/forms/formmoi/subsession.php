<?php
class Form_Formmoi_Subsession extends Zend_Form{
    public function init(){
       
    }
    
    public function createForm($makhomoc)
    {    
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
                array('ViewScript', array('viewScript' =>'formmoi/subsession.phtml')),
                'Form'
        ));
    
        Zend_Session::start();
        $mysession = new Zend_Session_Namespace('Zend_Auth');

        if($mysession->checked!=null)
        {
            foreach ($mysession->checked as $item)
            {
                $them =  $this->createElement('checkbox', ''.$item, array('decorators' => array('ViewHelper')));
                $them->setAttrib('class', 'checkbox');
                $this->addElement($them);
            }
        }
        
        $khohang = $this->createElement('hidden', 'mykhohang', array('decorators' => array('ViewHelper'),));
        $khohang->setAttrib('class', 'formEdit')->setValue($makhomoc);
        $this->addElement($khohang);
        
        $nhuom =  $this->createElement('submit', 'chonlonhuom', array('decorators' => array('ViewHelper'),'label'=>'Chọn Lô Nhuộm'));
        $nhuom->setAttrib('class', 'btn btn-primary');
        $this->addElement($nhuom);
        
        $bochon =  $this->createElement('submit', 'bochon', array('decorators' => array('ViewHelper'),'label'=>'Bỏ Chọn'));
        $bochon->setAttrib('class', 'btn btn-primary');
        $this->addElement($bochon);
    }
    
}
