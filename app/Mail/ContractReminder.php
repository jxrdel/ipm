<?php

namespace App\Mail;

use App\Models\Notifications;
use App\Models\PurchaseContracts;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractReminder extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     */
    public function __construct(public Notifications $notification)
    {
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contract Expiration Notice - ' . $this->notification->ItemName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $enddate = Carbon::parse($this->notification->contract->EndDate)->format('l, M jS Y');
        $today = Carbon::now();
        $daysDifference = $today->diffInDays(Carbon::parse($this->notification->contract->EndDate)) + 1;

        if ($this->notification->ItemId == 1){
            $url = 'http://10.100.0.86:5050/PurchaseContracts';
        }else{
            $url = 'http://10.100.0.86:5050/EmployeeContracts';
        }

        return new Content(
            markdown: 'contractreminder',
            with: [
                'itemname' => $this->notification->ItemName,
                'enddate' => $enddate,
                'daysdifference' => $daysDifference,
                'url' => $url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
