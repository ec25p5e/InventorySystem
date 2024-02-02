<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function index() {
        $dates = Notifications::select(DB::raw('CAST(created_at AS DATE) as notification_date'))
            ->groupBy(DB::raw('CAST(created_at AS DATE)'))
            ->orderByRaw('CAST(created_at AS DATE) DESC')
            ->get();

        $notificationsForDate = function ($date) {
            $notifications = Notifications::where('user_id_ref', Auth::id())
                ->where('created_at', 'like', $date . '%')
                ->orderBy('created_at', 'desc')
                ->get();

            return $notifications;
        };


        return view('notifications.index', [
            'dates' => $dates,
            'notificationsForDate' => $notificationsForDate,
        ]);
    }
}
