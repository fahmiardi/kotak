<?php
include $_SERVER['DOCUMENT_ROOT'].'/include/magicquotes.inc.php';

// sent saran success
if (isset($_GET['success'])) {
	include_once 'success.html';
	exit();
}

// send saran
if (isset($_POST['propinsi']) || isset($_POST['kirim'])) {
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/include/db.inc.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/include/helper.inc.php';
	
	$namaLengkap=$_POST['namaLengkap'];
	$profesi=$_POST['profesi'];
	$instansi=$_POST['instansi'];
	$alamat=$_POST['alamat'];
	$_propinsi=$_POST['propinsi'];
	$_kota=$_POST['kota'];
	$phone=$_POST['phone'];
	$fax=$_POST['fax'];
	$email=$_POST['email'];
	$perihal=$_POST['perihal'];
	$_kategori=$_POST['kategori'];
	$isiSaran=$_POST['isiSaran'];

	if($namaLengkap=="" || $email=="" || $perihal=="" || $isiSaran=="" || $_propinsi==0 || $_kota==0 || $_kategori==0) {
				
		
			if(!valid_email($email)) {
				$error = "Email tidak valid.";
			}
			else {
				if(isset($_POST['kirim'])) {
					$error = "Pastikan form (<span class='red'>*</span>) harus diisi.";
				}
				else {
					$error='';
				}
			}
		
	
		//crawl propinsi
		try {
			$sql = "SELECT id, namaPropinsi 
					FROM propinsi";
			$result = $pdo->query($sql);
		}
		catch (PDOException $e) {
			$error = 'Error catching propinsi: ' . $e->getMessage();
			include_once $_SERVER['DOCUMENT_ROOT'].'/error.html.php';
			exit();
		}
		
		foreach($result as $row) {
			$propinsi[] = array('id'=>$row['id'], 'propinsi'=>$row['namaPropinsi']);
		}
		
		//crawl kota
		try {
			$sql = "SELECT id, namaKota 
					FROM kota 
					WHERE idPropinsi = :idPropinsi";
			$query = $pdo->prepare($sql);
			
			$query->bindValue(':idPropinsi', $_propinsi);
			$query->execute();
		}
		catch (PDOException $e) {
			$error = 'Error catching propinsi: ' . $e->getMessage();
			include_once $_SERVER['DOCUMENT_ROOT'].'/error.html.php';
			exit();
		}
		
		$kota = array();
		foreach($query as $row) {
			$kota[] = array('id'=>$row['id'], 'kota'=>$row['namaKota']);
		}
		
		//crawl kategori
		try {
			$sql = "SELECT id, namaKategori 
					FROM kategori";
			$result = $pdo->query($sql);
		}
		catch (PDOException $e) {
			$error = 'Error catching kategori: ' . $e->getMessage();
			include_once $_SERVER['DOCUMENT_ROOT'].'/error.html.php';
			exit();
		}
		
		foreach($result as $row) {
			$kategori[] = array('id'=>$row['id'], 'kategori'=>$row['namaKategori']);
		}
		
		include_once 'form.html.php';
		exit();
	}
	
	
	try {
	
		$sql = 'INSERT INTO saran 
				SET namaLengkap = :namaLengkap, 
					profesi = :profesi,
					instansi = :instansi,
					alamat = :alamat,
					phone = :phone,
					fax = :fax,
					email = :email,
					perihal = :perihal,
					isiSaran = :isiSaran,
					idKota = :idKota,
					idKategori = :idKategori,
					saranDate = NOW(),
					mark = :mark';
		$s = $pdo->prepare($sql);
		$s->bindValue(':namaLengkap', $namaLengkap);
		$s->bindValue(':profesi', $profesi);
		$s->bindValue(':instansi', $instansi);
		$s->bindValue(':alamat', $alamat);
		$s->bindValue(':phone', $phone);
		$s->bindValue(':fax', $fax);
		$s->bindValue(':email', $email);
		$s->bindValue(':perihal', $perihal);
		$s->bindValue(':isiSaran', $isiSaran);
		$s->bindValue(':idKota', $_kota);
		$s->bindValue(':idKategori', $_kategori);
		$s->bindValue(':mark', "unread");
		$s->execute();
	}
	catch (PDOException $e) {
	
		$error = 'Error adding submitted saran: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'].'/error.html.php';
		exit();
	}
	
	header('Location: ?success');
	exit();
}

// form tulis saran
include_once $_SERVER['DOCUMENT_ROOT'].'/include/db.inc.php';

$propinsi = array();
$kota = array();
$kategori = array();

try {
	$sql = "SELECT id, namaPropinsi 
			FROM propinsi";
	$result = $pdo->query($sql);
}
catch (PDOException $e) {
	$error = 'Error catching propinsi: ' . $e->getMessage();
	include_once $_SERVER['DOCUMENT_ROOT'].'/error.html.php';
	exit();
}

foreach($result as $prop) {
	$propinsi[] = array('id'=>$prop['id'], 'propinsi'=>$prop['namaPropinsi']);
}

try {
	$sql = "SELECT id, namaKategori 
			FROM kategori";
	$result = $pdo->query($sql);
}
catch (PDOException $e) {
	$error = 'Error catching kategori: ' . $e->getMessage();
	include_once $_SERVER['DOCUMENT_ROOT'].'/error.html.php';
	exit();
}

foreach($result as $kat) {
	$kategori[] = array('id'=>$kat['id'], 'kategori'=>$kat['namaKategori']);
}

include_once 'form.html.php';

?>
