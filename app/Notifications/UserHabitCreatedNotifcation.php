<?php

namespace App\Notifications;

use App\Models\UserHabitTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class UserHabitCreatedNotifcation extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserHabitTask $task)
    {
        $this->task = $task;
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
            "title"   => "Hi ".$notifiable->name,
            "message" => "Did you ".$this->task->habit_name." today ?",
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
            ->priority("high")
            ->title("Hi ".$notifiable->name)
            ->body("Did you ".$this->task->habit_name." today ?")
            ->setJsonData([
                'task' => [
                    $this->task->only('id','habit_name','description','status')
                ]
            ]);
    }
}
