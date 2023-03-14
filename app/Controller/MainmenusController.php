<?php
class MainmenusController extends AppController{
	public $components = array('Function');
	
	public function getSetting(){
		$this->autoRender = false;
		$this->loadModel('Setting');
		$rsSetting=$this->Setting->query("Select * from settings");
		
		echo $rsSetting[0]["settings"]["headerText"]."!".$this->webroot."img/".$rsSetting[0]["settings"]["logo"];
		
	}	
	function index(){
		//var_dump( $this->Function->cekSession($this));exit();
		echo $this->Function->cekSession($this);
		
		}
	function generatePanel($jenis,$perusahaanId,$divisi,$groupId){}
	function generatePanel2($groupId){}
	function generateApp($appName,$appId,$appColor,$appIcon,$appPlatform){}		
	}
	
?>
