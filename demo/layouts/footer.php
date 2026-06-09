<?php ?>

<style>
/* ===========================
   RESPONSIVE FOOTER FIXES
   (NO CLASS CHANGES)
=========================== */

/* ---------- GENERAL MOBILE IMPROVEMENTS ---------- */
@media (max-width: 992px) {

    .footer-content {
        gap: 30px;
    }

    .footer-col {
        margin-bottom: 10px;
    }

    .footer-description {
        font-size: 14px;
        line-height: 1.6;
    }
}

/* ---------- TABLET (2 COLUMNS) ---------- */
@media (max-width: 768px) {

    .footer-content {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .footer-brand {
        grid-column: span 2;
        text-align: center;
    }

    .footer-logo {
        justify-content: center;
    }

    .footer-social {
        justify-content: center;
    }

    .footer-contact {
        align-items: center;
    }

    .trust-badges {
        justify-content: center;
        gap: 12px;
    }

    .footer-bottom-left {
        text-align: center;
    }

    .footer-links-bottom {
        justify-content: center;
        margin-top: 8px;
    }
}

/* ---------- MOBILE (1 COLUMN STACKED) ---------- */
@media (max-width: 480px) {

    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .footer-col {
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .footer-col:last-child {
        border-bottom: none;
    }

    .footer-logo {
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .footer-logo-text h3 {
        font-size: 18px;
    }

    .footer-logo-text span {
        font-size: 12px;
    }

    .footer-title {
        justify-content: center;
        font-size: 16px;
    }

    .footer-links li {
        margin-bottom: 6px;
    }

    .newsletter-form {
        max-width: 100%;
    }

    .input-wrapper input {
        padding-left: 40px;
        font-size: 14px;
    }

    .newsletter-btn {
        font-size: 14px;
        padding: 10px;
    }

    .footer-contact {
        gap: 6px;
        font-size: 14px;
    }

    .trust-badges {
        flex-direction: column;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 15px;
    }

    .footer-links-bottom {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .separator {
        display: none;
    }

    .back-to-top {
        right: 15px;
        bottom: 15px;
        padding: 10px;
    }
}

/* ---------- EXTRA SMALL DEVICES ---------- */
@media (max-width: 360px) {

    .footer-description {
        font-size: 13px;
    }

    .footer-title {
        font-size: 15px;
    }

    .newsletter-btn span {
        display: none;
    }
}
</style>

<footer class="main-footer">
    <!-- Wave Decoration -->
    <div class="footer-wave" aria-hidden="true">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" role="img">
            <path d="M0,0 C150,100 350,0 600,50 C850,100 1050,0 1200,50 L1200,120 L0,120 Z" fill="url(#gradient1)"></path>
            <defs>
                <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#000000;">
                        <animate attributeName="stop-color" values="#000000;#0ea5e9;#000000" dur="3s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="100%" style="stop-color:#0ea5e9;">
                        <animate attributeName="stop-color" values="#0ea5e9;#000000;#0ea5e9" dur="3s" repeatCount="indefinite" />
                    </stop>
                </linearGradient>
            </defs>
        </svg>
    </div>

    <div class="container">
        <!-- Main Footer Content -->
        <div class="footer-content">

            <!-- Brand Column -->
            <div class="footer-col footer-brand">
                <div class="footer-logo">
                    <div class="footer-logo-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="footer-logo-text">
                        <h3>SERENDIB</h3>
                        <span>SCHOOL</span>
                    </div>
                </div>

                <p class="footer-description">
                    Serendib School is committed to shaping confident, responsible, and academically strong students through a blend of modern learning and traditional values.  
                </p>

                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span class="social-tooltip">Facebook</span>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                        <span class="social-tooltip">Instagram</span>
                    </a>
                    <a href="#" class="social-link" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                        <span class="social-tooltip">YouTube</span>
                    </a>
                </div>
            </div>

            <!-- School Links -->
            <div class="footer-col">
                <h3 class="footer-title">
                    <i class="fas fa-bolt"></i>
                    Quick Links
                </h3>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <!-- <li><a href="academics.php"><i class="fas fa-chevron-right"></i> Academics</a></li> -->
                    <li><a href="register.php"><i class="fas fa-chevron-right"></i> Admissions</a></li>
                    <!-- <li><a href="news.php"><i class="fas fa-chevron-right"></i> News & Events</a></li> -->
                    <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>

            <!-- Student & Parent Services -->
            <div class="footer-col">
                <h3 class="footer-title">
                    <i class="fas fa-users"></i>
                    Parent & Student Services
                </h3>
                <ul class="footer-links">
                    <li><a href="login.php"><i class="fas fa-chevron-right"></i> Student Portal</a></li>
                    <li><a href="login.ph"><i class="fas fa-chevron-right"></i> Parent Portal</a></li>
                    <!-- <li><a href="#"><i class="fas fa-chevron-right"></i> School Calendar</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Policies</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Transport Info</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Downloads</a></li> -->
                </ul>
            </div>

            <!-- Newsletter & Contact -->
            <div class="footer-col">
                <h3 class="footer-title">
                    <i class="fas fa-envelope"></i>
                    Stay Updated
                </h3>

                <p class="newsletter-text">Subscribe to receive school updates, notices, and announcements.</p>

                <form class="newsletter-form" id="newsletterForm">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="newsletter-btn">
                        <span>Subscribe</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <div class="footer-contact">
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>+94 77 844 8391</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Gampola, Sri Lanka</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="trust-badges">
            <div class="trust-item"><i class="fas fa-user-shield"></i><span>Safe & Secure Campus</span></div>
            <div class="trust-item"><i class="fas fa-chalkboard-teacher"></i><span>Certified Teachers</span></div>
            <div class="trust-item"><i class="fas fa-book-reader"></i><span>Quality Education</span></div>
            <div class="trust-item"><i class="fas fa-bus"></i><span>School Transport</span></div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <p class="copyright">
                    <i class="fas fa-heart"></i>
                    © <?= date('Y') ?> <strong>Serendib School</strong>. All rights reserved.
                </p>
                <div class="footer-links-bottom">
                    <a href="privacy-policy.php">Privacy Policy</a>
                    <span class="separator">•</span>
                    <a href="terms-of-service.php">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>

<script>
(function(){
    // Newsletter
    const form = document.getElementById('newsletterForm');
    if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const email = form.querySelector("input").value;
            Swal.fire({
                icon: 'success',
                title: 'Subscribed!',
                text: 'You will receive school updates at ' + email,
                timer: 2000,
                showConfirmButton: false
            });
            form.reset();
        });
    }

    // Back to top
    const btn = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        btn.classList.toggle('visible', window.scrollY > 300);
    });
    btn.addEventListener('click', () => window.scrollTo({top:0,behavior:'smooth'}));
})();
</script>
