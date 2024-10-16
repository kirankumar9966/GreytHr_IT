<div class="main">


    <div wire:loading
        wire:target="submit, showEditItMember, cancel,cancelLogout, confirmDelete, delete, showAddItMember">
        <div class="loader-overlay">
            <div>
                <div class="logo">
                    <!-- <i class="fas fa-user-headset"></i> -->
                    <img src="{{ asset('images/Screenshot 2024-10-15 120204.png') }}" width="58" height="50"
                        alt="">&nbsp;
                    <span>IT</span>&nbsp;&nbsp;

                    <span>EXPERT</span>
                </div>
            </div>
            <div class="loader-bouncing">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>


    <div class="row">
        @if($showAddIt)
        <div class="col-11 d-flex justify-content-start mb-1 mt-4" style="margin-left: 4%;">
            <button class="btn text-white btn-sm" style="background-color: #02114f;" wire:click='cancel'> <i
                    class="fas fa-arrow-left"></i> Back</button>

        </div>
        <div class="col-11  mt-4 itadd-maincolumn">

            <div class="d-flex justify-content-between align-items-center ">
                <h2 class="mb-4 addEditHeading">{{ $editMode ? 'Edit IT Member' : 'Add IT Member' }}</h2>
            </div>

            <div class="border rounded p-3 bg-light itAdd1">
                <form wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="employeeId" class="form-label">Employee ID</label>
                        <select id="employeeId" wire:model="employeeId" wire:change="updateEmployeeName"
                            class="form-select" {{ $editMode ? 'disabled' : '' }}>
                            <option value="" selected>Select Employee ID</option>
                            @foreach($itMembers as $member)
                            <option value="{{ $member->emp_id}}">{{ $member->emp_id }}</option>
                            @endforeach
                        </select>
                        @error('employeeId') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="employeeName" class="form-label">Employee Name</label>
                        <input type="text" id="employeeName" wire:model="employeeName" class="form-control" readonly>
                        @error('employeeName') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>


                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date Of Birth</label>
                        <input type="date" id="dateOfBirth" wire:model="dateOfBirth"
                            wire:keydown.debounce.500ms="validateField('dateOfBirth')" class="form-control" readonly>
                        @error('dateOfBirth') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>


                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" wire:model.lazy="image" class="form-control"
                            accept="image/jpeg, image/png, image/gif, image/webp">

                        @if ($editMode && $image)
                        <!-- Use the temporary URL if it's a newly uploaded image -->
                        @if (is_string($image))
                        <img src="{{ $image }}" class="itAdd2" alt="Image">
                        <!-- <p>{{ basename($image) }}</p> -->
                        @else
                        <img src="{{ $image->temporaryUrl() }}" class="itAdd2" alt="Image">
                        <!-- <p>{{ $image->getClientOriginalName() }}</p> -->
                        @endif
                        @elseif ($editMode && $this->image)
                        <!-- Display the existing image from the database -->
                        <img src="{{ $this->image }}" alt="Image" class="itAdd2">
                        <!-- <p>{{ basename($this->image) }}</p> -->
                        @endif

                        <div wire:loading wire:target="image" class="mt-2">
                            <i class="fas fa-spinner fa-spin"></i> Uploading...
                        </div>

                        @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone </label>
                        <input type="tel" id="phoneNumber" wire:model.lazy="phoneNumber"
                            wire:keydown="resetValidationForField('phone')" maxlength="10"
                            oninput="formatPhoneNumber(this)" class="form-control" {{ $editMode ? '' : 'readonly' }}
                            maxlength="10">
                        @error('phoneNumber') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" wire:model="email" wire:keydown.debounce.500ms="validateEmail"
                            class="form-control" readonly>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn text-white border-white"
                            style="background-color: #02114f;">{{ $editMode ? 'Update' : 'Submit' }}</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if($showEditDeleteIt)

        <div class="d-flex justify-content-end mt-5">
            <button class="btn text-white btn-sm itAdd3" style="background-color: #02114f;"
                wire:click='showAddItMember'><i class="fas fa-user-plus "></i>
                Add Member</button>
        </div>
        <div class="col-11  mt-4 ml-4">

            <div class="table-responsive it-add-table-res">


                <table class="custom-table">
                    <thead>
                        <tr>
                            <th class="req-table-head" scope="col">S.No</th>

                            <th class="req-table-head" wire:click="toggleSortOrder('it_emp_id')"
                                style="cursor: pointer;">IT Employee ID
                                @if($sortColumn == 'it_emp_id')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </th>
                            <!-- Sortable Employee ID Column -->
                            <th class="req-table-head" wire:click="toggleSortOrder('emp_id')" style="cursor: pointer;">
                                Employee ID
                                @if($sortColumn == 'emp_id')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </th>

                            <!-- Sortable Employee Name Column -->
                            <th class="req-table-head" wire:click="toggleSortOrder('employee_name')"
                                style="cursor: pointer;">
                                Employee Name
                                @if($sortColumn == 'employee_name')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </th>

                            <!-- Non-sortable Image Column -->
                            <th class="req-table-head">Image</th>

                            <!-- Sortable Date Of Birth Column -->
                            <th class="req-table-head" wire:click="toggleSortOrder('date_of_birth')"
                                style="cursor: pointer;">
                                Date Of Birth
                                @if($sortColumn == 'date_of_birth')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </th>

                            <!-- Sortable Phone Column -->
                            <th class="req-table-head" wire:click="toggleSortOrder('phone_number')"
                                style="cursor: pointer;">
                                Phone
                                @if($sortColumn == 'phone_number')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </th>

                            <!-- Sortable Email Column -->
                            <th class="req-table-head" wire:click="toggleSortOrder('email')" style="cursor: pointer;">
                                Email
                                @if($sortColumn == 'email')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </th>

                            <th class="req-table-head">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itRelatedEmye as $itemployee)
                        <tr>

                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $itemployee->it_emp_id }}</td>
                            <td>{{ $itemployee->emp_id }}</td>
                            <td>{{ ucwords(strtolower($itemployee->employee_name)) }}</td>
                            <td><img src="{{ $itemployee->image_url }}" alt="Image" class="itAdd4"></td>

                            <td>{{ \Carbon\Carbon::parse($itemployee->date_of_birth)->format('d-M-Y') }}</td>
                            <td>{{ $itemployee->phone_number }}</td>
                            <td>{{ $itemployee->email }}</td>
                            <td class="d-flex flex-direction-row">
                                <!-- Edit Action -->
                                <div class="col mx-1">
                                    <button class="btn btn-white border-dark"
                                        wire:click="showEditItMember({{ $itemployee->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>

                                <!-- Delete Action -->
                                <div class="col mx-1">
                                    <button class="btn text-white border-white" style="background-color: #02114f;"
                                        wire:click='cancelLogout'>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="20">

                                <div class="req-td-norecords">
                                    <img src="{{ asset('images/Closed.webp') }}" alt="No Records"
                                        class="req-img-norecords">


                                    <h3 class="req-head-norecords">No data found</h3>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif


        @if ($showLogoutModal)
        <div class="modal logout1" id="logoutModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-white logout2">
                        <h6 class="modal-title logout3" id="logoutModalLabel">Confirm Deactivation</h6>
                    </div>
                    <div class="modal-body text-center logout4">
                        Are you sure you want to deactivate?
                    </div>
                    <div class="modal-body text-center">
                        <form wire:submit.prevent="delete">
                            <span class="text-danger d-flex align-start">*</span>
                            <div class="row">
                                <div class="col-12 req-remarks-div">

                                    <textarea wire:model.lazy="reason" class="form-control req-remarks-textarea logout5"
                                        placeholder="Reason for deactivation"></textarea>

                                </div>
                            </div>
                            @error('reason') <span class="text-danger d-flex align-start">{{ $message }}</span>@enderror
                            <div class="d-flex justify-content-center p-3">
                                <button type="submit" class="submit-btn mr-3"
                                    wire:click="confirmDelete({{ $itemployee->id }})" @if($loading) disabled
                                    @endif>Deactivate</button>
                                <button type="button" class="cancel-btn1 ml-3" wire:click="cancel">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="modal-body text-center">
                    <form wire:submit.prevent="postRemarks('{{ $itemployee->id }}')">
                        <div class="row">
                            <div class="col-12 req-remarks-div">
                                <textarea wire:model.lazy="remarks.{{ $itemployee->id }}" class="form-control req-remarks-textarea" placeholder="Reason for deletion"></textarea>
                                <button type="submit" class="btn btn-dark ml-2" @if($loading) disabled @endif>Post</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-center p-3">
                    <button type="button" class="submit-btn mr-3"
                        wire:click="delete({{ $itemployee->id }})">Delete</button>
                    <button type="button" class="cancel-btn1 ml-3" wire:click="cancel">Cancel</button>
                </div> -->
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
        @endif

    </div>
</div>


<script>
function formatPhoneNumber(input) {
    // Allow only digits and limit to 10 characters
    input.value = input.value.replace(/\D/g, '').substring(0, 10);
}
</script>
