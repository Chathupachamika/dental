<footer class="footer-container bg-gray-950 border-t border-gray-800">
    <div class="footer-content">
        <!-- Logo Section -->
        <div class="logo-section">
            <img src="/images/logo.png" alt="CASONS RENT-A-CAR" class="footer-logo">
            <div class="footer-logo-title">CASONS</div>
        </div>

        <!-- Quick Links -->
        <div class="footer-column">
            <h3 class="footer-title">Quick Links</h3>
            <ul class="footer-links">
                <li><a href="#" class="footer-link">Home</a></li>
                <li><a href="#" class="footer-link">Manage Cars</a></li>
                <li><a href="#" class="footer-link">Manage Drivers</a></li>
                <li><a href="#" class="footer-link">Manage Customers</a></li>
                <li><a href="#" class="footer-link">Manage Reports</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-column">
            <h3 class="footer-title">Contact Info</h3>
            <ul class="footer-links">
                <li class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>181, Gothami Gardens, <br>
                        Gothami road, Rajagiriya,<br>
                        Sri Lanka.</span>
                </li>
                <li class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+94 11 4 377 366</span>
                </li>
                <li class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@casonsrentacar.com</span>
                </li>
            </ul>
        </div>

        <!-- Help Center -->
        <div class="footer-column">
            <h3 class="footer-title">Help Center</h3>
            <ul class="footer-links">
                <li><a href="#" class="footer-link">FAQS</a></li>
                <li><a href="#" class="footer-link">Terms & Conditions</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div class="social-media">
            <a href="#" class="social-link facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-link whatsapp">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <p>© 2025 CASONS. All rights reserved.</p>
    </div>
</footer>

<style>
    .footer-container {

        padding: 4rem 2rem 1rem;
        color: white;
    }

    .footer-content {
        max-width: 1300px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .logo-section {
        display: flex;
        align-items: center;
        flex-direction: column;
        text-align: center;
    }

    .footer-logo {
        width: 160px;
        height: auto;
    }

    .footer-logo-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        margin-top: 0.5rem;
    }

    .footer-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: white;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-link {
        color: #9ca3af;
        text-decoration: none;
        display: block;
        padding: 0.5rem 0;
        transition: color 0.3s ease;
    }

    .footer-link:hover {
        color: #EA2F2F;
    }

    .contact-item {
        display: flex;
        align-items: baseline;
        gap: 0.75rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .contact-item i {
        color: #9ca3af;
        width: 20px;
    }

    .social-media {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #333;
        color: white;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        transform: translateY(-3px);
    }

    .social-link.facebook:hover {
        background-color: #1877f2;
    }

    .social-link.instagram:hover {
        background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
    }

    .social-link.whatsapp:hover {
        background-color: #25d366;
    }

    .copyright {
        text-align: center;
        padding-top: 2rem;
        border-top: 1px solid #EA2F2F;
        color: #EA2F2F;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .footer-content {
            grid-template-columns: repeat(3, 1fr);
        }

        .logo-section {
            grid-column: span 3;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .social-media {
            grid-column: span 3;
            justify-content: center;
            margin-top: 2rem;
        }
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: repeat(2, 1fr);
        }

        .logo-section {
            grid-column: span 2;
        }

        .social-media {
            grid-column: span 2;
        }
    }

    @media (max-width: 480px) {
        .footer-content {
            grid-template-columns: 1fr;
        }

        .logo-section {
            grid-column: span 1;
        }

        .social-media {
            grid-column: span 1;
        }

        .footer-container {
            padding: 3rem 1rem 1rem;
        }
    }

    /* Hover Animations */
    .footer-link {
        position: relative;
    }

    .footer-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 1px;
        bottom: 0;
        left: 0;
        background-color: white;
        transition: width 0.3s ease;
    }

    .footer-link:hover::after {
        width: 100%;
    }

    .contact-item:hover i {
        transform: scale(1.1);
    }

    .social-link i {
        transition: transform 0.3s ease;
    }

    .social-link:hover i {
        transform: scale(1.2);
    }
</style>
