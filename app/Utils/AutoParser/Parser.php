<?php
namespace App\Utils\AutoParser;
 
class Parser{
	private $arg = array();
	function __construct($arg) {
		$this->arg = $arg;
	}

	public function splitContext($context)
	{
		return explode(":", $context);
	}

	public function parse($context)
	{
		$clauses = $this->splitContext($context);

		//check clauses length
		
		$condition = new ParserCondition($this->arg);

		$rule = new ParserRule($this->arg);

		if($condition->evaluate($clauses[0])) return $rule->evaluate($clauses[1]); else return -1;
		
	}
}