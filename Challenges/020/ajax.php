<?php
$booknumber = intval($_POST['booknumber']);

set_error_handler(function(){});
//get file
if(false !== file_get_contents("http://www.gutenberg.org/files/$booknumber/$booknumber-0.txt")){
	$string =  file_get_contents("http://www.gutenberg.org/files/$booknumber/$booknumber-0.txt");
} else {
	$string =  file_get_contents("http://www.gutenberg.org/ebooks/$booknumber.txt.utf-8");
}
restore_error_handler();

//split into chapters
$chapters = preg_split("/Chapter[^\n]+\n/i", $string);;
//free up memory
unset($string);

preg_match("/Title:(.*)\n/", $chapters[0], $title);
$title = $title[1];

preg_match("/Author:(.*)\n/", $chapters[0], $author);
$author = $author[1];
if(count($chapters) > 1){
	//remove preamble
	array_splice($chapters, 0, 1);
	//remove postamble
	if(count($chapters) > 0){
		$chapters[count($chapters) - 1] = preg_split("/THE\sEND/", $chapters[count($chapters) - 1])[0];
	}
	
	$wordcount;
	foreach ($chapters as $key => $chapter) {
		$wordcount[] = word_count($chapter);
		$sentences[] = preg_match_all("/[^\.!?]+/", $chapter);
	}
}

/*
total word count
word count per chapter
median and mean words per sentence
total sentence count
find names and count how many times they are mentioned
*/

function word_count($string){
	return count(preg_split("/\s/",$string));
}

echo 'Title:' . $title . '<br>';
echo 'Author:' . $author . '<br>';
if(count($chapters) > 1){
	echo 'Chapters:' . count($chapters) . '<br>';
	echo 'Total sentences: ' . array_sum($sentences) . '<br>';
	echo 'Sentences per chapter: ' .  round(array_sum($sentences) / count($sentences)) . '<br>';
	echo 'Total words: ' . array_sum($wordcount) . '<br>';
	echo 'Words per chapter: ' .  round(array_sum($wordcount) / count($wordcount)) . '<br>';
}

?>