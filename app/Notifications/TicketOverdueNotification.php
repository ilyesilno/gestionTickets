<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     protected $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->error() // Makes the email stand out (red line)
        ->subject("URGENT: Ticket #{$this->ticket->id} is Overdue!")
        ->greeting("Hello {$notifiable->name},")
        ->line("Ticket **#{$this->ticket->id}: {$this->ticket->title}** is now overdue.")
        ->line("Current Status: " . $this->ticket->status)
        // ->action('View Ticket', route('tickets.show', $this->ticket))
        ->line('Please take immediate action!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
