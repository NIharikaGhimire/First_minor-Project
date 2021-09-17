<?php

include 'admin/db_connect.php';

$ts = $conn->query("SELECT * FROM theater_settings where theater_id={$_GET['id']} and movie_id={$_GET['mid']}");
$data = array();
while($row=$ts->fetch_assoc()){
	array_push($data,$row);
}

$mov = $conn->query("SELECT * FROM movies where id =".$_GET['mid'])->fetch_array();
$dur = explode('.', $mov['duration']);
$freeEntry = $mov['entry_fee'];
$dur[1] = isset($dur[1]) ? $dur[1] : 0;
$hr = sprintf("%'.02d\n",$dur[0]);
$min = isset($dur[1]) ? (60 * ('.'.$dur[1])) : '0';
$min = sprintf("%'.02d\n",$min);
 // $min = $min > 0 ? $min : '00';
$duration = $hr.' : '.$min;

?>
<div class="row">
	<div class="form-group col-md-12">
		<label for="" class="control-label">Choose Seat Group</label>
		<select name="seat_group" id="seat_group" class="custom-select default-browser" onchange="resetPrice()">
			<option value="" selected > Select a seat group.</option>
			<?php 
			foreach($data as $k => $v):?>
				<option value="<?= $v['id'] ?>" data-count="<?= $v['seat_count'] ?>" data-letter="<?= $v['seat_group'] ?>" data-json="<?= str_replace('"', "'", $v['seats']) ?>"><?= $v['seat_group'] ?></option> 
			<?php endforeach; ?>
		</select>
	</div>

	<div id="display-count" class="col-md-5 pt-2"></div>		
</div>

<p id="js-visible" style="display: none;">Choose a seat</p>

<div class="row js-append-sheat"></div>

<div class="row">
	
	<div class="form-group col-md-6">
		<label for="" class="control-label">Date</label>
		<select name="date" id="date" class="custom-select browser-default">
			<?php 
			for($i = 0 ; $i <  date("Ymd",strtotime($mov['end_date'])) - date('Ymd');$i++ ){
				if(date('Ymd') >= date("Ymd",strtotime($mov['date_showing']))){
					echo "<option value='".date('Y-m-d',strtotime(date('Y-m-d').' +'.$i.' days'))."'>".date('M d,Y',strtotime(date('Y-m-d').' +'.$i.' days'))."</option>";
				}
			}
			?>
		</select>
	</div>
	<div class="form-group col-md-6">
		<label for="" class="control-label">Time</label>
		<select name="time" id="time" class="custom-select browser-default">
			<?php 
			$i = 1;
			$start = '2020-01-01 09:00';
			$time='';
			$dur[1] = isset($dur[1]) ? $dur[1] : 0;
			while ( $i < 10) {
				if(empty($time)){
					echo '<option value="'.date('h:i A',strtotime($start)).'">'.date('h:i A',strtotime($start)).'</option>';
					$time = date('h:i A',strtotime($start));
				}else{
					$time = empty($time) ? $start : $time;
					if(date('Hi',strtotime($time)) < '2100'){
						echo '<option value="'.date('h:i A',strtotime($time.' +'.$dur[0].' hours +'.$dur[1].' minutes')).'">'.date('h:i A',strtotime('+'.$dur[0].' hours +'.$dur[1].' minutes'.$time)).'</option>';
						$time = date('Y-m-d H:i',strtotime('+'.$dur[0].' hours +'.$dur[1].' minutes'.$time));
					}
				}
				$i++;
			}
			?>
		</select>
	</div>
</div>

<div class="row">

	<div class="form-group col-md-6">
		<label for="" class="control-label">Total Amount</label>
		<input type="text" name="amount" required="" class="form-control js-price" readonly value="0">
	</div>
	<div class="form-group col-md-6">
		<label for="" class="control-label">Qty</label>
		<input type="number" name="qty" id="qty" class="form-control js-qty" value="0" readonly required="">
	</div>
</div>

<script src="js/scripts.js"></script>
<!-- Helper to increment or decrement the price valu on change of seat -->
<script>
	function resetPrice(){
		$('.js-price').val(0);
	}
	function setTotal(event,value){
		let values = $('.js-price').val();
		let quantity = $('.js-qty').val();
		if(event.checked){
			$('.js-price').val(parseInt(values) + parseInt(value));
			$('.js-qty').val(parseInt(quantity) + 1);
		}else{
			$('.js-price').val(parseInt(values) - value);
			$('.js-qty').val(parseInt(quantity) - 1);
		}
	}
</script>
<script>
			var entryFee = "<?= $freeEntry ?>";
	$(document).ready(function(){
		$('#seat_group').change(function(e){
			e.preventDefault();
			$('#display-count').html($(this).find('option[value="'+$(this).val()+'"]').attr('data-count')+' seats available')
			$('#qty').removeAttr('max').attr('max',$(this).find('option[value="'+$(this).val()+'"]').attr('data-count'))
			const totalSeat = $(this).find('option[value="'+$(this).val()+'"]').attr('data-count');
			const [allSeats] = $(this).find('option[value="'+$(this).val()+'"]');
			const data = $(allSeats).data('json');
			const fullName = $(allSeats).data('letter');

			let letter = fullName.charAt(0);
			$('.js-append-sheat').empty();
			$('#js-visible').css("display","block");

			$('.js-append-sheat').append(`
				<input type="hidden" name="selected_seats"  value="${data}"/>
				`)

			for (let i = 1; i <= totalSeat; i++) {
				let value = letter + i;
				let status = data.includes(value)
				let checkStatus = status ? 'checked' : ''
				let checkDisable = status ? 'disabled readonly' : ''

				$('.js-append-sheat').append(`
					<div class="col-md-6">
					<div class="input-group mb-3">
					<div class="input-group-prepend">
					<div class="input-group-text">
					<input type="checkbox" 
					class="js-check" 
					name="seats[]" 
					onchange="setTotal(this,entryFee)"
					${checkStatus}
					${checkDisable}
					value="${value}" aria-label="Checkbox for following text input">
					</div> 
					</div>
					<input type="text" value="${value}" class="form-control" aria-label="Text input with checkbox" readonly >
					</div>
					</div>
					`);
			}

		});
	});


</script>