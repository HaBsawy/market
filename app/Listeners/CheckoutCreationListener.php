<?php

namespace App\Listeners;

use App\Events\CheckoutCreationEvent;
use App\Jobs\SendMailJob;
use App\Mail\CheckoutCreationMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CheckoutCreationListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(CheckoutCreationEvent $event)
    {
        $checkout = $event->checkout;
        SendMailJob::dispatch($checkout);
    }
}
