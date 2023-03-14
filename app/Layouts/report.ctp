<html>
<head>
<?php //include styling file
	  
	  echo $this->Html->css('style');
	  echo $this->Html->css('/css/bootstrap.min'); 
	  echo $this->Html->css('/css/metisMenu.min'); 
	  echo $this->Html->css('/css/sb-admin-2');  
	  echo $this->Html->css('/css/font-awesome.min'); 
	  echo $this->Html->css('/css/dataTables.bootstrap.css');
	  echo $this->Html->css('/css/dataTables.responsive.css');
	  //include script file
	  echo $this->Html->script('jquery.min');
	  echo $this->Html->script('functions');
	  
	  echo $this->Html->script('bootstrap.min');
	  echo $this->Html->script('metisMenu.min');
	  echo $this->Html->script('sb-admin-2');
	  echo $this->Html->script('jquery.dataTables.min.js');
	  echo $this->Html->script('dataTables.bootstrap.min.js');
	  $helpers = array('Function');
	  $this->Function->cekJScript();

	  echo $this->Html->charset();
?>
<title></title>

</head>
<body style="background:#FFF">
 <?php echo $this->fetch('content'); ?></div>
 </body>
</html>
