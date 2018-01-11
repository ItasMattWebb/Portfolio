<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/css/site.css">
        <title>Laravel Bookstore</title>
    </head>
    <body>
        <div id="bg">
            <?php
            $loginpage = 4;
            include "include.php";
            echo '<div id="header">Laravel Bookstore</div>';
            echo Form::open(array('url' => 'store/register', 'method' => 'post'));
            echo Form::label('username', 'Username: ');
            echo Form::text('username', Input::get('username')) . "<br><br>";
            echo Form::label('password', 'Password: ');
            echo Form::password('password') . "<br><br>";
            echo Form::label('email', 'E-mail Address: ');
            echo Form::email('email', Input::get('email')) . "<br>";
            echo Form::submit('register');
            echo Form::close();
			echo $message . "<br>";
            echo "please fill in all fields";
            ?>
        </div>
    </body>
</html>