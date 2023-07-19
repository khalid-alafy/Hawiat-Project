<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;


class OrderCreatedNotification extends Notification
{
    use Queueable;

   
    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        // $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }


    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'subject' => 'New Order Created',
            'message' => 'An order has been created by user ' . $notifiable->name,
            // You can add any additional data you want to store in the database
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'subject' => 'New Order Created',
            'message' => 'An order has been created by user ' . $notifiable->name,
        ]);
    }
    
    public function broadcastOn()
    {
        return [
            new PrivateChannel('OrderCreated.User.' . auth('sanctum')->user()->id),
            new PrivateChannel('OrderCreated.Company.' .auth('sanctum')->user()->id),
        ];
    }

}
