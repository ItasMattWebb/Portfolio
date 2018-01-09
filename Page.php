<?php


class Page{

	protected static $instance = null;
	public $title = "";
	public $content = "";
	public $header = "<!DOCTYPE html><html>";
	public $footer = "</html>";
	public $extras = [];

	public function __contruct(){

	}


	public function addContent($title, $content){
		if(!isset($content["title"])){
			$content["title"]->add($content);
		}
	}

	public static function getInstance(){
		if(!isset(static::$instance)){
			static::$instance = new static;
		}
		return static::$instance;
	}

	public function output($name){
		if(isset($this->content[$name]) && count($this->content[$name]) > 0){
			foreach ($this->content[$name] as $key => $item) {
				echo $item;
			}
		}
	}

	public function generate($title, $content, $header = "main", $footer = "main"){
		$this->title .= $title;
		$this->header .= file_render("Headers/" . $header . ".php");
		$this->content .= file_render($content . ".php");
		$this->footer .= file_render("Footers/" . $footer . ".php");
	}

	public function load_template($template){
		echo $this->header;
		include $template . ".php";
		echo $this->footer;
	}

	public function render($template){

		$contents = file_get_contents($template . ".tpl");

		$replace = array(
			"title" => $this->title,
			"content" => $this->content,
			"header" => $this->header,
			"footer" => $this->footer,
		);

		foreach ($replace as $key => $value) {
			$contents = str_replace("{" . $key . "}" , $value, $contents);
		}
		foreach ($this->extras as $key => $value){
			$contents = str_replace("{" . $key . "}" , $value, $contents);
		}
		echo $contents;
	}

}

?>