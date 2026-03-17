<?php

namespace App\Console\Commands;

use App\Jobs\SendOrderNotificationJob;
use Illuminate\Console\Command;
use App\Domain\Notification\NotificationStatus;
use App\Domain\Notification\NotificationLogRepositoryInterface;
use App\Domain\Users\UserRepositoryInterface;
use App\Domain\Orders\OrderRepositoryInterface;

class RetryFailedNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:retry-failed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reenvia para os jobs novamente';

    /**
     * Execute the console command.
     */
    public function handle(NotificationLogRepositoryInterface $log_interface, 
    UserRepositoryInterface $user_interface, OrderRepositoryInterface $order_interface)
    {
        $failedlogs = $log_interface->findByStatus(NotificationStatus::FAILED);

        if(empty($failedlogs)){
            $this->info('Nenhuma notificacao falhada encontrada');
        }

        foreach($failedlogs as $log){
            $user = $user_interface->findById($log->user_id);
            $order = $order_interface->findById($log->order_id);

            if($user && $order){
                SendOrderNotificationJob::dispatch($user,$order);
                $this->info("Notificacao do pedido reenviada");
            }
        }

    }
}
