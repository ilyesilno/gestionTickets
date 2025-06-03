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
    protected $signature = 'tickets:check-sla';

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
           
            if($ticket->statut == 'ouvert'){
                $ticket->increment('duree_qualification',1);
            }
            if($ticket->statut == 'en cours'){
                $ticket->increment('duree_resolution',1);
            }
            if($ticket->support_level == 1){
                $ticket->increment('n1_duration',1);

            }
            if($ticket->support_level == 2){
                $ticket->increment('n2_duration',1);

            }
            if($ticket->support_level == 3){
                $ticket->increment('n3_duration',1);

            }

            $ticket->update();



                   
                }
            
        $this->info('Overdue ticket check complete.');

       
            
    }
    protected function sendNotification(Ticket $ticket)
    {
        $this->info('init notifying');
        
        // $responsable = Responsable::where('id',$ticket->respo_id);
        // $recipients = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'support_manager');
        // })->get();

        // $recipients =  [$responsable];

        foreach ($recipients as $recipient) {
            $recipient->notify(new TicketOverdueNotification($ticket));
        }

        // Notify the ticket creator if they exist
        // if ($ticket->creator) {
        //      $ticket->creator->notify(new TicketOverdueNotification($ticket));
        // }
    }
}
