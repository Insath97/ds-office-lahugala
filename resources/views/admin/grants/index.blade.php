@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Grants</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Grants</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Grants</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.grants.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Create New Grant
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Grant Code</th>
                                    <th>Land Registry No</th>
                                    <th>Grant Holder</th>
                                    <th>NIC</th>
                                    <th>GN Division</th>
                                    <th>Land Type</th>
                                    <th>Surveyed</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grants as $grant)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $grant->code }}</td>
                                        <td>{{ $grant->land_registry_no }}</td>
                                        <td>{{ $grant->client->name ?? 'N/A' }}</td>
                                        <td>{{ $grant->client->nic ?? 'N/A' }}</td>
                                        <td>{{ $grant->gnDivision->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $grant->type_of_land }}</span>
                                        </td>
                                        <td>
                                            @if ($grant->surveyed)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $grant->created_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <button class="btn btn-info mr-1 text-center view-details"
                                                    data-toggle="modal" data-target="#grantDetailsModal"
                                                    data-grant-id="{{ $grant->id }}">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </button>
                                                <a href="{{ route('admin.grants.edit', $grant->id) }}"
                                                    class="btn btn-success mr-1 text-center">
                                                    <i class="fas fa-edit fa-lg"></i>
                                                </a>
                                                <a href="{{ route('admin.grants.destroy', $grant->id) }}"
                                                    class="btn btn-danger text-center delete-item">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grant Details Modal -->
    <div class="modal fade" id="grantDetailsModal" tabindex="-1" role="dialog" aria-labelledby="grantDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white rounded-top">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0">LAND GRANT CERTIFICATE - DETAILED VIEW</h5>
                            <small class="text-white-50">Grant Code: <strong id="grantCode"
                                    class="text-white">-</strong></small>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 1.8rem;">&times;</span>
                        </button>
                    </div>
                </div>

                <!-- Status Indicators - Responsive (Auto-layout) -->
                <div class="bg-light border-bottom py-2">
                    <div class="container-fluid">
                        <div class="row justify-content-center text-center align-items-center">
                            <!-- Original in Grantee -->
                            <div class="col-auto col-sm-4 col-md col-lg mb-2 mb-md-0 px-1">
                                <span class="badge badge-secondary badge-pill px-2 py-1 d-inline-flex align-items-center"
                                    id="statusOriginalInGrantee">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    <span class="d-none d-sm-inline">Original</span>
                                    <span class="d-inline d-sm-none">Orig.</span>
                                </span>
                            </div>

                            <!-- Office Copy -->
                            <div class="col-auto col-sm-4 col-md col-lg mb-2 mb-md-0 px-1">
                                <span class="badge badge-secondary badge-pill px-2 py-1 d-inline-flex align-items-center"
                                    id="statusOfficeCopy">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    <span class="d-none d-sm-inline">Office</span>
                                    <span class="d-inline d-sm-none">Office</span>
                                </span>
                            </div>

                            <!-- Land Registry Copy -->
                            <div class="col-auto col-sm-4 col-md col-lg mb-2 mb-md-0 px-1">
                                <span class="badge badge-secondary badge-pill px-2 py-1 d-inline-flex align-items-center"
                                    id="statusLandRegistryCopy">
                                    <i class="fas fa-archive mr-1"></i>
                                    <span class="d-none d-md-inline">Registry</span>
                                    <span class="d-none d-sm-inline d-md-none">Reg.</span>
                                    <span class="d-inline d-sm-none">Reg.</span>
                                </span>
                            </div>

                            <!-- Surveyed -->
                            <div class="col-auto col-sm-4 col-md col-lg mb-2 mb-md-0 px-1">
                                <span class="badge badge-secondary badge-pill px-2 py-1 d-inline-flex align-items-center"
                                    id="statusSurveyed">
                                    <i class="fas fa-map-marked-alt mr-1"></i>
                                    <span class="d-none d-sm-inline">Surveyed</span>
                                    <span class="d-inline d-sm-none">Surv.</span>
                                </span>
                            </div>

                            <!-- Transferred -->
                            <div class="col-auto col-sm-4 col-md col-lg mb-2 mb-md-0 px-1">
                                <span class="badge badge-secondary badge-pill px-2 py-1 d-inline-flex align-items-center"
                                    id="statusTransferred">
                                    <i class="fas fa-exchange-alt mr-1"></i>
                                    <span class="d-none d-sm-inline">Transferred</span>
                                    <span class="d-inline d-sm-none">Trans.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body p-0">
                    <div class="container-fluid py-4">
                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading grant details...</p>
                        </div>

                        <!-- Content Area -->
                        <div id="modalContent">
                            <!-- Boundaries Section - Single Row -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card border-info shadow-sm">
                                        <div class="card-header bg-info text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-compass mr-2"></i>Land Boundaries</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row text-center">
                                                <div class="col-md-3 mb-2">
                                                    <div class="border rounded p-3 bg-light"
                                                        style="border-top: 3px solid #e53e3e !important;">
                                                        <small class="text-muted font-weight-bold d-block">NORTH
                                                            BOUNDARY</small>
                                                        <div class="font-weight-bold text-dark mt-2 fs-6"
                                                            id="modalBoundaryNorth">-
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="border rounded p-3 bg-light"
                                                        style="border-right: 3px solid #3182ce !important;">
                                                        <small class="text-muted font-weight-bold d-block">EAST
                                                            BOUNDARY</small>
                                                        <div class="font-weight-bold text-dark mt-2 fs-6"
                                                            id="modalBoundaryEast">-
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="border rounded p-3 bg-light"
                                                        style="border-bottom: 3px solid #38a169 !important;">
                                                        <small class="text-muted font-weight-bold d-block">SOUTH
                                                            BOUNDARY</small>
                                                        <div class="font-weight-bold text-dark mt-2 fs-6"
                                                            id="modalBoundarySouth">-
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="border rounded p-3 bg-light"
                                                        style="border-left: 3px solid #d69e2e !important;">
                                                        <small class="text-muted font-weight-bold d-block">WEST
                                                            BOUNDARY</small>
                                                        <div class="font-weight-bold text-dark mt-2 fs-6"
                                                            id="modalBoundaryWest">-
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Sections in Columns -->
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-lg-6">
                                    <!-- Grant Holder Information -->
                                    <div class="card border-primary mb-4 shadow-sm">
                                        <div class="card-header bg-primary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-user-tie mr-2"></i>Grant Holder
                                                Information
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">FULL NAME</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalGrantHolder">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">NIC NUMBER</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalNIC">-</div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <small class="text-muted font-weight-bold">ADDRESS</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalAddress">-</div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <small class="text-muted font-weight-bold">GN DIVISION</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalGNDivision">-
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <small class="text-muted font-weight-bold">GRANT CODE</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalGrantCode">-
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Land Specifications -->
                                    <div class="card border-success shadow-sm">
                                        <div class="card-header bg-success text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-mountain mr-2"></i>Land Specifications
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">LAND TYPE</small>
                                                    <div><span class="badge badge-primary fs-6"
                                                            id="modalLandType">-</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">EXTEND TYPE</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalExtendType">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">EXTENT VALUE</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalExtentValue">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">LAND REGISTRY NO</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalLandRegistryNo">
                                                        -</div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <small class="text-muted font-weight-bold">SURVEY PLAN NO</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalSurveyPlan">-
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-lg-6">
                                    <!-- Nomination Information -->
                                    <div class="card border-warning mb-4 shadow-sm">
                                        <div class="card-header bg-warning text-dark py-2">
                                            <h6 class="mb-0"><i class="fas fa-users mr-2"></i>Nomination Information
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">NOMINATION STATUS</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalNomination">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">NOMINEE NAME</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalNomineeName">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">RELATIONSHIP</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalRelationship">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">NOMINATED DATE</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalNominatedDate">-
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transfer Information -->
                                    <div class="card border-danger mb-4 shadow-sm">
                                        <div class="card-header bg-danger text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-exchange-alt mr-2"></i>Transfer
                                                Information
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">TRANSFER STATUS</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalTransferred">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">TRANSFEREE NAME</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalTransfereeName">
                                                        -</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">TRANSFERRED AREA</small>
                                                    <div class="font-weight-bold text-dark fs-6"
                                                        id="modalTransferredArea">-
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">DATE ISSUED</small>
                                                    <div class="font-weight-bold text-dark fs-6" id="modalDateIssued">-
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Permit Information -->
                                    <div class="card border-info mb-4 shadow-sm">
                                        <div class="card-header bg-info text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-file-contract mr-2"></i>Permit Information
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">RELATED PERMIT NO</small>
                                                    <div class="font-weight-bold text-dark fs-6"
                                                        id="modalRelatedPermitNo">-</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted font-weight-bold">PERMIT ISSUED DATE</small>
                                                    <div class="font-weight-bold text-dark fs-6"
                                                        id="modalPermitIssuedDate">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-secondary shadow-sm">
                                        <div class="card-header bg-secondary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Additional Remarks</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="border-0 p-3 bg-light">
                                                <div id="modalDescription" class="text-dark fs-6"
                                                    style="min-height: 80px;">
                                                    No additional remarks provided.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light rounded-bottom">
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <div>
                            <button class="btn btn-outline-primary btn-sm mr-2" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i>Print
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="exportToPDF()">
                                <i class="fas fa-download mr-1"></i>Export PDF
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i>Close
                            </button>
                            <button type="button" class="btn btn-primary" id="editGrantBtn">
                                <i class="fas fa-edit mr-1"></i>Edit Grant
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $("#table-1").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [9] // Actions column
                }]
            });

            // Handle view details button click
            $('.view-details').on('click', function() {
                const grantId = $(this).data('grant-id');
                console.log('Loading grant ID:', grantId);

                // Show loading spinner
                $('#loadingSpinner').show();
                $('#modalContent').hide();

                $.ajax({
                    url: "{{ route('admin.grants.show', '') }}/" + grantId,
                    method: 'GET',
                    success: function(response) {
                        console.log('AJAX Response:', response);

                        $('#loadingSpinner').hide();
                        $('#modalContent').show();

                        if (response.success) {
                            const grant = response.data;
                            console.log('Grant Data:', grant);
                            updateModalContent(grant);
                        } else {
                            showToast('error', response.message ||
                                'Failed to load grant details.');
                            $('#grantDetailsModal').modal('hide');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.log('XHR Response:', xhr.responseText);

                        $('#loadingSpinner').hide();
                        $('#modalContent').show();

                        showToast('error',
                            'Failed to load grant details. Please check console for details.'
                        );
                        $('#grantDetailsModal').modal('hide');
                    }
                });
            });

            // Reset modal when closed
            $('#grantDetailsModal').on('hidden.bs.modal', function() {
                resetModalContent();
            });
        });

        // Function to format date from ISO string
        function formatDate(isoDateString) {
            if (!isoDateString) return 'N/A';

            try {
                const date = new Date(isoDateString);

                // Check if date is valid
                if (isNaN(date.getTime())) {
                    return 'Invalid Date';
                }

                // Format as YYYY-MM-DD
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            } catch (error) {
                console.error('Error formatting date:', error, isoDateString);
                return 'N/A';
            }
        }

        // Function to update modal content with ALL data
        function updateModalContent(grant) {
            console.log('Updating modal with grant:', grant);

            // Basic grant info
            $('#grantCode').text(grant.code || 'N/A');
            $('#modalGrantCode').text(grant.code || 'N/A');
            $('#modalGrantHolder').text(grant.client?.name || 'N/A');
            $('#modalNIC').text(grant.client?.nic || 'N/A');
            $('#modalAddress').text(grant.address || 'N/A');
            $('#modalGNDivision').text(grant.gn_division?.name || 'N/A');

            // Land specifications
            $('#modalLandType').text(grant.type_of_land || 'N/A');
            $('#modalExtendType').text(grant.extend || 'N/A');
            $('#modalExtentValue').text(grant.extent_value ? grant.extent_value + ' ' + grant.extend : 'N/A');
            $('#modalLandRegistryNo').text(grant.land_registry_no || 'N/A');
            $('#modalSurveyPlan').text(grant.surveyed_plan_no || 'N/A');

            // Boundaries
            $('#modalBoundaryNorth').text(grant.boundary_north || 'N/A');
            $('#modalBoundaryEast').text(grant.boundary_east || 'N/A');
            $('#modalBoundarySouth').text(grant.boundary_south || 'N/A');
            $('#modalBoundaryWest').text(grant.boundary_west || 'N/A');

            // Nomination information
            $('#modalNomination').text(grant.nomination ? 'Yes' : 'No');
            $('#modalNomineeName').text(grant.name_of_nominees || 'N/A');
            $('#modalRelationship').text(grant.relationship || 'N/A');
            $('#modalNominatedDate').text(formatDate(grant.nominated_date) || 'N/A');

            // Transfer information
            $('#modalTransferred').text(grant.transferred ? 'Yes' : 'No');
            $('#modalTransfereeName').text(grant.transferee_name || 'N/A');
            $('#modalTransferredArea').text(grant.transferred_extend_area ? grant.transferred_extend_area + ' ' + grant
                .extend : 'N/A');
            $('#modalDateIssued').text(formatDate(grant.date_of_issued) || 'N/A');

            // Permit information
            $('#modalRelatedPermitNo').text(grant.related_permit_no || 'N/A');
            $('#modalPermitIssuedDate').text(formatDate(grant.permit_issued_date) || 'N/A');

            // Description
            $('#modalDescription').text(grant.description || 'No additional remarks provided.');

            // Update status badges
            updateStatusBadges(grant);

            // Set edit button URL
            $('#editGrantBtn').attr('onclick', `window.location.href='/admin/grants/${grant.id}/edit'`);
        }

        // Function to reset modal content
        function resetModalContent() {
            // Reset all fields to default
            $('#grantCode').text('-');
            $('#modalGrantCode').text('-');
            $('#modalGrantHolder').text('-');
            $('#modalNIC').text('-');
            $('#modalAddress').text('-');
            $('#modalGNDivision').text('-');
            $('#modalLandType').text('-');
            $('#modalExtendType').text('-');
            $('#modalExtentValue').text('-');
            $('#modalLandRegistryNo').text('-');
            $('#modalSurveyPlan').text('-');
            $('#modalBoundaryNorth').text('-');
            $('#modalBoundaryEast').text('-');
            $('#modalBoundarySouth').text('-');
            $('#modalBoundaryWest').text('-');
            $('#modalNomination').text('-');
            $('#modalNomineeName').text('-');
            $('#modalRelationship').text('-');
            $('#modalNominatedDate').text('-');
            $('#modalTransferred').text('-');
            $('#modalTransfereeName').text('-');
            $('#modalTransferredArea').text('-');
            $('#modalDateIssued').text('-');
            $('#modalRelatedPermitNo').text('-');
            $('#modalPermitIssuedDate').text('-');
            $('#modalDescription').text('No additional remarks provided.');

            // Reset all badges to inactive state
            resetStatusBadges();
        }

        // Function to update status badges
        function updateStatusBadges(grant) {
            console.log('Updating badges with grant data:', grant);

            // Original in Grantee
            updateBadgeStatus('statusOriginalInGrantee', grant.original_in_grantee, 'success', 'secondary');

            // Office Copy
            updateBadgeStatus('statusOfficeCopy', grant.office_copy, 'info', 'secondary');

            // Land Registry Copy
            updateBadgeStatus('statusLandRegistryCopy', grant.land_registry_copy, 'warning', 'secondary');

            // Surveyed
            updateBadgeStatus('statusSurveyed', grant.surveyed, 'warning', 'secondary');

            // Transferred
            updateBadgeStatus('statusTransferred', grant.transferred, 'danger', 'secondary');
        }

        // Function to reset all status badges
        function resetStatusBadges() {
            $('.badge-pill').removeClass('badge-success badge-info badge-warning badge-danger').addClass('badge-secondary');
        }

        function updateBadgeStatus(elementId, status, activeClass, inactiveClass) {
            const element = $('#' + elementId);
            if (status) {
                element.removeClass('badge-' + inactiveClass).addClass('badge-' + activeClass);
            } else {
                element.removeClass('badge-' + activeClass).addClass('badge-' + inactiveClass);
            }
        }

        function exportToPDF() {
            showToast('info', 'PDF export feature will be implemented soon.');
        }

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
    </script>
@endpush
