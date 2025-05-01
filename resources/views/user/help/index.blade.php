@extends('user.layouts.app')

@section('styles')
<style>
    /* Base Styles */
    :root {
        --primary: #0ea5e9;
        --primary-light: #e0f2fe;
        --primary-dark: #0284c7;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --radius-sm: 0.125rem;
        --radius-md: 0.375rem;
        --radius-lg: 0.5rem;
        --radius-xl: 0.75rem;
        --radius-2xl: 1rem;
        --radius-full: 9999px;
    }

    /* Help Page Container */
    .help-container {
        max-width: 100%;
        margin: 0 auto;
    }

    /* Hero Section */
    .help-hero {
        background: linear-gradient(135deg, var(--primary-light) 0%, #f0f9ff 100%);
        padding: 3rem 2rem;
        border-radius: var(--radius-xl);
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .help-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
    }

    .help-hero h1 {
        color: var(--gray-800);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .help-hero p {
        color: var(--gray-600);
        font-size: 1.125rem;
        max-width: 700px;
        margin: 0 auto 1.5rem;
    }

    /* Search Bar */
    .search-container {
        max-width: 600px;
        margin: 0 auto 1rem;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border-radius: var(--radius-full);
        border: 1px solid var(--gray-200);
        background-color: white;
        font-size: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
    }

    .search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
    }

    /* Quick Links */
    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .quick-link-card {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
        text-align: center;
    }

    .quick-link-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-light);
    }

    .quick-link-icon {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
        display: block;
    }

    .quick-link-title {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .quick-link-description {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--gray-200);
        padding-bottom: 0.75rem;
    }

    .section-icon {
        font-size: 1.5rem;
        color: var(--primary);
        margin-right: 0.75rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    /* FAQ Accordion */
    .faq-container {
        margin-bottom: 3rem;
    }

    .faq-wrapper {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 1rem;
        border: 1px solid var(--gray-200);
    }

    .faq-question {
        padding: 1rem 1.5rem;
        background-color: white;
        border-bottom: 1px solid transparent;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        background-color: var(--gray-50);
    }

    .faq-question h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .faq-answer {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        background-color: var(--gray-50);
    }

    .faq-answer.active {
        padding: 1.5rem;
        max-height: 500px; /* Adjust based on content */
    }

    .faq-answer p {
        margin: 0;
        color: var(--gray-600);
        line-height: 1.6;
    }

    .faq-answer p:not(:last-child) {
        margin-bottom: 1rem;
    }

    .faq-arrow {
        transition: transform 0.3s ease;
    }

    .faq-question.active .faq-arrow {
        transform: rotate(180deg);
    }

    .faq-question.active {
        background-color: var(--primary-light);
        border-bottom: 1px solid var(--gray-200);
    }

    /* Contact Section */
    .contact-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .contact-info {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--gray-200);
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-light);
        color: var(--primary);
        border-radius: var(--radius-md);
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .contact-text {
        flex-grow: 1;
    }

    .contact-text h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.25rem;
    }

    .contact-text p {
        margin: 0;
        color: var(--gray-600);
        line-height: 1.5;
    }

    /* Contact Form */
    .contact-form {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--gray-200);
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-300);
        background-color: white;
        font-size: 0.875rem;
        color: var(--gray-800);
        transition: all 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .submit-btn {
        background: linear-gradient(to right, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
    }

    /* Support Team Section */
    .support-team {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .support-card {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }

    .support-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .support-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        background-color: var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 3px solid var(--primary-light);
    }

    .support-avatar i {
        font-size: 2rem;
        color: var(--primary);
    }

    .support-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.25rem;
    }

    .support-role {
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
    }

    .support-contact {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    /* Knowledge Base */
    .kb-articles {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kb-article {
        background-color: white;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--primary);
        transition: all 0.3s ease;
    }

    .kb-article:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .kb-article h4 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.75rem;
    }

    .kb-article p {
        color: var(--gray-600);
        margin: 0 0 1rem;
        font-size: 0.875rem;
    }

    .kb-link {
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .kb-link i {
        margin-left: 0.25rem;
        transition: transform 0.2s ease;
    }

    .kb-link:hover i {
        transform: translateX(3px);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .help-hero {
            padding: 2rem 1.5rem;
        }

        .help-hero h1 {
            font-size: 1.75rem;
        }

        .contact-wrapper {
            grid-template-columns: 1fr;
        }

        .search-container {
            padding: 0 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="help-container">
    <!-- Hero Section -->
    <div class="help-hero">
        <h1>Help & Support Center</h1>
        <p>Welcome to our support hub. Find answers to common questions or reach out to our support team.</p>

        <!-- Search -->
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search for help topics..." id="faqSearch">
        </div>
    </div>

    <!-- Quick Links -->
    <div class="quick-links">
        <div class="quick-link-card">
            <i class="fas fa-calendar-check quick-link-icon"></i>
            <h4 class="quick-link-title">Appointments</h4>
            <p class="quick-link-description">Learn how to schedule, manage, or cancel your appointments</p>
        </div>

        <div class="quick-link-card">
            <i class="fas fa-file-medical quick-link-icon"></i>
            <h4 class="quick-link-title">Medical Records</h4>
            <p class="quick-link-description">Access your medical history and treatment records</p>
        </div>

        <div class="quick-link-card">
            <i class="fas fa-credit-card quick-link-icon"></i>
            <h4 class="quick-link-title">Billing & Payments</h4>
            <p class="quick-link-description">Understand your invoices and payment options</p>
        </div>

        <div class="quick-link-card">
            <i class="fas fa-user-cog quick-link-icon"></i>
            <h4 class="quick-link-title">Account Settings</h4>
            <p class="quick-link-description">Update your profile and manage notifications</p>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="faq-container">
        <div class="section-header">
            <i class="fas fa-question-circle section-icon"></i>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>

        <div class="faq-items" id="faqItems">
            <div class="faq-wrapper">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>How do I book an appointment?</h3>
                    <i class="fas fa-chevron-down faq-arrow"></i>
                </div>
                <div class="faq-answer">
                    <p>Booking an appointment is simple:</p>
                    <p>1. Navigate to the "Appointments" section in the sidebar menu or click on the "Book Appointment" button on your dashboard.</p>
                    <p>2. Select your preferred date from the calendar view. Available time slots will be highlighted.</p>
                    <p>3. Choose your preferred time slot and select the type of treatment or consultation you need.</p>
                    <p>4. Add any notes or specific concerns you want the doctor to know about.</p>
                    <p>5. Review your appointment details and click "Confirm Booking" to schedule your appointment.</p>
                    <p>You will receive an email confirmation and a reminder notification 24 hours before your scheduled appointment.</p>
                </div>
            </div>

            <div class="faq-wrapper">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>How can I view my medical history?</h3>
                    <i class="fas fa-chevron-down faq-arrow"></i>
                </div>
                <div class="faq-answer">
                    <p>You can access your complete medical history through your patient portal:</p>
                    <p>1. Click on "Medical Records" in the main navigation menu.</p>
                    <p>2. You'll see a comprehensive overview of your dental history, including past treatments, diagnoses, and dental images.</p>
                    <p>3. Use the filters or search functionality to find specific records or treatments.</p>
                    <p>4. Click on any record to view detailed information about that particular treatment or visit.</p>
                    <p>Your medical records are securely stored and can only be accessed by you and your authorized healthcare providers.</p>
                </div>
            </div>

            <div class="faq-wrapper">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>How do I update my personal information?</h3>
                    <i class="fas fa-chevron-down faq-arrow"></i>
                </div>
                <div class="faq-answer">
                    <p>To update your personal information:</p>
                    <p>1. Click on your profile icon in the top-right corner of any page.</p>
                    <p>2. Select "Profile Settings" from the dropdown menu.</p>
                    <p>3. Update your personal details, contact information, emergency contacts, or insurance information as needed.</p>
                    <p>4. Click "Save Changes" to update your profile.</p>
                    <p>It's important to keep your information current to ensure we can contact you regarding appointments and provide appropriate care.</p>
                </div>
            </div>

            <div class="faq-wrapper">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>How do I pay my invoice?</h3>
                    <i class="fas fa-chevron-down faq-arrow"></i>
                </div>
                <div class="faq-answer">
                    <p>You can pay your invoices through several convenient methods:</p>
                    <p><strong>Online Payment:</strong> Go to "Invoices" in the sidebar menu, find the invoice you want to pay, and click the "Pay" button. You can use credit/debit cards or other supported payment methods.</p>
                    <p><strong>In-Person:</strong> Visit our clinic and pay at the reception desk using cash, credit/debit cards, or check.</p>
                    <p><strong>Automatic Payments:</strong> Set up automatic payments through your profile settings if you prefer a hassle-free experience.</p>
                    <p>All online payments are processed securely, and you will receive a receipt via email once your payment is complete.</p>
                </div>
            </div>

            <div class="faq-wrapper">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>How do I reschedule or cancel an appointment?</h3>
                    <i class="fas fa-chevron-down faq-arrow"></i>
                </div>
                <div class="faq-answer">
                    <p>To reschedule or cancel an appointment:</p>
                    <p>1. Go to the "Appointments" section in the sidebar menu.</p>
                    <p>2. Find your upcoming appointment in the list.</p>
                    <p>3. Click on the "Reschedule" or "Cancel" button next to the appointment.</p>
                    <p>4. If rescheduling, you'll be directed to choose a new date and time.</p>
                    <p>5. Confirm your changes.</p>
                    <p><strong>Please note:</strong> Appointments must be canceled or rescheduled at least 24 hours in advance to avoid cancellation fees. Emergency situations will be considered on a case-by-case basis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Knowledge Base -->
    <section class="kb-container">
        <div class="section-header">
            <i class="fas fa-book-open section-icon"></i>
            <h2 class="section-title">Knowledge Base</h2>
        </div>

        <div class="kb-articles">
            <div class="kb-article">
                <h4>Patient Portal Guide</h4>
                <p>Learn how to navigate and use all features of your patient portal effectively.</p>
                <a href="#" class="kb-link">Read more <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="kb-article">
                <h4>Insurance Coverage Information</h4>
                <p>Understand what treatments are covered by different insurance plans we accept.</p>
                <a href="#" class="kb-link">Read more <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="kb-article">
                <h4>Preparing for Your Dental Visit</h4>
                <p>Tips and information about what to do before your scheduled dental appointment.</p>
                <a href="#" class="kb-link">Read more <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="section-header">
            <i class="fas fa-headset section-icon"></i>
            <h2 class="section-title">Contact Support</h2>
        </div>

        <div class="contact-wrapper">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Email Support</h4>
                        <p>support@dentalclinic.com</p>
                        <p class="text-sm text-muted">We typically respond within 24 hours</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Phone Support</h4>
                        <p>(555) 123-4567</p>
                        <p class="text-sm text-muted">Monday to Friday, 9 AM - 5 PM</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Visit Us</h4>
                        <p>123 Dental Street, Suite 100<br>Dental City, DC 12345</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Chat</h4>
                        <p>Available on weekdays from 10 AM - 4 PM</p>
                       </div>
                </div>
            </div>

            <div class="contact-form">
                <h3 class="form-title">Send Us a Message</h3>
                <form>
                    <div class="form-group">
                        <label class="form-label" for="subject">Subject</label>
                        <select class="form-control" id="subject" required>
                            <option value="">Select a topic</option>
                            <option value="appointment">Appointment Issue</option>
                            <option value="billing">Billing Question</option>
                            <option value="technical">Technical Support</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Your Message</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Please describe your issue or question in detail..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        Submit Request <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Toggle Function
    window.toggleFaq = function(element) {
        // Toggle active class on question
        element.classList.toggle('active');

        // Toggle active class on answer
        var answer = element.nextElementSibling;
        answer.classList.toggle('active');
    };

    // FAQ Search Functionality
    const searchInput = document.getElementById('faqSearch');
    const faqItems = document.getElementById('faqItems');
    const faqWrappers = faqItems.querySelectorAll('.faq-wrapper');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        if (searchTerm === '') {
            // Show all FAQ items if search is empty
            faqWrappers.forEach(wrapper => {
                wrapper.style.display = 'block';
            });
            return;
        }

        // Filter FAQ items
        faqWrappers.forEach(wrapper => {
            const question = wrapper.querySelector('.faq-question h3').textContent.toLowerCase();
            const answer = wrapper.querySelector('.faq-answer').textContent.toLowerCase();

            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                wrapper.style.display = 'block';
            } else {
                wrapper.style.display = 'none';
            }
        });
    });

    // Submit form handling
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loader if available in the app
            if (window.showLoader) {
                window.showLoader('Submitting your request...');
            }

            // Simulate form submission
            setTimeout(() => {
                // Hide loader
                if (window.hideLoader) {
                    window.hideLoader();
                }

                // Reset form
                contactForm.reset();

                // Show success message (you can implement this with a toast or alert)
                alert('Your support request has been submitted successfully. We will contact you shortly.');
            }, 1500);
        });
    }
});
</script>
@endsection

<Actions>
  <Action name="Add chat bot integration" description="Implement a live chat feature for real-time support" />
  <Action name="Create video tutorials section" description="Add video guides for common procedures and questions" />
  <Action name="Add support ticket system" description="Implement a ticket-based support tracking system" />
  <Action name="Implement FAQ categories" description="Organize FAQs into searchable categories" />
  <Action name="Add interactive troubleshooter" description="Create an interactive guide to solve common issues" />
</Actions>
