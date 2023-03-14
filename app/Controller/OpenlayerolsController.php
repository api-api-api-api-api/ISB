<?php

App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  Openlayerol  sController extends AppController {
    public $components = array('Function','Paginator');	
    public function index(){
	echo $this->Function->cekSession($this);
	}
}
