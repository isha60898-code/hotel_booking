<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
if(is_logged_in()){ redirect('/hotel_booking/index.php'); }
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=post('email');
  $pass=post('password');
  $stmt=$mysqli->prepare("SELECT id,password_hash,name FROM users WHERE email=?");
  $stmt->bind_param('s',$email);
  $stmt->execute();
  $u=$stmt->get_result()->fetch_assoc();
  if($u && password_verify($pass,$u['password_hash'])){
    $_SESSION['user_id']=$u['id'];
    $_SESSION['user_name']=$u['name'];
    $redir=get('redirect','/hotel_booking/index.php');
    redirect($redir);
  } else { $error='Invalid credentials'; }
}
include __DIR__.'/includes/header.php';
?>
<section class="container mx-auto px-4 py-14 max-w-md">
  <h1 class="text-3xl font-bold mb-6">Login</h1>
  <?php if($error): ?><div class="card p-3 bg-red-50 text-red-700 mb-4"><?php echo h($error); ?></div><?php endif; ?>
  <form class="card p-6 grid gap-3" method="post">
    <input class="input" type="email" name="email" placeholder="Email" required>
    <input class="input" type="password" name="password" placeholder="Password" required>
    <button class="btn" data-spinner>Login</button>
    <div class="text-sm text-slate-600">No account? <a class="text-sky-600" href="/hotel_booking/register.php">Sign up</a></div>
  </form>
</section>
<?php include __DIR__.'/includes/footer.php'; ?>
