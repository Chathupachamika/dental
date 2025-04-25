@extends('admin.admin_logged.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-chart-line text-primary me-2"></i> Daily Report
            </h5>
            <h6 id="date-label" class="text-muted"></h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-4">
                <div class="input-group" style="width: 300px;">
                    <input type="date" class="form-control" name="date" id="date">
                    <button type="button" onclick="search_place()" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-gradient-to-r from-blue-500 to-blue-600 text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-white-50">Total Appointments</h6>
                                    <h2 class="mb-0">{{count($invoice)}}</h2>
                                </div>
                                <div class="icon-shape bg-blue-700 text-white rounded-circle shadow">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-gradient-to-r from-teal-500 to-teal-600 text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-white-50">Total Amount</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        $total = 0;
                                        ?>
                                        @foreach($invoice as $k => $bD)
                                        <?php
                                        $total += ($bD['totalAmount']);
                                        ?>
                                        @endforeach
                                        ₹{{ number_format($total, 2) }}
                                    </h2>
                                </div>
                                <div class="icon-shape bg-teal-700 text-white rounded-circle shadow">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-gradient-to-r from-purple-500 to-purple-600 text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-white-50">Advance Amount</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        $total = 0;
                                        ?>
                                        @foreach($invoice as $k => $bD)
                                        <?php
                                        $total += ($bD['advanceAmount']);
                                        ?>
                                        @endforeach
                                        ₹{{ number_format($total, 2) }}
                                    </h2>
                                </div>
                                <div class="icon-shape bg-purple-700 text-white rounded-circle shadow">
                                    <i class="fas fa-hand-holding-usd fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Revenue Breakdown</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Payment Status</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="paymentStatusChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Appointment Details</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Treatment</th>
                                            <th>Total Amount</th>
                                            <th>Advance</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($invoice))
                                            @foreach($invoice as $item)
                                            <tr>
                                                <td>{{ $item->patient->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if(isset($item->invoiceTreatment) && count($item->invoiceTreatment))
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($item->invoiceTreatment as $treatment)
                                                                <li>{{ $treatment->treatMent }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">No treatments</span>
                                                    @endif
                                                </td>
                                                <td>₹{{ number_format($item->totalAmount, 2) }}</td>
                                                <td>₹{{ number_format($item->advanceAmount, 2) }}</td>
                                                <td>₹{{ number_format($item->totalAmount - $item->advanceAmount, 2) }}</td>
                                                <td>
                                                    @if($item->totalAmount == $item->advanceAmount)
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($item->advanceAmount > 0)
                                                        <span class="badge bg-warning">Partial</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center py-4">No appointments found for this date</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        // Revenue Chart
        var revenueCtx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Total Amount', 'Advance Amount', 'Balance'],
                datasets: [{
                    label: 'Amount (₹)',
                    data: [
                        <?php
                        $totalAmount = 0;
                        $advanceAmount = 0;
                        foreach($invoice as $item) {
                            $totalAmount += $item->totalAmount;
                            $advanceAmount += $item->advanceAmount;
                        }
                        echo $totalAmount . ', ' . $advanceAmount . ', ' . ($totalAmount - $advanceAmount);
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.7)',
                        'rgba(14, 165, 233, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderColor: [
                        'rgba(37, 99, 235, 1)',
                        'rgba(14, 165, 233, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Payment Status Chart
        var paymentStatusCtx = document.getElementById('paymentStatusChart').getContext('2d');
        var paymentStatusChart = new Chart(paymentStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Partial', 'Unpaid'],
                datasets: [{
                    data: [
                        <?php
                        $paid = 0;
                        $partial = 0;
                        $unpaid = 0;
                        foreach($invoice as $item) {
                            if($item->totalAmount == $item->advanceAmount) {
                                $paid++;
                            } elseif($item->advanceAmount > 0) {
                                $partial++;
                            } else {
                                $unpaid++;
                            }
                        }
                        echo $paid . ', ' . $partial . ', ' . $unpaid;
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    };

    var query = <?php echo json_encode((object)Request::only(['date',])); ?>;

    function search_place() {
        Object.assign(query, {
            'date': $('#date').val()
        });
        window.location.href = "{{route('admin.chart.index')}}?" + $.param(query);
    }
</script>
@endsection
