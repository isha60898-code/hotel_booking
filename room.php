<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
$id=(int)get('id');
$check_in=get('check_in');
$check_out=get('check_out');
$guests=(int)get('guests',1);
$stmt=$mysqli->prepare("SELECT * FROM rooms WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$room=$stmt->get_result()->fetch_assoc();
if(!$room){ redirect('/hotel_booking/search.php'); }
include __DIR__.'/includes/header.php';
?>
<section class="container mx-auto px-4 py-10">
  <div class="grid md:grid-cols-2 gap-8">
    <img src="<?php echo h($room['image_url']); ?>" class="w-full h-96 object-cover rounded-xl card" alt="" onerror="this.">
    <div>
      <h1 class="text-3xl font-bold"><?php echo h($room['title']); ?></h1>
      <div class="text-slate-600 mt-2">Sleeps <?php echo (int)$room['max_guests']; ?></div>
      <div class="text-2xl font-extrabold mt-4">$<?php echo number_format($room['price_per_night'],2); ?> <span class="text-base font-normal text-slate-500">/night</span></div>
      <p class="mt-4 leading-7"><?php echo nl2br(h($room['description'])); ?></p>
      <form class="mt-6 grid md:grid-cols-4 gap-3" action="/hotel_booking/book.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
        <input class="input" type="date" name="check_in" value="<?php echo h($check_in); ?>" required>
        <input class="input" type="date" name="check_out" value="<?php echo h($check_out); ?>" required>
        <input class="input" type="number" name="guests" min="1" value="<?php echo $guests ?: 1; ?>" required>
        <button class="btn" data-spinner>Book now</button>
      </form>
    </div>
  </div>
  <?php if (!empty($gallery)): ?>
    <div class="mt-10">
      <h2 class="text-xl font-semibold mb-4">Gallery</h2>
      <div class="grid md:grid-cols-3 gap-4">
        <?php foreach ($gallery as $img): ?>
          <img src="<?php echo h($img); ?>" class="w-full h-56 object-cover rounded-xl card" alt="" onerror="this.style.display='none'">
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
