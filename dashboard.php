<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
require_login();
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['cancel_id'])){
  $cid=(int)$_POST['cancel_id'];
  $stmt=$mysqli->prepare("DELETE FROM bookings WHERE id=? AND user_id=? AND check_in > CURDATE()");
  $stmt->bind_param('ii',$cid,$_SESSION['user_id']);
  $stmt->execute();
}
$stmt=$mysqli->prepare("SELECT b.*, r.title, r.image_url FROM bookings b JOIN rooms r ON r.id=b.room_id WHERE b.user_id=? ORDER BY b.check_in DESC");
$stmt->bind_param('i',$_SESSION['user_id']);
$stmt->execute();
$bookings=$stmt->get_result();
include __DIR__.'/includes/header.php';
?>
<section class="container mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-6">My bookings</h1>
  <div class="grid gap-4">
    <?php while($row=$bookings->fetch_assoc()): ?>
      <div class="card p-4 grid md:grid-cols-3 gap-4 items-center">
        <img src="<?php echo h($row['image_url']); ?>" class="w-full h-40 object-cover rounded-lg" alt="">
        <div>
          <div class="font-semibold text-lg"><?php echo h($row['title']); ?></div>
          <div class="text-slate-600 mt-1"><?php echo h($row['check_in']); ?> → <?php echo h($row['check_out']); ?> · Guests <?php echo (int)$row['guests']; ?></div>
          <div class="mt-2 font-bold">$<?php echo number_format($row['total_price'],2); ?></div>
        </div>
        <div class="text-right">
          <?php if(strtotime($row['check_in'])>time()): ?>
            <form method="post"><input type="hidden" name="cancel_id" value="<?php echo $row['id']; ?>"><button class="btn-secondary">Cancel</button></form>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
