<?php

namespace App\Notifications;

use App\Models\UserRoutineTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class RoutineReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $routine_transaction;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserRoutineTransaction $routine_transaction)
    {
        $this->routine_transaction = $routine_transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ExpoChannel::class, "database"];
    }
    public function toArray($notifiable)
    {
        return [
            "title"   => "Reminder",
            "message" => "Hi, {$notifiable->name} it's a reminder for your habit {$this->routine_transaction->habit}.",
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NotificationChannels\ExpoPushNotifications\ExpoMessage
     */

    public function toExpoPush($notifiable)
    {
        return ExpoMessage::create()
            ->badge(1)
            ->enableSound()
            ->title("Reminder")
            ->priority("high")
            ->body("Hi, {$notifiable->name} it's a reminder for your habit {$this->routine_transaction->habit}.");
    }
}
