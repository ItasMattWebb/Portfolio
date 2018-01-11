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
		$message = "";
        if (Input::get('password') != null && Input::get('username') != null && Input::get('email') != null) {
            $username = Input::get('username');
            $password = Hash::make(Input::get('password'));
            $email = Input::get('email');
            $userexists = User::where('username', '=',$username)->get()->isEmpty();
            $emailexists = User::where('email', '=', $email)->get()->isEmpty();
            if (!$userexists || !$emailexists) {
                $message = "This username or email is already taken.";
            } else {
                $user = new User;
                $user->username = $username;
                $user->password = $password;
                $user->email = $email;
                $user->save();
        		if (Auth::attempt(['username' => $username, 'password' => Input::get('password')])) {
                	Session::put('username', $username);
            		return Redirect::to('/store/browse');
				}
            }
        }

        if (Auth::check()) {
            return Redirect::to('/store/browse');
        }
        else {
            return View::make('register')->with('message', $message);
		}
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
            $rate = Rate::where("bookid", "=", $bookId);
            $userRating = Rate::where("bookid", "=", $bookId)->where("userid", "=", $userId)->first();
            $book = Book::find($bookId);
            $timesRated = $rate->count();
			$userRate = new Rate();
            //Checks if user has already rated the book, and updates the rating
            if ($userRating == null) {
				$userRate->userid = $userId;
				$userRate->bookid = $bookId;
			} else {
				$userRate = $userRating;
			}
			$userRate->rating = $rating;
			$userRate->save();

            $book->rating = $rate->avg('rating');
            $book->save();
            return Redirect::to('/store/select/' . $bookId);
        }
        else
            return Redirect::to('/store/login');
    }

    /**
     * Handles adding a book to the user's cart
     */
    public function addCartAction($bookId) {
    	$book = Book::find($bookId);
		if($book->availability < 1){
        	return View::make('select')->with('booklist', $book);
		}
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $cart = Cart::where("bookid", "=", $bookId)->where("userid", "=", $userId)->first();
            if ($cart === null) {
            	$cart = new Cart();
                $cart->bookid = $bookId;
                $cart->userid = $userId;
                $cart->save();
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
            $cart = Cart::where('userid', '=', $id)->get();
            return View::make('cart')->with('query', $cart);
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
    public function removeCartAction($bookId) {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $cart = Cart::where("bookid", "=", $bookId)->where("userid", "=", $userId)->first();
            if ($cart !== null) {
                $cart->delete();
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
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cart = Cart::where('userid', '=', $id)->get();
            return View::make('checkout')->with('query', $cart);
        }
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
            $id = Auth::user()->id;
            $cart = Cart::where('userid', '=', $id)->get();
            return View::make('receipt')->with(array('query' => $cart, 'credit', Input::get('credit')));
        }
    }

}

?>
