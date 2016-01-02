<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->view->param =($this->_request);
        $option =array("layout"=>"layouts", "layoutPath"=>APPLICATION_PATH."/layouts/scripts");
        
        $trees = new Model_Caymoc();
        $paginator = Zend_Paginator::factory($trees->fetchAll());
        $paginator->setDefaultItemCountPerPage(8);
        $allItems = $paginator->getTotalItemCount();
        $countPages = $paginator->count();
        
        $p = $this->getRequest()->getParam('p');
        if(isset($p))
        {
            $paginator->setCurrentPageNumber($p);
        } else $paginator->setCurrentPageNumber(1);
        
        $currentPage = $paginator->getCurrentPageNumber();
        
        $this->view->trees = $paginator;
        $this->view->countItems = $allItems;
        $this->view->countPages = $countPages;
        $this->view->currentPage = $currentPage;
        
        if($currentPage == $countPages)
        {
            $this->view->nextPage = $countPages;
            $this->view->previousPage = $currentPage-1;
        }
        else if($currentPage == 1)
        {
            $this->view->nextPage = $currentPage+1;
            $this->view->previousPage = 1;
        }
        else {
            $this->view->nextPage = $currentPage+1;
            $this->view->previousPage = $currentPage-1;
        }
        
        Zend_Layout::startMVC($option);
    }

    public function mainAction()
    {
        //$this->view->mainpage = "true";
        $this->view->param =($this->_request);
        $option =array("layout"=>"Main", "layoutPath"=>APPLICATION_PATH."/layouts/main");
        Zend_Layout::startMVC($option);
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect(HOST_PROJECT);
    }

    public function preDispatch()
    {
        $auth = Zend_Auth::getInstance();
        if( !$auth->hasIdentity())
        {
            if($this->_request->getActionName() != "index")
                $this->_redirect(HOST_PROJECT);
        }
    }

    public function nhaplieuAction()
    {
        $this->view->param =($this->_request);
        $option =array("layout"=>"Main", "layoutPath"=>APPLICATION_PATH."/layouts/nhap");
        Zend_Layout::startMVC($option);
    }

    public function xemAction()
    {
        $this->view->param = $this->_request;
        $option =array("layout"=>"Main", "layoutPath"=>APPLICATION_PATH."/layouts/xem");
        Zend_Layout::startMVC($option);
    }

    public function chinhsuaAction()
    {
        $this->view->param =($this->_request);
        $option = array("layout"=>"Main", "layoutPath"=>APPLICATION_PATH."/layouts/chinhsua");
        Zend_Layout::startMVC($option);
    }

    public function notpermissionAction()
    {
        
    }

    public function xoaAction()
    {
        $this->view->param = $this->_request;
        $option =array("layout"=>"Main", "layoutPath"=>APPLICATION_PATH."/layouts/xoa");
        Zend_Layout::startMVC($option);
    }

    public function taichinhAction()
    {
        $this->view->param = $this->_request;
        $option =array("layout"=>"taichinh", "layoutPath"=>APPLICATION_PATH."/layouts/taichinh");
        Zend_Layout::startMVC($option);
    }

    public function exportAction()
    {
        $this->view->param = $this->_request;
        $option =array("layout"=>"index", "layoutPath"=>APPLICATION_PATH."/layouts/export");
        Zend_Layout::startMVC($option);
    }


}



















