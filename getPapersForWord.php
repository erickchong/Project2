<?php
include 'WordCloud.php';


$author = $_GET['author'];
$word = $_GET['word'];
$limit = $_GET['limit'];
$provider = new LibraryController;
$paper_list = $provider->combinePapers($word, $limit);
?>

<html>
<head>
<link rel="stylesheet" href="./css/papers-page.css">
</head>
<header>
	<div id="header"><?php echo strtoupper($word)?></div>
</header>
<body>
	<?php 
		echo "<center><table border=0 style=\"width: 100%; height: 100%;\">
        <tr>
        <td class = \"td1\" align=\"center\">Paper</td>
        <td class = \"td1\" align=\"center\">Author List</td>
        <td class = \"td1\" align=\"center\">Conference Name</td>
        </tr>";
		for($x = 0; $x < count($paper_list); $x++){
			$title_is = $paper_list[$x]['title'];
			echo "<tr>"
			."<td class = \"td1\" align=\"center\">".$title_is."</td>"
			."<td class = \"td1\" align=\"center\">";
			$author_array = $paper_list[$x]["authors"];
			for($y = 0; $y < count($author_array); $y++){
				$author_is = $author_array[$y];
				echo "<a href=\"getWordCloudForAuthor.php?author={$author_is}&limit={$limit}\">$author_is</a> \n "	;
			}
			echo "</td>"
			."<td class = \"td1\" align=\"center\"> conference name </td>"
			."</tr>";
		}

		echo "</table>"
		."</center>";
	?>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>
	