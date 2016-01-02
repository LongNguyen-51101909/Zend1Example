<?php
class Form_Export_Index extends Zend_Form {
    public function init(){

        $this->setDisableLoadDefaultDecorators(true);

        $this->setDecorators(array(
            array('ViewScript', array('viewScript' =>'export/export.phtml')),
            'Form'
        ));

        $data = new My_Data();
        
        $madonxuat= $this->createElement('text', 'madonxuat', array('decorators' => array('ViewHelper'),
            'value' => $_POST["madonxuat"]));
        $them =  $this->createElement('submit', 'them', array('decorators' => array('ViewHelper'),'label'=>'Chọn'));

        $madonxuat->setAttrib('class', 'formEdit');

        $this->addElement($madonxuat)
        ->addElement($them)
        ;
    }
}