<?php

namespace App\Mail;

use App\Models\Shipping;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $shipping;
    protected $receiver;
    public function __construct(Shipping $shipping, $receiver)
    {
        $this->shipping = $shipping;
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('akinyemi.010@gmail.com')
                ->markdown('emails.orders.shipped',[
                    'shipping' => $this->shipping,
                    'client' => $this->receiver
                ]);
    }
}
