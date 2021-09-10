<?php

require('config.php');
?>
<form action = "submit.php" method = "post">
	<script
	src = "https://checkout.stripe.com/checkout.js" class="stripe-button" 
	data-key ="<?php echo $publishableKey ?>"
	data-amount = "500"
	data-name = "Theater Seat Booking system"
	data-description ="Theater Seat Booking system desc"
	data-image =""
	data-currency = "inr"
	data-email = "niharikaghimire29@gmail.com"

	 >
		
	</script>

	</form>