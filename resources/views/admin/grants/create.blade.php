@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Grants</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.grants.index') }}">Grants</a></div>
                <div class="breadcrumb-item">Create New</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create New Grant</h4>
                </div>

                <div class="card-body">
                    <!-- AJAX Form -->
                    <form id="grantForm" action="{{ route('admin.grants.store') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Grant Code <span class="text-danger">*</span></label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror" placeholder="Enter grant code"
                                    value="{{ old('code') }}">
                                <span class="text-danger error-text code_error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Land Registry Number <span class="text-danger">*</span></label>
                                <input type="text" name="land_registry_no"
                                    class="form-control @error('land_registry_no') is-invalid @enderror"
                                    placeholder="Enter land registry number" value="{{ old('land_registry_no') }}">
                                <span class="text-danger error-text land_registry_no_error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client <span class="text-danger">*</span></label>
                                <select name="client_id"
                                    class="form-control select2 @error('client_id') is-invalid @enderror">
                                    <option value="">Select Client</option>
                                    @forelse ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }} - {{ $client->nic }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No clients found</option>
                                    @endforelse
                                </select>
                                <span class="text-danger error-text client_id_error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label>GN Division <span class="text-danger">*</span></label>
                                <select name="gn_division_id"
                                    class="form-control select2 @error('gn_division_id') is-invalid @enderror">
                                    <option value="">Select GN Division</option>
                                    @forelse ($gn_divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ old('gn_division_id') == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No GN divisions found</option>
                                    @endforelse
                                </select>
                                <span class="text-danger error-text gn_division_id_error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Date Issued <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_issued"
                                    class="form-control @error('date_of_issued') is-invalid @enderror"
                                    value="{{ old('date_of_issued') }}">
                                <span class="text-danger error-text date_of_issued_error"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="d-block font-weight-bold text-dark mb-3">Document Status</label>
                                <div class="d-flex justify-content-around bg-light rounded-lg p-3 border">
                                    <label class="custom-switch mb-0">
                                        <input type="checkbox" name="original_in_grantee" value="1"
                                            class="custom-switch-input" {{ old('original_in_grantee') ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description font-weight-normal ml-2">Original in
                                            Grantee</span>
                                    </label>
                                    <label class="custom-switch mb-0">
                                        <input type="checkbox" name="office_copy" value="1" class="custom-switch-input"
                                            {{ old('office_copy') ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description font-weight-normal ml-2">Office Copy</span>
                                    </label>
                                    <label class="custom-switch mb-0">
                                        <input type="checkbox" name="land_registry_copy" value="1"
                                            class="custom-switch-input" {{ old('land_registry_copy') ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description font-weight-normal ml-2">Land Registry
                                            Copy</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                placeholder="Enter full address">{{ old('address') }}</textarea>
                            <span class="text-danger error-text address_error"></span>
                        </div>

                        <!-- Land Specifications - All three fields in one row (EXACT SAME AS PERMITS) -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Type of Land <span class="text-danger">*</span></label>
                                <select name="type_of_land"
                                    class="form-control @error('type_of_land') is-invalid @enderror">
                                    <option value="">Select Land Type</option>
                                    <option value="agricultural"
                                        {{ old('type_of_land') == 'agricultural' ? 'selected' : '' }}>Agricultural</option>
                                    <option value="residential"
                                        {{ old('type_of_land') == 'residential' ? 'selected' : '' }}>Residential</option>
                                    <option value="commercial" {{ old('type_of_land') == 'commercial' ? 'selected' : '' }}>
                                        Commercial</option>
                                    <option value="industrial" {{ old('type_of_land') == 'industrial' ? 'selected' : '' }}>
                                        Industrial</option>
                                    <option value="forest" {{ old('type_of_land') == 'forest' ? 'selected' : '' }}>Forest
                                    </option>
                                    <option value="barren" {{ old('type_of_land') == 'barren' ? 'selected' : '' }}>Barren
                                    </option>
                                    <option value="pasture" {{ old('type_of_land') == 'pasture' ? 'selected' : '' }}>
                                        Pasture</option>
                                    <option value="mining" {{ old('type_of_land') == 'mining' ? 'selected' : '' }}>Mining
                                    </option>
                                    <option value="recreational"
                                        {{ old('type_of_land') == 'recreational' ? 'selected' : '' }}>Recreational</option>
                                    <option value="conservation"
                                        {{ old('type_of_land') == 'conservation' ? 'selected' : '' }}>Conservation</option>
                                </select>
                                <span class="text-danger error-text type_of_land_error"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Extend Type <span class="text-danger">*</span></label>
                                <select name="extend" class="form-control @error('extend') is-invalid @enderror">
                                    <option value="">Select Extend Type</option>
                                    <option value="acre" {{ old('extend') == 'acre' ? 'selected' : '' }}>Acre</option>
                                    <option value="root" {{ old('extend') == 'root' ? 'selected' : '' }}>Root</option>
                                    <option value="perches" {{ old('extend') == 'perches' ? 'selected' : '' }}>Perches
                                    </option>
                                    <option value="hectare" {{ old('extend') == 'hectare' ? 'selected' : '' }}>Hectare
                                    </option>
                                </select>
                                <span class="text-danger error-text extend_error"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Extent Value</label>
                                <input type="number" name="extent_value" step="0.01"
                                    class="form-control @error('extent_value') is-invalid @enderror"
                                    placeholder="Enter extent value" value="{{ old('extent_value') }}">
                                <span class="text-danger error-text extent_value_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is the land surveyed? <span class="text-danger">*</span></label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary {{ old('surveyed', 0) == 0 ? 'active' : '' }}">
                                    <input type="radio" name="surveyed" id="surveyed_no" autocomplete="off"
                                        value="0" {{ old('surveyed', 0) == 0 ? 'checked' : '' }}> No
                                </label>
                                <label class="btn btn-primary {{ old('surveyed') == 1 ? 'active' : '' }}">
                                    <input type="radio" name="surveyed" id="surveyed_yes" autocomplete="off"
                                        value="1" {{ old('surveyed') == 1 ? 'checked' : '' }}> Yes
                                </label>
                            </div>
                            <span class="text-danger error-text surveyed_error"></span>
                        </div>

                        <div class="form-group" id="surveyed_plan_container"
                            style="display: {{ old('surveyed') ? 'block' : 'none' }};">
                            <label>Surveyed Plan Number</label>
                            <input type="text" name="surveyed_plan_no"
                                class="form-control @error('surveyed_plan_no') is-invalid @enderror"
                                placeholder="Enter survey plan number" value="{{ old('surveyed_plan_no') }}">
                            <span class="text-danger error-text surveyed_plan_no_error"></span>
                        </div>

                        <h2 class="section-title">Land Boundaries</h2>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>North Boundary <span class="text-danger">*</span></label>
                                <input type="text" name="boundary_north"
                                    class="form-control @error('boundary_north') is-invalid @enderror"
                                    placeholder="North boundary" value="{{ old('boundary_north') }}">
                                <span class="text-danger error-text boundary_north_error"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label>East Boundary <span class="text-danger">*</span></label>
                                <input type="text" name="boundary_east"
                                    class="form-control @error('boundary_east') is-invalid @enderror"
                                    placeholder="East boundary" value="{{ old('boundary_east') }}">
                                <span class="text-danger error-text boundary_east_error"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label>South Boundary <span class="text-danger">*</span></label>
                                <input type="text" name="boundary_south"
                                    class="form-control @error('boundary_south') is-invalid @enderror"
                                    placeholder="South boundary" value="{{ old('boundary_south') }}">
                                <span class="text-danger error-text boundary_south_error"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label>West Boundary <span class="text-danger">*</span></label>
                                <input type="text" name="boundary_west"
                                    class="form-control @error('boundary_west') is-invalid @enderror"
                                    placeholder="West boundary" value="{{ old('boundary_west') }}">
                                <span class="text-danger error-text boundary_west_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is there a nomination? <span class="text-danger">*</span></label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary {{ old('nomination', 0) == 0 ? 'active' : '' }}">
                                    <input type="radio" name="nomination" id="nomination_no" autocomplete="off"
                                        value="0" {{ old('nomination', 0) == 0 ? 'checked' : '' }}> No
                                </label>
                                <label class="btn btn-primary {{ old('nomination') == 1 ? 'active' : '' }}">
                                    <input type="radio" name="nomination" id="nomination_yes" autocomplete="off"
                                        value="1" {{ old('nomination') == 1 ? 'checked' : '' }}> Yes
                                </label>
                            </div>
                            <span class="text-danger error-text nomination_error"></span>
                        </div>

                        <div class="form-row" id="nomination_container"
                            style="display: {{ old('nomination') ? 'block' : 'none' }};">
                            <div class="form-group col-md-4">
                                <label>Name of Nominees</label>
                                <input type="text" name="name_of_nominees"
                                    class="form-control @error('name_of_nominees') is-invalid @enderror"
                                    placeholder="Nominee name" value="{{ old('name_of_nominees') }}">
                                <span class="text-danger error-text name_of_nominees_error"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Relationship</label>
                                <input type="text" name="relationship"
                                    class="form-control @error('relationship') is-invalid @enderror"
                                    placeholder="Relationship with nominee" value="{{ old('relationship') }}">
                                <span class="text-danger error-text relationship_error"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nominated Date</label>
                                <input type="date" name="nominated_date"
                                    class="form-control @error('nominated_date') is-invalid @enderror"
                                    value="{{ old('nominated_date') }}">
                                <span class="text-danger error-text nominated_date_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is ownership transferred? <span class="text-danger">*</span></label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary {{ old('transferred', 0) == 0 ? 'active' : '' }}">
                                    <input type="radio" name="transferred" id="transferred_no" autocomplete="off"
                                        value="0" {{ old('transferred', 0) == 0 ? 'checked' : '' }}> No
                                </label>
                                <label class="btn btn-primary {{ old('transferred') == 1 ? 'active' : '' }}">
                                    <input type="radio" name="transferred" id="transferred_yes" autocomplete="off"
                                        value="1" {{ old('transferred') == 1 ? 'checked' : '' }}> Yes
                                </label>
                            </div>
                            <span class="text-danger error-text transferred_error"></span>
                        </div>

                        <div class="form-row" id="transfer_container"
                            style="display: {{ old('transferred') ? 'block' : 'none' }};">
                            <div class="form-group col-md-6">
                                <label>Transferee Name</label>
                                <input type="text" name="transferee_name"
                                    class="form-control @error('transferee_name') is-invalid @enderror"
                                    placeholder="Transferee name" value="{{ old('transferee_name') }}">
                                <span class="text-danger error-text transferee_name_error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Transferred Extend Area</label>
                                <input type="number" name="transferred_extend_area" step="0.01"
                                    class="form-control @error('transferred_extend_area') is-invalid @enderror"
                                    placeholder="Transferred area" value="{{ old('transferred_extend_area') }}">
                                <span class="text-danger error-text transferred_extend_area_error"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Related Permit Number</label>
                                <input type="text" name="related_permit_no"
                                    class="form-control @error('related_permit_no') is-invalid @enderror"
                                    placeholder="Related permit number" value="{{ old('related_permit_no') }}">
                                <span class="text-danger error-text related_permit_no_error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Permit Issued Date</label>
                                <input type="date" name="permit_issued_date"
                                    class="form-control @error('permit_issued_date') is-invalid @enderror"
                                    value="{{ old('permit_issued_date') }}">
                                <span class="text-danger error-text permit_issued_date_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Remarks</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Enter any additional remarks or description">{{ old('description') }}</textarea>
                            <span class="text-danger error-text description_error"></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Save Grant
                            </button>
                            <a href="{{ route('admin.grants.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // Initialize conditional fields on page load
            initializeConditionalFields();

            // Toggle surveyed plan number field based on radio button selection
            $('input[name="surveyed"]').on('change', function() {
                toggleSurveyedPlan();
            });

            // Toggle nomination fields based on radio button selection
            $('input[name="nomination"]').on('change', function() {
                toggleNominationFields();
            });

            // Toggle transfer fields based on radio button selection
            $('input[name="transferred"]').on('change', function() {
                toggleTransferFields();
            });

            // Function to initialize all conditional fields
            function initializeConditionalFields() {
                toggleSurveyedPlan();
                toggleNominationFields();
                toggleTransferFields();
            }

            // Function to toggle surveyed plan field
            function toggleSurveyedPlan() {
                if ($('input[name="surveyed"]:checked').val() == '1') {
                    $('#surveyed_plan_container').show();
                } else {
                    $('#surveyed_plan_container').hide();
                    // Don't clear the value on initialization, only on user change
                }
            }

            // Function to toggle nomination fields
            function toggleNominationFields() {
                if ($('input[name="nomination"]:checked').val() == '1') {
                    $('#nomination_container').show();
                } else {
                    $('#nomination_container').hide();
                    // Don't clear the values on initialization, only on user change
                }
            }

            // Function to toggle transfer fields
            function toggleTransferFields() {
                if ($('input[name="transferred"]:checked').val() == '1') {
                    $('#transfer_container').show();
                } else {
                    $('#transfer_container').hide();
                    // Don't clear the values on initialization, only on user change
                }
            }

            // Clear fields only when user explicitly changes to "No"
            $('input[name="surveyed"]').on('change', function() {
                if ($(this).val() == '0') {
                    $('input[name="surveyed_plan_no"]').val('');
                }
            });

            $('input[name="nomination"]').on('change', function() {
                if ($(this).val() == '0') {
                    $('input[name="name_of_nominees"]').val('');
                    $('input[name="relationship"]').val('');
                    $('input[name="nominated_date"]').val('');
                }
            });

            $('input[name="transferred"]').on('change', function() {
                if ($(this).val() == '0') {
                    $('input[name="transferee_name"]').val('');
                    $('input[name="transferred_extend_area"]').val('');
                }
            });

            /* AJAX Form Submission */
            $('#grantForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);
                let submitBtn = $('#submitBtn');

                // Disable submit button and show loading state
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

                // Clear previous error messages
                form.find('span.error-text').text('');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        // Clear previous error messages
                        form.find('span.error-text').text('');
                    },
                    success: function(response) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-save"></i> Save Grant');

                        if (response.success) {
                            // Show success toast
                            showToast('success', response.message);

                            // Clear form after successful submission
                            form[0].reset();
                            $('.select2').val('').trigger('change');
                            $('#surveyed_plan_container').hide();
                            $('#nomination_container').hide();
                            $('#transfer_container').hide();

                            // Redirect to grants index after delay
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.grants.index') }}";
                            }, 1500);
                        }
                    },
                    error: function(response) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-save"></i> Save Grant');

                        // Handle validation errors
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('span.' + key + '_error').text(value[0]);
                            });
                            showToast('error', 'Please fix the validation errors.');
                        } else if (response.status === 500) {
                            showToast('error', response.responseJSON.message ||
                                'An error occurred while creating the grant.');
                        } else {
                            showToast('error', 'An unexpected error occurred.');
                        }
                    }
                });
            });

            function showToast(type, message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            }
        });
    </script>
@endpush
