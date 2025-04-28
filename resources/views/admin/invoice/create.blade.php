@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i> Invoice
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.invoice.store') }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control" value="{{ $patient->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Age:</label>
                            <input type="text" class="form-control" value="{{ $patient->age }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender:</label>
                            <input type="text" class="form-control" value="{{ $patient->gender }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <textarea class="form-control" readonly>{{ $patient->address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mobile:</label>
                            <input type="text" class="form-control" value="{{ $patient->mobileNumber }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIC:</label>
                            <input type="text" class="form-control" value="{{ $patient->nic }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Treatment:</label>
                    <div id="treatment-container">
                        <div class="treatment-row d-flex align-items-center mb-2">
                            <select name="treatments[]" class="form-control treatment-select me-2" style="width: 200px;">
                                <option value="">Choose</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Extraction">Extraction</option>
                                <option value="Surgical removal">Surgical removal</option>
                                <option value="Restoration">Restoration</option>
                                <option value="Full mouth scaling">Full mouth scaling</option>
                                <option value="Denture">Denture</option>
                                <option value="OtherDenticles">OtherDenticles</option>
                                <option value="Crowns">Crowns</option>
                                <option value="Bridges">Bridges</option>
                                <option value="Implant">Implant</option>
                            </select>
                            <select name="sub_types[]" class="form-control subtype-select me-2" style="width: 150px; display: none;">
                                <option value="">Choose</option>
                            </select>
                            <select name="positions[]" class="form-control position-select me-2" style="width: 100px; display: none;">
                                <option value="">Choose</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm remove-treatment">Remove</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2" id="add-treatment">Add</button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Other Note:</label>
                    <textarea name="otherNote" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Next Visit Date:</label>
                    <input type="date" name="visitDate" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Total:</label>
                    <input type="number" name="totalAmount" id="totalAmount" class="form-control" value="0.00" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Advance:</label>
                    <input type="number" name="advanceAmount" class="form-control" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Balance:</label>
                    <input type="number" class="form-control" value="0" readonly>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add this if not already loaded -->

<script>
$(document).ready(function () {
    console.log('JavaScript loaded.');

    const treatmentOptions = {
        'Consultation': [],
        'Extraction': ['UL', 'UR', 'LL', 'LR'],
        'Surgical removal': ['UL', 'UR', 'LL', 'LR'],
        'Restoration': ['LCC', 'GIC', 'TF', 'RCT'],
        'Full mouth scaling': ['Normal', 'Polishing', 'Betel Stains', 'Chromogenic Stains'],
        'Denture': ['Acrylic', 'Valplast', 'Metal'],
        'OtherDenticles': ['URA', 'LRA', 'FA', 'Anderson Type FA', 'Twin Bloc'],
        'Crowns': ['PFM', 'Metal', 'Cercornium'],
        'Bridges': ['PFM', 'Cercornium'],
        'Implant': ['UL', 'UR', 'LL', 'LR'],
        'Other': []
    };

    const positionOptions = ['1', '2', '3', '4', '5', '6', '7', '8'];

    $(document).on('change', '.treatment-select', function () {
        const treatment = $(this).val();
        const $row = $(this).closest('.treatment-row');
        const $subtypeSelect = $row.find('.subtype-select');
        const $positionSelect = $row.find('.position-select');

        console.log('Selected treatment:', treatment);

        $subtypeSelect.empty().append('<option value="">Choose</option>');
        $positionSelect.empty().append('<option value="">Choose</option>');

        if (treatmentOptions[treatment] && treatmentOptions[treatment].length > 0) {
            $subtypeSelect.show();
            treatmentOptions[treatment].forEach(function (subtype) {
                $subtypeSelect.append('<option value="' + subtype + '">' + subtype + '</option>');
            });
        } else {
            $subtypeSelect.hide();
        }

        if (['Extraction', 'Surgical removal', 'Implant'].includes(treatment)) {
            $positionSelect.show();
            positionOptions.forEach(function (position) {
                $positionSelect.append('<option value="' + position + '">' + position + '</option>');
            });
        } else {
            $positionSelect.hide();
        }
    });

    $('#add-treatment').click(function () {
        const newRow = `
            <div class="treatment-row d-flex align-items-center mb-2">
                <select name="treatments[]" class="form-control treatment-select me-2" style="width: 200px;">
                    <option value="">Choose</option>
                    @foreach(['Consultation', 'Extraction', 'Surgical removal', 'Restoration', 'Full mouth scaling', 'Denture', 'OtherDenticles', 'Crowns', 'Bridges', 'Implant'] as $treatment)
                        <option value="{{ $treatment }}">{{ $treatment }}</option>
                    @endforeach
                </select>
                <select name="sub_types[]" class="form-control subtype-select me-2" style="width: 150px; display: none;">
                    <option value="">Choose</option>
                </select>
                <select name="positions[]" class="form-control position-select me-2" style="width: 100px; display: none;">
                    <option value="">Choose</option>
                </select>
                <button type="button" class="btn btn-danger btn-sm remove-treatment">Remove</button>
            </div>
        `;
        $('#treatment-container').append(newRow);
    });

    $(document).on('click', '.remove-treatment', function () {
        $(this).closest('.treatment-row').remove();
    });
});
</script>
@endsection
