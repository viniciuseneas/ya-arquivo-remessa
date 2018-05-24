# ya-arquivo-remessa

### Versão 0.3

* Biblioteca para geração de arquivos de remessa.


| Banco        | Carteira     | done?        |
|------------- | -------------| -------------|
| Bradesco     | 09           | X            |
| Banco do Brasil     | 17           | X            |
| SICOOB       |              
| CEF |

###Sequence Diagram
                    
```seq
Ator->RemessaFactory: chama create() 
RemessaFactory->Validator: run()
Validator-->Validator: compara dados\n obrigatorios
Validator-->Ator: throw exception dados obrigatorios
RemessaFactory-->RemessaFactory: Valida caminho\n do arquivo
RemessaFactory-->Ator: thow exception caminho\n invalido ou acesso negado
RemessaFactory-->RemessaFactory: configure() define build de\n acordo com banco
RemessaFactory-->Ator: throw exception \nbanco nao localizado
RemessaFactory-->RemessaFactory: build() chamada ao builder
RemessaFactory->(BB/CEF/BRADESCO)\nBuilder: builder()
(BB/CEF/BRADESCO)\nBuilder-->(BB/CEF/BRADESCO)\nBuilder: preenche dados do header
(BB/CEF/BRADESCO)\nBuilder-->(BB/CEF/BRADESCO)\nBuilder: preenche dados do trailler
(BB/CEF/BRADESCO)\nBuilder-->(BB/CEF/BRADESCO)\nBuilder: preenche dados do detalhe/transacao
(BB/CEF/BRADESCO)\nBuilder-->RemessaFactory: retorna (BB/CEF/BRADESCO)\nBuilder
RemessaFactory->(BB/CEF/BRADESCO)\nBuilder: montarArquivo()
(BB/CEF/BRADESCO)\nBuilder-->Ator: throw exception sem acesso ao arquivo
(BB/CEF/BRADESCO)\nBuilder-->(BB/CEF/BRADESCO)\nBuilder: monta arquivo\nde remessa
(BB/CEF/BRADESCO)\nBuilder->RemessaFactory: string caminho do arquivo;
RemessaFactory->Ator: retorna string caminho do arquivo
```