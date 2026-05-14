<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index()
    {
        // 1. Ambil log terbaru beserta relasi user yang melakukannya (causer)
        $logs = Activity::with('causer')->latest()->get();

        // 2. Kelompokkan log berdasarkan tanggal untuk format Timeline
        $groupedLogs = $logs->groupBy(function($date) {
            $carbonDate = Carbon::parse($date->created_at);

            if ($carbonDate->isToday()) {
                return 'Hari Ini, ' . $carbonDate->translatedFormat('j F Y');
            } elseif ($carbonDate->isYesterday()) {
                return 'Kemarin, ' . $carbonDate->translatedFormat('j F Y');
            } else {
                return $carbonDate->translatedFormat('l, j F Y');
            }
        });

        return view('log', compact('groupedLogs'));
    }
}
