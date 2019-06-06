<?php

namespace App\Models;

use App\Models\Expense;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email', 'password', 'balance', 'currency', 'app_version', 'language_code', 'api_token', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }


    public function incomes()
    {
        return $this->hasMany(Income::class);
    }


    public function incomeCategories()
    {
        return $this->hasMany(IncomeCategory::class);
    }


    public function expenseCategories()
    {
        return $this->hasMany(ExpenseCategory::class);
    }


    public function getIncomes()
    {
        $incomes = $this->incomes()->orderBy('created_at', 'desc')->get();

        foreach( $incomes as $index => $income ) {
            $incomes[$index]->when = $income->created_at->diffForHumans();
        }

        return $incomes;
    }


    public function getExpenses()
    {
        $expenses = $this->expenses()->orderBy('created_at', 'desc')->get();

        foreach( $expenses as $index => $expense ) {
            $expenses[$index]->when = $expense->created_at->diffForHumans();
        }

        return $expenses;
    }


    public function getIncomeCategories()
    {
        $cats = $this->incomeCategories;

        foreach( $cats as $index => $cat ) {
            $cats[$index]->when = $cat->created_at->diffForHumans();
        }

        return $cats;
    }


    public function getExpenseCategories()
    {
        $cats = $this->expenseCategories;

        foreach( $cats as $index => $cat ) {
            $cats[$index]->when = $cat->created_at->diffForHumans();
        }

        return $cats;
    }


    public function calculateBalance()
    {
        $total = 0;

        foreach( $this->incomes as $income ) {
            $total += $income->amount;
        }

        foreach( $this->expenses as $expense ) {
            $total -= $expense->amount;
        }

        $this->balance = $total;

        $this->save();

        return $total;
    }
}
