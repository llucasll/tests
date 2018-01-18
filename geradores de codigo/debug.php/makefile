executavel = .out

exec:
	php exemplo.c.php > exemplo.c
	gcc -o exemplo$(executavel) exemplo.c lib/debug.c
	./exemplo$(executavel) # | less
