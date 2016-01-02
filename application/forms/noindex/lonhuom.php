<?php
class Form_Noindex_Lonhuom extends Zend_Form{
    public function createLonhuom($opMau){
        
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
                array('ViewScript', array('viewScript' =>'formmoi/lonhuom_layout.phtml')),
                'Form'
        ));
        
        
        $ngaynhuom = $this->createElement('text', 'ngaynhuom', array('decorators' => array('ViewHelper'),));
        $mamau = $this->createElement('select', 'mamau', array('decorators' => array('ViewHelper'),'multioptions'=>$opMau));
        $socaynhuom= $this->createElement('text', 'socaynhuom', array('decorators' => array('ViewHelper'),));
        $them =  $this->createElement('submit', 'them', array('decorators' => array('ViewHelper'),'label'=>'Thêm'));
        
        $mamau->setAttrib('class', 'formEdit');
        
        $this->addElement($socaynhuom)
             ->addElement($ngaynhuom)
             ->addElement($mamau)
             ->addElement($them)
             ;
    }
}