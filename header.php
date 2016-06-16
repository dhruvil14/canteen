<?php
require_once 'config.php';
if(isset($_COOKIE['id'])){
	$id = $_COOKIE['id'];
	$sorgu = $db->prepare("SELECT * FROM kisiler WHERE id = :id");
	$sorgu->bindParam('id',$id);
	$sorgu->execute();
	$row = $sorgu->fetch(PDO::FETCH_ASSOC);
	$ad_soyad = $row['ad_soyad'];
	error_reporting(0);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<script src="bootstrap/js/ajax.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/font-awesome.css">
	<script src="bootstrap/js/ajax.js"></script>
	<script src="js/min/jquery-v1.10.2.min.js" type="text/javascript"></script>
	<script src="js/min/bootstrap.min.js"></script>
	<style>
		*{
			margin:0;
			padding:0;
		}
		.login_panel table tr td, .add_panel table tr td{
			padding:15px 15px 2px 2px;
		}
		.container-fluid{
			height:100%;
			display:table;
			width: 100%;
			padding: 0;
		}

		.row-fluid {height: 100%; display:table-cell; vertical-align: middle;}

		.centering {
			float:none;
			margin:0 auto;
		}
		.login_panel, .add_panel{
			position: absolute;
			margin-top:250px;
			left:50%;
			transform: translate(-50%,-50%);
			color:#fff;
			background-color:#67918e;
			width:500px;
			height:300px;
			padding:50px;
			-webkit-border-radius:6px;
			-webkit-box-shadow:1px 1px 10px #000;
			font:21px Calibri Light;
		}
		.urunler{
			background-color:#17bbc2;
			color:#fff;
			text-align:center;
			width:120px;
			height:120px;
			font:30px Calibri Light;
			-webkit-border-radius:6px;
			-moz-border-radius:6px;
			-o-border-radius:6px;
			border-radius:6px;
			float:left;
			margin-right:15px;
			margin-bottom:15px;
			-webkit-user-select:none;
			-moz-user-select:none;
			-o-user-select:none;
			user-select:none;
			cursor:pointer;
			text-overflow:ellipsis;
			//white-space:nowrap;
			overflow:hidden;
		}
		.u{
			margin-top:80px;
		}
		.sepet{
			background-color:#3f443e;
			height:500px;
			overflow-y:scroll;
			color:#e1e3e0;
			margin-top:5px;
			-webkit-border-radius:6px;
			-moz-border-radius:6px;
			-o-border-radius:6px;
			border-radius:6px;
		}
		.sepet ul li{
			list-style-type:none;
			font:21px Calibri Light;
			padding-left:15px;
		}

		.fiyat{
			float:right;
			padding-right:15px;
		}
		.urun ul li{
			list-style-type:none;
			float:left;
			margin-right:30px;
			font:28px Calibri Light;
		}
		.link{
			cursor:pointer;
			-webkit-user-select:none;
			-moz-user-select:none;
			-o-user-select:none;
			user-select:none;
		}
		.sepet hr{
			border-color:#565d54;
		}
		.sepet-baslik{
			font:32px Calibri Light;
			padding-left:15px;
			margin-top:5px;
		}
		.ownerPanel table{
			font:19px Calibri Light;
		}
		.ownerPanel table tbody td, .ownerPanel table thead th {
			padding-left:50px;
			padding-top:30;
		}
		.ownerPanel table tbody td:nth-child(4){
			white-space:nowrap;
		}
		.boxes{
			width:250px;
		}
		.price{
			background-color:#000;
		}
	</style>
	<script>
		$(document).ready(function(){
			$('.login_panel form').submit(function(){
				if($('.login_panel input[type=text]').val() == '' || $('.login_panel input[type=password]').val() == '') {
					alert('Boş bırakmayın');
					return false;
				}
			});
			$('.tane').keydown(function(e){
				if(e.keyCode == 13){
					/*$('#myModal').attr('class':'modal fade');
					$('#myModal').css('display':'none');*/
					//return false;

				}
			});
			$('.add_panel form').submit(function(){
				/*if($('.add_panel input[type=text]').val() == '' || $('.add_panel input[type=number]').val() == '' || flag) {
					alert('Boş bırakmayın');
					alert(flag);
					return false;
				}*/
			});

			$.urun_goster = function(urun_turu,urun_goster){
				$.ajax({
					type:"POST",
					url:"islemler.php",
					data:{urun_turu,urun_goster},
					dataType:"xml",
					success:function(data){
						$(".urunler").remove();
						$(data).find("urun").each(function(){
							var id = $(this).find("id").text();
							var ad = $(this).find("ad").text();
							var fiyat = $(this).find("fiyat").text();
							var ad_ = '"' + ad + '"';
							var veri = "<div class='urunler' onclick='$.addCart("+ id +","+ fiyat +","+ ad_ +")' alt='"+ ad +"' title='"+ ad +"'>";
							veri += ad;
							veri += "</div>";
							$(".u").append(veri);
						});
					}
				});
			}

			$.urun_ekle = function(){
				if($('.add_panel form input[type=text]').val() == '' || $('.add_panel form input[type=password]').val() == ''){
					alert('Boş bırakmayınız');
				}else{
					var formdata = $(".add_panel form").serializeArray();
					var data = {};
					var values = [];
					var i = 0;
					$(formdata).each(function(index, obj){
						data[obj.name] = obj.value;
						values[i] = obj.value;
						i++;
					});
					$.ajax({
						type:"POST",
						url:"islemler.php",
						data:{adi:values[0],fiyati:values[1],turu:values[2],urunEkleBlank:''},
						success:function(data){
							alert(data);
						}
					});
				}
				return false;
			}

			$.orderOK = function(siparisID){
				$.ajax({
					type:"POST",
					url:"islemler.php",
					data:{siparisID},
					success:function(data){
					}
				});
			}

			$.listOrder = function(listOrder){
				$.ajax({
					type:"POST",
					url:"islemler.php",
					data:{listOrder},
					dataType:"xml",
					success:function(data){
						$(".ownerPanel tbody tr").remove();					
						$(data).find("urun").each(function(){
							var kisiAdi = $(this).find("kisiAdi").text();
							var urunAdi = $(this).find("urunAdi").text();
							var tarih = $(this).find("tarih").text();
							var adet = $(this).find("adet").text();
							var id = $(this).find("id").text();
							var veri = "<tr>";
							var ad_ = '".ownerPanel tbody tr"';
							veri += "<td>"+ kisiAdi +"</td><td>"+ urunAdi +"</td><td>"+ adet +"</td><td>"+ tarih +"</td><td><input type='button' name='Onayla' onclick='$.orderOK("+ id +");' value='Onayla' class='btn btn-info'></td></tr>";
							$(".ownerPanel tbody").append(veri);
						});
					}
				});
			}
			setInterval(function(){
				$.listOrder('');
			},5000);
			$.addCart = function(id,fiyat,ad){
				$('#myModal').modal();
				$('.id').val(id);
				$('.ad').val(ad);
				$('.fiyat').val(fiyat);
			}

			$.order = function(id,fiyat,adet){
			//alert(id);
		}
		
		$.deleteCart = function(t,id,fiyat){
			order_g_p.splice(t,1);
			order_g_id.splice(t,1);
			toplam -= fiyat;
			$('.tut').html(toplam);
			//$('.fiyat i:eq('+ t +')').hide();
			$('.sepet li:eq('+ (t + 1) +')').hide();
		}
		var toplam = 0;
		var order_g_id = [];
		var order_g_p = [];
		var order_g_index = [];
		var t = 0;
		var satir = -1;

		$('.siparis_form').submit(function(){
			var adet = parseInt($('.tane').val());
			if($('.tane').val().trim() == '') {
				for(var j = 0;j<order_g_id.length;j++){
					alert(order_g_id[j]);
				}
			}
			else{
				var id = $('.id').val();
				var ad = $('.ad').val();
				var fiyat = $('.fiyat').val();
				var tutar = (adet * fiyat);
				var flag = false;
				var flag_i = -1;
				var y_adet = adet;
				var y_tutar = tutar;

				for(var i = 0;i<order_g_id.length;i++){
					if(id == order_g_id[i]){
						flag = true;
						flag_index = i;
						break;
					}
				}

				if(flag){
					order_g_p[flag_index] += adet;
					y_adet = order_g_p[flag_index];
					satir = order_g_index[flag_index];
					y_tutar = (y_adet * fiyat);
					$('.adet:eq('+ satir +')').html(y_adet);
					$('.tutar:eq('+ (satir) +')').html(y_tutar);
				}else{
					order_g_id[t] = id;
					order_g_p[t] = adet;
					order_g_index[t] = t;
					var veri = "<li>"+ ad +" x <span class='adet'>" + adet +"</span><div class='fiyat'><span class='tutar'>";
					veri += tutar + "</span> TL ";
					veri += " - <i class='fa fa-times' style='cursor:pointer;' onclick='$.deleteCart("+ t +","+ id +","+ tutar +")'></i></div><hr></li>";
					$(".sepet ul").append(veri);
					t++;
				}
				toplam += parseInt(tutar);
				$('.tut').html(toplam);
			}
			/*$('#myModal').attr('class','modal fade');
			$('#myModal').css({'display':'none'});*/
			$('#myModal').modal('hide');
			$('.tane').val('');
			return false;

		});

$.order_now = function(id,adet,blank){
	$.ajax({
		type:"POST",
		url:"islemler.php",
		data:{id,adet,blank},
		success:function(data){
		}
	});
}

$('.order-now').click(function(){
	if(order_g_id.length == 0) alert('Lütfen ürün seçiniz..');
	else{
		for(var i = 0;i<order_g_id.length;i++){
			$.order_now(order_g_id[i],order_g_p[i],'');
		}
		alert('Sipariş Verildi');
	}
});

$.urun_goster('İçecek','');
$.listOrder('');
});
</script>
</head>
<body>
	<div class="dev-row">
		<div class="col-xs-12 header" style="background-color:#306491;height:90px;">
			<a href="index.php"><img src="images/logo.png" width="200" style="margin-top:5px;margin-left:-15px;-webkit-transform:rotate(0deg);"></a>
			<div class="kisi" style="color:#e1e3e0;float:right;font:26px Calibri Light;margin-top:30px;<?php if(!isset($_COOKIE['id'])) echo 'display:none;'; ?>"><?php echo $ad_soyad ?> | <i class="fa fa-plus-circle" alt="Ürün Ekle" title="Ürün Ekle" style="font-size:21px;cursor:pointer;" onclick="javascript:window.location='urun_ekle.php';"></i> |<i class="fa fa-power-off" alt="Çıkış" title="Çıkış" style="font-size:21px;margin-left:5px;cursor:pointer;" onclick="javascript:window.location='islemler.php?cikis';"></i></div>
		</div>
	</div>	