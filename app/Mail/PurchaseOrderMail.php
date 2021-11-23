<?php

namespace App\Mail;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $id;
    public $purchase;
    public function __construct($id)
    {
        $purchases = Purchase::with('request')->findOrFail($id);
        $this->purchase = Purchase::with('request')->findOrFail($id);
        $this->subject = 'SIPR - New Request PO '.$purchases->purchase_code.' by '.$purchases->request->name;     
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('email.request_po');
    }
}
