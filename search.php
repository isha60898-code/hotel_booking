<?php include __DIR__.'/includes/header.php'; $q=get('q'); $check_in=get('check_in'); $check_out=get('check_out'); $guests=(int)get('guests',1);
$rooms=[]; if($check_in && $check_out){ $sql="SELECT r.* FROM rooms r WHERE r.max_guests>=? AND r.id NOT IN (SELECT b.room_id FROM bookings b WHERE NOT (? >= b.check_out OR ? <= b.check_in)) AND (r.title LIKE CONCAT('%',?,'%') OR ?='') ORDER BY r.price_per_night"; $stmt=$mysqli->prepare($sql); $stmt->bind_param('issss',$guests,$check_in,$check_out,$q,$q); $stmt->execute(); $rooms=$stmt->get_result(); }
?>

<section class="container mx-auto px-4 py-10">
  <h1 class="text-3xl font-bold mb-4">Search</h1>
  <form class="grid md:grid-cols-5 gap-3 card p-4" action="/hotel_booking/search.php" method="get">
    <input class="input" type="text" name="q" value="<?php echo h($q); ?>" placeholder="Destination or hotel name">
    <input class="input" type="date" name="check_in" value="<?php echo h($check_in); ?>" required>
    <input class="input" type="date" name="check_out" value="<?php echo h($check_out); ?>" required>
    <input class="input" type="number" name="guests" min="1" value="<?php echo $guests ?: 1; ?>" placeholder="Guests">
    <button class="btn" data-spinner>Search</button>
  </form>
  <div class="mt-8 grid-auto">
    <?php if($check_in && $check_out && $rooms): while($row=$rooms->fetch_assoc()): ?>
      <a href="/hotel_booking/room.php?id=<?php echo $row['id']; ?>&check_in=<?php echo h($check_in); ?>&check_out=<?php echo h($check_out); ?>&guests=<?php echo $guests; ?>" class="card">
        <img src="<?php echo h($row['image_url']); ?>" alt="" class="w-full h-48 object-cover">
        <div class="p-4">
          <div class="font-semibold text-lg"><?php echo h($row['title']); ?></div>
          <div class="text-slate-600 mt-1">Sleeps <?php echo (int)$row['max_guests']; ?></div>
          <div class="mt-2 font-bold">$<?php echo number_format($row['price_per_night'],2); ?>/night</div>
        </div>
      </a>
    <?php endwhile; elseif($check_in && $check_out): ?>
      <div class="text-slate-600">No rooms available. Try different dates or guests.</div>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
