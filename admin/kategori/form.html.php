<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/helper.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php htmlout($pageTitle); ?></title>
	<style type="text/css">
		
	</style>
</head>
<body>
	<p>MENU UTAMA: <a href="../saran">Manage Saran</a> | <a href=".">Manage Kategori</a> | <a href="../user">Manage User</a> | <a href="../region">Manage Kota</a></p>
	<p><a href="?add">Tambah Kategori</a> | <a href=".">List Kategori</a></p>
	<h1><?php htmlout($pageTitle); ?></h1>	
	<div>
		<form action="?<?php htmlout($action); ?>" method="post">
			<div>
				<label for="namaKategori">Nama Kategori:<input type="text" name="namaKategori" value="<?php htmlout($name); ?>"></label>
			</div>
			<div>
				<input type="hidden" name="id" value="<?php htmlout($id); ?>">
				<input type="submit" action="<?php htmlout($action); ?>" value="<?php htmlout($button); ?>">
			</div>
		</form>
	</div>
</body>
</html>
