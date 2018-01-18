# Sobre a micro-biblioteca Debug PHP -> C

Essa biblioteca é, como se pode ver, apenas um pequeno experimento, para explorar as potencialidades do PHP enquanto gerador de código (a ser usado em diversos níveis de metaprogramação).

Esse projeto se encontra, atualmente, em

https://github.com/llucasll/tests/tree/master/lib/geradores%20de%20codigo/debug.php/

## Instalação

Será necessária a instalação do interpretador PHP.

Em uma distribuição derivada do Ubuntu/Debian, use

	$ sudo apt install php7.0-cli
	
## Motivação (ou, "Desculpa para testar os limite do PHP")

Convém entender, primeiramente, o que essa biblioteca faz.

Quando estamos programando, é comum printar certos valores de variáveis com a intenção de debugar o código. Entretanto, esses prints não podem permanecer no arquivo final gerado (entregue ao usuário final, ou avaliador, se for um projeto acadêmico).

Com a intenção de minimizar os problemas trazidos pelo debug, sem atrapalhar a produtividade do programador, diferentes framewoks provêm mecanismos de depuração que são transparentes para o usuário final (desde utilizar uma variável global que determine se é para printar os debugs ou não, até simplesmente salvar em um `arquivo.log`). Acredito que a melhor (ou única) maneira seria a existência de uma função `debug()` que recebesse valores analogamente ao printf, mas o substituindo para abstrair a implementação: a função debug pode chamar o printf, salvar num arquivo de log ou simplesmente não fazer nada; bastando alterar o seu comportamento em um único lugar (a conhecida vantagem do uso de funções).

Em alguns casos, porém, como em projetos Open Source, pode ser conveniente tirar esses debugs mesmo no código-fonte (versão compartilhada publicamente). Para tal, um gerador de código em PHP seria muito conveniente para decidir, numa etapa anterior à compilação, se os debugs vão ou não para o código-fonte.

A ideia é que o programador use um código misto, escrevendo seu programa naturalmente em C e inserindo pequenos scripts em PHP quando desejar fazer uso do debug.

## Explorando

O primeiro passo para entender a lógica por trás do projeto é ler o makefile. Ele basicamente resume a forma como os arquivos contidos aqui se organizam.

#### Organização

Na última versão/commit eu separei aquilo que tinha caráter de biblioteca em `lib/`.

(Para ver a versão anterior simplesmente use
	
	$ git checkout master~

Para retornar à versão mais atual, use
	
	$ git checkout master
	
)

Restou então, na pasta principal, os arquivos
* `README.md` - este aqui
* `makefile` - quem coordena pré-compilação, compilação e execução, de forma automatizada
* `exemplo.c.php` - que gera o `exemplo.c`
* `exemplo.c` - deixei apenas para facilitar a compreesão (futuramente, o ideal é o makefile apagar esses arquivos intermediários)

Estes arquivos estão aqui apenas para exemplificar [como usar]/testar a biblioteca

#### `Lib/`

Aqui dentro encontramos 3 arquivos que fazem toda a mágica:
* `debug.h` - um cabeçalho como outro qualquer 
* `debug.c` - responsável unicamente por prover a implementação da função `debug()`, em C
* `debug.php` - onde a mágica, de fato, acontece .-. (implementa `debug()` em PHP)

## Funcionamento

Primeiramente, é importante entender que há uma função `debug()` implementada em C (em `debug.c`) e outra em PHP (em `debug.php`).
Essas funções não só estão em linguagens distintas, como têm funções distintas:
* A função `debug()` em C é responsável por implementar o que fazer com as strings de debug fornecidas em tempo de execução
* A função `debug()` em PHP é responsável por determinar o que fazer quando o programador solicita o uso de depuração - controlada pela var `$DEBUG`:
	
	`if true`, o comportamento é gerar a chamada à função `debug()` em C, no código-fonte
	
	`if false`, o comportamento é não fazer nada (ou seja, o código-fonte gerado será igual ao anterior à pré-compilação, ignorando às chamadas ao PHP)

## Um detalhe não fundamental

Pensando em simplificar ao máximo para o programador-usuário da biblioteca, o arquivo `debug.php` já se ocupa em importar o `debug.h`. Assim, o programador fica livre de fazer importação duas vezes.

O include em PHP e em C se comportam de maneiras distintas, então talvez seja confuso entender essa parte: ao dar include de `debug.php`, o arquivo `exemplo.c.php` está incluindo em sua saída tudo o que for saída de `debug.php`. Ou seja, o include de `debug.h` (presente na primeira linha de `debug.php`) fará parte do arquivo gerado (`debug.c`).

Esse detalhe não é imprenscindível para a compreensão da biblioteca.

## Considerações finais

Estou cansado de escrever esse arquivo (shashhhsaha). Escrevi direto, de uma vez.

Esse projeto é apenas um exemplo de uso do PHP como gerador de código C, e essa documentação é um esboço.

