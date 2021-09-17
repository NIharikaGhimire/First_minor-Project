<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct() {
		$this->db->close();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			// var_dump($_SESSION);
			return 1;
		}else{
			return 2;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function save_movie(){
		extract($_POST);
		$data = " title = '".$title."' ";
		$data .= ", description = '".$description."' ";
		$data .= ", date_showing = '".$date_showing."' ";
		$data .= ", end_date = '".$end_date."' ";
		$duration =  $duration_hour .'.'.(($duration_min / 60) * 100);
		$data .= ", duration = '".$duration."' ";


		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/img/'. $fname);
			$data .= ", cover_img = '".$fname."' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO movies set ". $data);
			if($save)
				return 1;
		}else{
			$save = $this->db->query("UPDATE movies set ". $data." where id =".$id);
			if($save)
				return 1;
		}
	}
	function delete_movie(){
		extract($_POST);
		$delete  = $this->db->query("DELETE FROM movies where id =".$id);
		if($delete)
			return 1;
	}
	function delete_theater(){
		extract($_POST);
		$delete  = $this->db->query("DELETE FROM theater where id =".$id);
		if($delete)
			return 1;
	}
	function save_theater(){
		extract($_POST);
		if(empty($id))
			$save = $this->db->query("INSERT INTO theater set name = '".$name."' ");
		else
			$save = $this->db->query("UPDATE theater set name = '".$name."' where id = ".$id);
		if($save)
			return 1;
	}
	function save_seat(){
		extract($_POST);
		$data = " theater_id = '".$theater_id."' ";
		$data .= ", seat_group = '".$seat_group."' ";
		$data .= ", seat_count = '".$seat_count."' ";
		$data .= ", movie_id = '".$movie_id."' ";
		if(empty($id))
			$save = $this->db->query("INSERT INTO theater_settings set ".$data." ");
		else
			$save = $this->db->query("UPDATE theater_settings set ".$data." where id = ".$id);
		if($save)
			return 1;

	}
	function delete_seat(){
		extract($_POST);
		$delete  = $this->db->query("DELETE FROM theater_settings where id =".$id);
		if($delete)
			return 1;
	}
	function save_reserve(){
		
		$seats = $_POST['seats'];
		$stripe_id = $_GET['stripe_id'];
		$charge_id = $_GET['charge_id'];
		$totalSeats = count($_POST['seats']);
		extract($_POST);
		$data = " movie_id = '".$movie_id."' ";
		$data .= ", ts_id = '".$seat_group."' ";
		$data .= ", username = '".$username."' ";
		$data .= ", contact_no = '".$contact_no."' ";
		$data .= ", qty = '".$qty."' ";
		$data .= ", `date` = '".$date."' ";
		$data .= ", `time` = '".$time."' ";
		$data .= ", `amount` = '".$amount."' ";
		$data .= ", `stripe_id` = '".$stripe_id."' ";
		$data .= ", `charge_id` = '".$charge_id."' ";
		$data .= ", `is_booked` = '".json_encode($_POST['seats'])."' ";


		$save = $this->db->query("INSERT INTO books set ".$data);

		$row = $this->db->query("SELECT seats FROM theater_settings where id = {$seat_group}");

		$result = $row->fetch_array();

		if($result['seats']){
			$val = json_encode(array_merge(json_decode($result['seats']),$seats));
		}else{
			$val = json_encode($seats);
		}

		$this->db->query("UPDATE theater_settings set seats = '".$val."' where id = ".$seat_group);


		if($save)
			return 1;
	}

	// Process to Refund 
	function process_refund()
	{
		$save = $this->db->query("UPDATE books set refund = 1 where id = ".$_GET['booksId']);

		if($save)
			return 1;
	}
}



