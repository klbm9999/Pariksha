<?php 
	set_time_limit(30);
	error_reporting(E_ALL);
	$config = include('config.php');

	/**
	* Question class, contains the question part, the options and the corresponding answer
	*/	

	define('NO_OF_QUESTIONS', $config['no_of_questions']);
	define('DB_HOST', $config['host']);
	define('DB_USER', $config['user']);
	define('DB_PASS', $config['pass']);
	define('DB_NAME', $config['db_name']);
	
	
	class Question
	{
		private $qno;
		private $description;
		private $options;
		private $answer;
		function __construct($qnumber,$desc,$optn,$ans)
		{
			$this->qno = $qnumber;
			$this->description = $desc;
			$this->options = explode(',', $optn);
			$this->answer = $ans;
		}
		function html($qno) 
		{
			$qno = $qno+1;
			?>

			<div class="d-flex p-2"> <?php echo $qno.'. '.$this->description; ?> </div>
	 		<div class="d-flex flex-column p-3">
	 			<?php for($i=0;$i<count($this->options);$i++) { ?>
		 			<div class="p-1"><input type="radio" name=<?php echo "q".$qno; ?> value= <?php echo $i+1; ?> > <?php echo $this->options[$i]; ?></input></div>
	 			<?php  } ?>
	 		</div>

	 		<?php  
		}
		function get_answer()
		{
			return strval($this->answer);
		}
		function get_qno()
		{
			return strval($this->qno);
		}
	}

	function connect_db()
	{
		$servername = DB_HOST;
		$username = DB_USER;
		$password = DB_PASS;
		$dbname = DB_NAME;

		try {
			$connection = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "Connected successfully";
		} 
		catch (PDOException $e) {
			echo 'Connection Failed : '.$e->getMessage();
		}		
		
		return $connection;
	}

	function fetch_random_set_questions() {
		$conn = connect_db();
		$no_of_questions = NO_OF_QUESTIONS;
		$qnos = UniqueRandomNumbersWithinRange(1,5,$no_of_questions);

		$questions = array();

		$stmt = $conn->prepare('SELECT qno,description,options,answer FROM questions WHERE qno=:qno');

		for ($q=0; $q < count($qnos); $q++) { 
			$stmt->bindParam(':qno',$qnos[$q]);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			foreach ($stmt->fetchAll() as $key => $value) {
				$temp = new Question($value["qno"],$value["description"],$value["options"],$value["answer"]);
				$questions[] = $temp;
			}
		}
		$conn = NULL;
		return $questions;
	}

	function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
	    $numbers = range($min, $max);
	    shuffle($numbers);
	    return array_slice($numbers, 0, $quantity);
	}

	function verifySubmission($submission,$encrypted_qno)
	{
		$qnos = decrypt($encrypted_qno);
		$qnos = str_split($qnos);

		$conn = connect_db();
		$stmt = $conn->prepare('SELECT answer FROM questions WHERE qno=:qno');

		$answers = array();

		for($i=0;$i<count($qnos);$i++) {
			$stmt->bindParam(':qno',$qnos[$i]);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			foreach ($stmt->fetchAll() as $key => $value) {
				$temp = $value["answer"];
				$answers[] = $temp;
			}	
		}

		$count = 0;
		$sub = json_decode($submission);
		$no_of_questions = min(count($sub),NO_OF_QUESTIONS);

		for ($i=0; $i <$no_of_questions; $i++) { 
			if ($sub[$i]->value==$answers[$i]) {
				$count++;
			}
		}
		$score = $count.'/'.NO_OF_QUESTIONS;
		return $score;
	}

	// THIS IS TOTALLY NOT USEFUL ENCRYPTION AND DECRYPTION FIXIT

	function encrypt($message)
	{
		return base64_encode($message);
	}


	function decrypt($encrypted)
	{
		return base64_decode($encrypted);
	}

	function logout() {
		session_destroy();
	}

	function load_frontend_scripts() {
	?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		 <script type="text/javascript" src="js/script.js"></script>

	 <?php 
	}

	/*function test() {
		$instance = new Question('whats your name','a,b,c,d',1);
		$instance->print();
	}*/

 ?>