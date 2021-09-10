 
<?php
include 'admin/db_connect.php';

$mov = $conn->query("SELECT * FROM movies where id =".$_GET['id'])->fetch_array();
$duration = explode('.', $mov['duration']);
$hr = sprintf("%'.02d\n",$duration[0]);
$min = isset($duration[1]) ? (60 * ('.'.$duration[1])) : '0';
$min = sprintf("%'.02d\n",$min);
 // $min = $min > 0 ? $min : '00';
$duration = $hr.' : '.$min;

?>

<header class="masthead">
	<div class="container pt-5">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-4">
					<img src="assets/img/<?php echo $mov['cover_img'] ?>" alt="" class="reserve-img">
				</div>
				<div class="col-md-8">
					<div class="card bg-primary">
						<div class="card-body text-white">
							<h3><b><?php echo $mov['title'] ?></b></h3>
							<hr>
							<p class=""><small><b>Synopsis: </b><i><?php echo $mov['description'] ?></i></small></p>
							<p class=""><small><b>Duration: </b><i><?php echo $duration ?></i></small></p>
						</div>
					</div>
					<div class="card bg-light mt-2">
						<div class="card-body">
							<h4>Reserve your seat Here</h4>

							<form  id="save-reserve">
								<input type="hidden" name="movie_id" value="<?php echo $_GET['id'] ?>">
								<div class="row">

									<div class="form-group col-md-6">
										<label for="" class="control-label" >Username</label>
										<input type="text" name="username" required="" class="form-control" 
										value="<?=  (count($_SESSION)) >0 ?  $_SESSION['user'] : '' ?>">
									</div> 
									<?php //echo $_SESSION['user']?> 
									<div class="form-group col-md-6">
										<label for="" class="control-label">Contact #</label>
										<input type="number" name="contact_no" required="" class="form-control"
										value="<?=  (count($_SESSION)) >0 ?  $_SESSION['contact'] : '' ?>" 

										> 										
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label for="" class="control-label">Theater</label>
										<select class="browser-default custom-select" name="theater_id">
											<option value="" selected >  Select a theater</option>
											<?php 
											$qry = $conn->query("SELECT * FROM  theater order by name asc");
											while($row= $qry->fetch_assoc()):
												?>	
												<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
											<?php endwhile; ?>
										</select>
									</div> 								</div> 


									<div id="display-other">
									</div>

									<div class="row ml-1">
										<button type="submit" class="btn btn-primary w-100 rounded-pill">Pay</button>
									</div>
								</form>
								<!-- Modal -->
								<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">
													Please fill up your card credentials.
												</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form action="#">
													<div class="form-group">
														<label for="cardNumber">Card Number</label>
														<input type="email" class="form-control" id="cardNumber" placeholder="Enter your card number" name="number">
													</div>

													<div class="form-group">
														<label for="exporation">Expiration</label>
														<input type="text" class="form-control" id="exporation" name="expiry" placeholder="MM/YY">
													</div>

													<div class="form-group">
														<label for="cvv">CVV</label>
														<input type="text" class="form-control" id="cvv" name="cvv" placeholder="Your CVV">
													</div>

													<button type="button" id="submitPayment" class="btn btn-primary w-100 rounded-pill">Submit</button>

												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
</div>

<script>
	$('[name="theater_id"]').change(function(){
		$.ajax({
			url:'manage_reserve.php?id='+$(this).val()+'&mid=<?php echo $_GET['id'] ?>',
			success:function(resp){
				$('#display-other').html(resp)
			}
		})
	});

	$(document).ready(function(){
		$('#save-reserve').submit(function(e){
			e.preventDefault();
			var numberOfChecked = $('input:checkbox:checked').length;

			if(numberOfChecked == 0){
				swal({
					text: "Please, select a seat.",
					icon: "error",
					button: "Ok",
				});
			}else{
				// $('#save-reserve button').attr('disabled',true).html("Processing..")
				$('#paymentModal').modal('show')
			}
		});
	})
</script>
<script>

	$(function() {
		$('#submitPayment').click(function(e){
			e.preventDefault();
			var expMonthAndYear = $('input[name=expiry]').val().split("/");
			Stripe.card.createToken({
				number: $('input[name=number]').val(),
				cvc: $('input[name=cvv]').val(),
				exp_month: expMonthAndYear[0],
				exp_year: expMonthAndYear[1]
			}, stripeResponseHandler);
		});
	});

	var stripeResponseHandler = function(status, response) {
		if (response.error) { 
    // Show appropriate error to user
    swal({
					text: response.error.message,
					icon: "error",
					button: "Ok",
				});
  } else {
    // Get the token ID:
    var token = response.id;
    // Save token mapping it to customer for all future payment activities
    // alert("sucess")
    	let moviePrice = $('.js-price').val();
		let movieQuantity = $('.js-qty').val();
    $.ajax({
    	url:`payment/submit.php?price=${moviePrice}&quantity=${movieQuantity}`,
    	method:'POST',
    	data:response,
    	success:function(resp){
    		$('#paymentModal').modal('hide')
    		swal({
					text: "Payment Success",
					icon: "success",
					button: "Ok",
				});
				setTimeOut(() =>{
					window.location.reload();
				},3000)
    	}
    });
  }
}


</script>