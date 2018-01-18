#include "debug.h"

void debug(const char *format, ...){
	va_list arg;

	va_start (arg, format);
	vfprintf (stdout, format, arg);
	va_end (arg);
		
	printf("\n");//TODO
}
