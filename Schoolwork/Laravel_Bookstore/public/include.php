<a href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/store/browse">home</a>

<?php
$logged = Session::get('username');
if (!isset($loginpage) && !isset($logged)) {
    echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/register">register</a>
        <a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/login">login</a>';
}

echo Form::open(array('url' =>  '/store/search'));
echo "<br>search: " . Form::text('search') . " ";
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
} else {
    if (isset($logged)) {
        echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/user">' . $logged . '</a> ';
        echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/logout">logout</a>';
        echo '<a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/viewcart"> Cart</a>';
    }
}
?>
