![Logo da api](/public/images/logo%20trainsys.png)

# API TrainSys

TrainSys é uma api desenvolvida em Laravel 10, onde foi utilizada tambem e biblioteca Dompdf que nos permite criar arquivos em PDF. Este projeto foi criado com o intuito de fazer o cadastro dos usuarios desta api, os mesmo poderão cadastrar estudante, atualizar informações dos estudantes, excluir com softdelete, cadastrar exercícios e desenvolver treinos para o estudantes. Com essa api, conseguimos aprimorar a administração dos estudantes e de seus treinamentos.

## Links das bibliotecas utilizadas no projeto

[PHP](https://www.php.net/)
[Laravel](https://laravel.com/)
[Dompdf](https://github.com/dompdf/dompdf)

## Vídeo de apresentação:

https://drive.google.com/file/d/1J8idnq3bmrF4DvYrHo8_zUEcDXuwiIp8/view?usp=drive_link

## Modelagem da base de dados PostgreSQL

Foi utilizado o app https://dbdiagram.io/ para modelagem prévia da base postgres.

Acesse a documentação do modelo: https://dbdiagram.io/d/FitManage_Tech-6578de3c56d8064ca0e811f3

![Modelagem Dbdiagram](/public/images/FitManage_Tech_dbdiagram.png)

## Executando o projeto

Para executarmos essa api precisaremos dos seguintes programas:

[VSCode](https://code.visualstudio.com/) + [github.com/DEVinZucchetti/api_academia](https://github.com/GabrielmValadao/FitManage_Tec) + [Docker desktop](https://www.docker.com/products/docker-desktop/) + [Dbeaver](https://dbeaver.io/)

-Clonar o repositório https://github.com/GabrielmValadao/FitManage_Tec

-Criar uma base de dados no Docker com nome api_academia

teremos que rodar o seguinte comando no seu Powershell, abrir com administrador e rodar o seguinte comando:

docker run --name academia -e POSTGRESQL_USERNAME=admin -e POSTGRESQL_PASSWORD=admin -e POSTGRESQL_DATABASE=api_academia -p 5432:5432 bitnami/postgresql

-Criar um arquivo .env na raiz do projeto com os seguintes parametros:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=academia_api
DB_USERNAME=admin
DB_PASSWORD=admin'
```

Abrir um novo terminal e fazer o seguinte comando:

```sh
composer install
```

O comando composer install irá instalar todas as dependencias do projeto

Após isso, fazer a conexão entre o Docker e o Dbeaver, o Dbeaver será a interface do nosso banco de dados

Executar em seguida em um novo terminal no projeto:

```sh
php artisan serve
```

## Documentação da API
