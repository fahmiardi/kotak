<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/helper.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ADMIN :: Manage Kategori</title>
	<style type="text/css">
		
	</style>
</head>
<body>
	<p>MENU UTAMA: <a href="../saran">Manage Saran</a> | <a href=".">Manage Kategori</a> | <a href="../user">Manage User</a> | <a href="../region">Manage Kota</a></p>
	<p><a href="?add">Tambah Kategori</a> | <a href=".">List Kategori</a></p>
	<div>
		<table border="0" width="100%" cellpadding="1" cellspacing="1">
			<tr>
				<td>No.</td>
				<td>Kategori</td>
				<td>Actions</td>	
			</tr>
			<?php $no=1; ?>
			<?php foreach ($kategori as $_kat): ?>
			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $_kat['id']; ?>">
				<tr bgcolor="<?php echo ($_kat['idx']) ? '#DDD' : '#CCC' ;  ?>">
					<td><span><?php echo $no; ?>.</span>
					<td><span><?php htmlout($_kat['nama']); ?></span></td>
					<td><input type="submit" name="action" value="Edit"><input type="submit" name="action" value="Trash" onclick="return confirm('Are you sure?');"></td>
				</tr>
			</form>
			<?php $no++; ?>
			<?php endforeach; ?>
		</table>	
	</div>
</body>
</html>
