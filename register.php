<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
if(is_logged_in()){ redirect('/hotel_booking/index.php'); }
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=post('name');
  $email=post('email');
  $pass=post('password');
  $stmt=$mysqli->prepare("SELECT id FROM users WHERE email=?");
  $stmt->bind_param('s',$email);
  $stmt->execute();
  $ex=$stmt->get_result()->fetch_assoc();
  if($ex){
    $error='Email already registered';
  } else {
    $hash=password_hash($pass,PASSWORD_DEFAULT);
    $stmt=$mysqli->prepare("INSERT INTO users(name,email,password_hash,created_at) VALUES(?,?,?,NOW())");
    $stmt->bind_param('sss',$name,$email,$hash);
    $stmt->execute();
    $_SESSION['user_id']=$stmt->insert_id;
    $_SESSION['user_name']=$name;
    redirect('/hotel_booking/index.php');
  }
}
include __DIR__.'/includes/header.php';
?>
<section class="container mx-auto px-4 py-14 max-w-md">
  <h1 class="text-3xl font-bold mb-6">Create account</h1>
  <?php if($error): ?><div class="card p-3 bg-red-50 text-red-700 mb-4"><?php echo h($error); ?></div><?php endif; ?>
  <form class="card p-6 grid gap-3" method="post">
    <input class="input" type="text" name="name" placeholder="Full name" required>
    <input class="input" type="email" name="email" placeholder="Email" required>
    <input class="input" type="password" name="password" placeholder="Password" required>
    <button class="btn" data-spinner>Create account</button>
  </form>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
