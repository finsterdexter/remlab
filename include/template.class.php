<?php
// Update the HTML template with defined variables 
class HtmlTemplate {
	var $template;
	var $html;
	var $parameters = array();
	
	function getTemplate($template) {
		$this->template = $template;
	}
	
	function setParameter($variable, $value) {
		$this->parameters[$variable] = $value;
	}
	
	function createPage() {
		$this->html = implode("", (file($this->template)));
		foreach ($this->parameters as $key => $value) {
			$templateName = '{' . $key . '}';
			$this->html = str_replace($templateName, $value, $this->html);
		}
		echo $this->html;
	}
}

?>