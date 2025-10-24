<?php
include 'db.php';
$filter = "";
$where = "";

if (isset($_GET['category']) && $_GET['category'] != "") {
    $filter = $_GET['category'];
    $where = "WHERE category = '$filter'";
}

if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];
    $where = "WHERE title LIKE '%$search%' OR description LIKE '%$search%' OR location LIKE '%$search%'";
}

$sql = "SELECT * FROM events $where ORDER BY event_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>كل الفعاليات</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- رأس الصفحة -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">🎟️ فعاليات مدينتي</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
        <li class="nav-item"><a class="nav-link active" href="events.php">الفعاليات</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">عن الدليل</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">

  <!-- أدوات البحث والفلترة -->
  <form class="row g-2 mb-4" method="GET">
    <div class="col-md-5">
      <input type="text" name="search" class="form-control" placeholder="ابحث عن فعالية..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
    </div>
    <div class="col-md-4">
      <select name="category" class="form-select">
        <option value="">كل التصنيفات</option>
        <?php
        $cats = ['ثقافة','رياضة','موسيقى','عائلي'];
        foreach ($cats as $cat) {
            $sel = ($filter == $cat) ? 'selected' : '';
            echo "<option value='$cat' $sel>$cat</option>";
        }
        ?>
      </select>
    </div>
    <div class="col-md-3">
      <button class="btn btn-dark w-100">🔍 بحث</button>
    </div>
  </form>

  <!-- شبكة الفعاليات -->
  <div class="row g-4">
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
        <div class='col-md-4'>
          <div class='card h-100 shadow-sm'>
            <img src='assets/img/{$row['image']}' class='card-img-top' height='200'>
            <div class='card-body'>
              <h5 class='card-title'>{$row['title']}</h5>
              <p class='card-text text-muted'>{$row['category']} | {$row['event_date']}</p>
              <p class='card-text'>{$row['location']}</p>
              <a href='event.php?id={$row['id']}' class='btn btn-primary w-100'>عرض التفاصيل</a>
            </div>
          </div>
        </div>";
      }
    } else {
      echo "<p class='text-center'>❌ لا توجد فعاليات مطابقة للبحث.</p>";
    }
    ?>
  </div>
</div>

<!-- تذييل -->
<footer class="bg-dark text-white text-center py-3 mt-5">
  <p>© 2025 دليل فعاليات المدينة</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>