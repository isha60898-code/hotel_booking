<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
require_login();
$id=(int)get('id');
$stmt=$mysqli->prepare("SELECT b.*, r.title, r.image_url FROM bookings b JOIN rooms r ON r.id=b.room_id WHERE b.id=? AND b.user_id=?");
$stmt->bind_param('ii',$id,$_SESSION['user_id']);
$stmt->execute();
$b=$stmt->get_result()->fetch_assoc();
if(!$b){ redirect('/hotel_booking/index.php'); }
include __DIR__.'/includes/header.php';
?>
<section class="container mx-auto px-4 py-14">
  <div class="card p-6 max-w-2xl mx-auto text-center">
    <img src="<?php echo h($b['image_url']); ?>" class="w-full h-64 object-cover rounded-lg" alt="">
    <h1 class="text-3xl font-bold mt-6">Booking confirmed</h1>
    <p class="mt-2">Your stay at <?php echo h($b['title']); ?> from <?php echo h($b['check_in']); ?> to <?php echo h($b['check_out']); ?> is confirmed.</p>
    <div class="mt-4 text-2xl font-extrabold">Total $<?php echo number_format($b['total_price'],2); ?></div>
    <a class="btn mt-6" href="/hotel_booking/dashboard.php">Go to My Bookings</a>
  </div>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
