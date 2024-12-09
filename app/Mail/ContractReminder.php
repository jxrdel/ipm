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
    public function __construct(public Notifications $notification) {}

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
        $today = Carbon::now();
        $enddate = Carbon::parse($this->notification->contract->EndDate)->format('l, M jS Y');
        $difference = Carbon::parse($today)->diff($enddate);

        $label = '';

        if ($this->notification->IsCustomNotification) {
            $label = $this->notification->CustomMessage;
        } else {
            if ($difference->y > 0) {
                $label = 'Please be advised that the contract for ' . $this->notification->ItemName . ' ends in ' . $difference->y . ' year(s), ' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($enddate)->format('F jS, Y');
            } elseif ($difference->y < 1 && $difference->m > 0) {
                $label = 'Please be advised that the contract for ' . $this->notification->ItemName . ' ends in ' . $difference->m . ' month(s) and ' . $difference->d . ' day(s) on ' . Carbon::parse($enddate)->format('F jS, Y');
            } elseif ($difference->y < 1 && $difference->m < 1 && $difference->d > 0) {
                $label = 'Please be advised that the contract for ' . $this->notification->ItemName . ' ends in ' . $difference->d . ' day(s) on ' . Carbon::parse($enddate)->format('F jS, Y');
            } elseif ($difference->y < 1 && $difference->m < 1 && $difference->d < 1) {
                $label = 'Please be advised that the contract for ' . $this->notification->ItemName . ' ends today on ' . Carbon::parse($enddate)->format('F jS, Y');
            }
        }

        if ($this->notification->TypeId == 1) {
            $url = 'https://contracts.moh.gov.tt/PurchaseContracts';
        } else {
            $url = 'https://contracts.moh.gov.tt/EmployeeContracts';
        }

        return new Content(
            markdown: 'contractreminder',
            with: [
                'label' => $label,
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
