<?php

namespace App\Http\Livewire\Departement;

use App\Models\Departement;
use Livewire\Component;

class DepartementIndex extends Component
{
    public $search = '';
    public $name;
    public $editMode = false;
    public $departementId;

    protected $rules = [
        'name' => 'required',
    ];

    public function showEditModal($id)
    {
        $this->reset();
        $this->departementId = $id;
        $this->loadDepartement();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departementModal', 'actionModal' => 'show']);
    }

    public function loadDepartement()
    {
        $departement = Departement::find($this->departementId);
        $this->name = $departement->name;
    }
    public function deleteDepartement($id)
    {
        $departement = Departement::find($id);
        $departement->delete();
        session()->flash('departement-message', 'Departement successfully deleted');
    }
    public function showDepartementModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departementModal', 'actionModal' => 'show']);
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departementModal', 'actionModal' => 'hide']);
    }
    public function storeDepartement()
    {
        $this->validate();
        Departement::create([
           'name'         => $this->name
       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departementModal', 'actionModal' => 'hide']);
        session()->flash('departement-message', 'Departement successfully created');
    }
    public function updateDepartement()
    {
        $validated = $this->validate([
            'name'        => 'required'
        ]);
        $departement = Departement::find($this->departementId);
        $departement->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departementModal', 'actionModal' => 'hide']);
        session()->flash('departement-message', 'Departement successfully updated');
    }
    public function render()
    {
        $departements = Departement::paginate(20);
        if (strlen($this->search) > 1) {
            $departements = Departement::where('name', 'like', "%{$this->search}%")->paginate(20);
        }

        return view('livewire.departement.departement-index', [
            'departements' => $departements
        ])->layout('layouts.main');
    }
}