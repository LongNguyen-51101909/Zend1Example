<?php
    $param = $this->param->getParams();
    
    if(array_key_exists("madonhang", $param))
    {
        require_once 'giaohang.php';
    }
    else if(array_key_exists("donhang", $param))
    {
        require_once 'donhang_xem.php';
    }