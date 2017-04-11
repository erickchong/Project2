<?php
include 'WordCloud.php';

$author = $_GET['author'];
$limit = $_GET['limit'];
$provider = new WordCloud;
$cloud = $provider->WordCloudGenerator($author, $limit);;

?>

<html>
<head>
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<link href="./css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="./css/secondWordCloud.css" rel="stylesheet">
</head>
<body>
	<header>
    	<div id="header">NerdEngine</div>
  	</header> 
  	
	<div id="author_title"><?php echo strtoupper($author)?></div>
	<div id="cloudResult">
		<?php 
		echo $cloud;
		?>
	</div>

</body>
</html>