<?php
namespace App\Utils\AutoParser;
 
class ParserRule{
	private $arg = array();
	function __construct($arg) {
		$this->arg = $arg;
	}

	public function splitClause($clause)
	{
		return explode(',', $clause);
	}

	public function evaluate($rule)
	{
		$clauses = $this->splitClause($rule);

		//if(sizeof($clauses)==1) return $this->arg[$clauses[0]] and true; 
		//Check clause length
		$values = array();

		foreach (explode('-', $clauses[1]) as $s) {
			if(is_numeric($s)){
				array_push($values, $s);
			}
		}

		if(!is_null($this->arg[$clauses[0]])) return $this->arg[$clauses[0]]*($values[0]/100) + $values[1];

	}
}