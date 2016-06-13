<?php
require 'config.php';
if(isset($_POST['giris'])){
	$kadi = trim($_POST['kadi']);
	$sifre = trim($_POST['sifre']);
	$sorgu = $db->prepare("SELECT * FROM kisiler WHERE kadi = :kadi AND sifre = :sifre");
	$sorgu->bindParam(':kadi',$kadi);
	$sorgu->bindParam(':sifre',$sifre);
	$sorgu->execute();
	if($sorgu->rowCount() > 0){
		$row = $sorgu->fetch(PDO::FETCH_ASSOC);
		setcookie('id',$row['id'],time()+ (24*60*60));
		header('location:index.php');
	}else{
		header('location:giris.php');
	}
}
else if(isset($_POST['kayit'])){
	$kadi = trim($_POST['kadi']);
	$sifre = trim($_POST['sifre']);
	$ad_soyad = trim($_POST['ad_soyad']);
	$sorgu = $db->prepare("INSERT INTO kisiler VALUES ('',:ad_soyad,:kadi,:sifre,0)");
	$sorgu->bindParam(':ad_soyad',$ad_soyad);
	$sorgu->bindParam(':kadi',$kadi);
	$sorgu->bindParam(':sifre',$sifre);
	$sorgu->execute();
	header('location:giris.php');
}

else if(isset($_POST['urunEkleBlank'])){
	$adi = trim($_POST['adi']);
	$turu = trim($_POST['turu']);
	$fiyati = trim($_POST['fiyati']);
	$query = $db->prepare("INSERT INTO gidalar VALUES ('',:adi,:turu,:fiyati)");
	$query->bindParam(':adi',$adi);
	$query->bindParam(':turu',$turu);
	$query->bindParam(':fiyati',$fiyati);
	$query->execute();
	if($query) echo "Ürün Eklendi";
}

else if(isset($_GET['cikis'])){
	setcookie('id','',time() - 1);
	header('location:giris.php');
}
else if(isset($_POST['urun_goster'])){
	$turu = $_POST['urun_turu'];
	$query = $db->prepare("SELECT * FROM gidalar WHERE turu = :turu");
	$query->bindParam(':turu',$turu);
	$query->execute();
	$aa="<?xml version='1.0' encoding='utf-8'?>
<users>";
	header('Content-type: text/xml');
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		$aa.="
   <urun>
	  <id>".$row['g_id']."</id>
      <ad>".$row['g_ad']."</ad>
      <fiyat>".$row['fiyat']."</fiyat>
   </urun>";
	}
	echo $aa.="</users>";
}
else if(isset($_POST['blank'])){
	$g_id = $_POST['id'];
	$adet = $_POST['adet'];
	$k_id = $_COOKIE['id'];
	$query = $db->prepare("SELECT * FROM siparisler WHERE (g_id = :g_id AND k_id = :k_id)");
	$query->bindParam(':k_id',$k_id);
	$query->bindParam(':g_id',$g_id);
	$query->execute();
	$signal = '+';
	$fark = 0;
	if($query->rowCount() > 0){
		$row = $query->fetch(PDO::FETCH_ASSOC);
		if($adet < $row['adet']) $signal = '-';
		$fark = abs($adet - $row['adet']);
		$query2 = $db->prepare("UPDATE siparisler SET adet = adet ". $signal ." :fark, onay = 0 WHERE s_id = :s_id");
		$query2->bindParam(':s_id',$row['s_id']);
		$query2->bindParam(':fark',$fark);
		$query2->execute();
	}else{
		$sorgu = $db->prepare("INSERT INTO siparisler VALUES ('',:k_id,:g_id,:adet,0,now())");
		$sorgu->bindParam(':k_id',$k_id);
		$sorgu->bindParam(':g_id',$g_id);
		$sorgu->bindParam(':adet',$adet);
		$sorgu->execute();
	}
}
else if(isset($_POST['siparisID'])){
	$s_id = $_POST['siparisID'];
	$query = $db->prepare("UPDATE siparisler SET onay = 1 WHERE s_id = :s_id");
	$query->bindParam(':s_id',$s_id);
	$query->execute();
}
else if(isset($_POST['listOrder'])){
	$query = $db->prepare("SELECT s.*,k.*,g.* FROM siparisler as s, kisiler as k, gidalar as g WHERE (k.id = s.k_id) AND (s.g_id = g.g_id) AND (s.onay = 0) ORDER BY s_id DESC");
	$query->execute();
	$aa="<?xml version='1.0' encoding='utf-8'?>
<users>";
	header('Content-type: text/xml');
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		$date = strtotime($row['tarih']);
		$aa.="
   <urun>
	  <kisiAdi>".$row['ad_soyad']."</kisiAdi>
      <urunAdi>".$row['g_ad']."</urunAdi>
      <adet>".$row['adet']."</adet>
      <id>".$row['s_id']."</id>
      <tarih>".date('d-m-Y H:i',$date)."</tarih>
   </urun>";
	}
	echo $aa.="</users>";
}
else header('location:giris.php');

function showRequest(){
	require 'config.php';
	$i = 0;
	$query = $db->prepare("SELECT s.*,k.*,g.* FROM siparisler as s, kisiler as k, gidalar as g WHERE (k.id = s.k_id) AND (s.g_id = g.g_id)");
	$query->execute();
	$aa = array();
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		$aa[$i] = $row;
		$i++;
	}
	return $aa;
}

function userControl(){
	require 'config.php';
	$id = $_COOKIE['id'];
	$type = -1;
	$query = $db->prepare("SELECT * FROM kisiler WHERE id = :id");
	$query->bindParam(':id',$id);
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC);
	$type = $row['tip'];
	return $type;
}
?>