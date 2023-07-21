<?php

namespace App\Notifications;

use App\Models\Webhook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;
use Illuminate\Notifications\Notification;

class AppleServerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$message)
    {
        $this->title = $title;
        $this->message = $message;
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "title"   => $this->title,
            "message" => $this->message,
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
            ->title($this->title)
            ->priority("high")
            ->body($this->message);
    }
}
