<?php
include 'LibraryController.php';
use PHPUnit\Framework\TestCase;

/**
 * Test WordCloud.php
 */

final class WordCloudTest extends TestCase
{
	//tests if words are correctly filtered out
	public function test_filter_words(){
		//(Arrange) All words should be filtered out except "Hello" and "World"
		$words = "he,she,they,them,they,and,the,me,thislyricsisnotforcommercialuse,hello,world";
        $words = explode(",", $words);
        $hello = "hello,world";
        $hello = explode(",", $hello);


        $allWordsFiltered = "he,she,they,them,they,and,the,me";
        $allWordsFiltered = explode(",", $allWordsFiltered);
        $wordsEmpty = ",";
        $wordsEmpty = explode(",", $wordsEmpty);

        $noWordsFiltered = "tired,world";
		$noWordsFiltered = explode(",", $noWordsFiltered);
        $wordsFilled = "tired,world";
        $wordsFilled = explode(",", $wordsFilled);
        

        //Act
        $cloud = new WordCloud();
        $words = $cloud->filter_words($words);
        $allWordsFiltered = $cloud->filter_words($allWordsFiltered);
        $noWordsFiltered = $cloud->filter_words($noWordsFiltered);


        //Assert
        sort($words);
        sort($hello);
        
        //sort($allWordsFiltered);
        sort($wordsEmpty);

        sort($noWordsFiltered);
        sort($wordsFilled);
        
        $this->assertEquals($words, $hello);
        $this->assertNull($allWordsFiltered);
        $this->assertEquals($noWordsFiltered, $wordsFilled);
	}

	//tests if word frequency is counted correctly
	public function test_word_freq(){
		//Arrange
		$words = "lol,lol,lol,lmao,HA,ha,ha,ha,jk,jk";
        $words = explode(",", $words);


        //Act
        $cloud = new WordCloud();
        $frequency_list = $cloud->word_freq($words);


        //Assert
        //make sure each word is counted correctly
        $this->assertEquals($frequency_list["lol"], 3);
        $this->assertEquals($frequency_list["lmao"], 1);
        $this->assertEquals($frequency_list["ha"], 4);
        $this->assertEquals($frequency_list["jk"], 2);
        //testing if word is not present, returns 0 count
        $this->assertEquals($frequency_list["hello"], 0); 
	}

	//Word Cloud is an API so we just need to test if the API call worked or not, not the substance of the API
	// public function test_word_cloud(){
	// 	//Arrange


 //        //Act
	// 	$cloud = new WordCloud();
	// 	$name = "Rihanna";
 //        $text = $cloud->getLyricsForArtist($name);
 //        $words = str_word_count($text, 1);
 //        $word_frequency = $cloud->word_freq($words);
	// 	$word_c = $cloud->word_cloud($word_frequency, $name);
	// 	$tags = $word_c[1];

	// 	//Assert
	// 	//tests if the right number of tags come up 
	// 	//$this->assertEquals($tags, 14);
	// 	//tests if the call worked
	// 	$this->assertLessThan($tags, 0);

	// }

	//this test should check if the API call was successful or not (the job of a remote API client), not what is in those calls
	// public function test_getLyricsForArtist(){
	// 	//Arrange
	// 	$cloud = new WordCloud();
	// 	$lyrics_content = $cloud->getLyricsForArtist("Rihanna");
	// 	$lyrics_no_content = $cloud->getLyricsForArtist("asdfadsfadfgag");

	// 	//Assert
	// 	//make sure lyrics ARE returned for an artist that exists
	// 	$this->assertLessThan(sizeof($lyrics_content), 0);
	// 	//make sure NO lyrics returned for an artist that does not exist
	// 	$this->assertEquals($lyrics_no_content, '');

	// }

	public function test_WordCloudGenerator(){

		//Arrange
		$cloud = new WordCloud();
		$name = "madan";
		$library = new LibraryController;
        $text = $library->combineKeywords($name, 10);

		//Act
        //$text = $cloud->getLyricsForArtist($name);
        $words = str_word_count($text, 1);
        $word_frequency = $cloud->word_freq($words);
		$word_c = $cloud->word_cloud($word_frequency, $name);
		$tags = $word_c[1];

		//Assert
		//tests if the right number of tags come up 
		$this->assertEquals($tags, 15);
		//tests if the call worked
		//$this->assertLessThan($tags, 0);
	}

	// public function test_getLyricsForSong(){
	// 	//test not needed
	// }

	// public function test_getSongByTrackID(){
	// 	//test not needed
	// }

	// //tests for getSongsByWord
	// //1) If songs returned by word are accurate. Testing by having a sample word, and seeing if the array that is returned, has a random song that contains that word.
	// // 2) If word is empty, songs returned are empty
	// // 3) If word is not alphabetical, songs returned are empty
	// // 4) If word is not in song, songs returned are empty
	// public function test_getSongsByWord(){
	// 	//Arrange
	// 	$cloud = new WordCloud();
	// 	$randomSongFound = false;
	// 	$name = "Rihanna";
	// 	$word = "thief";
	// 	$emptyWord = "";
	// 	$noAlph= "&&&";
	// 	$noWordInSong = "askjdf";
		
	// 	//Act
	// 	$word = $cloud->getSongsByWord($word,$name);
	// 	$emptyWord = $cloud->getSongsByWord($emptyWord, $name);
	// 	$noAlph = $cloud->getSongsByWord($noAlph, $name);
	// 	$noWordInSong = $cloud->getSongsByWord($noWordInSong, $name);

	// 	//testing to see if array returned from word, has a random song that contains the word.
	// 	//random song used is disturbia, which does have the word "thief"
	// 	for($y = 0; $y < count($word); $y++){ 
	// 		if ($word[$y] == "disturbia")
	// 			$randomSongFound = true;
	// 	}

	// 	//Assert
	// 	$this->assertEquals($randomSongFound, true);
	// 	$this->assertEquals(sizeof($emptyWord), 0);
	// 	$this->assertEquals(sizeof($noAlph), 0);
	// 	$this->assertEquals(sizeof($noWordInSong), 0);
			

		
	// }

}