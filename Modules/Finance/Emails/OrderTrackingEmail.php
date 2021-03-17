<?php

namespace Modules\Finance\Emails;

use Plugin\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Finance\Dao\Repositories\BankRepository;

class OrderTrackingEmail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;
    public $manifest;

    public function __construct($order, $manifest)
    {
        $this->data = $order->first();
        $this->manifest = $manifest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(Helper::setViewEmail('order_tracking_email', 'finance'));
    }
}
