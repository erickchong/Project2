<?php
include 'WordCloud.php';

	if(isset($_POST['formSubmit'])) 
    {
    	$papers = $_POST['papers'];
		if(empty($papers)) 
        {
			//echo("<p>You didn't select any paper.</p>\n");
			$cloud = "";
		} 
        else 
        {
   //          $N = count($papers);

			// echo("<p>You selected $N paper(s): ");
			// for($i=0; $i < $N; $i++)
			// {
			// 	echo($papers[$i] . " ");
			// }
			// echo("</p>");
			$provider = new WordCloud;
			$cloud = $provider->CombinedWordCloudGenerator($papers);
		}
	}
	else{
		echo "nothing";
	}
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
  	
	
	<div id="cloudResult">
		<?php 
		echo $cloud;
		?>
	</div>

</body>
</html>