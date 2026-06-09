<?php
$pageTitle = "Home | Serendib International School";
include 'layouts/header.php';
?>
<style>
.news-comingsoon {
  padding: 40px 0;
}

.section-head {
  text-align: center;
  margin-bottom: 20px;
}

/* MAIN BOX */
.coming-soon-box {
  max-width: 1100px;
  margin: 0 auto;
  background: #ffffff;
  border-radius: 14px;
  box-shadow: 0 10px 30px rgba(3, 25, 50, 0.06);
  padding: 24px;
}

/* IMAGE GRID */
.coming-soon-images {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}

/* IMAGES */
.coming-soon-images img {
  width: 100%;
  height: 260px;            /* 👈 forces equal height */
  object-fit: cover;
  border-radius: 12px;
  display: block;
}

/* DESKTOP */
@media (min-width: 768px) {
  .coming-soon-images {
    grid-template-columns: 1fr 1fr; /* two images side by side */
  }

  .coming-soon-images img {
    height: 300px;
  }
}

/* CLICK CURSOR */
.open-modal {
  cursor: zoom-in;
}

/* MODAL OVERLAY */
.image-modal {
  display: none;
  position: fixed;
  z-index: 9999;
  inset: 0;
  background: rgba(0, 0, 0, 0.85);
  align-items: center;
  justify-content: center;
  padding: 20px;
}

/* MODAL IMAGE */
.modal-content {
  max-width: 90%;
  max-height: 90%;
  border-radius: 12px;
  animation: zoomIn 0.25s ease;
}

/* CLOSE BUTTON */
.close-modal {
  position: absolute;
  top: 20px;
  right: 28px;
  color: #fff;
  font-size: 34px;
  font-weight: bold;
  cursor: pointer;
}

/* ANIMATION */
@keyframes zoomIn {
  from {
    transform: scale(0.9);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

/* MOBILE */
@media (max-width: 600px) {
  .close-modal {
    font-size: 28px;
    top: 16px;
    right: 18px;
  }
}


</style>


<main>

<!-- HERO SECTION (WORKING + UNCHANGED LOGIC) -->
<section class="serendib-hero">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Welcome to Serendib School</h1>
        <p>
            A proud institution shaping young minds through academic excellence,
            character development, and holistic education.
        </p>

        <div class="hero-buttons">
            <a href="aboutUs.php" class="btn-main">About Us</a>
            <a href="register.php" class="btn-outline">Admissions</a>
        </div>
    </div>
</section>


<!-- ========================= -->
<!-- QUICK FACTS (ANIMATED) -->
<!-- ========================= -->
<section class="quick-facts">
    <div class="container quick-grid">

        <div class="quick-fact-card">
            <h3 data-count="60">0+</h3>
            <p>Students enrolled</p>
        </div>

        <div class="quick-fact-card">
            <h3 data-count="15">0</h3>
            <p>Experienced staff</p>
        </div>

        <div class="quick-fact-card">
            <h3 data-count="3">0+</h3>
            <p>Extra curricular clubs</p>
        </div>

        <div class="quick-fact-card">
            <h3 class="static-text">State-of-the-art</h3>
            <p>Labs & sports facilities</p>
        </div>

    </div>
</section>


<!-- ========================= -->
<!-- PROGRAMS WITH HOVER -->
<!-- ========================= -->
<section class="programs">
    <div class="container section-head">
        <h2>Our Programs</h2>
        <!-- <a href="academics.php" class="view-link">View All Programs →</a> -->
    </div>

    <div class="container program-grid">

        <article class="program-card">
            <img src="assets/img/ser1.jpeg" alt="Primary">
            <h3>Primary Education</h3>
            <p>Foundational learning, inquiry-based activities and strong literacy focus.</p>
        </article>

        <article class="program-card">
            <img src="assets/img/ser2.jpeg" alt="Secondary">
            <h3>Secondary School</h3>
            <p>Rigorous curriculum, exam preparation and personalized guidance.</p>
        </article>

        <article class="program-card">
            <img src="assets/img/ser4.jpg" alt="Clubs">
            <h3>Clubs & Activities</h3>
            <p>Robotics, arts, sports, debate and leadership programs.</p>
        </article>

    </div>
</section>


<!-- ========================= -->
<!-- NEWS / EVENTS (COMING SOON) -->
<!-- ========================= -->
<section class="news-comingsoon">
    <div class="container section-head">
        <h2>News & Events</h2>
    </div>

    <div class="coming-soon-box">
<div class="coming-soon-images">
    <img src="assets/img/news/news1.png" 
         data-full="assets/img/news/news1.png"
         alt="School event"
         class="open-modal">

    <img src="assets/img/news/news2.png" 
         data-full="assets/img/news/news2.png"
         alt="School announcement"
         class="open-modal">
</div>

    </div>
</section>




<!-- ========================= -->
<!-- WHY SERENDIB -->
<!-- ========================= -->
<section class="why-serendib">
    <div class="container why-wrapper">

        <div class="why-text">
            <h2>Why Serendib School?</h2>

            <ul class="why-list">
                <li><strong>Strong academic record</strong> — dedicated teachers & modern digital-ready labs.</li>
                <li><strong>Holistic development</strong> — arts, sports, leadership & character building.</li>
                <li><strong>Safe and supportive campus</strong> — monitored facilities & student welfare programs.</li>
                <li><strong>Global outlook</strong> — language programs & international collaboration opportunities.</li>
            </ul>

            <div class="why-buttons">
                <!--<a href="tour.php" class="btn-main">Schedule a Campus Tour</a>-->
                <a href="contact.php" class="btn-outline-dark">Contact Us</a>
            </div>
        </div>

        <div class="why-images">
            <div class="why-img-box">
                <img src="assets/img/ser5.jpg" alt="Students learning">
            </div>
            <div class="why-img-box">
                <img src="assets/img/ser6.jpg" alt="School library">
            </div>
            <div class="why-img-box">
                <img src="assets/img/ser7.jpg" alt="Science lab">
            </div>
            <div class="why-img-box">
                <img src="assets/img/ser8.jpg" alt="School sports">
            </div>
        </div>

    </div>
</section>



<!-- ========================= -->
<!-- ADMISSIONS CTA -->
<!-- ========================= -->
<section class="admissions-cta">
    <div class="container cta-wrapper">
        <div>
            <h3>Admissions Open for 2026</h3>
            <p>Apply now — limited seats available. View application details & scholarships.</p>
        </div>

        <a href="register.php" class="btn-main">Apply Now</a>
    </div>
</section>


<!-- ========================= -->
<!-- TESTIMONIALS -->
<!-- ========================= -->
<!--<section class="testimonials">-->
<!--    <div class="container">-->
<!--        <h2>From Our Community</h2>-->

<!--        <div class="testimonial-grid">-->

<!--            <div class="testimonial-item">-->
<!--                <p>"Serendib School gave our daughter confidence and a love for learning."</p>-->
<!--                <span>— Mrs. Silva, Parent</span>-->
<!--            </div>-->

<!--            <div class="testimonial-item">-->
<!--                <p>"Excellent facilities and engaging clubs — my son learned robotics."</p>-->
<!--                <span>— Mr. Perera, Parent</span>-->
<!--            </div>-->

<!--            <div class="testimonial-item">-->
<!--                <p>"Supportive teachers and strong values — Serendib prepares students for life."</p>-->
<!--                <span>— Alumna, 2019</span>-->
<!--            </div>-->

<!--        </div>-->
<!--    </div>-->
<!--</section>-->


<!-- ========================= -->
<!-- NEWSLETTER -->
<!-- ========================= -->
<section class="newsletter">
    <div class="container newsletter-box">
        <h3>Stay Connected</h3>
        <p>Subscribe for campus updates, events, and important announcements.</p>

        <form onsubmit="event.preventDefault(); subscribeNewsletter();">
            <input type="email" id="newsletter-email" placeholder="your.email@domain.com" required>
            <button class="btn-main">Subscribe</button>
        </form>
    </div>
</section>

</main>


<!-- IMAGE MODAL -->
<div class="image-modal" id="imageModal">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
<script>
// ==================
// Animated Counters
// ==================
function animateCounter(el) {
    let target = parseInt(el.dataset.count);
    let suffix = el.innerText.includes("+") ? "+" : "";
    let count = 0;
    let speed = 20;

    let interval = setInterval(() => {
        count += Math.ceil(target / 50);
        if (count >= target) {
            count = target;
            clearInterval(interval);
        }
        el.innerText = count + suffix;
    }, speed);
}

document.addEventListener("DOMContentLoaded", () => {
    let counters = document.querySelectorAll(".quick-fact-card h3:not(.static-text)");
    counters.forEach(counter => animateCounter(counter));
});

function subscribeNewsletter() {
    let email = document.getElementById('newsletter-email').value;
    if (!email) return;

    Swal.fire({
        icon: 'success',
        title: 'Subscribed',
        text: 'Thank you! We will send updates to ' + email,
        timer: 2200,
        showConfirmButton: false
    });

    document.getElementById('newsletter-email').value = '';
}
</script>

<script>
/* IMAGE MODAL SCRIPT */
const modal = document.getElementById("imageModal");
const modalImg = document.getElementById("modalImage");
const closeBtn = document.querySelector(".close-modal");

document.querySelectorAll(".open-modal").forEach(img => {
  img.addEventListener("click", () => {
    modal.style.display = "flex";
    modalImg.src = img.dataset.full;
  });
});

closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.style.display = "none";
  }
});
</script>



<?php include 'layouts/footer.php'; ?>