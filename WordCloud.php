<?php
include 'LibraryController.php';

class WordCloud


{
    
    /* Builds an array of words with all stop words filtered out. (case-insensitive) */
    function filter_words($words) {
        $bad_words = "La,he,she,they,them,they,and,the,I,me,thislyricsisnotforcommercialuse,*******,This,Lyrics,is,NOT,for,Commercial,use";
        $bad_words = explode(",", $bad_words);
        foreach ($words as $pos => $word) {
            if (!in_array(strtolower($word), $bad_words, TRUE)) {
                $filtered_words[$pos] = $word;
            }
        }
        return $filtered_words;
    }
    /* Builds an array of words as keys and their frequency as the value. (case-insensitive) */
    function word_freq($words) {
        $frequency_list = array();
        foreach ($words as $pos => $word) {
            $word = strtolower($word);
            if (array_key_exists($word, $frequency_list)) {
                ++$frequency_list[$word];
            }
            else {
                $frequency_list[$word] = 1;
            }
        }
        return $frequency_list;
    }
   
    /* Builds the word cloud and returns a string containing a div of the word cloud. */
    function word_cloud($words, $name, $limit) {
        $tags = 0;
        $cloud = "<div id=\"innerCloud\">";
        
        /* This word cloud generation algorithm was taken from the Wikipedia page on "word cloud"
           with some minor modifications to the implementation */
        
        /* Initialize some variables */
        $fmax = 96; /* Maximum font size */
        $fmin = 8; /* Minimum font size */
        $tmin = min($words); /* Frequency lower-bound */
        $tmax = max($words); /* Frequency upper-bound */
        foreach ($words as $word => $frequency) {
        
            if ($frequency > $tmin) {
                $font_size = floor(  ( $fmax * ($frequency - $tmin) ) / ( $tmax - $tmin )  );
                /* Define a color index based on the frequency of the word */
                $random = rand(1, 3);
                if($random == 1){
                    $r = 0; $g = 0; $b = floor( 255 * ($frequency / $tmax) );
                }else if($random == 2){
                    $r = 0; $g = floor( 255 * ($frequency / $tmax) ); $b = 0;
                }else{
                    $r = floor( 255 * ($frequency / $tmax) ); $g = 0; $b = 0;
                }   
               // $r = 0; $g = 0; $b = floor( 255 * ($frequency / $tmax) );
                $color = '#' . sprintf('%02s', dechex($r)) . sprintf('%02s', dechex($g)) . sprintf('%02s', dechex($b));
            }
            else {
                $font_size = 0;
            }
            
            if ($font_size >= $fmin) {
                $cloud .= "<a href=\"getPapersForWord.php?author={$name}&word={$word}&limit={$limit}\" style=\"font-size: {$font_size}px; color: $color;\">$word</a> ";
                $tags++;
            }
        }
        
        $cloud .= "</div>";
        
        return array($cloud, $tags);  
    }

    

    // function getLyricsForArtist($artist) {
    //     $urlBase = 'http://api.musixmatch.com/ws/1.1/';
    //     $apiKey = 'c68c8e440ab040696a20c467eb42ddc2';
    //     // first get track ids
    //     $query_type = "track.search";
    //     $artist_name = "?q_artist=" . $artist;
    //     $query = $urlBase . $query_type . $artist_name . '&apikey=' . $apiKey;
    //     $response = file_get_contents($query);
    //     $response = json_decode($response, true);
    //     $track_list = $response["message"]["body"]["track_list"];
    //     $track_ids = array( );
    //     foreach ($track_list as $track) {
    //         array_push($track_ids, $track["track"]["track_id"]);
    //     }
    //     // second get all the long strings of lyrics for each track
    //     $query_type = "track.lyrics.get";
    //     $lyrics_list = array( );
    //     foreach ($track_ids as $id_key => $id) {
    //         $track_id = "?track_id=" . $id;
    //         $query = $urlBase . $query_type . $track_id . '&apikey=' . $apiKey;
    //         $response = file_get_contents($query);
    //         $response = json_decode($response, true);
    //         array_push($lyrics_list, $response["message"]["body"]["lyrics"]["lyrics_body"]);
    //     }
    //     // turn these long lists of lyrics into a single array that is split by a space delimiter
    //     //$lyrics = array( );
    //     $lyrics = "";
    //     foreach ($lyrics_list as $string_id => $lyric_string) {
    //         $lyric_array = explode(" ", $lyric_string);
    //         foreach ($lyric_array as $word_id => $word) {
    //             $lyrics = $lyrics.$word;
    //         }
    //     }
        
    //     return $lyrics;
    // }

    function WordCloudGenerator($author, $limit){
        
        $provider = new WordCloud;
        $library = new LibraryController;
        $text = $library->combineKeywords($author, $limit);
        if($text == ""){
            return "author not found !";
        }else{
            $words = str_word_count($text, 1); /* Generate list of words */
            $word_count = count($words); /* Word count */
            $unique_words = count( array_unique($words) ); /* Unique word count */
            $words_filtered = $provider->filter_words($words); /* Filter out stop words from the word list */
            $word_frequency = $provider->word_freq($words); /* Build a word frequency list */
            $word_c = $provider->word_cloud($word_frequency, $author, $limit); /* Generate a word cloud and get number of tags */
            $word_cloud = $word_c[0]; /* The word cloud */
            $tags = $word_c[1]; /* The number of tags in the word cloud*/

            return $word_cloud;
        }
        //$text = $provider->getLyricsForArtist($artist_name);
        
    }

    // function getSongsByWord($_word, $_artist){
    //     $urlBase = 'http://api.musixmatch.com/ws/1.1/';
    //     $apiKey = 'c68c8e440ab040696a20c467eb42ddc2';
    //     $word_to_trackid_array = array(); // this array maps each word to the array of track_ids that contain that word 
    //     // first get track ids
    //     $query_type = "track.search";
    //     $artist_name = "?q_artist=" . $_artist;
    //     $query = $urlBase . $query_type . $artist_name . '&apikey=' . $apiKey;
    //     $response = file_get_contents($query);
    //     $response = json_decode($response, true);
    //     $track_list = $response["message"]["body"]["track_list"];
    //     $track_ids = array( );
    //     foreach ($track_list as $track) {
    //         array_push($track_ids, $track["track"]["track_id"]);
    //     }

    //     // second get all the long strings of lyrics for each track
    //     $query_type = "track.lyrics.get";
    //     $lyrics_list = array( );
    //     foreach ($track_ids as $id_key => $id) {
    //         $track_id = "?track_id=" . $id;
    //         $query = $urlBase . $query_type . $track_id . '&apikey=' . $apiKey;
    //         $response = file_get_contents($query);
    //         $response = json_decode($response, true);
    //         $response_lyrics = $response["message"]["body"]["lyrics"]["lyrics_body"];
    //         $temp_2D_arr = array($response_lyrics, $id); //array storing lyrics at 0 and track_id at 1
    //         array_push($lyrics_list, $temp_2D_arr); // $lyrics_list stores the 2 element array we created above
    //     }
       
    //     for($x = 0; $x < count($lyrics_list); $x++){ //for each entry in the array $lyrics_list, "lyrics"->"track_id"
    //         $lyrics_array = explode(" ", $lyrics_list[$x][0]); //explode the lyrics into an array
    //         for($y = 0; $y < count($lyrics_array); $y++){ //for each word in the array

    //             $word = $lyrics_array[$y]; //get the word
    //             $word = str_replace(",", "",$word); //remove commas
    //             $word = str_replace(")", "",$word); //remove bracket
    //             $word = str_replace("(", "",$word); //remove bracket
    //             $word = strtolower($word); //convert to lower case

                                
    //             if(count($word_to_trackid_array) == 0){ // if the $word_to_trackid_array is empty
    //                 $arr = array(); //create an array for the track_ids 
    //                 array_push($arr, $lyrics_list[$x][1]); //push the track_id ($lyrics_list[$x][1]) into this array
    //                 $word_to_trackid_array[$word] = $arr; //the array that we created earlier is the value associated with the key $word
    //             }else{ //if the $word_to_trackid_array is not empty
    //                 if(array_key_exists($word, $word_to_trackid_array)){ //if the word already exists as a key
    //                     $temp = $word_to_trackid_array[$word]; //obtain the word's track_id array
    //                     if(array_key_exists($lyrics_list[$x][1], $temp)){ // if the track_id already exists in the track_id array 
    //                          //do nothing
    //                     }else{ // if the track_id doesn't already exists in the track_id array 
    //                         array_push($temp, $lyrics_list[$x][1]); //push the track_id into the track_id array
    //                     }
    //                 }else{//if the word doesn't already exists as a key
    //                     $arr = array(); //create an array for the track_ids 
    //                     array_push($arr, $lyrics_list[$x][1]); //push the track_id ($lyrics_list[$x][1]) into this array
    //                     $word_to_trackid_array[$word] = $arr; //the array that we created earlier is the value associated with the key $word
    //                 }
    //             }
                
    //         }
    //     }

    //     return $word_to_trackid_array[strtolower($_word)]; //return the track_id
    // }
    
    // function getLyricsForSong($_artist, $_track_id, $_word) {
    //     $urlBase = 'http://api.musixmatch.com/ws/1.1/';
    //     $apiKey = 'c68c8e440ab040696a20c467eb42ddc2';
    //     $query_type = "track.lyrics.get";
    //     $track_id = "?track_id=" . $_track_id;
    //     $query = $urlBase . $query_type . $track_id . '&apikey=' . $apiKey;
    //     $response = file_get_contents($query);
    //     $response = json_decode($response, true);
    //     $lyrics_body = $response["message"]["body"]["lyrics"]["lyrics_body"];
    //     return $lyrics_body;
    // }

    // function getSongByTrackID($_track_id){
    //     $urlBase = 'http://api.musixmatch.com/ws/1.1/';
    //     $apiKey = 'c68c8e440ab040696a20c467eb42ddc2';
    //     $query_type = "track.get";
    //     $track_id = "?track_id=" . $_track_id;
    //     $query = $urlBase . $query_type . $track_id . '&apikey=' . $apiKey;
    //     $response = file_get_contents($query);
    //     $response = json_decode($response, true);
    //     $song_title = $response["message"]["body"]["track"]["track_name"];
    //     return $song_title;
    // }
}

?>