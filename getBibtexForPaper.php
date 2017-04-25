<?php
include_once 'WordCloud.php';

$title = $_GET['title'];
$source = $_GET['source'];
$id = $_GET['id'];

$bibtex = "";
$libraryController = new LibraryController();

$bibtex = $libraryController->getBibtexForPaper($source, $id);
if($source == 'ieee'){
	echo 'generating BibTex for IEEE conferences is in progress!';
}

?>

<html>
<head>
<link rel="stylesheet" href="./css/abstract-page.css">
<header>
	<div id="header">
		<?php
		echo $title; 
		?>
		<br><br><u><center>
		<?php
		echo "BIBTEX"; 

		?>
		</center></u>
	</div>
</header>
</head>

<body>
	<div id="bibtex">

		<?php echo $bibtex ?>
		<!-- <br /> -->
		<!-- <a href="<?php echo $pdfurl?>">pdf</a> -->
	</div>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>