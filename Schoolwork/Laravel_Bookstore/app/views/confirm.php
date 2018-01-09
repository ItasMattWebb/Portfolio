<!--DISPLAY View -->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/css/site.css">
        <title>Laravel Bookstore</title>
    </head>
    <body>
        <div id="bg">
            <?php
            include "include.php";
            ?>
            <div id="header">Laravel Bookstore</div>
            <div  align='center'>
                <p>Are you sure you want to remove <?php echo Book::find($bookid)->title; ?> from your cart?</p>
                <?php
                echo Form::open(array('url' => '/store/removecart/' . $bookid));
                echo Form::submit('Yes');
                echo Form::close();
                echo Form::open(array('url' => '/store/viewcart'));
                echo Form::submit('No');
                echo Form::close();
                ?>
            </div>
        </div>
    </body>
</html>