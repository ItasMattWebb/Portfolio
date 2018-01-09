<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/css/site.css"/>
        <title>Laravel Bookstore</title>
    </head>
    <body>
        <div id="bg">
            <?php
            $loginpage = 5;
            include "include.php";
            echo "<div id=\"header\">Laravel Bookstore</div>";
            if (Input::get('password') != null && Input::get('username') != null) {
                $username = Input::get('username');
                $password = Input::get('password');
                if (Auth::attempt(array('username' => $username, 'password' => $password))) {
                    echo $username . " logged in successfully.";
                    Session::put('username', $username);
                } else {
                    echo "Username or password is incorrect.";
                    echo Form::open(array('url' => 'store/login'));
                    echo Form::label('username', 'Username: ');
                    echo Form::text('username') . "<br><br>";
                    echo Form::label('password', 'Password: ');
                    echo Form::password('password') . "<br><br>";
                    echo Form::submit('login');
                    echo Form::close();
                }
            } else {
                echo Form::open(array('url' => 'store/login'));
                echo Form::label('username', 'Username: ');
                echo Form::text('username') . "<br><br>";
                echo Form::label('password', 'Password: ');
                echo Form::password('password') . "<br><br>";
                echo Form::submit('login');
                echo Form::close();
            }
            ?>
        </div>
    </body>
</html>