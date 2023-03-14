<html>
<head>
<title>.::: Integrated System PT Bernofarm :::.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<?php 
	  //include styling file
	  echo $this->Html->css('style');
	  echo $this->Html->meta('icon','img/pass.png');
	  echo $this->Html->css('/css/bootstrap.min'); 
	  echo $this->Html->css('/css/font-awesome.min'); 
	  //include script file
	  
	  echo $this->Html->script('jquery.min');
  	  echo $this->Html->script('bootstrap.min');
	  echo $this->Html->script('jquery.validate');
	  echo $this->Html->script('functions');
	  echo $this->Html->script('h1login');
	  ?>
<style type="text/css">body{ background:#d8e9d3;}</style>
</head>
<body>
<?php echo $this->fetch('content'); ?>
</body>
</html>
