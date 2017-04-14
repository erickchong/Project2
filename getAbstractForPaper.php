<?php
include 'WordCloud.php';


$title = $_GET['title'];
$source = $_GET['source'];
$word = $_GET['word'];
$provider = new LibraryController;
$abstract = $provider->getAbstractForPaper($title, $source);
$abstract = preg_replace("/\w*?".preg_quote($word)."\w*/i", "<span class='highlight'>$0</span>", $abstract);
?>

<html>
<head>
<link rel="stylesheet" href="./css/abstract-page.css">
<header>
	<div id="header"><?php echo $title ?></div>
</header>
</head>

<body>
	<div id="abstract">
		<?php echo $abstract ?>
	</div>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>
	