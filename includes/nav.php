<?php $logged = isset($_SESSION['user_id']); ?>
<header class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
  <div class="container mx-auto px-4 h-16 flex items-center justify-between">
    <a href="/hotel_booking/index.php" class="flex items-center gap-2">
      <span class="text-xl font-extrabold tracking-tight">SereneStay</span>
    </a>
    <nav class="hidden md:flex items-center gap-6 text-sm">
      <a class="nav-link" href="/hotel_booking/index.php">Home</a>
      <a class="nav-link" href="/hotel_booking/search.php">Search</a>
      <?php if($logged): ?>
        <a class="btn-secondary" href="/hotel_booking/dashboard.php">My Bookings</a>
        <a class="btn" href="/hotel_booking/logout.php">Logout</a>
      <?php else: ?>
        <a class="btn-secondary" href="/hotel_booking/login.php">Login</a>
        <a class="btn" href="/hotel_booking/register.php">Sign Up</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
