<?php
class HeadermenusController extends AppController{
	public $theMenu;	
	public $components = array('Function','Paginator');	
	function index(){
		$this->loadModel('Listmenu');
		$dataGroupMenu=$this->Listmenu->getGroupMenu($this->Session->read('dpfdpl_userId'));
		$n=0;		
		$this->printTree($dataGroupMenu,$n,$this->Session->read('dpfdpl_userId'),$this->Session->read('dpfdpl_perusahaanId'),$this->Session->read('dpfdpl_groupDivisi'));
		return $this->theMenu;
	}
	function printTree($results,$i,$userId,$perusahaanId,$divisi){

			if($i!=0){
				if($i==1){$lvlStr='second';}
				elseif($i==2){$lvlStr='third';}
				elseif($i==3){$lvlStr='fourth';}


			$this->theMenu=$this->theMenu."<ul class='nav nav-$lvlStr-level'>";}
			foreach($results as $result){
			$prefix="";
		
			if($result['listmenus']['mainPage']==""){$this->theMenu=$this->theMenu."<li><a href='#'>";}	
			else{	
			if($result['listmenus']['extApp']=='logistik'){
				$result['listmenus']['mainPage']="logistikmenus?mainPage=".$result['listmenus']['mainPage'].".jsp";
				}
			if($result['listmenus']['extApp']=='commitment'){
				$result['listmenus']['mainPage']="commitmentmenus?mainPage=".$result['listmenus']['mainPage'].".jsp";
				}	
			$this->theMenu=$this->theMenu."<li><a href=".$this->webroot.$result['listmenus']['mainPage']." target='_self'>";
			}
			if(strlen($result['listmenus']['icon'])>0){
				$this->theMenu=$this->theMenu."<i class='fa fa-".$result['listmenus']['icon']." fa-fw'></i>";
				}
			$this->theMenu=$this->theMenu.$result['listmenus']['namaMenu'];
			if($result['listmenus']['id']<>$result['listmenus']['parentId']){
				$children = $this->Listmenu->getChildren($result['listmenus']['id'],$userId,$perusahaanId,$divisi);
			 if(count($children)>0){				 
				$this->theMenu=$this->theMenu."<span class='fa arrow'></span></a>";				 
				$this->printTree($children,$i+1,$userId,$perusahaanId,$divisi);
				 }
			else{$this->theMenu=$this->theMenu."</a>";}	 
				} 
			else{
				$this->theMenu=$this->theMenu."</a>";
				}
				$this->theMenu=$this->theMenu."</a>";	
			$this->theMenu=$this->theMenu."</li>";
			}
			if($i!=0) {$this->theMenu=$this->theMenu."</ul>";}
		
		}	
		
	}
?> 
