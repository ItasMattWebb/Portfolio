<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/site.css"/>
        <title>Laravel Bookstore</title>
    </head>
    <body>
        <div id="bg">
            <?php
            include "include.php";
            echo "<div id=\"header\">Laravel Bookstore</div>";
            echo Form::open(array('url' => 'store/register', 'method' => 'post'));
            echo Form::label('username', 'Username: ');
            echo Form::text('username') . "<br><br>";
            echo Form::label('password', 'Password: ');
            echo Form::password('password') . "<br><br>";
            echo Form::label('email', 'E-mail Address: ');
            echo Form::email('email') . "<br><br>";
            echo Form::submit('register');
            echo Form::close();

            if (Input::get('password') != null && Input::get('username') != null && Input::get('email') != null) {
                $username = Input::get('username');
                $password = Hash::make(Input::get('password'));
                $email = Input::get('email');
                $userexists = User::where('username', '=',$username)->get();
                $emailexists = User::where('email', '=', $email)->get();
                if (isset($userexists->username) || isset($emailexists->username)) {
                    echo "This username or email is already taken.";
                } else {
                    $user = new User;
                    $user->username = $username;
                    $user->password = $password;
                    $user->email = $email;
                    $user->save();
                    $cart = new Cart;
                    $cart->save();
                    echo "Account created successfully";
                }
            } else {
                echo "please fill in all fields";
            }
            ?>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </body>
</html>