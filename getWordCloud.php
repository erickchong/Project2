<?php
include 'WordCloud.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' && $_POST['name'] != '') {
	$author = $_POST['name'];
	$provider = new WordCloud;
	$cloud = $provider->WordCloudGenerator($author, 10);
}
else{
	$cloud = null;
}
?>

<html>

<body>
<div id="artist_title"><?php echo strtoupper($author)?></div>
<div id="cloudResult">
<?php 
	echo $cloud;
?>
</div>

</body>
</html>