<?php

namespace App\Mail;

use App\Models\History;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $id;
    public $history;
    public $purchase;
    public $subject;
    public $body;
    public function __construct($id)
    {
        $history = History::with('user')->findOrFail($id);
        $purchases = Purchase::with('request')->findOrFail($history->purchase_id);
        $link = route('purchase.show', $history->purchase_id);
        $this->purchase = $purchases;
        $this->history = $history;
        if($history->status == 'menyetujui'){
            $this->subject = 'SIPR - Disetujui Request PO '.$purchases->purchase_code.' by '.$history->user->name;
            $this->body = 'Selamat permintaan request anda sudah di terima silahkan cek akun <a href="'.$link.'">sipr.gushcloud.co.id</a>';
        }elseif($history->status == 'tidak menyetujui'){
            $this->subject = 'SIPR - Ditolak Request PO '.$purchases->purchase_code.' by '.$history->user->name;
            $this->body = 'Mohon maaf permintaan anda ditolak :( untuk detail silahkan login akun <a href="'.$link.'">sipr.gushcloud.co.id</a>';
        }else{
            $this->subject = 'SIPR - Request PO '.$purchases->purchase_code;
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
        return $this->subject($this->subject)->view('email.approval');
    }
}
