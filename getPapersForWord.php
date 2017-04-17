<?php
include 'WordCloud.php';
include 'PDFGetter.php';

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
		echo "<form action=\"./getCombinedWordCloud.php\" method=\"post\">";

		echo "<center><table border=0 style=\"width: 100%; height: 100%;\">
        <tr>
        <th align=\"center\">&nbsp;</td>
        <th class = \"td1\" align=\"center\" height=50px>Paper</td>
        <th class = \"td1\" align=\"center\">Author List</td>
        <th class = \"td1\" align=\"center\">Conference Name</td>
        <th class = \"td1\" align=\"center\">Bibtex</td>

        </tr>";
		for($x = 0; $x < count($paper_list); $x++){
			$title_is = $paper_list[$x]['title'];
			$source_is = $paper_list[$x]['source'];
			$pdf_url_is = getPDFURL($source_is, $paper_list[$x]['pdfURL']);
			$id_is = $paper_list[$x]['id'];
			$attribute = $source_is."-".$id_is;
			
			echo "<tr>"
			."<td><div class=\"checkbox-inline\"><input type=\"checkbox\" name=\"papers[]\" value=\"{$attribute}\"></div></td>"
			."<td class = \"td1\" align=\"center\">";
			echo $source_is."  :  ";
			echo "<a href=\"getAbstractForPaper.php?title={$title_is}&word={$word}&source={$source_is}&pdfurl={$pdf_url_is}&id={$id_is}\">$title_is</a> ";
			echo "</td>"
			."<td class = \"td1\" align=\"center\">";
			$author_array = $paper_list[$x]["authors"];
			for($y = 0; $y < count($author_array); $y++){
				$author_is = $author_array[$y];
				echo "<a href=\"getWordCloudForAuthor.php?author={$author_is}&limit={$limit}\">$author_is</a> \n "	;
			}
			$conf_is = $paper_list[$x]['publication'];
			
			echo "</td>"
			."<td class = \"td1\" align=\"center\">";
			echo "<a href=\"getPapersForConference.php?conference={$conf_is}&limit={$limit}&source={$source_is}\">$conf_is</a> \n "	;
			echo "</td>"
			."<td class = \"td1\" align=\"center\">";
			echo "<a href=\"getBibtexForPaper.php?title={$title_is}&source={$source_is}&id={$id_is}\">bibtex</a> \n ";
			echo "</td></tr>";
		}

		echo "</table></center>";
		echo "<input type=\"submit\" name=\"formSubmit\" value=\"Submit\" />";
		echo "</form>";
	?>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>
	