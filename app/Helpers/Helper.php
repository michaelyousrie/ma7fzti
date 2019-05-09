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


function ajaxResponse( array $data = [] )
{
    return array_merge([
        'user'  => getUserObject()
    ], $data);
}


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
