
# Products Parser

Nesse desafio trabalharemos no desenvolvimento de uma REST API para utilizar os dados do projeto Open Food Facts, que é um banco de dados aberto com informação nutricional de diversos produtos alimentícios.

## Processo de Desenvolvimento

1º Passo - Criar Banco de dados mongoDb

    Utilize o Atlas para criação do banco MongoDb noSql utilizando a própria documentação do mongoDb, uma vez criado realizei alguns testes criando coleções e registros no Atlas para entender melhor o funcionamento do banco de dados noSql. Com o banco criado adicionei os valores de conexão e testei a conexão do banco de dados com meu projeto Laravel.
    
2º Passo - Desenvolver Commando para criação dos produtos
    
    Iniciei realizando as chamadas api aos links disponíveis e entendendo seus retornos. Desenvolvi uma service que distinguiria os novos arquivos dos já importados. A proxima tarefa era descompactação e leitura do arquivo .gz, onde realizei uma pesquisa até encontrar a melhor solução para o meu caso e utilizando a pasta Storage para salvar temporariamente os arquivos.

3º Passo - Adicionar o Schedule

    Utilizei a própria documentação do Laravel para criar um schedule que chamaria o comando diariamente as 23:59.

4º Passo - Definição dos endpoints

    De acordo com os endpoints solicitados foram definidas as rotas e controllers necessários para realizar o fluxo, foi analisado os pontos essenciais do objetivo da tarefa proposta para analisar pontos como o que deveria ser permitido ao usuário atualizar na rota de update, por exemplo. Todo o teste dos endpoints durante desenvolvimento foi feito utilizando o insomnia.

5º Passo - Criação dos testes unitários
    
    Para criar os testes o primeiro passo foi a configuração do banco de testes, a primeira ideia foi utilizar algo semelhante ao sqlite para a realização dos testes. Na investigação ao não encontrar foi utilizada uma instancia de testes do mongoDb. Outro problema encontrado foi para reverter as ações no banco após cada teste uma vez que não seria possivel utilizar 'use databaseTransactions' ou o 'use refreshDatabase', a solução encontrada foi a criação de um arquivo databaseHelper com uma função para limpar as coleções e o uso da função setUp no arquivo de testCase para chamar o databaseHelper a cada execução de teste.
    
6º Passo - Definição de uma API_KEY nos endpoints

    Foi decidido utilizar uma rota para gerar a apiKey atraves de um request que deve conter um email. Após criação da rota e da colection que armazena as apiKey's foi criado um middleware um para validação das chamadas de acordo com um header de 'Authorization'.

## Tecnologias

- Linguagem: Php
- Framework: Laravel
- Tecnologia: MongoDb, FakerPhp, PHPUnit

## Instalação

1. Clone o repositório: `git clone https://github.com/HenriqueTex/Products-Parser`
2. Acesse o diretório do projeto: `cd Products-Parser`
3. Instale as dependências: `npm install` ou `composer install`
4. Configure as variáveis de ambiente: crie um arquivo `.env` e `.env.testing` com base no arquivo `.env.example` e configure as informações necessárias.
6. Inicie o servidor local: `php artisan serve`

## Uso

    Para execução do projeto utilizar o comando 'php artisan schedule:work' para rodar o schedule localmente ou faça a chamada diretamente ao commando utilizando "php artisan app:get-api-data". Gere um apiToken através da rota "api/apiToken" enviando um json com o campo 'email' e utilize o token retornado para autenticar suas chamadas as rotas de index, show, update e delete.
    Para execução dos testes configure a env.testing execute "php artisan test".



## Referência

Esse projeto é um desafio proposto pela [Coodesh](https://coodesh.com/).



