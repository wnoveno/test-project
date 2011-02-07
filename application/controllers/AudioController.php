<?php

class AudioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    //	die(var_dump($this->getRequest()));
	//dump($this->getRequest()->getParams());
	
    }
    
    public function playAction(){
    	//dump($this->getRequest()->getParams());
    	$this->_helper->layout->disableLayout();
//    	$this->getResponse()
//     		->setHeader('Content-Disposition', ' inline; filename="lilly.mp3"')
//     		->setHeader('Cache-Control','no-cache')
//     		->setHeader('Content-type', 'audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3');
    	$this->setResponse(readfile(APPLICATION_PATH."/../public/data/Wolfgang/Wolfgang - 01 atomica.mp3"))
    		->setHeader('Content-Disposition', ' inline; filename="lilly.mp3"')
     		->setHeader('Cache-Control','no-cache')
     		->setHeader('X-Pad','avoid browser bug')
     		->setHeader('Content-type', 'audio/mpeg');
    
	}


}

