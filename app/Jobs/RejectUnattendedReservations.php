<?php

namespace App\Jobs;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RejectUnattendedReservations 
{
    use Dispatchable, InteractsWithQueue, SerializesModels; 

    public function handle(): void
    {
        $now = Carbon::now();
       
        $reservations = Reservation::where('status', 'pending')
        ->where(function ($query) use ($now) {
            $query->where('date', '<', $now->toDateString()) 
                  ->orWhere(function ($subQuery) use ($now) {
                      $subQuery->where('date', $now->toDateString()) 
                          ->whereRaw("
                              JSON_UNQUOTE(JSON_EXTRACT(time, '$[last]')) < ?
                          ", [$now->format('H:i')]);
                  });
        })
            ->update(['status' => 'rejected']);

    }
}
