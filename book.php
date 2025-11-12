<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
require_login();
$room_id=(int)post('room_id');
$check_in=post('check_in');
$check_out=post('check_out');
$guests=(int)post('guests',1);

$stmt=$mysqli->prepare("SELECT * FROM rooms WHERE id=?");
$stmt->bind_param('i',$room_id);
$stmt->execute();
$room=$stmt->get_result()->fetch_assoc();
if(!$room){ redirect('/hotel_booking/search.php'); }

if($guests>$room['max_guests']){
  redirect('/hotel_booking/room.php?id='.$room_id.'&check_in='.urlencode($check_in).'&check_out='.urlencode($check_out).'&guests='.$guests);
}

$sql="SELECT COUNT(*) c FROM bookings b WHERE b.room_id=? AND NOT (? >= b.check_out OR ? <= b.check_in)";
$stmt=$mysqli->prepare($sql);
$stmt->bind_param('iss',$room_id,$check_in,$check_out);
$stmt->execute();
$c=$stmt->get_result()->fetch_assoc()['c'];
if($c>0){
  redirect('/hotel_booking/search.php?check_in='.urlencode($check_in).'&check_out='.urlencode($check_out).'&guests='.$guests);
}

$n=nights_between($check_in,$check_out);
$total=$n*$room['price_per_night'];
$stmt=$mysqli->prepare("INSERT INTO bookings(user_id,room_id,check_in,check_out,guests,total_price,created_at) VALUES(?,?,?,?,?,?,NOW())");
$stmt->bind_param('iissid',$_SESSION['user_id'],$room_id,$check_in,$check_out,$guests,$total);
$stmt->execute();
$bid=$stmt->insert_id;
redirect('/hotel_booking/confirm.php?id='.$bid);
?>
