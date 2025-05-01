@extends('user.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-question-circle"></i> Help & Support
        </h2>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <h3 class="h5 mb-3">Frequently Asked Questions</h3>
            <div class="accordion">
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="mb-0">How do I book an appointment?</h4>
                    </div>
                    <div class="card-body">
                        <p>To book an appointment, click on the "Book Appointment" link in the sidebar menu. Follow the steps to select your preferred date, time, and treatment type.</p>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="mb-0">How can I view my medical history?</h4>
                    </div>
                    <div class="card-body">
                        <p>Your medical history can be accessed through the "Medical History" section in the sidebar menu. This includes all your past treatments and dental records.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="h5 mb-3">Contact Support</h3>
            <p>If you need additional help, you can reach our support team through:</p>
            <ul>
                <li>Email: support@dentalclinic.com</li>
                <li>Phone: (555) 123-4567</li>
                <li>Operating Hours: Monday to Friday, 9 AM - 5 PM</li>
            </ul>
        </div>
    </div>
</div>
@endsection
