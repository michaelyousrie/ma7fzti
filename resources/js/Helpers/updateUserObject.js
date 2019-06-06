function updateUserObject( user ) {
    user.getBalance = function() {
        return this.currency + " " + this.balance;
    }

    user.calcBalance = function() {
        return this.getIncomeValue() - this.getExpenseValue();
    }

    user.getTotalIncome = function() {
        let total = 0;
        
        this.incomes.forEach(income => {
            total += parseFloat( income.amount );
        });

        return this.currency + " " + total;
    }


    user.getTotalExpense = function() {
        let total = 0;
        
        this.expenses.forEach(expense => {
            total += expense.amount;
        });

        return this.currency + " " + total;
    }


    user.getIncomeValue = function() {
        let total = 0;
        
        this.incomes.forEach(income => {
            total += parseFloat( income.amount );
        });

        return parseFloat(total);
    }


    user.getExpenseValue = function() {
        let total = 0;
        
        this.expenses.forEach(expense => {
            total += parseFloat( expense.amount );
        });

        return parseFloat(total);
    }

    return user;
}

export {
    updateUserObject
}
