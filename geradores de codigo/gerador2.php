<?php
	foreach($argv as $lib)
		if($lib != $argv[0])
			echo "#include <$lib.h>\n";
?>

int main(void){
	printf("Hello World!");
}
