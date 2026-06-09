<?php
$pageTitle = "Home | Serendib International School";
include 'layouts/header.php';
include 'backend/conn.php';
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

/* =========================
   STUDENT OF THE WEEK
========================= */
.student-week {
    padding: 60px 20px;
    background: linear-gradient(135deg,#f8fafc,#ffffff);
}

.student-week-card {
    max-width: 1000px;
    margin: auto;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 30px;
}

.student-week-image {
    flex: 0 0 320px;
}

.student-week-image img {
    width: 100%;
    height: 100%;
    min-height: 320px;
    object-fit: cover;
}

.student-week-content {
    padding: 30px;
    flex: 1;
}

.student-badge {
    display: inline-block;
    background: #f59e0b;
    color: #fff;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 15px;
}

.student-week-content h2 {
    margin-bottom: 10px;
    color: #0f172a;
}

.student-week-content h3 {
    color: #2563eb;
    margin-bottom: 10px;
}

.student-house {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 15px 0;
}

.student-house img {
    width: 50px;
    height: 50px;
}

.student-reason {
    color: #555;
    line-height: 1.7;
}

@media(max-width:768px){
    .student-week-card{
        flex-direction: column;
    }

    .student-week-image{
        width:100%;
    }

    .student-week-image img{
        min-height:250px;
    }

    .student-week-content{
        text-align:center;
    }

    .student-house{
        justify-content:center;
    }
}
</style>

<?php

$studentWeek = $conn->query("
SELECT
    sow.*,

    s.first_name,
    s.last_name,

    c.class_name,

    h.name AS house_name,
    h.logo AS house_logo

FROM student_of_the_week sow

INNER JOIN students s
    ON s.id = sow.student_id

LEFT JOIN classes c
    ON c.id = s.class_id

LEFT JOIN house_members hm
    ON hm.entity_type='student'
   AND hm.entity_id=s.id

LEFT JOIN houses h
    ON h.id=hm.house_id

WHERE sow.is_active = 1

ORDER BY sow.week_date DESC

LIMIT 1
")->fetch_assoc();

?>
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
<!-- STUDENT OF THE WEEK -->
<!-- ========================= -->
<?php if($studentWeek): ?>

<section class="student-week">

    <div class="student-week-card">

<div class="student-week-image">

<img
    src="<?= !empty($studentWeek['image'])
        ? BASE_URL . 'uploads/student-of-the-week/' . $studentWeek['image']
        : BASE_URL . 'assets/img/student-of-week.jpg' ?>"
    alt="<?= htmlspecialchars(
        $studentWeek['first_name'] . ' ' .
        $studentWeek['last_name']
    ) ?>">

</div>

        <div class="student-week-content">

            <span class="student-badge">
                🏆 Student of the Week
            </span>

            <h2>
                <?= htmlspecialchars($studentWeek['title']) ?>
            </h2>

            <h3>
                <?= htmlspecialchars(
                    $studentWeek['first_name'] . ' ' .
                    $studentWeek['last_name']
                ) ?>
            </h3>

            <p>
                <strong>Grade:</strong>
                <?= htmlspecialchars($studentWeek['class_name']) ?>
            </p>

            <?php if(!empty($studentWeek['house_name'])): ?>

            <div class="student-house">

                <?php if(!empty($studentWeek['house_logo'])): ?>

                <img
                    src="<?= BASE_URL ?>uploads/houses/<?= htmlspecialchars($studentWeek['house_logo']) ?>"
                    alt="<?= htmlspecialchars($studentWeek['house_name']) ?>">

                <?php endif; ?>

                <strong>
                    <?= htmlspecialchars($studentWeek['house_name']) ?>
                </strong>

            </div>

            <?php endif; ?>

            <p class="student-reason">
                <?= nl2br(htmlspecialchars($studentWeek['description'])) ?>
            </p>

            <?php if(!empty($studentWeek['points_awarded'])): ?>

            <div style="
                margin-top:15px;
                display:inline-block;
                background:#ecfdf5;
                color:#047857;
                padding:10px 16px;
                border-radius:30px;
                font-weight:700;
            ">
                ⭐ <?= (int)$studentWeek['points_awarded'] ?> House Points Awarded
            </div>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php endif; ?>


<?php

// Total Students
$studentCount = 0;
$res = $conn->query("
    SELECT COUNT(*) AS total
    FROM students
    WHERE status = 'Active'
");
if($res){
    $studentCount = (int)$res->fetch_assoc()['total'];
}

// Total Teachers
$teacherCount = 0;
$res = $conn->query("
    SELECT COUNT(*) AS total
    FROM teachers
    WHERE status = 'Active'
");
if($res){
    $teacherCount = (int)$res->fetch_assoc()['total'];
}

// Total Houses
$houseCount = 0;
$res = $conn->query("
    SELECT COUNT(*) AS total
    FROM houses
");
if($res){
    $houseCount = (int)$res->fetch_assoc()['total'];
}

?>
<!-- ========================= -->
<!-- QUICK FACTS (ANIMATED) -->
<section class="quick-facts">
    <div class="container quick-grid">

        <div class="quick-fact-card">
            <h3 data-count="<?= $studentCount ?>">0+</h3>
            <p>Students Enrolled</p>
        </div>

        <div class="quick-fact-card">
            <h3 data-count="<?= $teacherCount ?>">0+</h3>
            <p>Qualified Teachers</p>
        </div>

        <div class="quick-fact-card">
            <h3 data-count="<?= $houseCount ?>">0+</h3>
            <p>Student Houses</p>
        </div>

        <div class="quick-fact-card">
            <h3 class="static-text">100%</h3>
            <p>Commitment to Excellence</p>
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