<?php
//TODO o certo seria usar require
include "lib/debug.php"; $DEBUG = true;?>

int main(void){

	int var = 4;
	char c = 'C';
	
	//.....
	<?php debug() ?>
	<?php debug(["int var"]) ?>
	<?php debug([],["Var 1: "]) ?>
	<?php debug(["int var"],["Var 1: "]) ?>
	<?php debug(["int var","char c"],["Var 1: "]) ?>
	<?php debug(["int var"],["Var 1: ","Var 2: "]) ?>
	<?php debug(["int var","char c"],["Var 1: ","Var 2: "]) ?>
	<?php debug(["int var","char c"]) ?>
	<?php debug([],["Var 1: ","Var 2: "]) ?>
	//...
	
}
