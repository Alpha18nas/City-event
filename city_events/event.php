<?php
include 'db.php';

// التحقق من وجود id بالرابط
if (!isset($_GET['id'])) {
    die("<h3 style='text-align:center; margin-top:50px;'>⚠️ لم يتم تحديد الفعالية.</h3>");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM events WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("<h3 style='text-align:center; margin-top:50px;'>❌ الفعالية غير موجودة.</h3>");
}

$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $event['title'] ?> - تفاصيل الفعالية</title>
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
        <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
        <li class="nav-item"><a class="nav-link active" href="events.php">الفعاليات</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">عن الدليل</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- تفاصيل الفعالية -->
<div class="container mt-5">
  <div class="card shadow-sm p-4">
    <img src="assets/img/<?= $event['image'] ?>" class="img-fluid rounded mb-4" alt="<?= $event['title'] ?>">
    <h2><?= $event['title'] ?></h2>
    <p class="text-muted"><?= $event['category'] ?> | <?= $event['event_date'] ?> | <?= $event['location'] ?></p>
    <p><?= nl2br($event['description']) ?></p>

    <div class="d-flex gap-2 mt-4">
      <!-- زر أضف للتقويم -->
      <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?= urlencode($event['title']) ?>&dates=<?= str_replace('-', '', $event['event_date']) ?>/<?= str_replace('-', '', $event['event_date']) ?>&details=<?= urlencode($event['description']) ?>&location=<?= urlencode($event['location']) ?>" target="_blank" class="btn btn-success">
        🗓️ أضف للتقويم
      </a>

      <!-- زر مشاركة -->
      <button class="btn btn-primary" onclick="shareEvent()">📤 شارك الفعالية</button>
    </div>
  </div>

  <!-- فعاليات ذات صلة -->
  <div class="mt-5">
    <h4 class="mb-3">🎯 فعاليات ذات صلة (<?= $event['category'] ?>)</h4>
    <div class="row g-3">
      <?php
      $cat = $event['category'];
      $related = $conn->query("SELECT * FROM events WHERE category='$cat' AND id != $id LIMIT 3");
      if ($related->num_rows > 0) {
        while ($r = $related->fetch_assoc()) {
          echo "
          <div class='col-md-4'>
            <div class='card h-100'>
              <img src='assets/img/{$r['image']}' class='card-img-top' height='180'>
              <div class='card-body'>
                <h6>{$r['title']}</h6>
                <a href='event.php?id={$r['id']}' class='btn btn-outline-primary btn-sm w-100'>عرض التفاصيل</a>
              </div>
            </div>
          </div>";
        }
      } else {
        echo "<p class='text-muted'>لا توجد فعاليات مشابهة حالياً.</p>";
      }
      ?>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  <p>© 2025 دليل فعاليات المدينة</p>
</footer>

<script>
function shareEvent() {
  const url = window.location.href;
  navigator.clipboard.writeText(url);
  alert("📋 تم نسخ رابط الفعالية!");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>