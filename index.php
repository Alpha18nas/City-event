<?php
include 'db.php';
$latest = $conn->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الرئيسية - فعاليات مدينتي</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- رأس الصفحة -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">🎟️ فعاليات مدينتي</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">الرئيسية</a></li>
        <li class="nav-item"><a class="nav-link" href="events.php">الفعاليات</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">عن الدليل</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- بانر ترحيبي -->
<div class="hero position-relative d-flex align-items-center justify-content-center text-center text-white">
  <div class="overlay"></div>
  <div class="content position-relative">
    <h1 class="fw-bold mb-3">مرحباً بك في <span class="text-warning">فعاليات مدينتي</span></h1>
    <p class="lead">اكتشف أجمل الفعاليات الثقافية، الرياضية، والفنية من حولك</p>
    <a href="events.php" class="btn btn-warning btn-lg mt-3">🎉 تصفّح الفعاليات</a>
  </div>
</div>

<!-- قسم أحدث الفعاليات -->
<div class="container mt-5">
  <h3 class="text-center mb-4">🕒 أحدث الفعاليات</h3>
  <div class="row g-4">
    <?php
    if ($latest->num_rows > 0) {
      while ($row = $latest->fetch_assoc()) {
        echo "
        <div class='col-md-4'>
          <div class='card h-100 shadow-sm'>
            <img src='assets/img/{$row['image']}' class='card-img-top' height='200'>
            <div class='card-body'>
              <h5 class='card-title'>{$row['title']}</h5>
              <p class='card-text text-muted'>{$row['event_date']} - {$row['location']}</p>
              <a href='event.php?id={$row['id']}' class='btn btn-primary w-100'>عرض التفاصيل</a>
            </div>
          </div>
        </div>";
      }
    } else {
      echo "<p class='text-center text-muted'>لا توجد فعاليات حالياً.</p>";
    }
    ?>
  </div>

  <div class="text-center mt-4">
    <a href="events.php" class="btn btn-outline-dark">عرض كل الفعاليات</a>
  </div>
</div>

<!-- دعوة للتواصل -->
<section class="contact-banner mt-5 text-center text-white py-5">
  <h3 class="mb-3">هل لديك فعالية ترغب بإضافتها؟</h3>
  <a href="contact.php" class="btn btn-light">📩 تواصل معنا</a>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p>© 2025 دليل فعاليات المدينة 💙</p>
</footer>

</body>
</html>