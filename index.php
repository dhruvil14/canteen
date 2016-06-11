<?php
if(!isset($_COOKIE['id'])) header('location:giris.php');
else {
	require 'header.php';
	require 'islemler.php';
}
?>
<div class="container-fluid">
	<div class="row-fluid">

	</div>
</div>
<div class="consumerPanel" style="display:<?php if(userControl() == 1) echo 'none;'; ?>">
	<div class="dev-row">
		<div class="col-xs-6 urun">
			<ul>
				<li><div class="link" onclick="$.urun_goster('İçecek','')">İçecekler</div></li>
				<li><div class="link" onclick="$.urun_goster('Bisküvi','')">Bisküviler</div></li>
				<li><div class="link" onclick="$.urun_goster('Çikolata','')">Çikolatalar</div></li>
			</ul>
			<div class="u">
				
			</div>

		<!-- Modal -->
		<form class="siparis_form">
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Sepete Ekle</h4>
		      </div>
		      <div class="modal-body">
		      
		      <span style="font:21px Calibri Light">Kaç adet ?</span>
		      	<input type="text" class="form-control tane" style="margin-top:5px;">
		      	<input type="hidden" class="id" value="">
		      	<input type="hidden" class="ad" value="">
		      	<input type="hidden" class="fiyat" value="">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
		        <input type="submit" value="Ekle" class="btn btn-primary add">
		      </div>
		    </div>
		  </div>
		</div>
		</form>
		</div>
		<div class="col-xs-6">
			<div class="sepet">
				<div class="sepet-baslik">Sepet</div><hr>
				<ul>
					<li><b>TOPLAM <div class="fiyat"><span class="tut">0</span> TL</div></b></li><hr />
				</ul>
				<input type="button" class="btn btn-info order-now" value="Sipariş Ver" style="">
			</div>
		</div>
	</div>
</div>
<div class="ownerPanel" style="display:<?php if(userControl() == 0) echo 'none;'; ?>">
	<div class="responsive-table">
		<table class="table" border="0" style="width:100%;height:300px;">
			<thead>
				<th width="400">Sipariş Veren</th>
				<th>Ürün</th>
				<th width="100">Adet</th>
				<th width="200">Tarih</th>
				<th>Onay</th>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
<?php
require 'footer.php';
?>