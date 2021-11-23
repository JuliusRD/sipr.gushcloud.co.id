<?php

namespace App\Mail;

use App\Models\HistoryReimbursement;
use App\Models\Reimbursement;
use App\Models\ReimbursementDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class ApprovalLampiranReimbursementMail extends Mailable
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
    public $pdf;
    public function __construct($id)
    {
        $history = HistoryReimbursement::with('user')->findOrFail($id);
        $reimbursement = Reimbursement::with('request')->findOrFail($history->reimbursement_id);
        $link = route('reimbursement.show', $history->reimbursement_id);
        $this->reimbursement = $reimbursement;
        $this->history = $history;
    
        $this->subject = 'SIPR - Disetujui Request PO '.$reimbursement->reimbursement_code.' by '.$history->user->name;
        $this->body = 'Selamat permintaan request anda sudah di terima.<br>
        Berikut terlampir detail PO untuk Request PO '.$reimbursement->reimbursement_code.'.<br>
        Untuk lengkapnya silahkan cek akun <a href="'.$link.'">sipr.gushcloud.co.id</a>';


        $reimbursement = Reimbursement::with('leader', 'institusi', 'request')->findOrFail($history->reimbursement_id);
        $reimbursement_detail = ReimbursementDetail::where('reimbursement_id', $history->reimbursement_id)->get();
        $subtotal = $reimbursement_detail->sum('total');
        $pdf = PDF::loadView('report.index', compact('reimbursement', 'reimbursement_detail', 'subtotal'))->setPaper('a4', 'portrait');
		$this->pdf = $pdf->output();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emailreimbursement.approval')->attachData($this->pdf, $this->subject.'.pdf', [
			'mime' => 'application/pdf',
		]);
    }
}
