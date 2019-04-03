<?php

use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory( Expense::class, 5 )->create();
    }
}
