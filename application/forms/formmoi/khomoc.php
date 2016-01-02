<?php
class Form_Formmoi_Khomoc extends Zend_Form{
    public function init(){
       
    }
    
    public function createForm($makho)
    {
        $khomoc = new Model_Caymoc();
        $khomocrow = $khomoc->getWhere_khomoc_CTP($makho);

        $this->setDisableLoadDefaultDecorators(true);
        
        $this->setDecorators(array(
                array('ViewScript', array('viewScript' =>'formmoi/khomoc_layout.phtml')),
                'Form'
        ));
        
        $makhoform = $this->createElement('hidden', 'mykhohang', array('decorators' => array('ViewHelper'),));
        $makhoform->setValue($makho);
        $this->addElement($makhoform);
        if($khomocrow)
        {
            foreach ($khomocrow as $item)
            {
                $row = $this->createElement('checkbox', ($item['MaMoc'].''), array('decorators' => array('ViewHelper'),));
                $row->setAttrib('class', 'checkbox');
                $this->addElement($row);
            }
            
            
            $them =  $this->createElement('submit', 'them', array('decorators' => array('ViewHelper'),'label'=>'Chọn'));
            $them->setAttrib('class', 'btn btn-primary');
            $this->addElement($them);
        }
        else 
        {
            echo "<div class='message' style='margin-left:0px !important;'>";
            echo "Kho Mộc Trống";
            echo "</div>";
        }
    }
    
}
