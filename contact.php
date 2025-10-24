<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sent = false;
$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // في السيرفر الحقيقي ممكن ترسلها بـ mail()
    // حالياً فقط نعرضها كاختبار محلي
    $sent = true;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>اتصل بنا - فعاليات مدينتي</title>
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
        <li class="nav-item"><a class="nav-link" href="events.php">الفعاليات</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">عن الدليل</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">اتصل بنا</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- المحتوى -->
<div class="container mt-5">
  <div class="card shadow-sm p-5">
    <h2 class="mb-4 text-center">📬 اتصل بنا</h2>

    <?php if ($sent): ?>
      <div class="alert alert-success text-center">
        ✅ تم إرسال رسالتك بنجاح!<br>
        <hr>
        <strong>الاسم:</strong> <?= $name ?><br>
        <strong>البريد:</strong> <?= $email ?><br>
        <strong>الرسالة:</strong> <?= nl2br($message) ?>
      </div>
    <?php else: ?>
      <form method="POST" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">الاسم الكامل</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">البريد الإلكتروني</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">رسالتك</label>
          <textarea name="message" rows="5" class="form-control" required></textarea>
        </div>
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary w-50">📤 إرسال الرسالة</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  <p>© 2025 دليل فعاليات المدينة | جميع الحقوق محفوظة</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>