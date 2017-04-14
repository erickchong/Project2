<?php
include 'WordCloud.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' && $_POST['name'] != '' && $_POST['limit'] != '') {
	$author = $_POST['name'];
	$limit = $_POST['limit'];
	$provider = new WordCloud;
	$cloud = $provider->WordCloudGenerator($author, $limit);
}
else{
	$cloud = null;
}
?>

<html>
<body>
<div id="author_title"><?php echo strtoupper($author)?></div>
<div id="cloudResult">
<?php 
echo $cloud;
?>
</div>

</body>
</html>