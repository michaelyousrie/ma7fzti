<?php

use App\Models\User;
use App\Models\Expense;
use App\Models\Language;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\IncomeCategory;
use App\Models\Income;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();

        for( $i = 1; $i <= 5; $i++ ) {
            $lang = factory( Language::class )->create();

            $user = factory( User::class )->create([
                'language_code' => $lang->code
            ]);


            // Expenses
            $ExpenseCategory = factory( ExpenseCategory::class )->create([
                'user_id'   => $user->id
            ]);

            factory( Expense::class, 10 )->create([
                'category_id'   => $ExpenseCategory->id,
                'user_id'       => $user->id
            ]);

            // Incomes
            $IncomeCategory = factory( IncomeCategory::class )->create([
                'user_id'   => $user->id
            ]);

            factory(Income::class, 10)->create([
                'category_id'   => $IncomeCategory->id,
                'user_id'       => $user->id
            ]);
        }
    }


    protected function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        Language::truncate();
        User::truncate();
        Expense::truncate();
        ExpenseCategory::truncate();
        Income::truncate();
        IncomeCategory::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
