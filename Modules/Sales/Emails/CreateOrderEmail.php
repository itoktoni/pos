<?php

namespace Modules\Sales\Emails;

use Plugin\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Sales\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Finance\Dao\Repositories\BankRepository;

class CreateOrderEmail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $master;
    public $order;
    public $detail;
    public $account;

    public function __construct($order)
    {
        $this->master = $order;
        $this->detail = $order->detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(Helper::setViewEmail('create_order_email', 'sales'));
    }
}
