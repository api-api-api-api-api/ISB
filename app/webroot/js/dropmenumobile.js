// JavaScript Document
$(document).ready(function(){
	$("ul.dropdown li").dropdown();
  $("#mobMenu").click(function(event){
	if(!$('#menu').is(':visible')){
		$('#menu').slideDown('normal');
		}
	else{		
		$('#menu').slideUp('normal');
		}
		event.stopPropagation();
	});
$('html').click(function(event){
		$('#menu').slideUp('normal');
		
	});
});

$.fn.dropdown = function() {
$(" #menu ul ").css({display: "none"}); // Opera Fix
$(" #menu li").click(function(){
	$(this).find('ul').slideUp('normal');
	if(!$(this).find('ul:first').is(':visible')){
		$('#menu ul:visible').slideUp('normal');
		$(this).find('ul:first').slideDown('normal');
		}
	else{
		
		$(this).find('ul:first').slideUp('normal');
		}
	event.stopPropagation();	
	});
}