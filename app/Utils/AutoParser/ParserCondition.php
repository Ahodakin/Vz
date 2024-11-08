<?php
namespace App\Utils\AutoParser;
 
class ParserCondition{
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

		if(sizeof($clauses)==1){
			if(array_key_exists($clauses[0], $this->arg))
				return $this->arg[$clauses[0]] and true;
			else
				return false;
		} 

		$values = array();

		foreach (explode('-', $clauses[1]) as $s) {
			if(is_numeric($s)){
				array_push($values, $s);
			}
		}



		return $this->arg[$clauses[0]] and ($this->arg[$clauses[0]] > $values[0]) and ($this->arg[$clauses[0]] < $values[1]);

	}
}