<?php
$pageTitle = "House Points | Serendib International School";

include 'layouts/header.php';
require_once 'backend/conn.php';
require_once 'backend/helpers.php';

/* ===============================
   ACTIVE ACADEMIC YEAR
================================ */
$year = $conn->query("
    SELECT id, year_name
    FROM academic_years
    WHERE is_active = 1
    LIMIT 1
")->fetch_assoc();

if (!$year) {
    die('No active academic year found');
}

/* ===============================
   HOUSE LEADERBOARD
================================ */
$houses = $conn->query("
    SELECT
        h.id,
        h.name,
        h.color,
        h.logo,
        COALESCE(SUM(l.points),0) AS points
    FROM houses h
    LEFT JOIN house_point_logs l
        ON l.house_id = h.id
       AND l.academic_year_id = {$year['id']}
    GROUP BY h.id
    ORDER BY points DESC
");
?>

<style>

/* ===============================
   PAGE
================================ */
.house-page{
    padding:40px 20px;
    background:#f4f7fb;
    min-height:100vh;
}

.page-header{
    text-align:center;
    margin-bottom:40px;
}

.page-header h1{
    font-size:40px;
    margin-bottom:10px;
    font-weight:800;
}

.page-header p{
    color:#666;
    font-size:17px;
}

/* ===============================
   HOUSE LEADERBOARD
================================ */
.house-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:24px;
    margin-bottom:50px;
}

.house-card{
    position:relative;
    background:#fff;
    border-radius:24px;
    padding:28px;
    text-align:center;
    box-shadow:0 12px 30px rgba(0,0,0,.08);
    transition:.3s ease;
    overflow:hidden;
}

.house-card:hover{
    transform:translateY(-6px);
}

.house-card.winner{
    border:4px solid gold;
    transform:scale(1.03);
}

.rank-badge{
    position:absolute;
    top:16px;
    right:16px;
    width:42px;
    height:42px;
    border-radius:50%;
    background:#111827;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:16px;
}

.house-logo{
    width:110px;
    height:110px;
    object-fit:contain;
    margin-bottom:14px;
}

.house-name{
    font-size:28px;
    font-weight:800;
    margin-bottom:8px;
}

.house-points{
    font-size:38px;
    font-weight:900;
    margin-top:10px;
}

.house-label{
    color:#666;
    font-size:14px;
}

/* ===============================
   STUDENTS SECTION
================================ */
.students-section-title{
    font-size:30px;
    font-weight:800;
    margin-bottom:25px;
    text-align:center;
}

.students-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:24px;
}

/* ===============================
   HOUSE COLUMN
================================ */
.house-column{
    background:#fff;
    border-radius:22px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    border-top:8px solid var(--house-color);
}

.house-column-header{
    text-align:center;
    margin-bottom:20px;
}

.house-column-header img{
    width:80px;
    height:80px;
    object-fit:contain;
    margin-bottom:10px;
}

.house-column-header h3{
    margin:0;
    font-size:24px;
    font-weight:800;
}

/* ===============================
   STUDENT CARD
================================ */
.student-card{
    display:flex;
    align-items:center;
    gap:12px;
    background:#f8fafc;
    padding:14px;
    border-radius:14px;
    margin-bottom:12px;
    transition:.25s ease;
    border-left:5px solid var(--house-color);
}

.student-card:hover{
    transform:translateX(4px);
}

.student-card.gold{
    background:#fff8dc;
    border-left-color:gold;
}

.student-card.silver{
    background:#f3f4f6;
    border-left-color:silver;
}

.student-card.bronze{
    background:#fff1e6;
    border-left-color:#cd7f32;
}

.student-rank{
    font-size:22px;
    width:42px;
    text-align:center;
}

.student-info{
    flex:1;
}

.student-name{
    font-weight:700;
    font-size:15px;
}

.student-points{
    font-size:14px;
    color:#555;
    margin-top:2px;
}

.empty{
    text-align:center;
    padding:20px;
    color:#777;
}

/* ===============================
   MOBILE
================================ */
@media(max-width:768px){

    .page-header h1{
        font-size:30px;
    }

    .house-points{
        font-size:30px;
    }

    .students-section-title{
        font-size:24px;
    }

}

/* ===============================
   MOBILE OPTIMIZATION
================================ */

@media (max-width:768px){

    .house-page{
        padding:20px 14px;
    }

    .page-header{
        margin-bottom:28px;
    }

    .page-header h1{
        font-size:28px;
        line-height:1.2;
    }

    .page-header p{
        font-size:15px;
    }

    /* House cards */
    .house-grid{
        grid-template-columns:1fr;
        gap:18px;
    }

    .house-card{
        padding:22px 18px;
        border-radius:20px;
    }

    .house-card.winner{
        transform:none;
    }

    .house-logo{
        width:80px;
        height:80px;
    }

    .house-name{
        font-size:24px;
    }

    .house-points{
        font-size:32px;
    }

    .rank-badge{
        width:36px;
        height:36px;
        font-size:14px;
    }

    /* Student section */
    .students-section-title{
        font-size:24px;
        margin-bottom:18px;
    }

    .students-grid{
        grid-template-columns:1fr;
        gap:18px;
    }

    .house-column{
        padding:16px;
        border-radius:18px;
    }

    .house-column-header img{
        width:65px;
        height:65px;
    }

    .house-column-header h3{
        font-size:22px;
    }

    /* Student cards */
    .student-card{
        padding:12px;
        gap:10px;
        border-radius:12px;
    }

    .student-card.gold,
    .student-card.silver,
    .student-card.bronze{
        transform:none;
    }

    .student-rank{
        width:34px;
        font-size:18px;
    }

    .student-name{
        font-size:14px;
    }

    .student-points{
        font-size:13px;
    }

}

/* Extra small phones */
@media (max-width:480px){

    .page-header h1{
        font-size:24px;
    }

    .house-name{
        font-size:22px;
    }

    .house-points{
        font-size:28px;
    }

    .student-card{
        flex-direction:row;
        align-items:center;
    }

}
</style>

<div class="house-page">

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1>🏆 House Points Championship</h1>
        <p>
            Academic Year:
            <strong><?= esc($year['year_name']) ?></strong>
        </p>
    </div>

    <!-- HOUSE LEADERBOARD -->
    <div class="house-grid">

        <?php
        $rank = 1;

        while($h = $houses->fetch_assoc()):
        ?>

        <div class="house-card <?= $rank == 1 ? 'winner' : '' ?>">

            <div class="rank-badge">
                #<?= $rank ?>
            </div>

            <img
                src="uploads/houses/<?= esc($h['logo']) ?>"
                alt="<?= esc($h['name']) ?>"
                class="house-logo"
            >

            <div
                class="house-name"
                style="color:<?= esc($h['color']) ?>"
            >
                <?= esc($h['name']) ?>
            </div>

            <div
                class="house-points"
                style="color:<?= esc($h['color']) ?>"
            >
                <?= number_format($h['points']) ?>
            </div>

            <div class="house-label">
                Total House Points
            </div>

        </div>

        <?php
        $rank++;
        endwhile;
        ?>

    </div>

    <!-- STUDENT LEADERBOARDS -->
    <h2 class="students-section-title">
        🌟 Top Student Contributors
    </h2>

    <?php
    $houses->data_seek(0);
    ?>

    <div class="students-grid">

        <?php while($house = $houses->fetch_assoc()): ?>

        <?php
        $students = $conn->query("
            SELECT
                s.id,
                CONCAT(s.first_name,' ',s.last_name) AS name,
                COALESCE(SUM(l.points),0) AS total_points
            FROM house_point_logs l
            JOIN students s
                ON s.id = l.entity_id
            WHERE l.entity_type = 'student'
              AND l.house_id = {$house['id']}
              AND l.academic_year_id = {$year['id']}
            GROUP BY s.id
            ORDER BY total_points DESC
            LIMIT 10
        ");
        ?>

        <div
            class="house-column"
            style="--house-color: <?= esc($house['color']) ?>"
        >

            <div class="house-column-header">

                <img
                    src="uploads/houses/<?= esc($house['logo']) ?>"
                    alt="<?= esc($house['name']) ?>"
                >

                <h3 style="color:<?= esc($house['color']) ?>">
                    <?= esc($house['name']) ?>
                </h3>

            </div>

            <?php
            $pos = 1;

            while($s = $students->fetch_assoc()):
            ?>

            <div class="student-card
                <?= $pos == 1 ? 'gold' : '' ?>
                <?= $pos == 2 ? 'silver' : '' ?>
                <?= $pos == 3 ? 'bronze' : '' ?>
            ">

                <div class="student-rank">
                    <?= $pos == 1 ? '🥇' : ($pos == 2 ? '🥈' : ($pos == 3 ? '🥉' : '#'.$pos)) ?>
                </div>

                <div class="student-info">

                    <div class="student-name">
                        <?= esc($s['name']) ?>
                    </div>

                    <div class="student-points">
                        <?= number_format($s['total_points']) ?> points
                    </div>

                </div>

            </div>

            <?php
            $pos++;
            endwhile;
            ?>

            <?php if ($students->num_rows == 0): ?>

                <div class="empty">
                    No contributors yet
                </div>

            <?php endif; ?>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include 'partials/footer.php'; ?>