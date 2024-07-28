<?php

namespace App\Listeners;

use App\Events\BookingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BookingListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingEvent $event): void
    {
        $message = '';

        if ($event->type == 'new') {
            $message = "New booking created with ID: {$event->booking->id_booking}";
        } elseif ($event->type == 'delete') {
            $message = "Booking deleted with ID: {$event->booking->id_booking}";
        } elseif ($event->type == 'update_qty') {
            $message = "Booking ID: {$event->booking->id_booking} has qty_ticket of 100";
        }

        Notification::create([
            'type' => $event->type,
            'message' => $message,
        ]);
    }
}
