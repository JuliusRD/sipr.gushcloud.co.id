<?php

namespace App\Mail;

use App\Models\HistoryReimbursement;
use App\Models\Reimbursement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalReimbursementMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $id;
    public $history;
    public $reimbursement;
    public $subject;
    public $body;
    public function __construct($id)
    {
        $history = HistoryReimbursement::with('user')->findOrFail($id);
        $reimbursement = Reimbursement::with('request')->findOrFail($history->reimbursement_id);
        $link = route('reimbursement.show', $history->reimbursement_id);
        $this->reimbursement = $reimbursement;
        $this->history = $history;
        if($history->status == 'menyetujui'){
            $this->subject = 'SIPR - Disetujui Request PO '.$reimbursement->reimbursement_code.' by '.$history->user->name;
            $this->body = 'Selamat permintaan request anda sudah di terima silahkan cek akun <a href="'.$link.'">sipr.gushcloud.co.id</a>';
        }elseif($history->status == 'tidak menyetujui'){
            $this->subject = 'SIPR - Ditolak Request PO '.$reimbursement->reimbursement_code.' by '.$history->user->name;
            $this->body = 'Mohon maaf permintaan anda ditolak :( untuk detail silahkan login akun <a href="'.$link.'">sipr.gushcloud.co.id</a>';
        }else{
            $this->subject = 'SIPR - Request PO '.$reimbursement->reimbursement_code;
            $this->body = '';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emailreimbursement.approval');
    }
}
