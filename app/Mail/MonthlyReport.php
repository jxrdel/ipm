<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $now;
    protected $contracts;

    public function __construct($contracts)
    {
        $this->contracts = $contracts;
        $this->now = Carbon::now();
    }

    public function build()
    {
        $contractsWithTimeRemaining = $this->contracts->map(function ($contract) {
            $startDate = $contract->StartDate ? Carbon::parse($contract->StartDate) : null;
            $endDate = $contract->EndDate ? Carbon::parse($contract->EndDate) : null;

            if ($endDate) {
                $now = Carbon::now();
                $diff = $now->diff($endDate);
                $months = $now->diffInMonths($endDate);
                $days = $diff->d + 1; // include today
                $timeRemaining = "$months months and $days days";
            } else {
                $timeRemaining = 'N/A';
            }

            return (object)[
                'Name' => $contract->Name ?? 'N/A',
                'StartDate' => $startDate ? $startDate->format('Y-m-d') : 'N/A',
                'EndDate' => $endDate ? $endDate->format('Y-m-d') : 'N/A',
                'Cost' => $contract->Cost ?? '0',
                'TimeRemaining' => $timeRemaining,
            ];
        });

        return $this->subject('Monthly Contract Report | ICT Contracts')
            ->markdown('monthlyreport', [
                'contracts' => $contractsWithTimeRemaining,
                'startdate' => $this->now->copy()->startOfMonth()->format('F jS, Y'),
                'enddate' => $this->now->copy()->addMonths(3)->endOfMonth()->format('F jS, Y'),
                'url' => route('purchasecontracts'),
            ]);
    }
}
