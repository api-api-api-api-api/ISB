$(document).ready(function(){
	$("ul.dropdown li").dropdown();
});

$.fn.dropdown = function() {
$(" #menu ul ").css({display: "none"}); // Opera Fix
$(" #menu li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(200);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
}