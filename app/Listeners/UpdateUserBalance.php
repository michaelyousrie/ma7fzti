<?php

namespace App\Listeners;

use App\Providers\BalanceGotUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserBalance
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BalanceGotUpdated  $event
     * @return void
     */
    public function handle(BalanceGotUpdated $event)
    {
        $event->user->calculateBalance();
    }
}
