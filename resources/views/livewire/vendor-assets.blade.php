<div class="main d-flex" style=" align-items: center; justify-content:center; flex-direction:column">


    <div wire:loading
        wire:target="cancel,submit,file_paths,createAssetType,removeFile,showAddVendorMember,updateStatus ,delete,clearFilters ,showEditAsset ,showViewVendor,showViewImage,showViewFile,showEditVendor,closeViewVendor,downloadImages,closeViewImage,closeViewFile,confirmDelete ,cancelLogout,restore">
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


    @if($showAddVendor)

    <div class="col-11 d-flex justify-content-start mb-1 mt-4" style="margin-left: 5%;">
        <button class="btn text-white btn-sm" style="background-color: #02114f;" wire:click='cancel'> <i
                class="fas fa-arrow-left"></i> Back</button>

    </div>
    <div class="col-11 mt-4 view-details-modal">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4 addEditHeading">{{ $editMode ? 'Edit Asset' : 'Add Asset' }}</h2>
        </div>

        <div class="border rounded p-3 bg-light" style="max-height: 400px; overflow-y: auto;">
            <form wire:submit.prevent="submit" enctype="multipart/form-data">
                <div class="row ">
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="vendor" class="vendor-asset-label">
                                    Vendor</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <select id="vendor" wire:model.lazy="selectedVendorId"
                                    wire:change="resetValidationForField('selectedVendorId')"
                                    class="vendor-selected-vendorID form-select ">
                                    <option value="" disabled hidden>Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->vendor_id }}">
                                        {{ ucwords(strtolower($vendor->vendor_name)) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('selectedVendorId')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="quantity" class="vendor-asset-label">
                                    Quantity</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="number" id="quantity" wire:model.lazy="quantity"
                                @if($editMode) disabled @endif
                                    wire:keydown="resetValidationForField('quantity')" class="form-control" min="1" />
                                @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <!-- Manufacturer -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="manufacturer" class="vendor-asset-label">
                                    Manufacturer</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="text" id="manufacturer" wire:model.lazy="manufacturer"
                                    wire:keydown="resetValidationForField('manufacturer')" class="form-control">
                                @error('manufacturer')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Asset Type -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="assetType" class="vendor-asset-label">
                                    Asset
                                    Type</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <select wire:model.lazy="assetType"
                                        wire:change="handleAssetTypeChangeAndResetValidation" id="assetType"
                                        class="vendor-selected-AssetType form-select" wire:key="asset-type-select">
                                        <option value="" disabled hidden>Select Asset Type</option>
                                        @foreach($assetNames as $asset)
                                        <option value="{{ $asset->id }}">{{ ucwords(strtolower($asset->asset_names)) }}
                                        </option>
                                        @endforeach
                                        <option value="others">Others</option>
                                    </select>

                                </div>
                                @error('assetType') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->

                    @if ($isModalOpen)
                    <div class="modal fade show" style="display: block;" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Asset Type</h5>
                                    <!-- Close modal on clicking the button -->
                                    <button type="button" class="btn-close" wire:click="closeModal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3 col-11">
                                            <label for="assetName" class="vendor-asset-label">Asset Name</label>
                                            <div style="display:flex;gap:5px">
                                                <input type="text" class="form-control" id="assetName"
                                                    style="width: 80%;" wire:model.lazy="newAssetName"
                                                    wire:keydown="resetValidationForField('newAssetName')">
                                                <button type="button" wire:click="createAssetType"
                                                    class="btn text-white"
                                                    style="background-color: #02114f;">Create</button>
                                            </div>


                                            @error('newAssetName')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Row for centering the button -->
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center"
                                                style="align-items:center">

                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backdrop -->
                    <div class="modal-backdrop fade show"></div>
                    @endif
                </div>

                <div class="row">
                    <!-- Asset Model -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="assetModel" class="vendor-asset-label">
                                    Asset
                                    Model</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="text" id="assetModel" wire:model.lazy="assetModel"
                                    wire:keydown="resetValidationForField('assetModel')" class="form-control">
                                @error('assetModel') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Asset Specification -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="assetSpecification" class="vendor-asset-label">
                                    Asset
                                    Specification <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="assetSpecification" wire:model.lazy="assetSpecification"
                                    wire:keydown="resetValidationForField('assetSpecification')" class="form-control">
                                @error('assetSpecification') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Color -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="color" class="vendor-asset-label ml-2"> Color</label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="color" wire:model="color" class="form-control">
                            </div>
                        </div>

                    </div>

                    <!-- Version -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="version" class="vendor-asset-label">Version</label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="version" wire:model="version" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <!-- Serial Number -->
                    @if($quantity == 1)
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="serialNumber" class="vendor-asset-label">
                                    Serial
                                    Number</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="text" id="serialNumber" wire:model.lazy="serialNumber"
                                    wire:keydown="resetValidationForField('serialNumber')" class="form-control"
                                    maxlength="20" minlength="6">
                                @error('serialNumber') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Invoice Number -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="invoiceNumber" class="vendor-asset-label">
                                    Invoice
                                    Number</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="text" id="invoiceNumber" wire:model.lazy="invoiceNumber"
                                    wire:keydown="resetValidationForField('invoiceNumber')" class="form-control">
                                @error('invoiceNumber') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">

                    @if (empty($gstState) && empty($gstCentral))
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                @if (!empty($gstIg))
                                <span class="text-danger">*</span>
                                @endif
                                <label for="gstIg" class="vendor-asset-label">IGST
                                </label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="gstIg" wire:model.lazy="gstIg" placeholder="Rs"
                                    wire:keydown="resetValidationForField('gstIg')" class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    inputmode="decimal">
                            </div>
                        </div>

                    </div>

                </div>
                @endif

                @if (empty($gstIg))
                <div class="row ">

                    <!-- GST State -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="gstState" class="vendor-asset-label">State
                                    GST
                                </label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="text" id="gstState" wire:model.lazy="gstState" placeholder="Rs"
                                    wire:keydown="resetValidationForField('gstState')" class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    inputmode="decimal">
                                @error('gstState') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                    </div>

                    <!-- GST Central -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="gstCentral" class="vendor-asset-label">Central GST
                                </label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="text" id="gstCentral" wire:model.lazy="gstCentral" placeholder="Rs"
                                    wire:keydown="resetValidationForField('gstCentral')" class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    inputmode="decimal">
                                @error('gstCentral') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                @endif


                <div class="row ">
                    <!-- Taxable Amount -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="taxableAmount" class="vendor-asset-label">
                                    Taxable
                                    Amount</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="number" id="taxableAmount" wire:model.lazy="taxableAmount" placeholder="Rs"
                                    wire:keydown="resetValidationForField('taxableAmount')" class="form-control">
                                @error('taxableAmount') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                    </div>
                    <!-- Invoice Amount -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="invoiceAmount" class="vendor-asset-label">
                                    Invoice
                                    Amount</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <div id="street" class="input-div-vendor p-2" wire:model.lazy="invoiceAmount">
                                    {{$invoiceAmount }}
                                </div>
                                @error('invoiceAmount') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>


                </div>


                <div class="row ">
                    <!-- Purchase Date -->
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="purchaseDate" class="vendor-asset-label">Purchase
                                    Date</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-8">
                                <input type="date" id="purchaseDate" wire:model.lazy="purchaseDate"
                                    wire:change="resetValidationForField('purchaseDate')" class="form-control"
                                    max="{{ \Carbon\Carbon::today()->toDateString() }}">
                                @error('purchaseDate') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="warranty_expire_date" class="vendor-asset-label">Warranty Expiration Date
                                </label>
                            </div>
                            <div class="col-8">
                                <input type="date" id="warranty_expire_date" wire:model.lazy="warranty_expire_date"
                                    wire:change="resetValidationForField('warranty_expire_date')" class="form-control"
                                    min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}">
                                @error('warranty_expire_date') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="end_of_life" class="vendor-asset-label">End Of Life
                                </label>
                            </div>
                            <div class="col-8">
                                <input type="text" id="end_of_life" wire:model.lazy="end_of_life" maxlength="30"
                                    wire:change="resetValidationForField('end_of_life')" class="form-control">
                                @error('end_of_life') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <div class="col-4">

                                @if($barcode)
                                <!-- <h6>Generated Barcode:</h6> -->
                                <label for="barcode" class="vendor-asset-label">Generated Barcode
                                </label>
                            </div>
                            <div class="col-8">
                                <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode"
                                    style="max-width: 100%; height: auto;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-4">
                                <p class="text-primary"><label for="file"
                                        class="vendor-asset-label">Attachments</label><i class="fas fa-paperclip"></i>
                                </p>
                            </div>
                            <div class="col-8">
                                <!-- File input hidden -->
                                <input id="fileInput" type="file" wire:model="file_paths" class="form-control-file"
                                    multiple style="font-size: 12px; display: none;" />

                                <!-- Label triggers file input -->
                                <div class="d-flex" style="align-items: baseline;gap: 5px;">
                                    <button class="btn btn-outline-secondary " type="button" for="fileInput"
                                        onclick="document.getElementById('fileInput').click();">
                                        <i class="fa-solid fa-paperclip"></i>
                                    </button>
                                    @if(count($all_files)<=0) No File Choosen @else <p>{{count($all_files)}} File/s
                                        selected</p>
                                        @endif

                                </div>

                                @if($showSuccessMsg)
                                <div wire:poll.60="hideSuccessMsg">
                                    <p style="color:green;">{{$successImageMessage}}</p>
                                </div>
                                @endif


                                <div wire:loading wire:target="file_paths" class="mt-2">
                                    <i class="fas fa-spinner fa-spin"></i> Uploading...
                                </div>
                                @error('file_paths.*') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>

                    </div>

                </div>
                <div class="col-md-12 mb-2">
                    @if (is_array($previews) && count($previews) > 0)
                    <div class="mt-3">
                        <h6>File Previews:</h6>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($previews as $index => $preview)
                            <div class="file-preview-container text-center"
                                style="padding: 5px; border: 1px solid black; width: 120px; height: 120px; border-radius: 5px; position: relative; overflow: hidden;">

                                @if ($preview['type'] == 'image')
                                <!-- Show image preview -->
                                <img src="{{ $preview['url'] }}" alt="Preview" class="img-thumbnail"
                                    style="width: 75px; height: 75px;" />
                                <span class="mt-1">{{ $preview['name'] }}</span>
                                @else
                                <!-- Show non-image file -->
                                <div class="d-flex flex-column align-items-center">
                                    <i style="width: 75px; height: 75px;" class="fas fa-file fa-3x"></i>
                                    <span class="mt-1 uploaded-file-name"
                                        style="display: block; width: 100%;">{{ $preview['name'] }}</span>
                                </div>
                                @endif

                                <!-- Delete icon -->
                                <button type="button" class="delete-icon btn btn-danger"
                                    wire:click="removeFile({{ $index }})"
                                    style="position: absolute; top: 5%; right: 5%; z-index: 5;  font-size: 12px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif


                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" wire:click="submit" class="btn text-white border-white"
                        style="background-color: #02114f;">{{ $editMode ? 'Update' : 'Submit' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif



    @if($showEditDeleteVendor)

    @if($searchFilters)

    <div class="col-11 mb-3 mt-4 ml-4 employeeAssetList">
        <!-- Align items to the same row with space between -->
        <div class="col-11 col-md-11 mb-2 mb-md-0">
            <div class="row d-flex justify-content-between">
                <!-- Employee ID Search Input -->
                <div class="col-4">
                    <div class="input-group task-input-group-container">
                        <input type="text" class="form-control" placeholder="Search..." wire:model="searchEmp"
                            wire:input="filter">
                    </div>
                </div>

                <!-- Add Member Button aligned to the right -->
                @if(auth()->check() && (auth()->user()->hasRole('admin') ||
                auth()->user()->hasRole('super_admin')))
                <div class="col-auto">
                    <button class="btn text-white btn-sm" wire:click='showAddVendorMember'
                        style="padding: 7px;background-color: #02114f;">
                        <i class="fas fa-box " style="margin-right: 5px;"></i> Add Asset
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>


    @endif



    <div class="col-11 mt-4 ml-4">
        <div class="table-responsive it-add-table-res">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th class="vendor-table-head">S.No</th>
                        <th class="vendor-table-head">Vendor Name
                            <span wire:click.debounce.500ms="toggleSortOrder('vendor_id')" style="cursor: pointer;">
                                @if($sortColumn == 'vendor_name')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>


                        <th class="vendor-table-head">Asset ID
                            <span wire:click.debounce.500ms="toggleSortOrder('asset_id')" style="cursor: pointer;">
                                @if($sortColumn == 'asset_id')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th class="vendor-table-head">Manufacturer
                            <span wire:click.debounce.500ms="toggleSortOrder('manufacturer')" style="cursor: pointer;">
                                @if($sortColumn == 'manufacturer')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th class="vendor-table-head">Asset Type
                            <span wire:click.debounce.500ms="toggleSortOrder('$vendorAssets->asset_type_name')"
                                style="cursor: pointer;">
                                @if($sortColumn == 'asset_type')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th class="vendor-table-head">Invoice Number
                            <span wire:click.debounce.500ms="toggleSortOrder('invoice_number')"
                                style="cursor: pointer;">
                                @if($sortColumn == 'invoice_number')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th class="vendor-table-head">Serial Number
                            <span wire:click.debounce.500ms="toggleSortOrder('serial_number')" style="cursor: pointer;">
                                @if($sortColumn == 'serial_number')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th class="vendor-table-head">Status
                            <span wire:click.debounce.500ms="toggleSortOrder('is_active')" style="cursor: pointer;">
                                @if($sortColumn == 'is_active')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                <i class="fas fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th class="vendor-table-head">Barcode Image</th>

                        <th class="vendor-table-head d-flex justify-content-center">Actions</th>
                    </tr>
                </thead>
                <tbody>


                    @if($vendorAssets->count() > 0)
                    @foreach($vendorAssets as $vendorAsset)
                    <tr>
                        <td class="vendor-table-head">{{ $loop->iteration }}</td>
                        <td class="vendor-table-head">{{ $vendorAsset->vendor_name ?? 'N/A'}}</td>

                        <td class="vendor-table-head">{{ $vendorAsset->asset_id ?? 'N/A'}}</td>
                        <td class="vendor-table-head">{{ucwords(strtolower($vendorAsset->manufacturer )) ?? 'N/A' }}
                        </td>
                        <td class="vendor-table-head">{{ ucwords(strtolower($vendorAsset['asset_type_name'])) ?? 'N/A'}}
                        </td>
                        <td class="vendor-table-head">{{ $vendorAsset->invoice_number ?? 'N/A'}}</td>
                        <td class="vendor-table-head">{{ $vendorAsset->serial_number ?? 'N/A'}}</td>


                        <td class="vendor-table-head">{{ $vendorAsset->status ?? 'N/A'}}</td>

                        <td class="vendor-table-head">
                            @if($vendorAsset->barcode)
                            <!-- Text "View Barcode" without any action -->
                            <span>View Barcode</span>

                            <!-- Eye icon to trigger the modal -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#barcodeModal{{ $vendorAsset->id }}"
                                class="ms-2">
                                <i class="fas fa-eye "></i>
                            </a>

                            <!-- Modal for image preview -->
                            <div class="modal fade" id="barcodeModal{{ $vendorAsset->id }}" tabindex="-1"
                                aria-labelledby="barcodeModalLabel{{ $vendorAsset->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="barcodeModalLabel{{ $vendorAsset->id }}">Barcode
                                                Preview</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="data:image/png;base64,{{ $vendorAsset->barcode }}" alt="Barcode"
                                                style="max-width: 100%; height: auto;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            No Barcode
                            @endif
                        </td>


                        <td class="d-flex flex-direction-row">

                            <!-- View Action -->
                            <div class="col mx-1">
                                <button class="btn btn-white border-dark"
                                    wire:click="showViewVendor({{ $vendorAsset->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            @if(auth()->check() && (auth()->user()->hasRole('admin') ||
                            auth()->user()->hasRole('super_admin')))

                            <div class="col mx-1">

                                <button
                                    class="btn btn-white border-dark {{ $vendorAsset->is_active == 0 ? 'disabled' : '' }}"
                                    wire:click="showEditAsset({{ $vendorAsset->id }})"
                                    {{ $vendorAsset->is_active == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-edit"></i>
                                </button>

                            </div>
                            @endif

                            @if(auth()->check() && (auth()->user()->hasRole('super_admin')))

                            @if($vendorAsset->is_active == 1)
                            <div class="col mx-1">
                                <!-- Delete Button (Inactive if is_active is 0) -->
                                <button
                                    class="btn text-white border-white {{ $vendorAsset->is_active == 0 ? 'disabled' : '' }}"
                                    style="background-color: #02114f;"
                                    wire:click="confirmDelete({{ $vendorAsset->id }})"
                                    {{ $vendorAsset->is_active == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @endif
                            @endif

                            @if(auth()->check() && (auth()->user()->hasRole('super_admin')))

                            @if($vendorAsset->is_active == 0)
                            <div class="col mx-1">
                                <!-- Restore Button (Inactive if is_active is 1) -->
                                <button
                                    class="btn text-white border-white {{ $vendorAsset->is_active == 1 ? 'disabled' : '' }}"
                                    style="background-color: #02114f;" wire:click="cancelLogout({{ $vendorAsset->id }})"
                                    {{ $vendorAsset->is_active == 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                            @endif
                            @endif


                            <div class="col mx-1">
                                <select id="vendorStatus" wire:model.lazy="selectedStatus"
                                    wire:change="updateStatus({{ $vendorAsset->id }}, $event.target.value)"
                                    class="vendor-status-select">
                                    <option value="" disabled selected>Select Status</option>
                                    <!-- Placeholder option -->
                                    <option value="In Use">In Use</option>
                                    <option value="In Repair">In Repair</option>
                                    <option value="Available">Available</option>
                                </select>
                            </div>


                        </td>




                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="20">
                            <div class="req-td-norecords">
                                <img src="{{ asset('images/Closed.webp') }}" alt="No Records" class="req-img-norecords">
                                <h3 class="req-head-norecords">No records found</h3>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif


    <!-- View Vendor Details Modal -->
    @if($showViewVendorDialog && $currentVendorId)
    @php
    $vendorAsset = \App\Models\VendorAsset::find($currentVendorId);
    @endphp
    <div class="col-10 mt-4 view-details-modal">

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5>View Details</h5>
            </div>
            <button class="btn text-white" style="background-color: #02114f;" wire:click="closeViewVendor"
                aria-label="Close">

                Close
            </button>
        </div>


        <table class="table table-bordered mt-3 req-pro-table">

            <tbody>

                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Vendor ID</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->vendor_id)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Manufacturer</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->manufacturer)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Asset Type</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->asset_type)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Asset Model</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->asset_model)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Asset Specification</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->asset_specification)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Color</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->color)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Version</td>
                    <td class="view-td">{{ ucwords(strtolower($vendorAsset->version)) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Serial Number</td>
                    <td class="view-td">{{ $vendorAsset->serial_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Invoice Number</td>
                    <td class="view-td"> {{ $vendorAsset->invoice_number ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">GST State</td>
                    <td class="view-td">{{ $vendorAsset->gst_state ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">GST Central</td>
                    <td class="view-td">{{ $vendorAsset->gst_central ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Taxable Amount</td>
                    <td class="view-td">Rs. {{ $vendorAsset->taxable_amount ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Invoice Amount</td>
                    <td class="view-td">Rs. {{$vendorAsset->invoice_amount ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Purchase Date</td>
                    <td class="view-td">{{ \Carbon\Carbon::parse($vendorAsset->purchase_date)->format('d-M-Y') }}</td>
                </tr>
                <tr>
                    <td class="fs-6 fs-md-3 fs-lg-2">Attachments</td>
                    <td>
                        @if (!empty($vendorAsset->file_paths))
                        @php
                        // Check if $vendor->file_paths is a string or an array
                        $fileDataArray = is_string($vendorAsset->file_paths)
                        ? json_decode($vendorAsset->file_paths, true)
                        : $vendorAsset->file_paths;

                        // Separate images and files
                        foreach ($fileDataArray as $fileData) {
                        if (isset($fileData['mime_type'])) {
                        if (strpos($fileData['mime_type'], 'image') !== false) {
                        $images[] = $fileData;
                        } else {
                        $files[] = $fileData;
                        }
                        }
                        }
                        @endphp


                        {{-- view file popup --}}
                        @if ($showViewImageDialog && $currentVendorId === $vendorAsset->id)
                        <div class="modal custom-modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog custom-modal-dialog custom-modal-dialog-centered modal-lg"
                                role="document">
                                <div class="modal-content custom-modal-content">
                                    <div class="modal-header custom-modal-header">
                                        <h5 class="modal-title view-file">Attached Images</h5>
                                    </div>
                                    <div class="modal-body custom-modal-body">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                @foreach ($images as $image)
                                                @php
                                                $base64File = $image['data'];
                                                $mimeType = $image['mime_type'];
                                                @endphp
                                                <div class="swiper-slide">
                                                    <img src="data:{{ $mimeType }};base64,{{ $base64File }}"
                                                        class="img-fluid" alt="Image">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer custom-modal-footer">
                                        <button type="button" class="submit-btn"
                                            wire:click.prevent="downloadImages({{ $vendorAsset->id }})">Download</button>
                                        <button type="button" class="cancel-btn1"
                                            wire:click="closeViewImage">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                        @endif


                        @if ($showViewFileDialog && $currentVendorId === $vendorAsset->id)
                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title viewfile">View Files</h5>
                                    </div>
                                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                        <ul class="list-group list-group-flush">

                                            @foreach ($files as $file)

                                            @php

                                            $base64File = $file['data'];

                                            $mimeType = $file['mime_type'];

                                            $originalName = $file['original_name'];

                                            @endphp

                                            <li>

                                                <a href="data:{{ $mimeType }};base64,{{ $base64File }}"
                                                    download="{{ $originalName }}"
                                                    style="text-decoration: none; color: #007BFF; margin: 10px;">

                                                    {{ $originalName }} <i class="fas fa-download"
                                                        style="margin-left:5px"></i>

                                                </a>

                                            </li>

                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="cancel-btn1"
                                            wire:click="closeViewFile">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                        @endif


                        @php
                        // Initialize $images and $files as empty arrays to avoid null issues
                        $images = $images ?? [];
                        $files = $files ?? [];
                        @endphp
                        <!-- Trigger Links -->
                        @if (count($images) > 1)
                        <a href="#" wire:click.prevent="showViewImage({{ $vendorAsset->id }})"
                            style="text-decoration: none; color: #007BFF; font-size: 12px; text-transform: capitalize;">
                            View Images
                        </a>
                        @elseif (count($images) == 1)
                        <a href="#" wire:click.prevent="showViewImage({{ $vendorAsset->id }})"
                            style="text-decoration: none; color: #007BFF; font-size: 12px; text-transform: capitalize;">
                            View Image
                        </a>
                        @endif

                        @if (count($files) > 1)
                        <a href="#" wire:click.prevent="showViewFile({{ $vendorAsset->id }})"
                            style="text-decoration: none; color: #007BFF; font-size: 12px; text-transform: capitalize;">
                            View Files
                        </a>
                        @elseif (count($files) == 1)
                        <a href="#" wire:click.prevent="showViewFile({{ $vendorAsset->id }})"
                            style="text-decoration: none; color: #007BFF; font-size: 12px; text-transform: capitalize;">
                            View File
                        </a>
                        @endif

                        @if (count($images) == 0 && count($files) == 0)
                        <label for="">No Attachments</label>
                        @endif


                        @endif

                    </td>

                </tr>

            </tbody>
        </table>

    </div>


    @endif



    @if ($showLogoutModal)
    <div class="modal logout1" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white logout2">
                    <h6 class="modal-title logout3" id="logoutModalLabel">Confirm Deactivation
                    </h6>
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
                            <button type="submit" class="submit-btn mr-3">Deactivate</button>
                            <button type="button" class="cancel-btn1 ml-3" wire:click="cancel">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="d-flex justify-content-center p-3">
                    <button type="button" class="submit-btn mr-3" wire:click="delete({{ $vendorAsset->id }})">Delete</button>
                    <button type="button" class="cancel-btn1 ml-3" wire:click="cancel">Cancel</button>
                </div> -->
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif


    @if ($restoreModal)
    <div class="modal logout1" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white logout2">
                    <h6 class="modal-title logout3" id="logoutModalLabel">Confirm Restore</h6>
                </div>
                <div class="modal-body text-center logout4">
                    Are you sure you want to Restore?
                </div>

                <div class="d-flex justify-content-center p-3">
                    <button type="button" class="submit-btn mr-3"
                        wire:click="restore({{ $vendorAssetIdToRestore }})">Restore</button>

                    <button type="button" class="cancel-btn1 ml-3" wire:click="cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

</div>
