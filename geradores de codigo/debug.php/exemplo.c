#include "lib/debug.h"

int main(void){

	int var = 4;
	char c = 'C';
	
	//.....
	debug("\n");
	debug("\n%d", var);
	debug("\nVar 1: ");
	debug("\nVar 1: %d", var);
	debug("\nVar 1: %d, %c", var, c);
	debug("\nVar 1: %d\nVar 2: ", var);
	debug("\nVar 1: %d\nVar 2: %c", var, c);
	debug("\n%d, %c", var, c);
	debug("\nVar 1: \nVar 2: ");
	//...
	
}
