<!--DISPLAY View -->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/site.css">
        <title>Laravel Bookstore</title>
    </head>
    <body>
        <div id="bg">
            <?php
            include "include.php";
            ?>
            <div id="header">Laravel Bookstore</div>
            <div>
                <table border="0">
                    <tr class="tbl_header">
                        <th>Picture</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Remove</th>
                    </tr>
                    <?php
                    $stripe = false;
                    foreach ($query as $book) {
                        $entry = Book::find($book);
                        $stripe = !$stripe;
                        if ($stripe) {
                            echo '<tr class="odd"> ';
                        } else {
                            echo '<tr class="even"> ';
                        }
                        echo '<td><img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/assets' . $entry['picture'] . '" width="42px" height="42px"></td>';
                        echo '<td><a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/select/' . $entry['id'] . '"> ' . $entry['title'] . '</a></td>';
                        echo '<td>' . $entry['author'] . '</td>';
                        echo '<td>' . $entry['price'] . '</td>';
                        /**
                         * Display rating as stars
                         */
                        $rating = $entry['rating'];
                        $ratingstar = "";
                        for($i = 0; $i < 5; $i++) {
                        	if($i < $rating){
                            	$ratingstar .= "&#9733;";
                        	}
                            $ratingstar .= "&#9734;";
                        }
                        echo '<td>' . $ratingstar . '</td>';
                        echo '<td>';
                        if ($book != 0) {
                            echo Form::open(array('url' => dirname($_SERVER['SCRIPT_NAME']) . '/store/checkremovecart/' . $entry['id']));
                            echo Form::submit('remove from cart');
                            echo Form::close();
                            echo '</td></tr>';
                        }
                    }
                    echo '<tr class="even"><td></td><td></td><td></td><td></td><td></td><td><a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/checkout">checkout</a></td><tr>';
                    ?>

                </table>
            </div>
        </div>
    </body>
</html>