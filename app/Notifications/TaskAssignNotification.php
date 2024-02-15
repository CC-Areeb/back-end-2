<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignNotification extends Notification
{
    use Queueable;
    private $receiver;

    private $sender;
    /**
     * Create a new notification instance.
     */
    public function __construct($receiver, $sender)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $taskUrl = url('/tasks/' . $notifiable->id);
        return (new MailMessage)
            ->from($this->sender->email, $this->sender->name)
            ->line('Hello ' . $this->receiver->name . ',')
            ->line('You have been assigned a new task! by ' . $this->sender->name . '')
            // ->action('View Task', url('/tasks/' . $notifiable->id))
            ->action('View Task', $taskUrl)
            ->line('Thank you for using our application!');
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
