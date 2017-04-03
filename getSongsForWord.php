<?php
include 'WordCloud.php';


$artist = $_GET['artist'];
$word = $_GET['word'];
$provider = new WordCloud;
$song_list = $provider->getSongsByWord($word, $artist);
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
	    $formattedWord = $word;
		for($x = 0; $x<count($song_list); $x++){
	        $track_id = $song_list[$x];
	        //echo "track_id is ".$track_id;
	        $song_title = $provider->getSongByTrackID($track_id);
	        //echo "song_title is ".$song_title;
			echo "<div id=\"songLink\"><a href=\"getLyricsForSong.php?artist={$artist}&track_id={$track_id}&word={$word}\">$song_title</a></div>";
		}
	?>
<a href="index.html"><button id="back">Back</button></a>
</body>
</html>
	