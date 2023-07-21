<?php

namespace App\Notifications;

use App\Models\SubscriptionPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;

class SwitchToFreePlanNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $plan;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SubscriptionPlan $subscriptionPlan)
    {
        $this->plan = $subscriptionPlan;
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
            "message" => "Hi, {$notifiable->name} your has been switched to {$this->plan->name}.",
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
            ->title("Plan Switched")
            ->priority("high")
            ->body("Hi, {$notifiable->name} your has been switched to {$this->plan->name}.");
    }
}
