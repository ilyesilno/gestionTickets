<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Responsable;
use App\Notifications\TicketOverdueNotification;


class CheckSlaTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-sla-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'incrementation des durees sla sur les tickets ouverts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $this->info('Checking for overdue tickets...');
        $tickets = Ticket::where('statut', '!=', 'ferme')
        ->where('statut', '!=', 'resolu')
        ->get();

        if ($tickets->isEmpty()) {
        $this->info('no tickets found.');
        return Command::SUCCESS;
        }

        $this->warn(count($tickets) . ' overdue tickets found.');

        foreach ($tickets as $ticket) {
            // Important: Add logic here to prevent repeated notifications
            // For example, if you add a `last_overdue_notified_at` timestamp to the Ticket model:
            
               // Notify hourly if still overdue
                    $this->info("Ticket #{$ticket->id} is overdue: {$ticket->title}");

                    $this->sendOverdueNotification($ticket);

                    // Update notification timestamp to prevent immediate re-notification
                    $ticket->update(['last_overdue_notified_at' => now()]);
                }
            
        $this->info('Overdue ticket check complete.');

       
            
    }
    protected function sendNotification(Ticket $ticket)
    {

        $responsable = Responsable::where('id',$ticket->respo_id);
        // $recipients = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'support_manager');
        // })->get();

        $recipients =  [$responsable];

        foreach ($recipients as $recipient) {
            $recipient->notify(new TicketOverdueNotification($ticket));
        }

        // Notify the ticket creator if they exist
        // if ($ticket->creator) {
        //      $ticket->creator->notify(new TicketOverdueNotification($ticket));
        // }
    }
}
