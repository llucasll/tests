<?php
	foreach($argv as $lib){
		if($lib != "gerador.php"){
?>
#include <<?=$lib?>.h>
<?php
		}
	}
?>

int main(void){
	printf("Hello World!");
}
