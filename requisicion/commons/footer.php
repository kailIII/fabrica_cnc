<script type="text/javascript" src="scripts/library/jquery.js"></script>
<script type="text/javascript" src="scripts/library/jquery.validate.js"></script>
<script type="text/javascript" src="scripts/multipart/jquery.maskedinput-1.0.js"></script>
<script type="text/javascript" src="scripts/multipart/ui.core.js"></script>
<script type="text/javascript" src="scripts/multipart/ui.accordion.js"></script>
<script type="text/javascript" src="scripts/library/attention_box-min.js"></script>
<script type="text/javascript" src="scripts/js/tools_form.js"></script>
<script type="text/javascript" src="scripts/js/logs.js"></script>
<script type="text/javascript" src="scripts/box/jquery.colorbox-min.js"></script>


<script type="text/javascript">
$(document).ready(function(){

	$("#recordClientPhone").mask("(999) 999-9999");
	$("#recordClientPhoneAlt").mask("(999) 999-9999");
	$("#recordClientZip").mask("99999");
	$("#recordPropertyZip").mask("99999");	
	$("#recordPurchaseZip").mask("99999");	

	// add * to required field labels
	$('label.required').append('&nbsp;<strong>*</strong>&nbsp;');

	// accordion functions
	var accordion = $("#stepForm").accordion(); 
	var current = 0;
	
	$.validator.addMethod("pageRequired", function(value, element) {
		var $element = $(element)
		function match(index) {
			return current == index && $(element).parents("#sf" + (index + 1)).length;
		}
		if (match(0) || match(1) || match(2) || match(3) || match(4) || match(5) || match(6)) {
			return !this.optional(element);
		}
		return "dependency-mismatch";
	}, $.validator.messages.required)
	
	var v = $("#cmaForm").validate({
		errorClass: "warning",
		onkeyup: false,
		onblur: false,
		submitHandler: function() {
			alert("Información Enviada");
		}
	});
	
	// Menus superiores
	
	$("#Item1").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item1").css("background","#ccc"); 
		accordion.accordion("activate", 0);
		current = 0;
	}); 
	
	$("#Item2").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item2").css("background","#ccc"); 
		accordion.accordion("activate", 1);
		current = 1;
	});
	
	$("#Item3").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item3").css("background","#ccc"); 
		accordion.accordion("activate", 2);
		current = 2;
	});
	
	$("#Item4").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item4").css("background","#ccc"); 
		accordion.accordion("activate", 3);
		current = 3;
	});
	
	$("#Item5").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item5").css("background","#ccc"); 
		accordion.accordion("activate", 4);
		current = 4;
	});
	
	$("#Item6").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item6").css("background","#ccc"); 
		accordion.accordion("activate", 5);
		current = 5;
	});
	
	$("#Item7").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item7").css("background","#ccc"); 
		accordion.accordion("activate", 6);
		current = 6;
	});
	// back buttons do not need to run validation
	$("#sf2 .prevbutton").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item1").css("background","#ccc"); 
		accordion.accordion("activate", 0);
		current = 0;
	}); 
	$("#sf3 .prevbutton").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item2").css("background","#ccc"); 
		accordion.accordion("activate", 1);
		current = 1;
	}); 
	$("#sf4 .prevbutton").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item3").css("background","#ccc"); 
		accordion.accordion("activate", 2);
		current = 2;
	}); 
	$("#sf5 .prevbutton").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item4").css("background","#ccc"); 
		accordion.accordion("activate", 3);
		current = 3;
	});
	$("#sf6 .prevbutton").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item5").css("background","#ccc"); 
		accordion.accordion("activate", 4);
		current = 4;
	});
	$("#sf7 .prevbutton").click(function(){
		$("#Barra div").css("background","#F5F5F5");
		$("#Item6").css("background","#ccc"); 
		accordion.accordion("activate", 5);
		current = 5;
	});
	// these buttons all run the validation, overridden by specific targets above
	$(".open6").click(function() {
	  
		$("#Barra div").css("background","#F5F5F5");
		$("#Item7").css("background","#ccc"); 
	    accordion.accordion("activate", 6);
	    current = 6;
	  
	});
	$(".open5").click(function() {
	  
		$("#Barra div").css("background","#F5F5F5");
		$("#Item6").css("background","#ccc"); 
	    accordion.accordion("activate", 5);
	    current = 5;
	  
	});
	$(".open4").click(function() {
	  
		$("#Barra div").css("background","#F5F5F5");
		$("#Item5").css("background","#ccc"); 
	    accordion.accordion("activate", 4);
	    current = 4;
	  
	});
	$(".open3").click(function() {
	  
		$("#Barra div").css("background","#F5F5F5");
		$("#Item4").css("background","#ccc"); 
	    accordion.accordion("activate", 3);
	    current = 3;
	  
	});
	$(".open2").click(function() {
	  
		$("#Barra div").css("background","#F5F5F5");
		$("#Item3").css("background","#ccc"); 
	    accordion.accordion("activate", 2);
	    current = 2;
	  
	});
	$(".open1").click(function() {
	  
	    $("#Barra div").css("background","#F5F5F5");
		$("#Item2").css("background","#ccc"); 
		//document.cmaForm1.submit();
		$.ajax({
			type : 'POST',
			url : 'core/post_calendario.php',
			data: $("#cmaForm1").serialize(),
			success : function (msg) { }});
		acabo();	
		accordion.accordion("activate", 1);
	    current = 1;
		
	});
	$(".open0").click(function() {
	 	$("#Barra div").css("background","#F5F5F5");
		$("#Item1").css("background","#ccc"); 
	    accordion.accordion("activate", 0);
	    current = 0;
	  
	});
	
	
	//$("a[rel^='prettyPhoto']").prettyPhoto();
});


/*
function cargarForms(form, url){
	$.ajax({
			type : 'POST',
			url : 'core/post_calendario.php',
			data: $("#cmaForm1").serialize(),
			success : function (msg) { }});
		
	}*/
</script>