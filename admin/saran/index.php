<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/db.inc.php';

// sending respon saran
if(isset($_POST['action']) && $_POST['action']=="Kirim Respon") {
	$_respon=FALSE;
	$_ceklis=FALSE;
	
	// error validation form
	if(isset($_POST['respon']) && $_POST['respon']=="") {
		$error[] = "Isi respon tidak boleh kosong.";	
		$_respon=TRUE;
	}
	
	if(empty($_POST['published']) && empty($_POST['sent'])) {
		$error[] = "Ceklis salah satu.";
		$_ceklis=TRUE;
	}
	
	if($_respon===TRUE || $_ceklis===TRUE) {
		if($_respon && !$_ceklis) {
			$_publish = isset($_POST['published']) ? $_POST['published'] : '' ;
			$_sent = isset($_POST['sent']) ? $_POST['sent'] : '' ;
		}
		if($_ceklis && !$_respon) {
			$isiRespon = $_POST['respon'];
		}
		
		// success validation form	
		try {		
			$sql = 'SELECT saran.id, namaLengkap, perihal, isiSaran, namaKota, namaKategori, namaPropinsi, respon, saranDate, responDate, responBy, email 
				FROM saran 
				INNER JOIN kota ON saran.idKota = kota.id 
				INNER JOIN propinsi ON kota.idPropinsi = propinsi.id 
				INNER JOIN kategori ON saran.idKategori = kategori.id 
				WHERE saran.id=:id';
			$result = $pdo->prepare($sql);
			$result->bindValue(':id', $_POST['id']);
			$result->execute();
		}
		catch (PDOException $e) {
			$error = 'Error catching saran: ' . $e->getMessage();
			include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
			exit();
		}

		$saran = array();
		$row = $result->fetch();
		$saran[] = array('id' => $row['id'], 'nama' => $row['namaLengkap'], 'perihal' => $row['perihal'], 'saran' => $row['isiSaran'], 'kota' => $row['namaKota'], 'kategori' => $row['namaKategori'], 'propinsi' => $row['namaPropinsi'], 'respon' => $row['respon'], 'date' => $row['saranDate'], 'responDate' => $row['responDate'], 'responBy' => $row['responBy'], 'email' => $row['email']);

		include 'formrespon.html.php';
		exit();
	}

	// Form RUN
	(isset($_POST['published'])) ? $published=1 : $published=0;

	$mark = "nosend";

	if(isset($_POST['sent'])) {
		//send to email
		$respon=0;
		if($respon==0) {
			$mark = "failedsent";
		}
		else {
			$mark = "sent";
		}
	}

	try {
		$sql = "UPDATE saran 
			SET published='".$published."', 
				mark='".$mark."',
				respon=:respon,
				responBy='admin',
				responDate=NOW() 
			WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':respon', $_POST['respon']);
		$result->bindValue(':id', $_POST['id']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error sending respon: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}
	
	header('Location: .');
	exit();
}

// form respon saran
if(isset($_POST['action']) && $_POST['action']=="Respon") {
	try {
		$sql = "UPDATE saran SET mark='read' WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->execute();
	} 	
	catch (PDOException $e) {
		$error = 'Error mark as read saran: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}

	try {		
		$sql = 'SELECT saran.id, namaLengkap, perihal, isiSaran, namaKota, namaKategori, namaPropinsi, respon, saranDate, responDate, responBy, email 
			FROM saran 
			INNER JOIN kota ON saran.idKota = kota.id 
			INNER JOIN propinsi ON kota.idPropinsi = propinsi.id 
			INNER JOIN kategori ON saran.idKategori = kategori.id 
			WHERE saran.id=:id';
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error catching saran: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}

	$saran = array();
	$row = $result->fetch();
	$saran[] = array('id' => $row['id'], 'nama' => $row['namaLengkap'], 'perihal' => $row['perihal'], 'saran' => $row['isiSaran'], 'kota' => $row['namaKota'], 'kategori' => $row['namaKategori'], 'propinsi' => $row['namaPropinsi'], 'respon' => $row['respon'], 'date' => $row['saranDate'], 'responDate' => $row['responDate'], 'responBy' => $row['responBy'], 'email' => $row['email']);

	include 'formrespon.html.php';
	exit();
}

// move saran to trash
if(isset($_POST['action']) && $_POST['action']=="Trash") {
	try {
		$sql = "UPDATE saran SET mark=:mark WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->bindValue(':mark', "trashed");
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error trashing saran: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

// permanent delete saran
if(isset($_POST['action']) && $_POST['action']=="Delete") {
	try {
		$sql = "DELETE FROM saran WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error permanent delete saran: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

// publish or unpublish saran
if(isset($_POST['action']) && $_POST['action']=="Publish" || isset($_POST['action']) && $_POST['action']=="Unpublish") {
	($_POST['action']=="Publish") ? $published=1 : $published=0;
	
	try {
		$sql = "UPDATE saran SET published='".$published."' WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error publish attribute saran: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}

	header("Location: ?responed");
	exit();
}

// Edit respon
if(isset($_POST['action']) && $_POST['action']=="Edit") {
	
}

// Update respon
if(isset($_POST['action']) && $_POST['action']=="Update") {
	
}

// send saran to email
if(isset($_POST['action']) && $_POST['action']=="Send Now" || isset($_POST['action']) && $_POST['action']=="Send Again") {
	// send to email	
	
	header("Location: ?responed");
	exit();
}

// filter saran responed
if(isset($_GET['responed'])) {
	try {
		$sql = 'SELECT saran.id, namaLengkap, perihal, isiSaran, namaKota, namaKategori, namaPropinsi, respon, saranDate, responDate, responBy, mark, published, email 
			FROM saran 
			INNER JOIN kota ON saran.idKota = kota.id 
			INNER JOIN propinsi ON kota.idPropinsi = propinsi.id 
			INNER JOIN kategori ON saran.idKategori = kategori.id 
			WHERE respon IS NOT NULL 
			AND mark!="trashed" 
			ORDER BY saranDate DESC';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e) {
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
		$saran[] = array('id' => $row['id'], 'nama' => $row['namaLengkap'], 'perihal' => $row['perihal'], 'saran' => $row['isiSaran'], 'kota' => $row['namaKota'], 'kategori' => $row['namaKategori'], 'propinsi' => $row['namaPropinsi'], 'respon' => $row['respon'], 'date' => $row['saranDate'], 'responDate' => $row['responDate'], 'responBy' => $row['responBy'], 'idx' => $type, 'mark' => $row['mark'], 'published' => $row['published'], 'email' => $row['email']);
	}

	include 'responed.html.php';
	exit();
}

// filter saran trashed
if(isset($_GET['trashed'])) {
	try {
		$sql = 'SELECT saran.id, namaLengkap, perihal, isiSaran, namaKota, namaKategori, namaPropinsi, respon, saranDate, responDate, responBy, mark, published 
			FROM saran 
			INNER JOIN kota ON saran.idKota = kota.id 
			INNER JOIN propinsi ON kota.idPropinsi = propinsi.id 
			INNER JOIN kategori ON saran.idKategori = kategori.id 
			WHERE mark="trashed" 
			ORDER BY saranDate DESC';
		$result = $pdo->query($sql);
	}
	catch (PDOException $e) {
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
		$saran[] = array('id' => $row['id'], 'nama' => $row['namaLengkap'], 'perihal' => $row['perihal'], 'saran' => $row['isiSaran'], 'kota' => $row['namaKota'], 'kategori' => $row['namaKategori'], 'propinsi' => $row['namaPropinsi'], 'respon' => $row['respon'], 'date' => $row['saranDate'], 'responDate' => $row['responDate'], 'responBy' => $row['responBy'], 'idx' => $type, 'mark' => $row['mark']);
	}

	include 'trashed.html.php';
	exit();
}

// view list saran
try {
	$sql = 'SELECT saran.id, namaLengkap, perihal, isiSaran, namaKota, namaKategori, namaPropinsi, respon, saranDate, responDate, responBy, mark 
		FROM saran 
		INNER JOIN kota ON saran.idKota = kota.id 
		INNER JOIN propinsi ON kota.idPropinsi = propinsi.id 
		INNER JOIN kategori ON saran.idKategori = kategori.id 
		WHERE published="0" 
		AND respon IS NULL 
		AND mark!="trashed" 
		ORDER BY saranDate DESC';
	$result = $pdo->query($sql);
}
catch (PDOException $e) {
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
	$saran[] = array('id' => $row['id'], 'nama' => $row['namaLengkap'], 'perihal' => $row['perihal'], 'saran' => $row['isiSaran'], 'kota' => $row['namaKota'], 'kategori' => $row['namaKategori'], 'propinsi' => $row['namaPropinsi'], 'respon' => $row['respon'], 'date' => $row['saranDate'], 'responDate' => $row['responDate'], 'responBy' => $row['responBy'], 'idx' => $type, 'mark' => $row['mark']);
}

include 'saran.html.php';
?>
