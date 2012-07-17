<?php include_once $_SERVER['DOCUMENT_ROOT'].'/include/helper.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Daftar Saran</title>
	<style type="text/css">
		
	</style>
</head>
<body>
	<p><a href="../">Tulis Saran</a> | <a href=".">List Saran</a></p>
	<div>
		<?php foreach ($saran as $_saran): ?>
			<div style="background-color: <?php echo ($_saran['idx']) ? '#CCC' : '#DDD'; ?>;">
				<div>
					<div><span>Perihal: <?php htmlout($_saran['perihal']); ?></span></div>
					<div><span><?php htmlout($_saran['saran']); ?></span></div>
					<div><span>By. <?php htmlout($_saran['nama']); ?>, <?php htmlout($_saran['kota']); ?> - <?php htmlout($_saran['propinsi']); ?></span></div>
					<div><span>at <?php changeDate($_saran['date']); ?></span></div>
				</div>				
				<div>
					<div><span><?php htmlout($_saran['respon']); ?></span></div>
					<div><span>Responed by. <?php htmlout($_saran['responBy']); ?></span></div>
					<div><span>at <?php changeDate($_saran['responDate']); ?></span></div>
				</div>			
			</div>
		<?php endforeach; ?>
	</div>
</body>
</html>
