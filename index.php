<?php include("path.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include(ROOT_PATH . "/app/include/head_links.php"); ?>
	<title>Online Counselling System</title>
</head>
<body>
	<!-- Header -->
	<section class="header">
	<!-- Navlinks -->
	<?php include(ROOT_PATH . "/app/include/navigation_links.php"); ?>
		<div class="text-box">
			<h1>Going through emotional hurts?</h1>
			<p>Do You Need Advice on Any Matter? <br>Speak to A Counselor</p>
			<button href="" class="hero-btn" onclick="showHide()">Chat with us</button>
			
		</div>
	</section>
	<!-- Chat box section -->
	<?php include(ROOT_PATH . "/app/include/chat.php"); ?>
	<!--- Our Values --->
	<?php include(ROOT_PATH . "/app/include/our_values.php"); ?>
	<!--- Our online Counsellors --->
	<?php include(ROOT_PATH . "/app/include/online_counsellors.php"); ?>
	<!--- Call to action --->
	<section class="cta">
		<h1>Do You Need Advice on Any Matter? </br>Speak to A Counselor</h1>
		<a href="" class="hero-btn">CONTACT UP</a>
	</section>

	<!--Page Footer-->
	<?php include(ROOT_PATH . "/app/include/footer.php"); ?>

	<script type="text/javascript" src="assets/js/app.js"></script>
	<script src="assets/js/jquery-3.6.4.min.js"></script>

	<script>
		// AutoScroll the chat box bar
		window.setInterval(function(){
            var scrollMessage = document.getElementById('messageScreen');
            scrollMessage.scrollTop = scrollMessage.scrollHeight;
        }, 500);


		// Jquery start
		$(document).ready(function(){
			$("#messages").on("keyup",function(){
				if($("#messages").val()){
					$("#send").css("display","block");
				}else{
					$("#send").css("display","none");
				}
			});
			//Disabled the autocomplete
    		$('#messages').attr('autocomplete','off');
		});		

		// When send button is clicked
		$("#send").on("click", function(e){
			$userMessage = $("#messages").val();
			$appendUserMessage = '<div class="chat usersMessages">'+ $userMessage + '</div>';
			$("#messageScreen").append($appendUserMessage)
		
			// Start ajax
			$.ajax({
				url: "app/controller/bot",
				type: "POST",
				//Sending data
				data:{messageValue: $userMessage},
				//response text
				success: function(data){
					//Show response	

					$appendBotResponse = '<div id="messagesContainer"> <div class="chat botMessages">' +data+ '</div></div>';
					$("#messageScreen").append($appendBotResponse);

				}
			});
			// $("messages").val("");
			$("#messages").val('');
			$("#send").css("display","none");
		});
	</script>
</body>
</html>