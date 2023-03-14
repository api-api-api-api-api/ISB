<?php
$this->layout = 'login';
?>
<script>
$(function(){$.fx.speeds._default = 1000;});

</script>
<?php
$helpers = array('Function');
$this->Function->cekJScript();
?>
<style>
@import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);
.social-login-box p{font-family: 'Exo', sans-serif;
	font-size: 20px;
	font-weight: 200;margin-left:10px;}
.lbl{
	display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	 border: none !important;
  border-bottom: 2px solid rgba(0, 0, 0, 0.2) !important;
  box-sizing: border-box !important;
  background: transparent !important;}	
.divInput{
	  position:relative ;
  height: 24px;
  border-bottom: 2px solid rgba(0, 0, 0, 0.2) !important;
  margin-bottom: 5px;}
.input{ position:absolute ;
  width: 195px;
  height: 24px;
  margin-left: 5px;
  margin-bottom:5px;
  background: transparent;
  font-size:14px;
  border: none;}  
 .error{ color: red;} 
 
</style>
		 <?php
		/* echo $this->Form->create('frmLogin', array('id' => 'frmLogin','name' => 'frmLogin','class' => 'style4'));
         echo $this->Html->div('logHeader lblBold', 'DPF Login');
         echo $this->Html->useTag('tagstart', 'div', array('class'=>'logBody'));         
         echo $this->Form->input('namaUser',array('id'=>'namaUser',
                                                   'name'=>'namaUser',
                                                   'placeholder'=>'Nama User',
                                                   'class'=>'required theTxt roundIt Uid',
                                                   'label'=>false,
                                                   'div'=>false));echo "<br><br>";
		echo $this->Form->input('password',array('id'=>'pass',
                                                   'name'=>'pass',
                                                   'placeholder'=>'password',
                                                   'class'=>'required theTxt roundIt Pass',
                                                   'type'=>'password',
                                                   'label'=>false,
                                                   'div'=>false));	
        echo $this->Form->button('Log In',array('id'=>'login',
                                                   'name'=>'login',
                                                   'class'=>'theBtn',
                                                  	'type'=>'submit',
                                                   'label'=>false,
                                                   'div'=>false));	
        echo $this->Form->button('Batal',array('id'=>'reset',
                                                   'name'=>'reset',
                                                   'class'=>'theBtn',
                                                   'type'=>'reset',
                                                   'label'=>false,
                                                   'div'=>false));											   										   									   
        echo $this->Html->useTag('tagend','div');
		echo '<br/><center>';
		echo $this->Form->label('errMsg', '',array('id'=>'errMsg','class'=>'lblError'));		
		echo '</center>';
		echo $this->Html->div('dialogBox', ' ',array('display'=>'none','id'=>'dialog','name'=>'dialogBox'));
		echo $this->Form->end();*/
         ?>
<div class="container">
    <div class="row" style="margin-top:160px">
    <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel" style="/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffd8a5+0,ffbd23+100 */
background: #ffd8a5; /* Old browsers */
background: -moz-linear-gradient(top,  #ffd8a5 0%, #ffbd23 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #ffd8a5 0%,#ffbd23 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #ffd8a5 0%,#ffbd23 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffd8a5', endColorstr='#ffbd23',GradientType=0 ); /* IE6-9 */
">
                <!--<div class="panel-heading" style="background:#0F0">                
                   <h3 class="panel-title"> 
                <span><img src="<?php echo $this->webroot;?>/img/headImg.png" style="width:48px"></span>
                </h3>
                </div>-->
                 <form action="" method="post" name="frmLogin" id="frmLogin" class="style4">
                <div class="panel-body" style="padding-top:40px;padding-bottom:40px;">
                 
                     <!--<div class="row">
    <div class="col-md-12" style="padding-left:20px; padding-right:20px;">
    	<div>
			<legend><i class="fa fa-gears"></i> <label id='headerText' style="font-size:14px !important"></label></legend>
		</div>
	</div>
</div>-->        
                    <div class="row">
                   <div class="col-xs-4 col-sm-4 col-md-4 separator social-login-box" style="padding: 20px 0;"> 
								<p id='headerText'></p>
                             </div>
                      <div class="col-xs-8 col-sm-8 col-md-8 login-box">
                           <div class="row" style="margin-top: 20px;"> 
			<div class="col-md-12 text-right">
				<div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="namaUser" id="namaUser" class="form-control required ip" placeholder="Nama User" maxlength="50">
                </div>
                <span style="color: red; font-style: italic; font-size: 11px;"></span>
			</div>
		</div>
        <div class="row" style="margin-top: 7px;" >
			<div class="col-md-12 text-right">
				<div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="pass" value="" id="pass" class="form-control required" placeholder="Password" maxlength="50">
                </div>
                <span style="color: red; font-style: italic; font-size: 11px;"></span>
			</div>
		</div>
                            <!--<div class="divInput">
                               <span class="fa fa-user" style="font-size:18px;"></span>
                                <input type="text" name="namaUser" id="namaUser" class="input required ip input-sm " placeholder="Nama User">
                            </div><br />
                            <div class="divInput">
                               <span class="fa fa-lock" style="font-size:20px;"></span>
                                <input type="password" name="pass" id="pass" class="input input-sm" placeholder="Password"></div>-->
                         
                            <p>
                                </p>
                         
                           
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align:right">
                    
                             <button type="submit" class="btn btn-labeled btn-default" id='btnLogin'>
                                <span class="btn-label"><i class="fa fa-check"></i></span>Log In</button>
                            <button type="reset" class="btn btn-labeled btn-default">
                                <span class="btn-label"><i class="fa fa-remove"></i></span>Cancel</button>
                             
                        </div>
                    </div>
                    
                </div>
            </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>		 