<?php include __DIR__.'/includes/header.php'; ?>
<section class="hero relative" style="background-image:url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1400&auto=format&fit=crop');">
  <div class="bg-black/50">
    <div class="container mx-auto px-4 py-24 text-white" data-aos="fade-up">
      <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">Find your next stay</h1>
      <p class="mt-4 text-lg md:text-xl max-w-2xl">Luxury and boutique hotels carefully curated for comfort, style, and unforgettable moments.</p>
      <form class="mt-8 grid md:grid-cols-4 gap-3 bg-white/90 p-4 rounded-xl text-slate-800" action="/hotel_booking/search.php" method="get">
        <input class="input" type="text" name="q" placeholder="Destination or hotel name">
        <input class="input" type="date" name="check_in" required>
        <input class="input" type="date" name="check_out" required>
        <div class="flex gap-2">
          <input class="input" type="number" name="guests" min="1" value="2" placeholder="Guests">
          <button class="btn" data-spinner>Search</button>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="container mx-auto px-4 py-14">
  <h2 class="text-2xl font-bold mb-6">Featured stays</h2>
  <div class="grid-auto">
    <?php $res = $mysqli->query("SELECT id,title,price_per_night,max_guests,image_url FROM rooms ORDER BY id LIMIT 6"); while($r=$res && $row=$res->fetch_assoc()): ?>
      <a href="/hotel_booking/room.php?id=<?php echo $row['id']; ?>" class="card fade-in" data-aos="fade-up">
        <img src="<?php echo h($row['image_url']); ?>" alt="" class="w-full h-48 object-cover">
        <div class="p-4">
          <div class="font-semibold text-lg"><?php echo h($row['title']); ?></div>
          <div class="text-slate-600 mt-1">Sleeps <?php echo (int)$row['max_guests']; ?></div>
          <div class="mt-2 font-bold">$<?php echo number_format($row['price_per_night'],2); ?>/night</div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
