<?php

$challenges = scandir('Challenges/');

array_splice($challenges, 0, 2);

$links = array();
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
foreach($challenges as $challenge) {
	if($_SERVER['REQUEST_URI'] == '/Challenges/' . $challenge . "/"){
		$links[] = '<a class="current">Challenge #' . $challenge . '</a>' ;
	} else {
		if(is_dir('Challenges/' . $challenge)){
			$links[] = '<a href="'. $protocol . $_SERVER['HTTP_HOST'] . '/Challenges/' . $challenge . '">Challenge #' . $challenge . '</a>' ;
		}
	}

}

?>

<ul>
	<?php foreach ($links as $key => $link) {
		echo "<li>" . $link . "</li>";
	} ?>
</ul>
