<?php
$pageTitle = "About Us | Serendib International School";
include 'layouts/header.php';
?>

<link rel="stylesheet" href="newAssets/css/aboutUs.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
/* MOBILE FIX FOR WHY-CHOOSE SECTION */
@media (max-width: 768px) {
    .why-choose-content {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
    .why-choose-text h2 {
        font-size: 22px !important;
        text-align: center !important;
    }
    .feature-item {
        align-items: flex-start !important;
    }
    .why-choose-image img {
        height: 240px !important;
        object-fit: cover !important;
    }
}
/* MOBILE FIX — TEAM CARD ONLY */
@media (max-width: 768px) {

    .team-swiper .swiper-slide {
        display: flex;
        justify-content: center;
    }

    .team-card {
        width: 100%;
        max-width: 340px; /* keeps card neat */
        margin: 0 auto;
    }

    .team-card img {
        height: 350px !important;   /* smaller image for mobile */
    }

    .team-info {
        text-align: center;
        padding: 12px !important;
    }

    .team-info h3 {
        font-size: 17px;
    }

    .team-info p {
        font-size: 14px;
        line-height: 1.45;
    }

    /* Hide arrows on mobile (pagination is enough) */
    .team-swiper .swiper-button-next,
    .team-swiper .swiper-button-prev {
        display: none;
    }
      .story-content {
    grid-template-columns: 1fr;
  }

  .story-text {
    order: 1;
  }

  .story-image {
    order: 2;
  }
}
}

/* Make all swiper slides equal height */
.team-swiper .swiper-slide {
    height: auto;
    display: flex;
}

.team-card img {
    width: 100%;
    height: 300px;
    display: block;
    object-fit: cover;
    object-position: center;
}


/* Make content stretch evenly */
.team-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

/* Arrow styling */
.team-swiper .swiper-button-next,
.team-swiper .swiper-button-prev {
    color: #0b2f5a;
}

.team-swiper .swiper-button-next:hover,
.team-swiper .swiper-button-prev:hover {
    color: #0b69c6;
}


</style>

<main class="about-wrapper">
    <!-- Hero Section -->
    <section class="about-hero serendib-hero" style="min-height:50vh;">
        <div class="about-hero-overlay hero-overlay" aria-hidden="true"></div>
        <div class="container">
            <div class="about-hero-content hero-content">
                <!-- <span class="about-badge coming-soon-tag" style="background:#f0c74a;color:#062043;">Our Story</span> -->
                <h1 class="about-hero-title serendib-hero-h1" style="color: #fff; margin-top:12px;">Serendib School — Nurturing Curiosity, Character & Courage</h1>
                <p class="about-hero-subtitle" style="color: rgba(255,255,255,0.95); max-width:720px; margin:auto;">
                    For over a decade Serendib School has combined strong academics with a caring community to develop the whole child — intellectually, socially and physically. We prepare learners for life, not just exams.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision-section" style="padding:40px 0;">
        <div class="container">
            <div class="mission-vision-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;">
                <div class="mission-card" style="background:#fff;padding:22px;border-radius:12px;box-shadow:0 8px 30px rgba(3,25,50,0.06);">
                    <div class="mission-icon" style="font-size:28px;color:#0b69c6;margin-bottom:10px;">
                        <i class="fas fa-bullseye" aria-hidden="true"></i>
                    </div>
                    <h3 style="color:#0b2f5a;">Our Mission</h3>
                    <p style="color:#51607a;">
                        To provide world-class education at an affordable cost, nurturing responsible global 
citizens equipped with knowledge, skills, and compassion.
                    </p>
                </div>

                <div class="mission-card" style="background:#fff;padding:22px;border-radius:12px;box-shadow:0 8px 30px rgba(3,25,50,0.06);">
                    <div class="mission-icon" style="font-size:28px;color:#0b69c6;margin-bottom:10px;">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                    </div>
                    <h3 style="color:#0b2f5a;">Our Vision</h3>
                    <p style="color:#51607a;">
                        To become a leading English medium mid-school in Central Sri Lanka that inspires 
academic excellence, creativity, and moral strength in every child.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="story-section" style="padding:40px 0;">
        <div class="container">
            <div class="story-content" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;">
                <div class="story-text">
                    <!-- <span class="section-badge coming-soon-tag" style="background:#0b69c6;color:#fff;">Who We Are</span> -->
                    <h2 class="section-title" style="margin-top:10px;color:#0b2f5a;">Our Journey</h2>
                    <p class="story-lead" style="color:#51607a;">
                        SERENDiB HiGH SCHOOL was established with a vision to provide modern education 
blended with discipline, values, and innovation. The institution has earned recognition in 
the Gampola region for its high teaching standards and student outcomes. 
                    </p>
                    <p style="color:#51607a;">
                        Encouraged by this success, the management now plans to expand its educational reach 
by launching SERENDiB MiD SCHOOL, focusing on the crucial middle-grade segment 
(Grades 6–11), where foundational academic and personal development take place.
                    </p>

                    <div class="story-stats" style="display:flex;gap:12px;margin-top:18px;flex-wrap:wrap;">
                        <div class="stat-item" style="background:#fff;padding:14px;border-radius:10px;box-shadow:0 6px 18px rgba(3,25,50,0.04);flex:1;min-width:120px;text-align:center;">
                            <h3 style="margin:0;color:#0b2f5a;">60+</h3>
                            <p style="margin:6px 0 0;color:#51607a;">Students</p>
                        </div>
                        <div class="stat-item" style="background:#fff;padding:14px;border-radius:10px;box-shadow:0 6px 18px rgba(3,25,50,0.04);flex:1;min-width:120px;text-align:center;">
                            <h3 style="margin:0;color:#0b2f5a;">15</h3>
                            <p style="margin:6px 0 0;color:#51607a;">Teaching Staff</p>
                        </div>
                        <div class="stat-item" style="background:#fff;padding:14px;border-radius:10px;box-shadow:0 6px 18px rgba(3,25,50,0.04);flex:1;min-width:120px;text-align:center;">
                            <h3 style="margin:0;color:#0b2f5a;">3+</h3>
                            <p style="margin:6px 0 0;color:#51607a;">Clubs & Activities</p>
                        </div>
                    </div>
                </div>

                <div class="story-image" style="position:relative;">
                    <img src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=1000&q=80&auto=format&fit=crop" alt="Students in class" style="width:100%;border-radius:12px;display:block;object-fit:cover;height:100%;">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
    <div class="container">
        <div class="section-header-center">
            <h2 class="section-title">Our Core Values</h2>
            <p class="section-description">
                Guiding principles that shape our teaching, relationships and community life
            </p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon"><i class="fas fa-book"></i></div>
                <h3>Excellence in Learning</h3>
                <p>High academic standards coupled with personalized support for every student.</p>
            </div>

            <div class="value-card">
                <div class="value-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h3>Character & Care</h3>
                <p>Respect, empathy and resilience are core to our pastoral programme.</p>
            </div>

            <div class="value-card">
                <div class="value-icon"><i class="fas fa-flask"></i></div>
                <h3>Innovation & Inquiry</h3>
                <p>Inquiry-led projects, modern labs and STEAM programs encourage curiosity.</p>
            </div>

            <div class="value-card">
                <div class="value-icon"><i class="fas fa-globe"></i></div>
                <h3>Global Citizenship</h3>
                <p>We build cultural awareness and prepare learners for a connected world.</p>
            </div>

            <div class="value-card">
                <div class="value-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Safety & Wellbeing</h3>
                <p>A secure campus and strong welfare systems ensure students thrive.</p>
            </div>

            <div class="value-card">
                <div class="value-icon"><i class="fas fa-users"></i></div>
                <h3>Community & Service</h3>
                <p>Working with families and local partners to make a positive impact.</p>
            </div>
        </div>
    </div>
</section>


    <!-- Why Choose Us Section -->
 <section class="why-choose-section" style="padding:50px 0;background:#ffffff;">
    <div class="container">
        <div class="why-choose-content" 
            style="display:grid;grid-template-columns:420px 1fr;gap:30px;align-items:center;">

            <!-- IMAGE -->
            <div class="why-choose-image" style="position:relative;">
                <div style="
                    position:absolute;
                    inset:0;
                    background:rgba(11,47,90,0.10);
                    border-radius:12px;
                    z-index:1;">
                </div>
                <img 
                    src="assets/img/ser9.png" 
                    alt="Campus" 
                    style="
                        width:100%;
                        border-radius:12px;
                        object-fit:cover;
                        z-index:2;
                        position:relative;
                        box-shadow:0 8px 22px rgba(11,47,90,0.15);
                    ">
            </div>

            <!-- TEXT -->
            <div class="why-choose-text">
                <h2 style="margin:0 0 10px;color:#0b2f5a;font-size:28px;font-weight:700;">
                    What Sets Us Apart
                </h2>

                <div class="feature-list" 
                    style="margin-top:18px;display:flex;flex-direction:column;gap:16px;">

                    <!-- Feature 1 -->
                    <div class="feature-item" style="display:flex;gap:14px;">
                        <div style="font-size:22px;color:#f0c74a;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin:0;color:#0b2f5a;font-size:17px;">Student-centred learning</h4>
                            <p style="margin:6px 0 0;color:#51607a;">
                                Personalised support, small class sizes and data-informed teaching.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-item" style="display:flex;gap:14px;">
                        <div style="font-size:22px;color:#f0c74a;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin:0;color:#0b2f5a;font-size:17px;">Rich extracurriculars</h4>
                            <p style="margin:6px 0 0;color:#51607a;">
                                Sports, music, robotics and community service to broaden horizons.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-item" style="display:flex;gap:14px;">
                        <div style="font-size:22px;color:#f0c74a;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin:0;color:#0b2f5a;font-size:17px;">Safe & modern campus</h4>
                            <p style="margin:6px 0 0;color:#51607a;">
                                Secure facilities, transport and well-resourced learning spaces.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


 <!-- Team Section -->
<section class="team-section" style="padding:40px 0;">
    <div class="container">

        <div class="section-header-center" style="text-align:center;margin-bottom:20px;">
            <h2 class="section-title" style="margin-top:10px;color:#0b2f5a;">Board of Directors</h2>
            <p class="section-description" style="color:#51607a;">
                Providing strategic direction, governance, and leadership for Serendib School
            </p>
        </div>

        <!-- Swiper -->
        <div class="swiper team-swiper">
            <div class="swiper-wrapper">

                <!-- Card 1 -->
                <div class="swiper-slide">
                    <div class="team-card" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(3,25,50,0.04);">
                        <img src="assets/img/invest/shaham3.png">                       
                        <div class="team-info" style="padding:14px;">
                            <h3 style="margin:0;color:#0b2f5a;">Mr. Shaham A. Ajward</h3>
                            <p style="margin:6px 0;color:#51607a;">Founder and Managing Director</p>
                            <p style="margin:0;color:#51607a;">
                                B.Sc, M.Sc, M.Phil (Agronomy)<br>
                                Assistant Lecturer – UoSJP
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide">
                    <div class="team-card" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(3,25,50,0.04);">
                        <img src="assets/img/invest/ziyard.jpeg">   
                        <div class="team-info" style="padding:14px;">
                            <h3 style="margin:0;color:#0b2f5a;">Mr. Ziyard Sameen</h3>
                            <p style="margin:6px 0;color:#51607a;">Director</p>
                            <p style="margin:0;color:#51607a;">Proprietor – Falcon (Pvt) Ltd</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="swiper-slide">
                    <div class="team-card" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(3,25,50,0.04);">
                        <img src="assets/img/invest/zahid2.png">
                        <div class="team-info" style="padding:14px;">
                            <h3 style="margin:0;color:#0b2f5a;">Mr. Zahid Fouzer</h3>
                            <p style="margin:6px 0;color:#51607a;">Director</p>
                            <p style="margin:0;color:#51607a;">CIMA Passed Finalist, MBA (UK)</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="swiper-slide">
                    <div class="team-card" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(3,25,50,0.04);">
                        <img src="assets/img/invest/nasik2.png">
                        <div class="team-info" style="padding:14px;">
                            <h3 style="margin:0;color:#0b2f5a;">Mr. M.N.A Nasik</h3>
                            <p style="margin:6px 0;color:#51607a;">Director</p>
                            <p style="margin:0;color:#51607a;">Assistant Operations Manager – Bluefield Tea Garden (Pvt)</p>
                            <p style="margin:0;color:#51607a;">BA (Hons) Business Administration & Management</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="swiper-slide">
                    <div class="team-card" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(3,25,50,0.04);">
                    <img src="assets/img/invest/shareeq2.png">
                       <div class="team-info" style="padding:14px;">
                            <h3 style="margin:0;color:#0b2f5a;">Mr. Shareeq A. Ajward</h3>
                            <p style="margin:6px 0;color:#51607a;">Director</p>
                            <p style="margin:0;color:#51607a;">Software Engineer – Yoors Digital</p>
                            <p style="margin:0;color:#51607a;">BSc – University of Peradeniya</p>
                        </div>
                    </div>
                </div>
                
                <!-- Card 6 -->
                <div class="swiper-slide">
                    <div class="team-card" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(3,25,50,0.04);">
                        <img src="assets/img/invest/majid.png">
                        <div class="team-info" style="padding:14px;">
                            <h3 style="margin:0;color:#0b2f5a;">Mr. N.M Majidh</h3>
                            <p style="margin:6px 0;color:#51607a;">Director</p>
                            <p style="margin:0;color:#51607a;">Bsc Mathematics, University of Peradeniya</p>
                            <p style="margin:0;color:#51607a;">Phd Mathematics(R), Texas Tech University</p>
                        </div>
                    </div>
                </div>               

            </div>

            <!-- Arrows -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>

    </div>
</section>



    <!-- CTA Section -->
    <!-- <section class="about-cta-section" style="padding:36px 0;background:linear-gradient(90deg,#fffaf0,#ffffff);">
        <div class="container">
            <div class="about-cta-content" style="display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap;">
                <div>
                    <h2 style="margin:0;color:#0b2f5a;">Ready to Visit Serendib?</h2>
                    <p style="margin:6px 0 0;color:#51607a;">Book a campus tour or request a prospectus to learn more about admissions and school life.</p>
                </div>
                <div style="display:flex;gap:12px;">
                    <a href="tour.php" class="btn btn-main" style="background:#f0c74a;color:#062043;border:none;padding:12px 18px;border-radius:8px;text-decoration:none;">Book a Tour</a>
                    <a href="admissions.php" class="btn-outline-dark" style="padding:12px 18px;border-radius:8px;">Admissions</a>
                </div>
            </div>
        </div>
    </section> -->
</main>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
const teamSwiper = new Swiper('.team-swiper', {
    slidesPerView: 4,
    spaceBetween: 18,
    loop: false,

    autoplay: false,

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    breakpoints: {
        0: { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        992: { slidesPerView: 4 }
    },

on: {
    init: function () {
        if (this.slides.length > 4) {
            this.params.loop = true;
            this.params.autoplay = {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            };
            this.update();
            this.autoplay.start();
        }
    }
}

});
</script>


<?php include 'layouts/footer.php'; ?>
