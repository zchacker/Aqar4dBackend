<?php
  $fn = fopen("codes.txt","r");
  
  while(! feof($fn))  {
	$result = fgets($fn);
	echo 'https://play.google.com/redeem?code='.$result;
	echo '<br/><br/>';
  
  }

  fclose($fn);
 
?>