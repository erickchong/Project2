<?php
include 'WordCloud.php';


$conference = $_GET['conference'];
$source = $_GET['source'];
$limit = $_GET['limit'];
$provider = new LibraryController;
$paper_list = $provider->getPapersForConference($conference, $source, $limit);
// if($source == 'acm'){
// 	echo 'generating papers for ACM conferences is in progress!';
// }

?>

<html>
<head>
<link rel="stylesheet" href="./css/papers-page.css">
</head>
<header>
	<div id="header"><?php echo strtoupper($conference)?></div>
</header>
<body>
	<?php 
		echo "<center><table border=0 style=\"width: 100%; height: 100%;\">
        <tr>
        
        <th class = \"td1\" align=\"center\" height=50px>Paper</td>
        <th class = \"td1\" align=\"center\">Author List</td>
        
        </tr>";
		for($x = 0; $x < count($paper_list); $x++){
			$title_is = $paper_list[$x]['title'];
			$source_is = $paper_list[$x]['source'];
			echo "<tr>"
			
			."<td class = \"td1\" align=\"center\">".$title_is."</td>"
			."<td class = \"td1\" align=\"center\">";
			$author_array = $paper_list[$x]["authors"];
			for($y = 0; $y < count($author_array); $y++){
				$author_is = $author_array[$y];
				echo "<a href=\"getWordCloudForAuthor.php?author={$author_is}&limit={$limit}\">$author_is</a> \n "	;
			}
			
			echo"</td></tr>";
		}

		echo "</table>"
		."</center>";
	?>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>
	