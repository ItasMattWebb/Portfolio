<?php

/**
 * BlogController:  Main controller for the L4_Blog application
 */
include("BaseController.php");

class BookstoreController extends BaseController {

    /**
     * Catches all non-specific requests to our application
     * and reroutes them to the browse action.
     */
    public function indexAction() {
        return Redirect::to('/store/browse');
    }

    /**
     * Returns the browse view with all the books in the library
     */
    public function browseAction() {
        $books = new Book();
        $bookList = $books->all();
        return View::make('browse')->with('booklist', $bookList);
    }

    /**
     * Returns the select view with the selected book
     */
    public function selectAction($select) {
        $books = new Book();
        $bookList = $books->find($select);
        return View::make('select')->with('booklist', $bookList);
    }

    /**
     * Returns the search view with a list of books matching the search parameters
     */
    public function searchAction() {
        $query = Book::where('course', 'LIKE', '%' . Input::get('search') . '%')
                        ->orwhere('title', 'LIKE', '%' . Input::get('search') . '%')
                        ->orwhere('isbn', 'LIKE', '%' . Input::get('search') . '%')
                        ->orwhere('instructor', 'LIKE', '%' . Input::get('search') . '%')->get();
        return View::make('search')->with('booklist', $query);
    }

    /**
     * Returns the register view if the user is not logged in
     */
    public function registerAction() {
        if (Auth::check()) {
            return Redirect::to('/store/browse');
        }
        else
            return View::make('register');
    }

    /**
     * Returns the login view if the user is not logged in
     */
    public function loginAction() {
        if (Auth::check()) {
            return Redirect::to('/store/browse');
        }
        else
            return View::make('login');
    }

    /**
     * Returns the user view if the user is logged in
     */
    public function userAction() {
        if (Auth::check()) {
            return View::make('user');
        }
        else
            return Redirect::to('/store/login');
    }

    /**
     * Handles changes to the user's account
     */
    public function userchangeAction($field) {
        $newname = Input::get('username');
        $newpassword = Input::get('password');
        $newemail = Input::get('email');
        if ($field == 'username' && $newname != null) {
            $user = Auth::user();
            $user->username = $newname;
            $user->save();
            Session::put('username', $newname);
        } else if ($field == 'password' && $newpassword != null) {
            $user = Auth::user();
            $user->password = Hash::make($newpassword);
            $user->save();
        } else if ($field == 'email' && $newemail != null) {
            $user = Auth::user();
            $user->email = $newemail;
            $user->save();
        }
        return View::make('user');
    }

    /**
     * logs the user out and redirects them to the browse page
     */
    public function logoutAction() {
        Session::flush();
        Auth::logout();
        return Redirect::to('/store/browse');
    }

    /**
     * Handles user ratings.
     */
    public function rateAction($rating) {
        if (Auth::check()) {
            $bookId = Session::get('currentbook');
            $userId = Auth::user()->id;
            $rate = Rate::find($bookId);
            $book = Book::find($bookId);
            $timesRated = substr_count($rate->userid, "id") - 1;
            //Checks if user has already rated the book, and updates the rating
            if (strpos($rate->userid, "id" . $userId) == true) {
                $totalarray = explode("+", $rate->rating);
                $ratearray = explode("id", $rate->userid);
                $pos = array_search($userId, $ratearray);
                $totalarray[$pos - 1] = $rating;
                $total = 0;
                $final = 0;
                foreach ($totalarray as $value) {
                    $total += $value;
                    if ($value != 0) {
                        $final .= "+" . $value;
                    }
                }
                $book->rating = $total / $timesRated;
                $book->save();
                $rate->rating = $final;
                $rate->save();
                return Redirect::to('/store/select/' . $bookId);
            }
            //Adds new rating as user has not rated the book
            else {
                $rate->rating .= "+" . $rating;
                $rate->userid .= "id" . $userId;
                $rate->save();
                $totalarray = explode("+", $rate->rating);
                $total = 0;
                foreach ($totalarray as $value) {
                    $total += $value;
                }
                $book->rating = $total / $timesRated;
                $book->save();
                return Redirect::to('/store/select/' . $bookId);
            }
        }
        else
            return Redirect::to('/store/login');
    }

    /**
     * Handles adding a book to the user's cart
     */
    public function addCartAction($bookid) {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $booktable = Cart::find($id);
            if (strpos($booktable->cart, "id" . $bookid) === false) {
                $insert = "id" . $bookid;
                $booktable->cart .= $insert;
                $booktable->save();
            }
            return Redirect::to('/store/viewcart');
        }
        else
            return Redirect::to('/store/login');
    }

    /**
     * Allows the user to view their cart
     */
    public function viewCartAction() {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cart = Cart::find($id);
            $cartarray = explode("id", $cart->cart);
            return View::make('cart')->with('query', $cartarray);
        }
        else
            return Redirect::to('/store/login');
    }

    /**
     * Allows the user to confirm if they want to remove a book from their cart
     */
    public function checkRemoveCartAction($bookid) {
        return View::make("confirm")->with('bookid', $bookid);
    }

    /**
     * Removes the book from the user's cart
     */
    public function removeCartAction($bookid) {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $booktable = Cart::find($id);
            if (strpos($booktable->cart, "id" . $bookid . "i") !== false) {
                $booktable->cart = str_replace("id" . $bookid . "i", "i", $booktable->cart);
                $booktable->save();
            }
            return Redirect::to('/store/viewcart');
        }
        else
            return Redirect::to('/store/login');
    }

    /**
     * Returns the checkout page with a list of items in the user's cart
     */
    public function checkoutAction() {
        $cartlist = explode("id", Cart::find(Auth::user()->id)->cart);
        Session::put('put', 'unset');
        return View::make('checkout')->with('query', $cartlist);
    }

    /**
     * Returns the receipt page if the user has not already checked out.
     */
    public function receiptAction() {
        $put = Session::get('put');
        if ($put == 'set') {
            Session::put('put', 'unset');
            return Redirect::to('/store/viewcart');
        } else {
            $cartlist = explode("id", Cart::find(Auth::user()->id)->cart);
            return View::make('receipt')->with(array('query' => $cartlist, 'credit', Input::get('credit')));
        }
    }

}

?>
