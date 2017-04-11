<?php
include 'WordCloud.php';


$artist = $_GET['author'];
$word = $_GET['word'];
$limit = $_GET['limit'];
$provider = new LibraryController;
$paper_list = $provider->combinePapers($word, $limit);
?>

<html>
<head>
<link rel="stylesheet" href="./dist/css/songs-page.css">
</head>
<header>
	<div id="header"><?php echo strtoupper($word)?></div>
</header>
<body>
	<?php 
		echo "<center><table border=1>
        <tr>
        <td>Paper</td>
        <td>Author List</td>
        <td>Conference Name</td>
        </tr>";
		for($x = 0; $x < count($paper_list); $x++){
			echo "<tr>"
			."<td width='180px' height='200px'>".$paper_list[$x]["tilte"]."</td>"
			."<td width='180px' height='200px'>";
			$author_array = $paper_list[$x]["authors"];
			for($y = 0; $y < count($author_array); $y++){
				echo $author_array[$y];
			}
			echo "</td>"
			."<td width='180px' height='200px'> conference name </td>"
			."</tr>";
		}

		echo "</table>"
		."</center>";

	  //       $track_id = $song_list[$x];
	  //       //echo "track_id is ".$track_id;
	  //       $song_title = $provider->getSongByTrackID($track_id);
	  //       //echo "song_title is ".$song_title;
			// echo "<div id=\"songLink\"><a href=\"getLyricsForSong.php?artist={$artist}&track_id={$track_id}&word={$word}\">$song_title</a></div>";
		//}
	?>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>
	