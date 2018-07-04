<?php 

	include 'scripts/qlib.php';
	ob_start();
	set_time_limit(30);
	session_start();
	$questions = fetch_random_set_questions();
	$qintegrity = "";
	for ($i=0; $i <count($questions) ; $i++) { 
			$qintegrity .= $questions[$i]->get_qno();
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

 	<?php load_frontend_scripts(); ?>

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