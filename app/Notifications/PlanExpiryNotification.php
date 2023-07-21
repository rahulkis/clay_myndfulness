<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class PlanExpiryNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $subscription_plan;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserSubscription $subscription_plan)
    {
        $this->subscription_plan = $subscription_plan;
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
        $message = "Hi, {$notifiable->name} Your plan will expire on " . $this->subscription_plan->end_date->format(config("modules.short_date_format")) . ". Please renew to enjoy continous service.\n Thank you.";
        if($this->subscription_plan->end_date < now()){
            if($this->subscription_plan->after_grace_period_date < now()){
                $message = "Hi, {$notifiable->name} Your plan has expired on " . $this->subscription_plan->end_date->format(config("modules.short_date_format")) . ". Please renew to enjoy our services.\n Thank you.";
            }else{
                $message = "Hi, {$notifiable->name} Your plan will expire on " . $this->subscription_plan->end_date->format(config("modules.short_date_format")) . ". Renew before grace period ".$this->subscription_plan->after_grace_period_date->format(config("modules.short_date_format"))." to enjoy continous service.\n Thank you.";
            }
        }
        return [
            "title"   => "Plan Expiry Notification",
            "message" => $message,
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
        $message = "Hi, {$notifiable->name} Your plan will expire on " . $this->subscription_plan->end_date->format(config("modules.short_date_format")) . ". Please renew to enjoy continous service.\n Thank you.";
        if($this->subscription_plan->end_date < now()){
            if($this->subscription_plan->after_grace_period_date < now()){
                $message = "Hi, {$notifiable->name} Your plan has expired on " . $this->subscription_plan->end_date->format(config("modules.short_date_format")) . ". Please renew to enjoy our services.\n Thank you.";
            }else{
                $message = "Hi, {$notifiable->name} Your plan will expire on " . $this->subscription_plan->end_date->format(config("modules.short_date_format")) . ". Renew before grace period ".$this->subscription_plan->after_grace_period_date->format(config("modules.short_date_format"))." to enjoy continous service.\n Thank you.";
            }
        }
        return ExpoMessage::create()
            ->badge(1)
            ->enableSound()
            ->title("Plan Expiry Notification")
            ->priority("high")
            ->body($message);
    }
}
