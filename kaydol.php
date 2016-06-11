<?php
require 'header.php';
?>

<div class="dev-row">
		<div class="col-xs-12">
			<div class="login_panel center-block">
				<form action="islemler.php" method="POST">
					<table border="0">
						<tr style="text-align:right">
							<td>Ad Soyad :</td>
							<td><input type="text" class="form-control" name="ad_soyad" style="width:250px;"></td>
						</tr>
						<tr>
							<td>Kullanıcı Adı :</td>
							<td><input type="text" class="form-control" name="kadi" style="width:250px;"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Şifre :</td>
							<td><input type="password" class="form-control" name="sifre" style="width:250px;"></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" class="btn btn-info kayit" name="kayit" style="width:250px;" value="Giriş Yap"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
<?php
require 'footer.php';
?>