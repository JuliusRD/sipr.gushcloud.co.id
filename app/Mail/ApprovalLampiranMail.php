<?php

namespace App\Mail;

use App\Models\History;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class ApprovalLampiranMail extends Mailable
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
    public $pdf;
    public function __construct($id)
    {
        $history = History::with('user')->findOrFail($id);
        $purchases = Purchase::with('request')->findOrFail($history->purchase_id);
        $link = route('purchase.show', $history->purchase_id);
        $this->purchase = $purchases;
        $this->history = $history;
    
        $this->subject = 'SIPR - Disetujui Request PO '.$purchases->purchase_code.' by '.$history->user->name;
        $this->body = 'Selamat permintaan request anda sudah di terima.<br>
        Berikut terlampir detail PO untuk Request PO '.$purchases->purchase_code.'.<br>
        Untuk lengkapnya silahkan cek akun <a href="'.$link.'">sipr.gushcloud.co.id</a>';


        $purchase = Purchase::with('leader', 'institusi', 'request')->findOrFail($history->purchase_id);
        $purchase_detail = PurchaseDetail::where('purchase_id', $history->purchase_id)->get();
        $subtotal = $purchase_detail->sum('total');
        $pdf = PDF::loadView('report.index', compact('purchase', 'purchase_detail', 'subtotal'))->setPaper('a4', 'portrait');
		$this->pdf = $pdf->output();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('email.approval')->attachData($this->pdf, $this->subject.'.pdf', [
			'mime' => 'application/pdf',
		]);       
    }
}
