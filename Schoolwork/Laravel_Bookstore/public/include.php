<div class="menu">
	<a href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/store/browse">Home</a>
	<?php
	$logged = Session::get('username');
	if (!isset($loginpage) && !isset($logged)) {
	    echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/register">Register</a>
	        <a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/login">Login</a>';
	} else if(isset($loginpage) && $loginpage == 4){
		echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/login">Login</a>';
	}
	if (isset($logged)) {
	    echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/user">' . $logged . '</a>
	    <a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/logout">Logout</a>
	    <a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/viewcart"> Cart</a>';
	}

	echo Form::open(array('url' =>  '/store/search'));
	echo "<br>Search: " . Form::text('search') . " ";
	echo Form::submit('search') . "<br><br>";
	echo Form::close();

	if (!isset($loginpage) && !isset($logged)) {
	    echo '<div class="login">';
	    echo Form::open(array('url' => dirname($_SERVER['SCRIPT_NAME']) . 'store/login'));
	    echo Form::label('username', 'Username: ');
	    echo Form::text('username') . "<br>";
	    echo Form::label('password', 'Password: ');
	    echo Form::password('password') . "<br>";
	    echo Form::submit('login');
	    echo Form::close();
	    echo "</div>";
	}
	?>
</div>