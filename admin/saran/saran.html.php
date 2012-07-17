<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/helper.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ADMIN :: Daftar Saran</title>
	<style type="text/css">
		
	</style>
</head>
<body>
	<p>MENU UTAMA: <a href=".">Manage Saran</a> | <a href="../kategori">Manage Kategori</a> | <a href="../user">Manage User</a> | <a href="../region">Manage Kota</a></p>
	<p><a href=".">List Saran</a> | <a href="?responed">List Respon</a> | <a href="?trashed">Trash</a></p>
	<table width="100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td>No.</td>
			<td>Perihal</td>
			<td>Actions</td>
		</tr>
		
		<?php 
		$no=1;		
		foreach ($saran as $_saran): ?>
		<tr bgcolor="<?php echo ($_saran['idx']) ? '#DDD' : '#CCC'; ?>">
			<td><?php echo $no; ?>.</td>
			<td><span style="font-weight:<?php echo ($_saran['mark']=='unread') ? 'bold' : '' ; ?>;"><?php htmlout($_saran['perihal']); ?></span></td>
			<td>
				<form action="" method="post">
					<input type="hidden" name="id" value="<?php htmlout($_saran['id']); ?>">
					<input type="submit" name="action" value="Respon"><input type="submit" name="action" value="Trash">
				</form>
			</td>
		</tr>
		<?php 
		$no++;
		endforeach; ?>
	</table>
</body>
</html>
