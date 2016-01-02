<?php
class Form_Formmoi_Caymoc extends Zend_Form{
    public function init(){
       
    }
    
    public function createForm($idkhosoi)
    {
        $ks = new Model_Khosoi();
        $khosoirow = $ks->getWhere($idkhosoi);
    
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
                array('ViewScript', array('viewScript' =>'formmoi/caymoc_layout.phtml')),
                'Form'
        ));
    
        $data = new My_Data();
        $loaisoi = new Model_Loaisoi();
        $loaisoirow = $loaisoi->getWhere($khosoirow['MaSoi']);
        
        $kho= new Model_Khohang();
        $khohang = $kho->getWhere($khosoirow['MaKho']);

        $opvai = $data->getOpLoaiVaiWithIdSoi($khosoirow['MaSoi']);
        $opkhomoc = $data->getOpKhoWithName('Kho Mộc');

        $khosoi = $this->createElement('text', 'makho', array('decorators' => array('ViewHelper'),));
        $loaisoi = $this->createElement('text', 'masoi', array('decorators' => array('ViewHelper'),));
        $sotansoi = $this->createElement('text', 'sotansoi', array('decorators' => array('ViewHelper'),));
        $loaivai = $this->createElement('select', 'mavai', array('multioptions'=>$opvai,'decorators' => array('ViewHelper'),));
        $socaymoc = $this->createElement('text', 'socaymoc', array('decorators' => array('ViewHelper'),));
        $tongmetvai = $this->createElement('text', 'tongsometvai', array('decorators' => array('ViewHelper'),));
        $khonhap = $this->createElement('select', 'khomoc', array('multioptions'=>$opkhomoc,'decorators' => array('ViewHelper'),));
        $them =  $this->createElement('submit', 'them', array('decorators' => array('ViewHelper'),'label'=>'Thêm'));
        
        $khosoi->setAttrib('class', 'formEdit')->setValue($khohang['TenKho']);
        $loaisoi->setAttrib('class', 'formEdit')->setValue($loaisoirow['TenSoi']);
        $loaivai->setAttrib('class', 'formEdit')->setAttrib('id', 'idvai');
        $sotansoi->setAttrib('class', 'smallfield');        
        $socaymoc->setAttrib('class', 'formEdit'); 
        $tongmetvai->setAttrib('class', 'formEdit');
        $khonhap->setAttrib('class', 'formEdit');
        
        $this->addElement($loaisoi)
             ->addElement($loaivai)
             ->addElement($socaymoc)
             ->addElement($sotansoi)
             ->addElement($khosoi)
             ->addElement($tongmetvai)
             ->addElement($khonhap)
             ->addElement($them)
             ;        
    }
    
    public function createCayMoc($soluong, $mavai,$sotansoi,$sometvai,$khomoc)
    {
        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' =>'formmoi/taocaymoc_layout.phtml')),
            'Form'
        ));
        $caymoc = array();
        for($i= 1; $i<=$soluong; $i++)
        {
            $temp = $this->createElement('text', ''.$i, array('decorators' => array('ViewHelper'),));
            $temp->setAttrib('class', 'caymocfield');
            $this->addElement($temp);
            
        }
        
        $slhidden = $this->createElement('hidden', 'soluong', array('decorators' => array('ViewHelper'),));
        $slhidden->setValue($soluong);
        
        $maloaivai = $this->createElement('hidden', 'mavai', array('decorators' => array('ViewHelper'),));
        $maloaivai->setValue($mavai);
        
        $sotansoiform = $this->createElement('hidden', 'sotan', array('decorators' => array('ViewHelper'),));
        $sotansoiform->setValue($sotansoi);
        
        $sometvaiform = $this->createElement('hidden', 'tongsomet', array('decorators' => array('ViewHelper'),));
        $sometvaiform->setValue($sometvai);
        
        $khomocform = $this->createElement('hidden', 'khomoc', array('decorators' => array('ViewHelper'),));
        $khomocform->setValue($khomoc);
        
        
        $them =  $this->createElement('submit', 'them', array('decorators' => array('ViewHelper'),'label'=>'Thêm'));
        $them->setAttrib('class', 'btn btn-primary')
             ->setAttrib('onclick', 'passarray()');
        
        $this->addElement($slhidden)
             ->addElement($maloaivai)
             ->addElement($sotansoiform)
             ->addElement($sometvaiform)
             ->addElement($khomocform)
             ->addElement($them);
        
    }
}
