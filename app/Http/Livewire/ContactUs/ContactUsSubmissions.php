<?php

namespace App\Http\Livewire\ContactUs;

use App\Models\ContactUs;
use App\Traits\WithSortable;
use Config;
use Livewire\Component;
use Livewire\WithPagination;

class ContactUsSubmissions extends Component
{
    use WithPagination;
    use WithSortable;
    protected $paginationTheme = 'bootstrap';
    public $search  = "";
    public $perPage;
    protected $listeners = ['confirmDelete'];

    public function mounted()
    {
        $this->perPage = Config::get('app.pagination_value');
    }
    public function confirmDelete($submission_id){
        try {
            $submission = ContactUs::find($submission_id);
            $submission->delete();
            $this->emit('swalalert',['title' => '','subtitle' => "Deleted.",'type' => 'success']);
        } catch (\Throwable $th) {
            $this->emit('swalalert',['title' => '','subtitle' => 'Something went wrong.','type' => 'error']);
        }
    }
    public function render()
    {
        $query = ContactUs::query()->search($this->search);

        return view('livewire.contact-us.contact-us-submissions',[
            'submissions' => $query
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage)
        ]);
    }
}
