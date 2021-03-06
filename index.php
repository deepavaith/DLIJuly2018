<!DOCTYPE html>
<?php 
	include 'conn.php';	
?>
<html lang="en">
	<head>
		<?php include "header.php"; ?> 		   
		<script>
			$(document).ready(function(){	
				$("#author").autocomplete({
					source: "autocompletefunction.php?From=author",
					minLength: 0,
					select: function(event,ui){
						$('#author').val(ui.item.value);
						$('#authorvalue').val(ui.item.authorvalue);	
						$('#ui-id-1').scrollTop(0);
						$('#subject').val("");	
						$('#subject').closest('.input').removeClass('input--filled');
						$('#title').val("");
						$('#title').closest('.input').removeClass('input--filled');
						$('#institution').val("");
						$('#institution').closest('.input').removeClass('input--filled');
						$('.search').val("");	
						displayresult('author',ui.item.authorvalue,"");		//For author ui.item.authorvalue don't change
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#subject").autocomplete({
					source: "autocompletefunction.php?From=subject",
					minLength: 0,
					select: function(event,ui){
						$('#subject').val(ui.item.value);
						$('#subjectid').val(ui.item.id);
						$('#ui-id-2').scrollTop(0);
						$('#author').val("");
						$('#author').closest('.input').removeClass('input--filled');
						$('#title').val("");
						$('#title').closest('.input').removeClass('input--filled');
						$('#institution').val("");
						$('#institution').closest('.input').removeClass('input--filled');
						$('.search').val("");
						displayresult('subject',ui.item.value,"");		
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#title").autocomplete({
					source: "autocompletefunction.php?From=title",
					minLength: 0,
					select: function(event,ui){
						$('#title').val(ui.item.value);
						$('#titleid').val(ui.item.id);	
						$('#ui-id-3').scrollTop(0);
						$('#author').val("");
						$('#author').closest('.input').removeClass('input--filled');					
						$('#subject').val("");	
						$('#subject').closest('.input').removeClass('input--filled');
						$('#institution').val("");
						$('#institution').closest('.input').removeClass('input--filled');
						$('.search').val("");
						displayresult('title',ui.item.value,"");			
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});	
				$("#institution").autocomplete({
					source: "autocompletefunction.php?From=institution",
					minLength: 0,
					select: function(event,ui){
						$('#institution').val(ui.item.value.slice(0,5));
						$('#institutionid').val(ui.item.id);
						$('#ui-id-4').scrollTop(0);						
						$('#author').val("");
						$('#author').closest('.input').removeClass('input--filled');					
						$('#subject').val("");	
						$('#subject').closest('.input').removeClass('input--filled');				
						$('#title').val("");
						$('#title').closest('.input').removeClass('input--filled');
						$('.search').val("");
						displayresult('institution',ui.item.value,"");	
					}
				}).focus(function () {
					$(this).autocomplete("search");
				});
			});		
			
			function displayresult(WhichField,Value,Value1){
				if(Value!=""){
					$(".modal").css('display','block');
					$(".searchterm").html('');
					if(WhichField=="author"){
						var WhichCategory="Author";
					}else if(WhichField=="subject"){
						var WhichCategory="Subject";
					}else if(WhichField=="title"){
						var WhichCategory="Title";
					}else if(WhichField=="institution"){
						var WhichCategory="Institution";
					}else{
						var WhichCategory="Date of citation";
					}
					//$(".searchterm").html('Your search "'+Value+'"');
				}else{
					$(".searchterm").html('');
				}
				if(WhichField=="mainsearch"){
					$('#author').val("");	
					$('#author').closest('.input').removeClass('input--filled');
					$('#subject').val("");	
					$('#subject').closest('.input').removeClass('input--filled');
					$('#title').val("");
					$('#title').closest('.input').removeClass('input--filled');
					$('#institution').val("");
					$('#institution').closest('.input').removeClass('input--filled');
				}
				//alert("value1--"+Value1);
				$('#searchresult').css('height','auto');$('.searchterm').html('Searching inside 551,427 books (31TB of data)');
				$.ajax({
					url: 'functions.php?WhichField='+WhichField+'&Value='+encodeURIComponent(Value)+'&Value1='+encodeURIComponent(Value1),
					success: function (data) {
						//alert(data);
						$('#searchresult').html(data);
						if(Value!=""){
							$( ".modal" ).delay( 800 ).fadeIn( "slow", function() {
								$(this).css('display','none');
							});
						}
					}
				});
			}
			
			function reset(){
				$('#author').val("");	
				$('#author').closest('.input').removeClass('input--filled');
				$('#subject').val("");	
				$('#subject').closest('.input').removeClass('input--filled');
				$('#title').val("");
				$('#title').closest('.input').removeClass('input--filled');
				$('#institution').val("");
				$('#institution').closest('.input').removeClass('input--filled');
				$('.search').val("");
				//$('#dateofcitation').val("0");
				$('#From').css("left","100%");
				$('.ui-widget-header').css("left","0%");
				$('.ui-widget-header').css("width","100%");
				$('#To').css("left","0%");
				$('#date').val("0 - 11966");
				$('.range-slider__value').html("0");
				$('#searchresult').html("");
				$('.searchterm').html("");
			}								
		</script>
	</head>
	<body>
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
			<div class="container topnav">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand topnav" href="" style="width: 108px;"><img src="img/ssd_small.52230aa.gif"></a><h3 style="float: left;margin-top: 25px;">DLI Mirror</h3>
					<div class="searchdiv"><input type="text" placeholder="Search books" class="search" value="" name="search" onkeyup="displayresult('mainsearch',this.value,'')"></div>
					<p class="copyright" style="float:right;font-weight: normal;text-align: right;">A mirror of the Digital Library of India | <a href="http://www.dli.ernet.in/static/dli/copyright.html">DLI Copyright policy </a><img src="img/jaja.7e363e1.png" style="width: 10%;"></p> 
				</div>
			   
			</div>
			<!-- /.container -->
		</nav>

		<?php
			/*$sql="SELECT * FROM books";
			$result = mysqli_query($conn,$sql);
			$numofrows=mysqli_num_rows($result);
			echo "here--".$numofrows;*/
			
			$sql="SELECT MIN(dc_date_citation) as Maxcitationvalue FROM books WHERE dc_date_citation<>''";
			$result = mysqli_query($conn,$sql);
			$row=mysqli_fetch_assoc($result);
			//echo "here".$row['Maxcitationvalue'];
		?>
		<!-- Page Content -->
		<div class="intro-header">
			<div class="container">
				<div class="row">
			
							<div class="searchterm col-lg-8-5"></div>
							<div class="filter col-lg-3"><p> Filters </p></div>
				
					<div class="content-div">
						
						<div class="col-lg-12 categorydiv">
							
							<!--<button name="reset" value="Reset"></button>-->
							<div class="col-lg-8-5" id="searchresult"></div>   
							<div class="modal"></div>
							<div class="col-lg-3 filterdiv">
								<p style="color: #000000;font-size: 16px;padding-top: 15px;float: left;margin-right: 10px;">Select search conditions</p>
								<input value="RESET" style="float: left;" type="button" onclick="reset()">
								<p style="color: #444;margin-top: 26px;font-size: 17px;padding-left: 2px;margin-bottom: 5px">
									<label for="date" style="padding-right:2em;" >Publication Date&nbsp;&nbsp;&nbsp;</label>
									<input id="date" readonly="" style="border:0; color:#db4437; font-weight:bold; background: transparent;" type="text">
								</p>
								<div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" id="From" style="left: 15%;"></span>
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" id="To" style="left: 60%;"></span>
								</div>	
								<span class="input input--hoshi">
									<input type="text" name="title" id="title" class="input__field input__field--hoshi">
									<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="title">
										<span class="input__label-content input__label-content--hoshi">Name of Text</span>
									</label>
								</span>
								<input value="" type="hidden" name="authorvalue" id="authorvalue">
								<span class="input input--hoshi">
									<input type="text" name="author" id="author" class="input__field input__field--hoshi">
									<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="author">
										<span class="input__label-content input__label-content--hoshi">Author</span>
									</label>
								</span>
								
								<span class="input input--hoshi">
									<input type="text" name="institution" id="institution" class="input__field input__field--hoshi">
									<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="institution">
										<span class="input__label-content input__label-content--hoshi">Institution</span>
									</label>
								</span>
								
								<span class="input input--hoshi">
									<input type="text" name="subject" id="subject" class="input__field input__field--hoshi">
									<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="subject">
										<span class="input__label-content input__label-content--hoshi">Subject</span>
									</label>
								</span>																					
							</div>
							
						</div>

					</div>
				</div>
			</div>
			<!-- /.container -->
		</div>
		<script>
			$( function() {
				$( "#slider-range" ).slider({
					range: true,
					min: 0,
					max: 11966,
					values: [ 0, 11966 ],
					slide: function( event, ui ) {
						$( "#date" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
						displayresult('rangefilter',ui.values[ 0 ],ui.values[ 1 ]);
					}
				});
				$( "#date" ).val( $( "#slider-range" ).slider( "values", 0 ) +
					" - " + $( "#slider-range" ).slider( "values", 1 ) );					
			} );
		</script>
		<!-- /.intro-header -->
		<!-- /.Page Content -->

		<!-- Footer -->
		<!--<footer style="margin-top: 89px;border: 1px solid #e7e7e7;">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">                    
						<p class="copyright text-muted small" style="text-align:center">A mirror of the Digital Library of India | <a href="http://www.dli.ernet.in/static/dli/copyright.html">DLI Copyright policy</a>  <img src="img/jaja.7e363e1.png"></p>                    
					</div>
				</div>
			</div>
		</footer>-->
		
		<!-- Textbox jQuery -->
		<script src="js/classie.js"></script>
		<script>
			<!--Textbox script-->
			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, '');
						};
					})();
				}

				[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== '' ) {
						classie.add( inputEl.parentNode, 'input--filled' );
					}

					// events:
					inputEl.addEventListener( 'focus', onInputFocus );
					inputEl.addEventListener( 'blur', onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, 'input--filled' );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === '' ) {
						classie.remove( ev.target.parentNode, 'input--filled' );
					}
				}
			})();
			
			<!--Date range slider-->
			var rangeSlider = function(){
			var slider = $('.range-slider'),
			  range = $('.range-slider__range'),
			  value = $('.range-slider__value');
				
			  slider.each(function(){
				
				value.each(function(){
				  var value = $(this).prev().attr('value');
				  $(this).html(value);
				});

				range.on('input', function(){
					$(this).next(value).html(this.value);
					$('#author').val("");	
					$('#author').closest('.input').removeClass('input--filled');
					$('#subject').val("");	
					$('#subject').closest('.input').removeClass('input--filled');
					$('#title').val("");
					$('#title').closest('.input').removeClass('input--filled');
					$('#institution').val("");
					$('#institution').closest('.input').removeClass('input--filled');
					$('.search').val("");
					displayresult('rangefilter',this.value,"");
				});
			  });
			};
			rangeSlider();
			
			function OpenFile(Id){
				//alert(Id);
				window.open('bookpage.php?Id='+Id);
			}
		</script>	
	</body>
</html>
