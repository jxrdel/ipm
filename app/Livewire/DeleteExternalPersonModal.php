<?php

namespace App\Livewire;

use App\Models\ExternalPersons;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteExternalPersonModal extends Component
{
    public $id;

    public function render()
    {
        return view('livewire.delete-external-person-modal');
    }

    #[On('show-delete-modal')]
    public function displayModal($id)
    {
        $this->id = $id;

        $this->dispatch('display-delete-modal');
    }

    public function deleteRecord(){
        $record = ExternalPersons::find($this->id);
        // dd($record);
        $record->delete();

        $this->dispatch('close-delete-modal');
        $this->dispatch('show-noti', message: 'Record deleted successfully');
        $this->dispatch('refresh-table');
    }
}
