<?php
$pageTitle = "Contact Us | Serendib International School";
include 'layouts/header.php';
?>

<link rel="stylesheet" href="newAssets/css/contact-us.css" />

<main class="contact-wrapper">

    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="contact-hero-overlay"></div>
        <div class="container">
            <div class="contact-hero-content">
                <!-- <span class="contact-badge">Get In Touch</span> -->
                <h1 class="contact-hero-title">We’re Here to Support You</h1>
                <p class="contact-hero-subtitle">Reach out to our school administration anytime</p>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards Section -->
    <section class="contact-info-section">
        <div class="container">
            <div class="contact-info-grid">

                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3>Visit Our Campus</h3>
                    <p>Serendib International School<br>No. 5,<br>Kandy Road, Bothalapitiya, Gampola, Sri Lanka</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                    <h3>Call Us</h3>
                    <p>+94 77 844 8391<br>Monday – Saturday, 8:00 AM – 5:00 PM</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Email</h3>
                    <p>contact@serendib.edu.lk</p>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                    <h3>Office Hours</h3>
                    <p>Monday – Saturday<br>8:00 AM – 5:00 PM</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact Form & Sidebar -->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-content-grid">

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <!-- <span class="section-badge">Send a Message</span> -->
                        <h2 class="section-title">Get in Touch With Us</h2>
                        <p class="section-description">For inquiries, feedback or admissions—fill the form below</p>
                    </div>

                    <form class="contact-form" id="contactForm">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="admissions">Admissions Inquiry</option>
                                <option value="academic">Academic Support</option>
                                <option value="administration">Administration</option>
                                <option value="fees">Fees & Finance</option>
                                <option value="events">Events / Activities</option>
                                <option value="general">General Inquiry</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="6" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <span>Send Message</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="contact-sidebar">

                    <!-- Quick Contact -->
                    <div class="sidebar-card">
                        <h3>Quick Contact</h3>
                        <div class="quick-contact-list">

                            <a href="tel:+94778448391" class="quick-contact-item">
                                <div class="quick-icon"><i class="fas fa-phone"></i></div>
                                <div class="quick-info">
                                    <span class="quick-label">School Office</span>
                                    <span class="quick-value">+94 77 844 8391</span>
                                </div>
                            </a>

                            <a href="mailto:admissions@serendibschool.lk" class="quick-contact-item">
                                <div class="quick-icon"><i class="fas fa-envelope"></i></div>
                                <div class="quick-info">
                                    <span class="quick-label">Admissions</span>
                                    <span class="quick-value">contact@serendib.edu.lk</span>
                                </div>
                            </a>

                            <a href="https://wa.me/94778448391" class="quick-contact-item">
                                <div class="quick-icon"><i class="fab fa-whatsapp"></i></div>
                                <div class="quick-info">
                                    <span class="quick-label">WhatsApp</span>
                                    <span class="quick-value">+94 77 844 8391</span>
                                </div>
                            </a>

                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="sidebar-card">
                        <h3>Follow Us</h3>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div class="sidebar-card sidebar-cta">
                        <div class="cta-icon"><i class="fas fa-question-circle"></i></div>
                        <h3>Have Questions?</h3>
                        <p>Find answers to common queries about admissions, fees, and school life</p>
                        <a href="faq.php" class="btn btn-outline-sm">Visit FAQ</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MAP -->
    <section class="map-section">
        <div class="container">
            <div class="map-header">
                <!-- <span class="section-badge">Location</span> -->
                <h2 class="section-title">Find Our Campus</h2>
            </div>

            <div class="map-wrapper">
                <iframe
                    src="https://www.google.com/maps?q=colombo%206%20sri%20lanka&output=embed"
                    width="100%"
                    height="450"
                    style="border:0;"
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Preview -->
    <section class="faq-preview-section">
        <div class="container">
            <div class="faq-preview-header">
                <!-- <span class="section-badge">FAQs</span> -->
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-description">Quick answers for parents and students</p>
            </div>

            <div class="faq-grid">

                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>What grades do you offer?</h4>
                    </div>
                    <p class="faq-answer">We offer classes from Grade 1 to Grade 11 under the national curriculum and English medium streams.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>How do I apply for admissions?</h4>
                    </div>
                    <p class="faq-answer">You can apply online through our Admissions Page. Shortlisted applicants will be contacted for an assessment.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Is school transport available?</h4>
                    </div>
                    <p class="faq-answer">Yes, we provide safe, GPS-enabled transport covering major routes in Colombo.</p>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Do you offer extracurricular activities?</h4>
                    </div>
                    <p class="faq-answer">Yes, we have over 20+ clubs including Robotics, Sports, Music, Art and Debate.</p>
                </div>

            </div>

            <div class="faq-cta">
                <p>Still need help?</p>
                <a href="faq.php" class="btn btn-primary">View All FAQs</a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="contact-newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-icon"><i class="fas fa-bell"></i></div>
                <h2>Stay Updated</h2>
                <p>Subscribe for school announcements, events & admission updates</p>

                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>

            </div>
        </div>
    </section>

</main>


<script>
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const btn = form.querySelector('button');
    const originalBtnHTML = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = 'Sending...';

    fetch('backend/handle_contact_form.php', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: 'Thank you for contacting us. Our team will get back to you shortly.',
                confirmButtonColor: '#004080'
            });
            form.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.msg || 'Something went wrong. Please try again.',
                confirmButtonColor: '#d33'
            });
        }
        btn.disabled = false;
        btn.innerHTML = originalBtnHTML;
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Please try again later.',
            confirmButtonColor: '#d33'
        });
        btn.disabled = false;
        btn.innerHTML = originalBtnHTML;
    });
});
</script>



<?php include 'layouts/footer.php'; ?>
