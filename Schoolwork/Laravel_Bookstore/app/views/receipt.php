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
                <table border="0">
                    <?php
                    Session::put('put', 'set');
                    $totalprice = 0;
                    $i = 1;
                    foreach ($query as $book) {
                        $entry = Book::find($book);
                        if ($entry != null) {
                            if ($entry['availability'] != 0) {
                                echo 'Book' . $i . ': ';
                                echo substr($entry['title'], 0, 45);
                                echo '    ' . $entry['price'];
                                echo '<br>';
                                $totalprice += $entry['price'];
                                $book = Book::find($book);
                                $book->availability -= 1;
                                $book->save();
                            } else {
                                echo "Item " . $i . " " . substr($entry['title'], 0, 45) . " Is currently out of stock and was removed from your cart.<br>";
                            }
                            $id = Auth::user()->id;
                            $booktable = Cart::find($id);
                            if (strpos($booktable->cart, "id" . $entry['id'] . "i") !== false) {
                                $booktable->cart = str_replace("id" . $entry['id'] . "i", "i", $booktable->cart);
                                $booktable->save();
                            }
                            $i++;
                        }
                    }
                    echo '$' . $totalprice . ' has been charged to #' . Input::get('credit');
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>