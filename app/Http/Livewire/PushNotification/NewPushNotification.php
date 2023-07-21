<?php

namespace App\Http\Livewire\PushNotification;

use App\Models\PushNotfication;
use App\Models\User;
use App\Notifications\AppleServerNotification;
use Livewire\Component;
use Log;

class NewPushNotification extends Component
{
    public $title;
    public $message;

    public function store()
    {
        $data = $this->validate([
            'title' => 'required|max:65',
            'message' => 'required|max:240'
        ]);
        PushNotfication::create($data);
        $users = User::select('id', 'name')->chunk(200, function($users){
            foreach ($users as $chunk) {
                foreach ($chunk as $user) {
                    $user->notify(new AppleServerNotification($this->title, $this->message));
                }
            }
        });
        $this->emitTo('push-notification.push-notifications-list','added');
        $this->dispatchBrowserEvent("closeModal");
    }
    public function render()
    {
        return view('livewire.push-notification.new-push-notification');
    }
}
