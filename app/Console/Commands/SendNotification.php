<?php

namespace App\Console\Commands;

use App\Mail\ContractReminder;
use App\Mail\MonthlyReport;
use App\Models\Notifications;
use App\Models\PurchaseContracts;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notifications = Notifications::all();
        foreach ($notifications as $notification) {
            if (Carbon::parse($notification->DisplayDate)->isToday()) { //Check if Display Date is today's date
                foreach ($notification->internalcontacts as $contact) {
                    Mail::to($contact->Email)->send(new ContractReminder($notification));
                }
                Mail::to('jardel.regis@health.gov.tt')->send(new ContractReminder($notification));
            }
            Log::info('Contract reminder for notification ID ' . $notification->ID . ' sent successfully.');
        }

        //Check if today is the first day of the month
        if (Carbon::now()->day == 1) {
            //Get purchase contracts ending in the next 4 months
            $fourMonthsFromNow = Carbon::now('AST')->copy()->addMonths(3)->endOfMonth();
            $contracts = PurchaseContracts::where('EndDate', '>=', Carbon::now())
                ->where('EndDate', '<=', $fourMonthsFromNow)
                ->get();
            $emails = [
                'jesse.bridgelal@health.gov.tt',
                'varma.maharaj@health.gov.tt',
                'stephan.myers@health.gov.tt',
                'stephon.stewart@health.gov.tt',
                'charles.glasgow@health.gov.tt',
                'frances.browne@health.gov.tt',
                'donald.bain@health.gov.tt',
                'jardel.regis@health.gov.tt',
            ];

            if ($contracts->isNotEmpty()) {
                Mail::to($emails)->send(new MonthlyReport($contracts));
            }
            Log::info('Monthly report sent successfully.');
        }
    }
}
