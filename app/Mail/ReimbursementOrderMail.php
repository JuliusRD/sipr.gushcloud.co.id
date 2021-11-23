<?php

namespace App\Mail;

use App\Models\Reimbursement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReimbursementOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $id;
    public $reimbursement;
    public function __construct($id)
    {
        $reimbursements = Reimbursement::with('request')->findOrFail($id);
        $this->reimbursement = Reimbursement::with('request')->findOrFail($id);
        $this->subject = 'SIPR - New Request PO '.$reimbursements->reimbursement_code.' by '.$reimbursements->request->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emailreimbursement.request_po');
    }
}
