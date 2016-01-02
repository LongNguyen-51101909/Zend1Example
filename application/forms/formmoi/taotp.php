<?php
class Form_Formmoi_Taotp extends Zend_Form{
    public function init(){
        
    }
    
    public function createForm($malo)
    {
        Zend_Session::start();
        $mysession = new Zend_Session_Namespace('Zend_Auth');
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' =>'formmoi/taotp.phtml')),
            'Form'
        ));
        
        if($mysession->checked)
        {
            foreach ($mysession->checked as $key=>$item)
            {
                $edit =  $this->createElement('text', $item.'', array('decorators' => array('ViewHelper'),'label'=>'Chọn'));
                $edit->setAttrib('class', 'thanhpham');
                $this->addElement($edit);
            }
        }
        
        $data = new My_Data();
        $opTP = $data->getOpKhoWithName("Kho Thành Phẩm");
        $thanhpham =  $this->createElement('select', 'khotp', array('multioptions'=>$opTP,'decorators' => array('ViewHelper')));
        $thanhpham->setAttrib('class', 'thanhpham');
        $this->addElement($thanhpham);
        
        $lonhuom =  $this->createElement('hidden', 'malonhuom', array('decorators' => array('ViewHelper')));
        $lonhuom->setValue($malo);
        $this->addElement($lonhuom);
        
        $them =  $this->createElement('submit', 'them', array('decorators' => array('ViewHelper'),'label'=>'Thêm'));
        $them->setAttrib('class', 'btn btn-primary');
        $this->addElement($them);
    }
    
}
