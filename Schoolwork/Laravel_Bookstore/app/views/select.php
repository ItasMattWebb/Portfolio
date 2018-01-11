<!-- EDIT View -->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/css/site.css"/>
        <title><?php echo substr($booklist->title, 0, 20); ?>... Bookstore</title>
    </head>
    <body>
        <div id="bg">            <?php
            include "include.php";
            echo '<div id="header">Laravel Bookstore</div><div>';
            echo '<table border="0"><tr class="tbl_header"><td>title</td><td>author</td><td>course</td><td>isbn</td><td>instructor</td></tr>';
            echo '<tr class="odd"><td>' . $booklist->title . '</td><td>';
            echo $booklist->author . '</td><td>';
            echo $booklist->course . '</td><td>';
            echo $booklist->isbn . '</td><td>';
            echo $booklist->instructor . '</td></tr>
                <tr class="tbl_header"><td>picture</td><td>availability</td><td>price</td><td>rating</td><td>add to cart</td></tr><tr class="even"><td>';
            echo '<img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/assets' . $booklist->picture . '"></td><td>';
            echo $booklist->availability . '</td><td>';
            echo $booklist->price . '</td><br><td>';
            $rating = $booklist->rating;
            $i = 0;
            while ($i < $rating) {
                $i++;
                echo '<a class="star" href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/rate/' . $i . '">&#9733; </a>';
            }
            while ($i < 5) {
                $i++;
                echo '<a class="star-blank" href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/rate/' . $i . '">&#9734; </a>';
            }
            echo '</td><td>';
            echo Form::open(array('url' => '/store/addcart/'. $booklist->id));
            echo Form::submit('add to cart', ['disabled' => $booklist->availability > 0]);
            echo Form::close();
            echo '</tr></table>';
            Session::put('currentbook', $booklist->id)
            ?>
        </div>
    </div>
</form>
</body>
</html>