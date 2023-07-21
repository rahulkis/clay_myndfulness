<?php

namespace App\Http\Livewire\PushNotification;

use App\Models\PushNotfication;
use Livewire\Component;
use Livewire\WithPagination;

class PushNotificationsList extends Component
{
    use WithPagination;
    public $perPage           = 10;
    public $search;
    protected $paginationTheme = 'bootstrap';

    protected $listeners  = ["delete","added"];

    public function added()
    {
    }
    public function delete(PushNotfication $notification)
    {
        $notification->delete();
        $this->emit('swalalert', ['title' => '', 'subtitle' => 'Record trashed.', 'type' => 'success']);
    }
    public function render()
    {
        $query = PushNotfication::query();
        return view('livewire.push-notification.push-notifications-list',[
            'notifications' => $query->orderBy('id','DESC')->paginate($this->perPage)
        ]);
    }
}
