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

class ApproveOrderEmail extends Mailable
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

    public function __construct($group)
    {
        $this->master = $group;
        $this->order = $group->order;
        $this->detail = $group->detail;
        $this->account = BankFacades::dataRepository()->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(Helper::setViewEmail('approve_order_email', 'sales'));
    }
}
