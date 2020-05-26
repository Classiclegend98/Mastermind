<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Mastermind Game</title>

  </head>
  <body>
  <div class="p-3 mb-2 bg-secondary text-white">Mastermind Game</div>
    
	  <?php

session_start();

if(!isset($_SESSION['number'])){
  $_SESSION['number'] = random_number();
  $_SESSION['tries'] = [];
}

if (isset($_POST['userNumber'])){
  $userName = $_POST['userName'];
  if (is_valid_numeric($userNumber)) {
    $noOfCorrectDigits = count_correct_digits($userNumber);
    $noOfDigitsInPosition = count_digits_in_position($userNumber);
	  
	$_SESSION['tries'][] = 
		"$userNumber : correct - $noOfCorrectDigits " . 
		 "in place - $noOfCorrectDigits <br>";
	  
	  echo implode($_SESSION['tries']);
	  
	  if ($userNumber == $_SESSION['number']){
		  echo "You win!";
		  die();
	  }
  }
}

function count_correct_digits(int $userNumber): int
{
  $sessionNumber = $_SESSION['number'];
  $commonDigits = array_intersect(
    str_split($sessionNumber),
    str_split($userNumber)
  );
  return count($commonDigits);
}


function count_digits_in_position (int $userNumber): int
{
	$sessionNumber = $_SESSION['number'];
	$count = 0;
	for ($i = 0; $i < 3; $i++) {
		if (substr($userNumber, $i, 1) == substr($sessionNumber, $i, 1)){
			$count++;
		}
	}
	return $count;
}
	  
function is_valid_number(int $userNumber): bool
{
	return strlen($userNumber)== 3 
		   && !has_repeated_digits($userNumber)  ; 
}
	  
?>
	  
<form method="post" action="mastermind.php">

  <label> Guess the number</label>
  <input type="text" name="userNumber"/>
  <button type="submit">Send</button>

</form>

<?php

echo random_number();

function random_number(): int
{
  do {
    $number = rand(102, 987);
  }

  while (has_repeated_digits($number));
    return $number;
}

function has_repeated_digits(int $number): bool
{
  $digits = str_split($number);
  $uniqueDigits = array_unique($digits);

  if (count($uniqueDigits) === count($digits)) {
    return false;
  } else {
    return true;
  }
}

     ?>

  </body>