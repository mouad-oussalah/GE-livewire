<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;
use Carbon\Carbon;
use Livewire\Component;

class EmployeeIndex extends Component
{
    public $search = '';
    public $Name;
    public $address;
    public $departementId;
    public $birthDate;
    public $dateHired;
    public $editMode = false;
    public $employeeId;
    public $selectedDepartementId = null;

    protected $rules = [
        'Name' => 'required',
        'address' => 'required',
        'departementId' => 'required',
        'birthDate' => 'required',
        'dateHired' => 'required',
    ];

    public function showEditModal($id)
    {
        $this->reset();
        $this->employeeId = $id;
        $this->loadEmployee();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }

    public function loadEmployee()
    {
        $employee = Employee::find($this->employeeId);
        $this->Name = $employee->name;
        $this->address = $employee->address;
        $this->departementId = $employee->departement_id;
        $this->birthDate = $employee->birthdate;
        $this->dateHired = $employee->date_hired;
    }
    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        session()->flash('employee-message', 'Employee successfully deleted');
    }
    public function showEmployeeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
    }
    public function storeEmployee()
    {
        $this->validate();
        Employee::create([
            'name' => $this->Name,
        'address' => $this->address,
        'departement_id' => $this->departementId,
        'birthdate' => $this->birthDate,
        'date_hired' => $this->dateHired,
       ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee-message', 'Employee successfully created');
    }
    public function updateEmployee()
    {
        $this->validate();
        $employee = Employee::find($this->employeeId);
        $employee->update([
           'name' => $this->Name,
        'address' => $this->address,
        'departement_id' => $this->departementId,
        'birthdate' => $this->birthDate,
        'date_hired' => $this->dateHired,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee-message', 'Employee successfully updated');
    }
    public function render()
    {
        $employees = Employee::paginate(5);
        if (strlen($this->search) > 2) {
            if ($this->selectedDepartementId) {
                $employees = Employee::where('name', 'like', "%{$this->search}%")
                             ->where('departement_id', $this->selectedDepartementId)
                             ->paginate(5);
            } else {
                $employees = Employee::where('name', 'like', "%{$this->search}%")->paginate(5);
            }
        } elseif ($this->selectedDepartementId) {
            $employees = Employee::where('departement_id', $this->selectedDepartementId)->paginate(5);
        }

        return view('livewire.employee.employee-index', ['employees' => $employees])->layout('layouts.main');
    }
}