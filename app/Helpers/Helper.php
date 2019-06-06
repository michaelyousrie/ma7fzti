<?php

use Illuminate\Support\Facades\Auth;

/**
 * Flashes a message to the session to be displayed by sweetalert
 * 
 * @param string $message
 * @param string $class
 * @param string $title
 * 
 * @return True
 */
function swal( $message, $class = null, $title = null )
{
    session()->flash('message', $message);

    if ( $class ) session()->flash('message-class', $class);
    
    if ( $title ) session()->flash('title', $title);

    return True;
}


/**
 * Check if there's a logged in user
 * 
 * @param null
 * 
 * @return boolean
 */
function loggedIn()
{
    return Auth::check();
}


/**
 * Send back a unified status in the ajax response
 * 
 * @param array $data
 * @param bool $success
 * 
 * @return array
 */
function ajaxResponse( array $data = [], bool $success = true )
{
    return [
        'success'=> $success,
        'data'  =>  $data
    ];
}


/**
 * Return a successful ajax response
 * 
 * @param array $data
 * 
 * @return array
 */
function successResponse( array $data = [] )
{
    return ajaxResponse($data, true);
}


/**
 * Return a failure ajax response
 * 
 * @param array $data
 * 
 * @return array
 */
function failResponse( array $data = [] )
{
    return ajaxResponse($data, false);
}


/**
 * Returns a user object with some modified data
 * 
 * @return App\Models\User
 */
function getUserObject()
{
    $user = Auth::user();

    $user->incomes = $user->getIncomes();
    $user->expenses = $user->getExpenses();
    $user->income_categories = $user->getIncomeCategories();
    $user->expense_categories = $user->getExpenseCategories();

    foreach( $user->incomes as $index => $income ) {
        $user->incomes[$index]->category = $income->category;
    }

    foreach( $user->expenses as $index => $expense ) {
        $user->expenses[$index]->category = $expense->category;
    }

    return $user;
}
