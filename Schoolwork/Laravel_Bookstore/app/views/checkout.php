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
            <div>
                <table>
                    <tr class="tbl_header">
                        <th>Picture</th>
                        <th>Title</th>
                        <th>Price</th>
                    </tr>
                    <?php
                    $stripe = false;
                    $totalprice = "";
                    foreach ($query as $book) {
                        $entry = Book::find($book);
                        $stripe = !$stripe;
                        if ($stripe) {
                            echo '<tr class="odd"> ';
                        } else {
                            echo '<tr class="even"> ';
                        }
                        echo '<td><img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/assets' . $entry['picture'] . '" width="42px" height="42px"></td>';
                        echo "<td>" . substr($entry['title'], 0, 45) . "<br>" . substr($entry['title'], 45) . "</a></td>";
                        echo '<td>' . $entry['price'] . '</td>';
                        echo '</td></tr>';
                        $totalprice += $entry['price'];
                    }
                    echo "<tr><td></td><td>Total:</td><td>" . $totalprice . "</td></tr></table></div><div>";
            echo Form::open(array('url' => dirname($_SERVER['SCRIPT_NAME']) . 'store/receipt'));
            echo Form::label('credit', 'Credit card #: ');
            echo Form::text('credit') . "<br>";
            echo Form::submit('complete purchase');
            echo Form::close();
            echo "</div>";
            ?>
        </div>
    </body>
</html>