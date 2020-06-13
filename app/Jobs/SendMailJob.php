<?php

namespace App\Jobs;

use App\Checkout;
use App\Mail\CheckoutCreationMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Checkout $checkout;

    /**
     * Create a new job instance.
     *
     * @param Checkout $checkout
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::select('email')->where('role', 'admin')->limit(5)->get()->toarray();
        foreach ($users as $user) {
            Mail::to($user['email'])->send(new CheckoutCreationMail($this->checkout));
        }
    }
}
