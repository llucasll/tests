# Sobre a micro-biblioteca Debug PHP -> C

Essa biblioteca é, como se pode ver, apenas um pequeno experimento, para explorar as potencialidades do PHP enquanto gerador de código (a ser usado em diversos níveis de metaprogramação).

Esse projeto se encontra, atualmente, em

https://github.com/llucasll/tests/tree/master/geradores%20de%20codigo/debug.php/

Recomendo ler esse mini-guia acompanhando na árvore de diretórios; e depois, relê-lo acompanhando no código-fonte.

## Instalação

Será necessária a instalação do interpretador PHP.

Em uma distribuição derivada do Ubuntu/Debian, use

	$ sudo apt install php7.0-cli

Para fazer o download desse repositório, aqui já vai o atalho:

	$ git clone https://github.com/llucasll/tests.git ~/desktop/github/tests;
	cd ~/desktop/github/tests/geradores\ de\ codigo/debug.php

***! ATENÇÃO: esse comando vai salvar automaticamente em seu desktop***

Se você usa o SO em português, provavelmente o comando certo seria

	$ git clone https://github.com/llucasll/tests.git ~/Área\ de\ trabalho/github/tests;
	cd ~/desktop/github/tests/geradores\ de\ codigo/debug.php
	
## Motivação (ou, "Desculpa para testar os limites do PHP")

Convém entender, primeiramente, o que essa biblioteca faz.

Quando estamos programando, é comum printar certos valores de variáveis com a intenção de debugar o código. Entretanto, esses prints não podem permanecer no arquivo final gerado (entregue ao usuário final, ou avaliador, se for um projeto acadêmico).

Com a intenção de minimizar os problemas trazidos pelo debug, sem atrapalhar a produtividade do programador, diferentes framewoks provêm mecanismos de depuração que são transparentes para o usuário final (desde utilizar uma variável global que determine se é para printar os debugs ou não, até simplesmente salvar em um `arquivo.log`). Acredito que a melhor (ou única) maneira seria a existência de uma função `debug()` que recebesse valores analogamente ao printf, mas o substituindo para abstrair a implementação: a função debug pode chamar o printf, salvar num arquivo de log ou simplesmente não fazer nada; bastando alterar o seu comportamento em um único lugar (a conhecida vantagem do uso de funções).

Em alguns casos, porém, como em projetos Open Source, pode ser conveniente tirar esses debugs mesmo no código-fonte (versão compartilhada publicamente). Para tal, um gerador de código em PHP seria muito conveniente para decidir, numa etapa anterior à compilação, se os debugs vão ou não para o código-fonte.

A ideia é que o programador use um código misto, escrevendo seu programa naturalmente em C e inserindo pequenos scripts em PHP quando desejar fazer uso do debug. Assim, ele não precisa remover manualmente cada chamada a `debug()` antes de publicar o código-fonte: o PHP já faz isso por ele. Em tempo de pré-compilação (no momento de gerar o código-fonte), o PHP decide sobre simplesmente ignorar esses scripts (assim eles não saem no fonte) ou "substituí-los" por chamadas à função debug(), em C.

## Explorando

O primeiro passo para entender a lógica por trás do projeto é ler o makefile. Para quem já está minimamente habituado com o uso de makefiles para compilação em C, e com o terminal no Linux, ele basicamente resume a mecânica da geração de código automática, e a forma como os arquivos contidos aqui se organizam.

#### Organização

Eu separei aquilo que tinha caráter de biblioteca em `lib/`.

Restou então, na pasta principal, os arquivos
* `README.md` - este aqui
* `makefile` - quem coordena pré-compilação, compilação e execução, de forma automatizada
* `exemplo.c.php` - que gera/cuja saída vai para o arquivo `exemplo.c`
* `exemplo.c` - deixei apenas por razões didáticas (futuramente, o ideal é o comando make, sem argumentos, não deixar arquivos intermediários, como esse)

Estes arquivos estão aqui apenas para exemplificar [como usar]/testar a biblioteca

#### `Lib/`

Aqui dentro encontramos 3 arquivos que fazem toda a mágica:
* `debug.h` - um cabeçalho como outro qualquer 
* `debug.c` - responsável unicamente por prover a implementação da função `debug()`, em C
* `debug.php` - onde a mágica, de fato, acontece .-. (implementa `debug()` em PHP)

## Funcionamento

Primeiramente, é importante entender que há uma função `debug()` implementada em C (em `lib/debug.c`) e outra em PHP (em `lib/debug.php`).
Essas funções não só estão em linguagens distintas, como têm funções distintas:
* A função `debug()` em C é responsável por implementar o que fazer com as strings de debug fornecidas em tempo de execução
* A função `debug()` em PHP é responsável por determinar o que fazer quando o programador solicita o uso de depuração - controlada pela var `$DEBUG`:
	
	`if true`, o comportamento é gerar a chamada à função `debug()` em C, no código-fonte
	
	`if false`, o comportamento é não fazer nada (ou seja, o código-fonte gerado será igual ao anterior à pré-compilação, ignorando/removendo os scripts em PHP)

## Um detalhe não fundamental

Pensando em simplificar ao máximo para o programador-usuário da biblioteca, o arquivo `lib/debug.php` já se ocupa em importar o `lib/debug.h`. Assim, o programador fica livre de fazer importação duas vezes.

O include em PHP e em C se comportam de maneiras distintas, então talvez seja confuso entender essa parte: ao dar include de `lib/debug.php`, o arquivo `exemplo.c.php` está incluindo em sua saída tudo o que for saída de `lib/debug.php`. Ou seja, o include de `lib/debug.h` (presente na primeira linha de `lib/debug.php`) fará parte do arquivo gerado (`exemplo.c`).

Esse detalhe não é imprenscindível para a compreensão da biblioteca.

## Considerações finais

Estou cansado de escrever esse arquivo (shashhhsaha). Escrevi direto, de uma vez.

*ATUALIZAÇÃO: fiz algumas modificações, para tornar mais compreensível.*

Esse projeto é apenas um exemplo de uso do PHP como gerador de código C, e essa documentação é um esboço.

