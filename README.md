![Logo da api](/public/images/logo%20trainsys.png)

# API TrainSys

TrainSys é uma api desenvolvida em Laravel 10, onde foi utilizada tambem e biblioteca Dompdf que nos permite criar arquivos em PDF. Este projeto foi criado com o intuito de fazer o cadastro dos usuarios desta api, os mesmo poderão cadastrar estudante, atualizar informações dos estudantes, excluir com softdelete, cadastrar exercícios e desenvolver treinos para o estudantes. Com essa api, conseguimos aprimorar a administração dos estudantes e de seus treinamentos.

## Links das bibliotecas utilizadas no projeto

[PHP](https://www.php.net/)
[Laravel](https://laravel.com/)
[Dompdf](https://github.com/dompdf/dompdf)

## Executando o projeto

Para executarmos essa api precisaremos dos seguintes programas:

[VSCode](https://code.visualstudio.com/) + [github.com/DEVinZucchetti/api_academia](https://github.com/GabrielmValadao/FitManage_Tec) + [Docker desktop](https://www.docker.com/products/docker-desktop/) + [Dbeaver](https://dbeaver.io/)

1. Primeiro teremos que rodar o seguinte comando no seu Powershell, abrir com administrador e rodar o seguinte comando:

docker run --name academia -e POSTGRESQL_USERNAME=admin -e POSTGRESQL_PASSWORD=admin -e POSTGRESQL_DATABASE=api_academia -p 5432:5432 bitnami/postgresql

2. Fazer o download do projeto no link do github

3. Abrir o projeto no VS code, abrir um novo terminal e fazer o seguinte comando:

composer install

este comando irá instalar todas as dependencias do projeto

4. Após isso, fazer a conexão entre o Docker e o Dbeaver, o Dbeaver será a interface do nosso banco de dados
