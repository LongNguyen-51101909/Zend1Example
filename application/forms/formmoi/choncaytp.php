<?php
class Form_Formmoi_Choncaytp extends Zend_Form{
    public function init(){
       
    }
    
    public function createForm($makho,$madonhang)
    {
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' =>'formmoi/choncaytp.phtml')),
            'Form'
        ));
        
        $donhang = new Model_Donhang();
        $donhangrow = $donhang->getWhere($madonhang);
        
        $caymoc = new Model_Caymoc();
        $caytp = new Model_Caythanhpham();
        $lonhuom = new Model_Lonhuom();
        
        $caytpall = $caytp->getWhere_khohang($makho);
        $optp = array();
        
        foreach ($caytpall as $key => $item)
        {
            $caymocrow = $caymoc->getWhere_ctp($item['MaCTP']);
            $lonhuomrow = $lonhuom->getWhere($caymocrow['MaLoNhuom']);
            
            if($caymocrow['MaVai'] == $donhangrow['MaVai'] && 
                $lonhuomrow['MaMau'] == $donhangrow['MaMau'] )
            {
                $optp[] = $item['MaCTP'];
            }
        }
        
        if($optp)
        {
            foreach ($optp as $item)
            {
                $row = $this->createElement('checkbox', ($item.''), array('decorators' => array('ViewHelper'),));
                $row->setAttrib('class', 'checkbox');
                $this->addElement($row);
            }
            
            $them =  $this->createElement('submit', 'chon', array('decorators' => array('ViewHelper'),'label'=>'Chọn'));
            $them->setAttrib('class', 'btn btn-primary');
            $this->addElement($them);
            
        }
        
        $donhangform = $this->createElement('hidden', 'mydonhang', array('decorators' => array('ViewHelper'),));
        $donhangform->setValue($madonhang);
        $this->addElement($donhangform);
        
        $khotpform = $this->createElement('hidden', 'mykhohang', array('decorators' => array('ViewHelper'),));
        $khotpform->setValue($makho);
        $this->addElement($khotpform);
    }
    
}
