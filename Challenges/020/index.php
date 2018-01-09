<?php
//set page data
$page = Page::getInstance();
$page->title = "Book Metadata Reader";

$booknumber = isset($_GET["booknumber"]) ? intval($_GET["booknumber"]) : 0;
set_error_handler(function(){});
//get file, hide errors if fail on first attempt
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

//check if chapters have content
foreach ($chapters as $key => $chapter) {
	if(strlen($chapter) < 50 || preg_match_all("/\n/", $chapter) < 3){
		unset($chapters[$key]);
	}
}
//rest keys
array_values($chapters);

//get book details
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
median and mean words per sentence
cache files
*/

function word_count($string){
	return count(preg_split("/\s/",$string));
}

//get protocol for JS link
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';

?>

<form name="book_form">
	<label><a href="http://www.gutenberg.org/wiki/Main_Page">Gutenberg</a> book number</label><input name="booknumber" type="number" value="<?=$booknumber; ?>" />
	<button name="submit">Submit</button>
</form>

<p id="info">
	<?php

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
</div>
<script type="text/javascript">

	document.getElementsByName("book_form")[0].addEventListener('submit', event => {
		event.preventDefault();
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			document.getElementById("demo").innerHTML = this.responseText;
			}
		};
		var parameters = "booknumber="+document.getElementsByName("booknumber")[0].value;
		ajax.open("POST", "<?=$protocol . $_SERVER['HTTP_HOST']; ?>/Challenges/020/ajax.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send(parameters);
		document.getElementById("info").innerHTML= "<img src=\"/Resources/loading.gif\">";
		ajax.onreadystatechange = function(){
			if (ajax.readyState==4){
				if (ajax.status==200){
					document.getElementById("info").innerHTML=ajax.responseText
				} else{
					alert("An error has occured making the request")
				}
			}
		}
	});

</script>