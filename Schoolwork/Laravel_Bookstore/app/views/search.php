<!--DISPLAY View -->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=dirname($_SERVER['SCRIPT_NAME']); ?>/css/site.css"/>
        <title>Laravel Bookstore</title>
        <link rel="icon" href="{{HTML::asset('favicon.ico')}}"  type="image/x-icon" />
    </head>
    <body>
        <div id="bg">
            <?php
            include "include.php";
            ?>
            <div id="header">Laravel Bookstore</div>
            <div>
                <table>
                    <tr class="tbl_header" id="tbl_header">
                        <th>Picture</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Rating</th>
                    </tr>
                    <?php
                    $stripe = false;
                    foreach ($booklist as $entry) {
                        $stripe = !$stripe;

                        if ($stripe) {
                            echo '<tr class="odd"> ';
                        } else {
                            echo '<tr class="even"> ';
                        }
                        echo '<td><img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/assets' . $entry->picture . '" width="42px" height="42px"></td>';
                        echo '<td><a href="' . dirname($_SERVER['SCRIPT_NAME']) . '/store/select/' . $entry->id . '"> ' . $entry->title . '</a></td>';
                        echo '<td>' . $entry->author . '</td>';
                        echo '<td>' . $entry->price . '</td>';
                        $rating = $entry->rating;
                        $ratingstar = "";
                        for($i = 0; $i < 5; $i++) {
                        	if($i < $rating){
                            	$ratingstar .= "&#9733;";
                        	}
                            $ratingstar .= "&#9734;";
                        }
                        echo '<td>' . $ratingstar . '</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>