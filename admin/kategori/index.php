<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/db.inc.php';

// form add kategori
if(isset($_GET['add'])) {
	$pageTitle = "ADMIN :: Tambah Kategori";
	$action = "addform";
	$name = "";
	$id = "";
	$button = "Tambah Kategori";
	
	include "form.html.php";
	exit();
}

// add kategori
if(isset($_GET['addform'])) {
	try {
		$sql = "INSERT INTO kategori SET namaKategori=:nama";
		$result = $pdo->prepare($sql);
		$result->bindValue(':nama', $_POST['namaKategori']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error inserting kategori: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}
	
	header("Location: .");
	exit();
}

// form edit kategori
if(isset($_POST['action']) && $_POST['action']=="Edit") { 
	try {
		$sql = "SELECT id, namaKategori FROM kategori WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error catching kategori: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}
	
	$row = $result->fetch();

	$pageTitle = "ADMIN :: Edit Kategori";
	$action = "editform";
	$name = $row['namaKategori'];
	$id = $row['id'];
	$button = "Update Kategori";
	
	include "form.html.php";
	exit();
}

// move kategori to Trash
if(isset($_POST['action']) && $_POST['action']=="Trash") { 

}

// permanent delete kategori
if(isset($_POST['action']) && $_POST['action']=="Delete") { 

}

// Update kategori
if(isset($_GET['editform'])) {
	try {
		$sql = "UPDATE kategori SET namaKategori=:nama WHERE id=:id";
		$result = $pdo->prepare($sql);
		$result->bindValue(':id', $_POST['id']);
		$result->bindValue(':nama', $_POST['namaKategori']);
		$result->execute();
	}
	catch (PDOException $e) {
		$error = 'Error updating kategori: ' . $e->getMessage();
		include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
		exit();
	}

	header("Location: .");
	exit();
}

// view list kategori
try {
	$sql = "SELECT id, namaKategori FROM kategori";
	$result = $pdo->query($sql);
}
catch (PDOException $e) {
	$error = 'Error catching kategori: ' . $e->getMessage();
	include_once $_SERVER['DOCUMENT_ROOT'] . '/error.html.php';
	exit();
}

$kategori = array();
$idx=0;
foreach ($result as $row) {
	if($idx == 0) {
		$type=TRUE;
		$idx++;
	}
	else {
		$type=FALSE;
		$idx--;
	}
	$kategori[] = array('id' => $row['id'], 'nama' => $row['namaKategori'], 'idx' => $type);
}

include "kategori.html.php";
?>
