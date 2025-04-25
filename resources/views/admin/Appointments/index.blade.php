@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">
                        <i class="fas fa-calendar-alt text-primary me-2"></i> Appointments
                    </h5>
                    <h6 id="date-label" class="text-muted"></h6>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary active" id="all-btn">All</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="pending-btn">Pending</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="confirmed-btn">Confirmed</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <select class="form-select" id="appointment-type" style="width: 200px;">
                        <option value="all">All Appointments</option>
                        <option value="user">User Booked</option>
                        <option value="admin">Admin Created</option>
                    </select>
                </div>
                <div class="input-group" style="width: 300px;">
                    <input type="date" class="form-control" name="date" id="date">
                    <button type="button" onclick="search_place()" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-user text-primary me-1"></i> Patient Name
                            </th>
                            <th>
                                <i class="fas fa-calendar-day text-primary me-1"></i> Visit Date
                            </th>
                            <th>
                                <i class="fas fa-sticky-note text-primary me-1"></i> Notes
                            </th>
                            <th>
                                <i class="fas fa-info-circle text-primary me-1"></i> Status
                            </th>
                            <th>
                                <i class="fas fa-dollar-sign text-primary me-1"></i> Total Amount
                            </th>
                            <th>
                                <i class="fas fa-money-bill-wave text-primary me-1"></i> Advance Amount
                            </th>
                            <th>
                                <i class="fas fa-tasks text-primary me-1"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($patients))
                            @foreach ($patients as $place)
                            @php
                                $isPending = false;
                                $isUserBooked = false;
                                $isCancelled = false;

                                // Check if this is a user-booked appointment (will have a note indicating this)
                                if (strpos($place->otherNote ?? '', 'Booked by user') !== false) {
                                    $isUserBooked = true;
                                }

                                // Check if appointment is cancelled
                                if (strpos($place->otherNote ?? '', 'Cancelled') !== false) {
                                    $isCancelled = true;
                                }

                                // Check if appointment is pending confirmation (user-booked with no amount set)
                                if ($isUserBooked && $place->totalAmount == 0) {
                                    $isPending = true;
                                }

                                // Determine appointment status
                                $status = 'Confirmed';
                                $statusClass = 'success';

                                if ($isPending) {
                                    $status = 'Pending';
                                    $statusClass = 'warning';
                                } elseif ($isCancelled) {
                                    $status = 'Cancelled';
                                    $statusClass = 'danger';
                                } elseif (Carbon\Carbon::parse($place->visitDate)->isPast()) {
                                    $status = 'Completed';
                                    $statusClass = 'info';
                                }
                            @endphp
                            <tr class="appointment-row {{ $isPending ? 'pending' : '' }} {{ $isCancelled ? 'cancelled' : '' }} {{ $isUserBooked ? 'user-booked' : 'admin-created' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle bg-primary-soft me-3">
                                            <span>{{ substr($place->patient->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $place->patient->name }}</h6>
                                            <small class="text-muted">ID: #{{ $place->patient->id }}</small>
                                            @if($isUserBooked)
                                                <span class="badge bg-primary ms-2">User Booked</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($place->visitDate)->format('M d, Y') }}</td>
                                <td>
                                    @if($place->otherNote)
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $place->otherNote }}">
                                            {{ $place->otherNote }}
                                        </span>
                                    @else
                                        <span class="text-muted">No notes</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">{{ $status }}</span>
                                </td>
                                <td>₹{{ number_format($place->totalAmount, 2) }}</td>
                                <td>₹{{ number_format($place->advanceAmount, 2) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="/ViewInvoice/{{$place->id}}"><i class="fas fa-eye me-2"></i> View Details</a></li>

                                            @if($isPending)
                                                <li><a class="dropdown-item text-success" href="{{ route('appointment.confirm', $place->id) }}"><i class="fas fa-check-circle me-2"></i> Confirm Appointment</a></li>
                                            @endif

                                            @if(!$isCancelled)
                                                <li><a class="dropdown-item" href="{{ route('appointment.edit', $place->id) }}"><i class="fas fa-edit me-2"></i> Edit Appointment</a></li>
                                                <li><a class="dropdown-item text-danger" href="{{ route('appointment.cancel', $place->id) }}" onclick="return confirm('Are you sure you want to cancel this appointment?')"><i class="fas fa-times-circle me-2"></i> Cancel</a></li>
                                            @endif

                                            @if($isUserBooked && !$isCancelled)
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="{{ route('appointment.notify', $place->id) }}"><i class="fas fa-bell me-2"></i> Send Notification</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h6>No Appointments Found</h6>
                                        <p class="text-muted">There are no appointments scheduled for this date.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if(count($patients) > 0)
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">Showing {{ count($patients) }} appointments</p>
                    </div>
                    @if(isset($patients) && method_exists($patients, 'links'))
                        <div>
                            {{ $patients->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const date = urlParams.get('date');
        if (date) {
            document.getElementById('date-label').innerHTML = date;
            document.getElementById('date').value = date;
        } else {
            const today = moment().format('YYYY-MM-DD');
            document.getElementById('date-label').innerHTML = today;
            document.getElementById('date').value = today;
        }

        // Set appointment type filter from URL if present
        const type = urlParams.get('type');
        if (type) {
            document.getElementById('appointment-type').value = type;
        }

        // Set status filter from URL if present
        const status = urlParams.get('status');
        if (status) {
            if (status === 'pending') {
                $('#pending-btn').addClass('active').siblings().removeClass('active');
                filterAppointmentsByStatus('pending');
            } else if (status === 'confirmed') {
                $('#confirmed-btn').addClass('active').siblings().removeClass('active');
                filterAppointmentsByStatus('confirmed');
            } else {
                $('#all-btn').addClass('active').siblings().removeClass('active');
            }
        }
    };

    var query = <?php echo json_encode((object)Request::only(['date', 'type', 'status'])); ?>;

    function search_place() {
        Object.assign(query, {
            'date': $('#date').val(),
            'type': $('#appointment-type').val()
        });
        window.location.href = "{{route('admin.appointments.index')}}?" + $.param(query);
    }

    // Filter appointments by type (user-booked or admin-created)
    $('#appointment-type').on('change', function() {
        Object.assign(query, {
            'type': $(this).val()
        });
        window.location.href = "{{route('admin.appointments.index')}}?" + $.param(query);
    });

    // Filter appointments by status
    $('#all-btn').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        Object.assign(query, {
            'status': 'all'
        });
        window.location.href = "{{route('admin.appointments.index')}}?" + $.param(query);
    });

    $('#pending-btn').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        Object.assign(query, {
            'status': 'pending'
        });
        window.location.href = "{{route('admin.appointments.index')}}?" + $.param(query);
    });

    $('#confirmed-btn').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        Object.assign(query, {
            'status': 'confirmed'
        });
        window.location.href = "{{route('admin.appointments.index')}}?" + $.param(query);
    });

    // Client-side filtering function
    function filterAppointmentsByStatus(status) {
        if (status === 'pending') {
            $('.appointment-row').hide();
            $('.pending').show();
        } else if (status === 'confirmed') {
            $('.appointment-row').hide();
            $('.appointment-row:not(.pending):not(.cancelled)').show();
        } else {
            $('.appointment-row').show();
        }
    }
</script>
@endsection
