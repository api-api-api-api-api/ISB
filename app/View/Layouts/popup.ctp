<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<?php //include styling file
		
	  echo $this->Html->css('style');
	  echo $this->Html->meta('icon','/img/pass.png');
	  echo $this->Html->css('/css/custom-theme/jquery-ui-1.8.2.custom'); 
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.base');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.android');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.windowsphone');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.mobile');
	  //include script file
	  echo $this->Html->script('jquery-1.8.3.min');
	  echo $this->Html->script('jquery.validate');
	  echo $this->Html->script('jquery-ui-1.8.2.custom.min');
	  echo $this->Html->script('/js/jqwidgets/jqx-all');
	  echo $this->Html->script('clock');
	  echo $this->Html->script('functions');
	  App::import('Vendor', 'Mobile_Detect', array('file' => 'Mobile_Detect.php'));
 		$detect = new Mobile_Detect;
		if($detect->isMobile()==1 || $detect->isTablet()==1){
			?>
			<script>var theme='android';</script>
			<?php
			 echo $this->Html->css('styleMainMobile');
	 		 echo $this->Html->script('dropmenumobile');
			}
		else{
			?>
			<script>var theme='myCust';</script>
			<?php
			 echo $this->Html->css('styleMain');
	  		echo $this->Html->script('dropmenu');
			 
			}	
	 
	  $helpers = array('Function');
	  $this->Function->cekJScript();

	  echo $this->Html->charset();
?>
<script type="text/javascript">
var obj_caller =opener;
document.title='PopUp '+obj_caller.popUp;
</script>
<title></title>

</head>
<body>

<div id="container">
    
  <div style="position:absolute"><?php echo $this->fetch('content'); ?></div><div id="loading" style="display:none"><center><img src="<?php echo $this->webroot;?>img/loading_1.gif" style="" align='bottom' /></center></div> 
<div style="display:none" name="dialogBox" id='dialog'>
</div>
</div>
<script>
function logout(){
   window.location="<?php echo $this->webroot;?>logout";
}
startClock();

</script>
</body>
</html>
