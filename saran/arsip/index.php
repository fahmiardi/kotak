<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/db.inc.php';

// list published saran
try {
	$sql = 'SELECT namaLengkap, perihal, isiSaran, namaKota, namaKategori, namaPropinsi, respon, saranDate, responDate, responBy 
		FROM saran 
		INNER JOIN kota ON saran.idKota = kota.id 
		INNER JOIN propinsi ON kota.idPropinsi = propinsi.id 
		INNER JOIN kategori ON saran.idKategori = kategori.id 
		WHERE published="1" 
		ORDER BY saranDate DESC';
	$result = $pdo->query($sql);
}
catch (PDOExceptio $e) {
	$error = 'Error adding submitted saran: ' . $e->getMessage();
	include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
	exit();
}

$saran = array();
$idx = 0;
foreach ($result as $row) {
	if($idx == 0) {
		$type=TRUE;
		$idx++;
	}
	else {
		$type=FALSE;
		$idx--;
	}
	$saran[] = array('nama' => $row['namaLengkap'], 'perihal' => $row['perihal'], 'saran' => $row['isiSaran'], 'kota' => $row['namaKota'], 'kategori' => $row['namaKategori'], 'propinsi' => $row['namaPropinsi'], 'respon' => $row['respon'], 'date' => $row['saranDate'], 'responDate' => $row['responDate'], 'responBy' => $row['responBy'], 'idx' => $idx);
}

include 'saran.html.php';
?>
