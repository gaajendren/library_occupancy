<?php

namespace App\Listeners;


use App\Events\ReservationNotification;
use App\Mail\ReservationTicket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendReservationTicket
{

    public function handle(ReservationNotification $event): void
    {
        Log::info('SendReservationTicket Listener Triggered for Reservation ID: ' . $event->reservation->id);
        Mail::to($event->reservation->get_student->email)->send(new ReservationTicket($event->reservation));      
    }

}
