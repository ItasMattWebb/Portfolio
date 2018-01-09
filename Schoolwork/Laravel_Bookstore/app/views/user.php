<!-- EDIT View -->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/css/site.css"/>
        <title><?php echo Auth::user()->username ?>'s account. Bookstore</title>
    </head>
    <body>
        <div id="bg">            
            <?php
            include "include.php";
            echo "<div id=\"header\">Laravel Bookstore</div><div>";
            echo '<table border="0"><tr class="tbl_header"><td>username</td><td>password</td><td>email</td></tr>';
            echo '<tr class="odd"><td>' . Auth::user()->username . '</td><td>' . Auth::user()->password . '</td><td>' . Auth::user()->email . '</td></tr>';
            echo '<tr class="even"><td>' . Form::open(array('url' => 'store/user/username'));
            echo Form::text('username') . "<br>";
            echo Form::submit('change username') . '</td>';
            echo Form::close();
            echo '</tr><tr class="odd"><td>' . Form::open(array('url' => 'store/user/password'));
            echo Form::password('password') . "<br>";
            echo Form::submit('change password');
            echo Form::close() . '</td></tr>';
            echo '<tr class="even"><td>' . Form::open(array('url' => 'store/user/email'));
            echo Form::email('email') . "<br>";
            echo Form::submit('change email') . '</td></tr>';
            echo Form::close();
            ?>
            </table>
        </div>
    </div>
</form>
</body>
</html>