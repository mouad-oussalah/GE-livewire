<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="row">
        <div class="card  mx-auto">
            <div>
                @if (session()->has('employee-message'))
                    <div class="alert alert-success">
                        {{ session('employee-message') }}
                    </div>
                @endif
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" wire:model="search" class="form-control mb-2"
                                        id="inlineFormInput" placeholder="Jane Doe">
                                </div>
                                <div class="col">
                                    <select wire:model="selectedDepartementId" class="form-control mb-2">
                                        <option selected>Choose Departement</option>

                                        @foreach (App\Models\Departement::all() as $departement)
                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col" wire:loading>
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <button wire:click="showEmployeeModal" class="btn btn-primary">
                            New Employee
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">#Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Date Hired</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr>
                                <th scope="row">{{ $employee->id }}</th>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->departement->name }}</td>
                                <td>{{ $employee->date_hired }}</td>
                                <td>
                                    <button wire:click="showEditModal({{ $employee->id }})"
                                        class="btn btn-success">Edit</button>
                                    <button wire:click="deleteEmployee({{ $employee->id }})"
                                        class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th>No Results</th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $employees->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($editMode)
                            <h5 class="modal-title" id="employeeModalLabel">Edit Employee</h5>
                        @else
                            <h5 class="modal-title" id="employeeModalLabel">Create Employee</h5>

                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="Name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="Name" type="text"
                                        class="form-control @error('Name') is-invalid @enderror"
                                        wire:model.defer="Name">

                                    @error('Name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror"
                                        wire:model.defer="address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="departementId"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Deprtement') }}</label>

                                <div class="col-md-6">
                                    <select wire:model.defer="departementId" class="custom-select">
                                        <option selected>Choose</option>

                                        @foreach (App\Models\Departement::all() as $departement)
                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('departementId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthDate"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Birthdate') }}</label>

                                <div class="col-md-6">
                                    <input id="birthDate" type="text"
                                        class="form-control @error('birthDate') is-invalid @enderror"
                                        wire:model.defer="birthDate">

                                    @error('birthDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dateHired"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Date Hired') }}</label>

                                <div class="col-md-6">
                                    <input id="dateHired" type="text"
                                        class="form-control @error('dateHired') is-invalid @enderror"
                                        wire:model.defer="dateHired">

                                    @error('dateHired')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                        @if ($editMode)
                            <button type="button" class="btn btn-primary" wire:click="updateEmployee">Update
                                Employee</button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="storeEmployee">Store
                                Employee</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>