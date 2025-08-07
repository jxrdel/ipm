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
        $csvData = $this->generateCsvData();

        return $this->subject('Monthly Report - ' . $this->now->format('F'))
            ->markdown('monthlyreport', [
                'contracts' => $this->contracts,
                'startdate' => $this->now->copy()->startOfMonth()->format('F jS, Y'),
                'enddate' => $this->now->copy()->addMonths(3)->endOfMonth()->format('F jS, Y'),
                'url' => route('purchasecontracts'),
            ])
            ->attachData($csvData, 'contracts' . $this->now->format('Y-m') . '.csv', [
                'mime' => 'text/csv',
            ]);
    }

    protected function generateCsvData()
    {
        $headers = ['Name', 'Start Date', 'End Date', 'Cost', 'Time Remaining'];
        $output = fopen('php://temp', 'r+');

        // Write headers
        fputcsv($output, $headers);

        // Write contract rows
        foreach ($this->contracts as $contract) {
            $startDate = $contract->StartDate ? Carbon::parse($contract->StartDate) : null;
            $endDate = $contract->EndDate ? Carbon::parse($contract->EndDate) : null;

            // Calculate time remaining if end date exists
            if ($endDate) {
                $now = Carbon::now();
                $diff = $now->diff($endDate);
                $timeRemaining = $now->diffInMonths($endDate) . ' months and ' . ($diff->d + 1) . ' days'; // +1 to include today
            } else {
                $timeRemaining = 'N/A';
            }

            fputcsv($output, [
                $contract->Name ?? 'N/A',
                $startDate ? $startDate->format('Y-m-d') : 'N/A',
                $endDate ? $endDate->format('Y-m-d') : 'N/A',
                $contract->Cost ?? '0',
                $timeRemaining,
            ]);
        }

        rewind($output);
        return stream_get_contents($output);
    }
}
