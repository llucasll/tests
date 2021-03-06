#include "lib/debug.h"
<?php
	/* PARA USAR EM PROGRAMAS .C */
	function getTipo($tipo){
		switch ($tipo) {
			case "int":
				return "%d";
				break;
			case "float":
				return "%f";
				break;
			case "char":
				return "%c";
				break;
			case "char[]":
				return "%s";
				break;
			case "char*":
				return "%s";
				break;
			case "string":
				return "%s";
				break;
			case "long":
				return "%lu";
				break;
			case "double":
				return "%lf";
				break;
			case "int":
				return "%d";
				break;
			
		}
	}
	function debug($vars = [], $strings = []){
		global $DEBUG;
		if($DEBUG){
			//echo "debug(\"\\n\");";
			//"debug(\"\");";
			//echo 'debug("");';
			echo "debug(\"\\n";
			for($i=0; $i<count($vars)||$i<count($strings); $i++){
				if(isset($strings[$i])){
					if($i) echo '\n'; //exibir cada var em uma linha
					echo $strings[$i];
				}
				if(isset($vars[$i])){
					$saida = explode(" ",$vars[$i]);
					//corrige a possibilidade de haverem mais vars que strings;
					//sem colocar vírgula nos casos em que count($strings)==0
					if(count($strings)<$i+1 && count($strings)) echo ", ";
					//se for apenas uma lista de variáveis, sem strings,
					//e não for a primeira da lista
					if(!count($strings) && $i)
						echo ", ";
					echo getTipo("$saida[0]");
					$definedVars[] = $saida[1];
				}
			}
			echo '"';
			if(isset($definedVars)) foreach($definedVars as $var){
				echo ", $var";
			}
			echo ");\n";
		}
	}
?>
