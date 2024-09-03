<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationsController extends Controller
{

    public function index()
    {
        return view('notifications');
    }

    public function getNotifications()
    {
        $today = Carbon::today();

        $query = Notifications::where('DisplayDate', '>=', $today)->get();

        $query->each(function ($notificaiton) {
            $notificaiton->FormattedDisplayDate = Carbon::parse($notificaiton->DisplayDate)->format('d/m/Y');
            // $notificaiton->DisplayDate = $notificaiton->DisplayDate->format('d/m/Y');
        });

        return DataTables::of($query)->make(true);
    }
}
