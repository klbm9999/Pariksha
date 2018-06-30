<?php 

	include 'scripts/qlib.php';
	ob_start();
	set_time_limit(30);
	session_start();
	$questions = fetch_random_set_questions();
	$qintegrity = "";
	for ($i=0; $i <count($questions) ; $i++) { 
			$qintegrity .= $questions[$i]->get_answer();
	}

	/*if(isset($_SESSION['questions'])) {
		$questions = $_SESSION['questions'];
	}
	else {
		$_SESSION['questions'] = $questions;
	}*/
 ?>

 <!DOCTYPE html>
 <html>
 <head>

 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 	<title>Quiz</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

 	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 	 <script type="text/javascript" src="js/script.js"></script> 

 </head>
 <body>
 
 	<div class="container-fluid">
 		<div id="result" class="text-center h4 d-none alert alert-info" role="alert"></div>
 		<form data= <?php echo encrypt($qintegrity); ?> >
 		<?php 

 			foreach ($questions as $index=>$q) {
 				$q->html($index);
 			}

 		 ?>
 		 <button type="button" onclick=verifySubmission()>Submit</button>
 		</form>
 	</div>

 </body>
 </html>

 <?php 


 ob_flush();

  ?>