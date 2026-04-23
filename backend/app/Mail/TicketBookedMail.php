<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketBookedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly Booking $booking)
    {
    }

    public function build(): self
    {
        return $this->subject('Your Event Ticket Confirmation')
            ->view('emails.ticket-booked', ['booking' => $this->booking]);
    }
}
