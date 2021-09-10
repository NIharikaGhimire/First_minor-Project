<?php
require('stripe-php-master/init.php');

$publishableKey ="pk_test_51JQl6tSEid0sNiv5NGGvOscQmDMm2iG21tymT4XxbOaGlL4AHCALFpgkK5hDtgXdaVh39j1djrLPC5FAwtbKokVR00swwUKXsP";

$secretkey = "sk_test_51JQl6tSEid0sNiv51zmYz3IcLPRHH1xeomcU6wtHEdTP4FIeGsu1GDoAVriuU6mkK5vONW9ypyZmZyG3wZ3CS9Ad00eKoL5MRt";

\Stripe\Stripe::setApiKey($secretkey);


?>
