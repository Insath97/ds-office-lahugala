@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Permits</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Permits</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Permits</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.permits.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Create New Permit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Permit Code</th>
                                    <th>Permit Holder</th>
                                    <th>NIC</th>
                                    <th>GN Division</th>
                                    <th>Land Type</th>
                                    <th>Surveyed</th>
                                    <th>Grant Issued</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permits as $permit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permit->code }}</td>
                                        <td>{{ $permit->client->name ?? 'N/A' }}</td>
                                        <td>{{ $permit->client->nic ?? 'N/A' }}</td>
                                        <td>{{ $permit->gnDivision->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $permit->type_of_land }}</span>
                                        </td>
                                        <td>
                                            @if ($permit->surveyed)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($permit->grant_issued)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-warning">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <button class="btn btn-info mr-1 text-center view-details"
                                                    data-toggle="modal" data-target="#permitDetailsModal"
                                                    data-permit-id="{{ $permit->id }}">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </button>
                                                <a href="{{ route('admin.permits.edit', $permit->id) }}"
                                                    class="btn btn-success mr-1 text-center">
                                                    <i class="fas fa-edit fa-lg"></i>
                                                </a>
                                                <a href="{{ route('admin.permits.destroy', $permit->id) }}"
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

    <!-- Permit Details Modal -->
    <div class="modal fade" id="permitDetailsModal" tabindex="-1" role="dialog" aria-labelledby="permitDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white rounded-top">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0">LAND PERMIT CERTIFICATE</h5>
                            <small class="text-white-50">Permit Code: <strong id="permitCode"
                                    class="text-white">-</strong></small>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 1.8rem;">&times;</span>
                        </button>
                    </div>
                </div>

                <!-- Status Indicators -->
                <div class="bg-light border-bottom py-3">
                    <div class="container-fluid">
                        <div class="row text-center">
                            <div class="col">
                                <span class="badge badge-success badge-pill px-3 py-2" id="statusPermitHolderCopy">
                                    <i class="fas fa-check-circle mr-1"></i>Holder Copy
                                </span>
                            </div>
                            <div class="col">
                                <span class="badge badge-info badge-pill px-3 py-2" id="statusOfficeHolderCopy">
                                    <i class="fas fa-file-alt mr-1"></i>Office Copy
                                </span>
                            </div>
                            <div class="col">
                                <span class="badge badge-warning badge-pill px-3 py-2" id="statusSurveyed">
                                    <i class="fas fa-map-marked-alt mr-1"></i>Surveyed
                                </span>
                            </div>
                            <div class="col">
                                <span class="badge badge-danger badge-pill px-3 py-2" id="statusGrantIssued">
                                    <i class="fas fa-certificate mr-1"></i>Grant Issued
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body p-0">
                    <div class="container-fluid py-4">
                        <!-- Boundaries Section - Single Row -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="card border-info shadow-sm">
                                    <div class="card-header bg-info text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-compass mr-2"></i>Land Boundaries</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row text-center">
                                            <div class="col-md-3 mb-1">
                                                <div class="border rounded p-2 bg-light"
                                                    style="border-top: 2px solid #e53e3e !important;">
                                                    <small class="text-muted font-weight-bold d-block">NORTH</small>
                                                    <div class="font-weight-bold text-dark mt-1" id="modalBoundaryNorth">-
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-1">
                                                <div class="border rounded p-2 bg-light"
                                                    style="border-right: 2px solid #3182ce !important;">
                                                    <small class="text-muted font-weight-bold d-block">EAST</small>
                                                    <div class="font-weight-bold text-dark mt-1" id="modalBoundaryEast">-
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-1">
                                                <div class="border rounded p-2 bg-light"
                                                    style="border-bottom: 2px solid #38a169 !important;">
                                                    <small class="text-muted font-weight-bold d-block">SOUTH</small>
                                                    <div class="font-weight-bold text-dark mt-1" id="modalBoundarySouth">-
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-1">
                                                <div class="border rounded p-2 bg-light"
                                                    style="border-left: 2px solid #d69e2e !important;">
                                                    <small class="text-muted font-weight-bold d-block">WEST</small>
                                                    <div class="font-weight-bold text-dark mt-1" id="modalBoundaryWest">-
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
                                <!-- Permit Holder Information -->
                                <div class="card border-primary mb-4 shadow-sm">
                                    <div class="card-header bg-primary text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-user-tie mr-2"></i>Permit Holder Information
                                        </h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">FULL NAME</small>
                                                <div class="font-weight-bold text-dark" id="modalPermitHolder">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">NIC NUMBER</small>
                                                <div class="font-weight-bold text-dark" id="modalNIC">-</div>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <small class="text-muted font-weight-bold">ADDRESS</small>
                                                <div class="font-weight-bold text-dark" id="modalAddress">-</div>
                                            </div>
                                            <div class="col-12">
                                                <small class="text-muted font-weight-bold">GN DIVISION</small>
                                                <div class="font-weight-bold text-dark" id="modalGNDivision">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Land Specifications -->
                                <div class="card border-success shadow-sm">
                                    <div class="card-header bg-success text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-mountain mr-2"></i>Land Specifications</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">LAND TYPE</small>
                                                <div><span class="badge badge-primary" id="modalLandType">-</span></div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">EXTEND TYPE</small>
                                                <div class="font-weight-bold text-dark" id="modalExtendType">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">LEDGER STATUS</small>
                                                <div class="font-weight-bold text-dark" id="modalLedger">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">SURVEY PLAN NO</small>
                                                <div class="font-weight-bold text-dark" id="modalSurveyPlan">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-6">
                                <!-- Legal Documentation -->
                                <div class="card border-warning mb-4 shadow-sm">
                                    <div class="card-header bg-warning text-dark py-2">
                                        <h6 class="mb-0"><i class="fas fa-file-signature mr-2"></i>Legal Documentation
                                        </h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">NOMINATION</small>
                                                <div class="font-weight-bold text-dark" id="modalNomination">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">NOMINEE NAME</small>
                                                <div class="font-weight-bold text-dark" id="modalNomineeName">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">RELATIONSHIP</small>
                                                <div class="font-weight-bold text-dark" id="modalRelationship">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">GRANT NUMBER</small>
                                                <div class="font-weight-bold text-dark" id="modalGrantNo">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">LAND REGISTRY NO</small>
                                                <div class="font-weight-bold text-dark" id="modalLandRegistry">-</div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted font-weight-bold">DATE ISSUED</small>
                                                <div class="font-weight-bold text-dark" id="modalDateIssued">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Remarks -->
                                <div class="card border-secondary shadow-sm">
                                    <div class="card-header bg-secondary text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Additional Remarks</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="border rounded p-3 bg-light">
                                            <div id="modalDescription" class="text-dark">
                                                No additional remarks provided.
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
                            <button class="btn btn-outline-primary btn-sm mr-2">
                                <i class="fas fa-print mr-1"></i>Print
                            </button>
                            <button class="btn btn-outline-info btn-sm">
                                <i class="fas fa-download mr-1"></i>Export
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i>Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-edit mr-1"></i>Edit Permit
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
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [8] // Actions column
            }]
        });

        // Sample data for demonstration
        const permitData = {
            1: {
                code: "PER001",
                holder: "John Doe",
                nic: "901234567V",
                address: "123 Main Street, Colombo 01",
                gnDivision: "Colombo 01",
                landType: "Residential",
                extendType: "acre",
                surveyed: "Yes",
                surveyPlan: "SPN001234",
                ledger: "Yes",
                boundaryNorth: "Road",
                boundaryEast: "River",
                boundarySouth: "Forest",
                boundaryWest: "Mountain",
                nomination: "No",
                nomineeName: "N/A",
                relationship: "N/A",
                grantIssued: "Yes",
                grantNo: "GRN001",
                landRegistry: "LR001234",
                dateIssued: "2023-01-15",
                permitHolderCopy: "Yes",
                officeHolderCopy: "No",
                description: "Residential land permit for housing construction."
            },
            2: {
                code: "PER002",
                holder: "Jane Smith",
                nic: "881234568V",
                address: "456 Kandy Road, Kandy",
                gnDivision: "Kandy",
                landType: "Agricultural",
                extendType: "acre",
                surveyed: "No",
                surveyPlan: "N/A",
                ledger: "No",
                boundaryNorth: "Canal",
                boundaryEast: "Road",
                boundarySouth: "Field",
                boundaryWest: "Stream",
                nomination: "Yes",
                nomineeName: "David Smith",
                relationship: "Son",
                grantIssued: "No",
                grantNo: "N/A",
                landRegistry: "N/A",
                dateIssued: "N/A",
                permitHolderCopy: "Yes",
                officeHolderCopy: "Yes",
                description: "Agricultural land for farming purposes."
            },
            3: {
                code: "PER003",
                holder: "Robert Johnson",
                nic: "871234569V",
                address: "789 Commercial Road, Gampaha",
                gnDivision: "Gampaha",
                landType: "Commercial",
                extendType: "hectare",
                surveyed: "Yes",
                surveyPlan: "SPN001235",
                ledger: "Yes",
                boundaryNorth: "Main Road",
                boundaryEast: "Building",
                boundarySouth: "Park",
                boundaryWest: "Market",
                nomination: "No",
                nomineeName: "N/A",
                relationship: "N/A",
                grantIssued: "No",
                grantNo: "N/A",
                landRegistry: "N/A",
                dateIssued: "N/A",
                permitHolderCopy: "No",
                officeHolderCopy: "Yes",
                description: "Commercial land for business establishment."
            }
        };

        // Handle view details button click
        $('.view-details').on('click', function() {
            const permitId = $(this).data('permit-id');

            $.ajax({
                url: "{{ route('admin.permits.show', '') }}/" + permitId,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const permit = response.data;

                        // Update modal content
                        updateModalContent(permit);
                    } else {
                        showToast('error', 'Failed to load permit details.');
                        $('#permitDetailsModal').modal('hide');
                    }
                },
                error: function() {
                    showToast('error', 'Failed to load permit details.');
                    $('#permitDetailsModal').modal('hide');
                }
            });

            if (permit) {
                $('#permitCode').text(permit.code);
                $('#modalPermitCode').text(permit.code);
                $('#modalPermitHolder').text(permit.holder);
                $('#modalNIC').text(permit.nic);
                $('#modalAddress').text(permit.address);
                $('#modalGNDivision').text(permit.gnDivision);
                $('#modalLandType').text(permit.landType);
                $('#modalExtendType').text(permit.extendType);
                $('#modalSurveyed').text(permit.surveyed);
                $('#modalSurveyPlan').text(permit.surveyPlan);
                $('#modalLedger').text(permit.ledger);
                $('#modalBoundaryNorth').text(permit.boundaryNorth);
                $('#modalBoundaryEast').text(permit.boundaryEast);
                $('#modalBoundarySouth').text(permit.boundarySouth);
                $('#modalBoundaryWest').text(permit.boundaryWest);
                $('#modalNomination').text(permit.nomination);
                $('#modalNomineeName').text(permit.nomineeName);
                $('#modalRelationship').text(permit.relationship);
                $('#modalGrantIssued').text(permit.grantIssued);
                $('#modalGrantNo').text(permit.grantNo);
                $('#modalLandRegistry').text(permit.landRegistry);
                $('#modalDateIssued').text(permit.dateIssued);
                $('#modalPermitHolderCopy').text(permit.permitHolderCopy);
                $('#modalOfficeHolderCopy').text(permit.officeHolderCopy);
                $('#modalDescription').text(permit.description);
            }



        });

        // Function to update modal content
        function updateModalContent(permit) {
            // Basic permit info
            $('#permitCode').text(permit.code);
            $('#modalPermitHolder').text(permit.client?.name || 'N/A');
            $('#modalNIC').text(permit.client?.nic || 'N/A');
            $('#modalAddress').text(permit.address);
            $('#modalGNDivision').text(permit.gn_division?.name || 'N/A');

            // Land specifications
            $('#modalLandType').text(permit.type_of_land);
            $('#modalExtendType').text(permit.extend);
            $('#modalLedger').text(permit.ledger ? 'Yes' : 'No');
            $('#modalSurveyPlan').text(permit.surveyed_plan_no || 'N/A');

            // Boundaries
            $('#modalBoundaryNorth').text(permit.boundary_north);
            $('#modalBoundaryEast').text(permit.boundary_east);
            $('#modalBoundarySouth').text(permit.boundary_south);
            $('#modalBoundaryWest').text(permit.boundary_west);

            // Legal documentation
            $('#modalNomination').text(permit.nomination ? 'Yes' : 'No');
            $('#modalNomineeName').text(permit.name_of_nominees || 'N/A');
            $('#modalRelationship').text(permit.relationship || 'N/A');
            $('#modalGrantNo').text(permit.grant_no || 'N/A');
            $('#modalLandRegistry').text(permit.land_registry_no || 'N/A');
            $('#modalDateIssued').text(permit.date_of_issued || 'N/A');

            // Description
            $('#modalDescription').text(permit.description || 'No additional remarks provided.');

            // Update status badges
            updateStatusBadges(permit);
        }

        // Function to update status badges
        function updateStatusBadges(permit) {
            // Permit Holder Copy
            if (permit.permit_holder_copy) {
                $('#statusPermitHolderCopy').removeClass('badge-secondary').addClass('badge-success');
            } else {
                $('#statusPermitHolderCopy').removeClass('badge-success').addClass('badge-secondary');
            }

            // Office Holder Copy
            if (permit.office_holder_copy) {
                $('#statusOfficeHolderCopy').removeClass('badge-secondary').addClass('badge-info');
            } else {
                $('#statusOfficeHolderCopy').removeClass('badge-info').addClass('badge-secondary');
            }

            // Surveyed
            if (permit.surveyed) {
                $('#statusSurveyed').removeClass('badge-secondary').addClass('badge-warning');
            } else {
                $('#statusSurveyed').removeClass('badge-warning').addClass('badge-secondary');
            }

            // Grant Issued
            if (permit.grant_issued) {
                $('#statusGrantIssued').removeClass('badge-secondary').addClass('badge-danger');
            } else {
                $('#statusGrantIssued').removeClass('badge-danger').addClass('badge-secondary');
            }
        }
    </script>
@endpush
