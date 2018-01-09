<?php
/**
 * Cart Data Model
 */
class Cart extends Eloquent {
    protected $table = "cart";
    public static $unguarded = true;
    public  $timestamps = false;
}
?>
