<html>
<head> 
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- <meta name="viewport" content="width=device-width, initial-scale=1">-->
   <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <meta name="description" content="Ottorent Client Order Page">
    <meta name="author" content="EDP Bernofarm -[devxecutor]-">
<?php //include styling file
		
	  echo $this->Html->css('style');
	  echo $this->Html->meta('icon','/img/favico.png');
	  echo $this->Html->css('/css/custom-theme/jquery-ui.min'); 
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.base');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.mycust');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.android');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.ui-redmond');
	  echo $this->Html->css('/css/jqwidgets/styles/jqx.mobile');
	  echo $this->Html->css('/css/bootstrap.min'); 
	  echo $this->Html->css('/css/sb-admin-2');  
	  echo $this->Html->css('/css/font-awesome.min'); 
	  echo $this->Html->css('/css/metisMenu.min'); 
	  echo $this->Html->css('/css/dataTables.bootstrap.css');
	  echo $this->Html->css('/css/dataTables.responsive.css');
	  echo $this->Html->css('/css/bootstrap-datetimepicker.min');
	  echo $this->Html->css('/css/aw/aw');
	echo $this->Html->css('/css/checkstyling');  
	  //include script file
	  echo $this->Html->script('jquery.min');
	  echo $this->Html->script('ajaxfileupload');
	  echo $this->Html->script('jqwidgets/jqx-all');
	  echo $this->Html->script('clock');
	  echo $this->Html->script('functions');
	  
	  echo $this->Html->script('moment.min');
  	  echo $this->Html->script('bootstrap.min');
	  echo $this->Html->script('metisMenu.min');
	  echo $this->Html->script('sb-admin-2');
	  echo $this->Html->script('jquery-ui.min');
	  echo $this->Html->script('aw');
	 
	  $helpers = array('Function');
	  $this->Function->cekJScript();
	  echo $this->Function->cekSession($this);
	  echo $this->Html->charset();
?>
<script>
$(document).ready(function(){
docRoot = '<?php echo Router::fullBaseUrl().$this->webroot; ?>';

	var url = docRoot+'/mainmenus/getSetting';
//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({}),
      dataType: "text",
      async:false,
      success: function(returnedVal){ 
      		returnedVal=returnedVal.split("!");
    	  document.getElementById("headerText").innerHTML=returnedVal[0];
    	  document.getElementById("headerLogo").src=returnedVal[1];
document.title='.::: '+returnedVal[0]+' :::.';
      }
   	}
	);	});
</script>
<title></title>

</head>
<body>
<?php

if($this->Session->read('dpfdpl_logistikState')==0){
	$srcLogistik="http://116.197.130.124:8180/logistik/logon.jsp?tld=".$this->Session->read('dpfdpl_logistikToken');
	
	SessionComponent::write('dpfdpl_logistikState', '1');
	
	}
else{$srcLogistik="";}	
$srcCommitment="http://116.197.130.124:8180/commitment/logon.jsp?tld=".$this->Session->read('dpfdpl_logistikToken');
?>
<iframe id='logistikLoad' src='<?php echo $srcLogistik;?>' class='textBuff col-md-12' height=""></iframe>

<iframe id='commitmentLoad' src='<?php echo $srcCommitment;?>' class='textBuff col-md-12' height=""></iframe>
<div id="wrapper">

        <!-- Navigation -->
       <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <img id="headerLogo" width="64px"  style=align="left"/> 
               <label style="color:#ff3d03;font-size:18px;text-shadow: 1px 2px #333;" id="headerText"></label>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li>
                                <div>
                                    <strong><?php  echo strtoupper($this->Session->read('dpfdpl_penanggungJawab')); ?></strong>
                               </div>
                                <div><?php  echo strtoupper($this->Session->read('cabangClientName')); ?></div>
                            </li>
                <li class="dropdown">
                       <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                      
                        <li><a href="gantipasswords"><i class="fa fa-gear fa-fw"></i> Ganti Password</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->webroot;?>logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo $this->webroot;?>mainmenus"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php echo $this->element('header'); ?>     
                       
                        <?php echo $this->Session->read("dpfdpl_extAppMenu");?>
                                       
                    </ul>
                </div>
               
                <!-- /.sidebar-collapse -->
            </div>
            
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <div id="loading" style="display:none"><center>
<img src="<?php echo $this->webroot;?>img/loading_1.gif" style="" align='bottom' /></center></div> 
                       <?php echo $this->fetch('content'); ?>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
       <form id="formPopup" method="post" action=""  class="form-horizontal">
      <div class="modal-content">
        <div class="modal-header">  <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title"></h4></div>
          <div class="modal-body">
            </div> 
            <div class="modal-footer">
               
              </div>
            </div></form></div></div>
        <!-- /#page-wrapper -->

    </div>
<?php

	  echo $this->Html->script('jquery.dataTables.min.js');
	  echo $this->Html->script('dataTables.bootstrap.min.js');
	  echo $this->Html->script('bootstrap-datetimepicker.min');
	  echo $this->Html->script('jquery.validate');
?>
<style>
.modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}
</style>
<script>

startClock();

</script>

<div style="display:none; z-index:1000;" name="dialogBox" id='dialog'>
</body>
</html>
