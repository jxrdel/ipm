<?php

namespace App\Console\Commands;

use App\Mail\ContractReminder;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Console\Command;
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
        // $notification = Notifications::find(56);
        // foreach($notification->internalcontacts as $contact){
        //     Mail::to($contact->Email)->send(new ContractReminder($notification));
        // }

        $notifications = Notifications::all();
        foreach ($notifications as $notification) {
            if (Carbon::parse($notification->DisplayDate)->isToday()) { //Check if Display Date is today's date
                foreach ($notification->internalcontacts as $contact) {
                    Mail::to($contact->Email)->send(new ContractReminder($notification));
                }
                Mail::to('jardel.regis@health.gov.tt')->send(new ContractReminder($notification));
            }
        }
    }
}
