<?php

namespace App\Mail;

use App\Checkout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutCreationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Checkout $checkout;

    /**
     * Create a new message instance.
     *
     * @param Checkout $checkout
     */
    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $checkout = $this->checkout;
        return $this->view('emails.checkoutCreation', compact('checkout'));
    }
}
