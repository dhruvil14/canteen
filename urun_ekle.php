<?php
require 'header.php';
?>
<div class="dev-row">
		<div class="col-xs-12">
			<div class="add_panel center-block">
				<form action="islemler.php" method="POST" onsubmit="return $.urun_ekle()">
					<table border="0">
						<tr>
							<td style="text-align:right;">Adı :</td>
							<td><input type="text" class="form-control boxes" name="adi" placeholder="Ürün Adı"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Fiyatı :</td>
							<td><input type="number" class="form-control boxes" name="fiyati" placeholder="Fiyat" min="1"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Türü :</td>
							<td>
								<select name="turu" class="form-control" style="font:18px Calibri Light;">
									<option name="İçecek">İçecek</option>
									<option name="Bisküvi">Bisküvi</option>
									<option name="Çikolata">Çikolata</option>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" class="btn btn-info giris boxes" name="urunEkle" style="font:18px Calibri Light;" value="Ürün Ekle"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
<?php
require 'footer.php';
?>