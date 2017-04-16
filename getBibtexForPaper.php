<?php
include_once 'WordCloud.php';

$title = $_GET['title'];
$source = $_GET['source'];
$id = $_GET['id'];

$bibtex = "";
$libraryController = new LibraryController();

if ($source == "acm")
{
	$bibtex = $libraryController->getACMBibtex($id);
}
else
{
	$bibtex = $libraryController->getIEEEBibtex($id);
}

?>

<html>
<head>
<link rel="stylesheet" href="./css/abstract-page.css">
<header>
	<div id="header"><?php echo $title ?></div>
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