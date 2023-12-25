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

Por fim, executar a seed para popular o banco de dados

```sh
php artisan db:seed PopulatePlans
```

## Documentação da API

### Endpoint - Rota Usuário

### S01 - Cadastro de usuário

```http
  POST /api/users
```

| Parâmetro  | Tipo     | Descrição                           |
| :--------- | :------- | :---------------------------------- |
| `id`       | `int`    | **Autoincremental**. Chave primaria |
| `name`     | `string` | **Obrigatório**. Nome do usuário    |
| `email`    | `string` | **Obrigatório**. Email do usuário   |
| `password` | `string` | **Obrigatório** Senha do usuário    |

Exemplo de solicitação JSON

```http
  {
    "name": "Henrique Corral",
  "email": "henrique@gmail.com",
  "date_birth": "1998-05-09",
  "cpf": "024.892.561-90",
  "password": "12345678",
  "plan_id": 2
}
```

| Response Status | Descrição       |
| :-------------- | :-------------- |
| `201`           | sucesso         |
| `400`           | dados inválidos |

### Endpoint - Rota Login

### S02 - Login

```http
  POST /api/login
```

Exemplo de solicitação JSON

```http
  {
  "email": "henrique@gmail.com",
  "password": "12345678"
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `token`         | retorno do numero do token, em caso de sucesso |
| `400`           | dados inválidos                                |
| `401`           | login inválido                                 |

### Endpoint - Rota Dashboard

### S03 - Dashboard

```http
  GET /api/dashboard
```

Exemplo de retorno JSON

```http
"registered_students": 1,
  "registered_exercises": 0,
  "current_user_plan": "PRATA",
  "remaining_students": 19
```

### Endpoint - Rotas Exercícios

### S04 - Cadastro de exercícios

```http
  POST /api/exercises
```

| Parâmetro     | Tipo     | Descrição                                                    |
| :------------ | :------- | :----------------------------------------------------------- |
| `id`          | `int`    | **Autoincremental**. Chave primaria                          |
| `description` | `string` | **Obrigatório**. Nome do exercício                           |
| `user_id`     | `string` | **Autoincremental**. Id do usuário que cadastrou o exercício |

Exemplo de solicitação JSON

```http
  {
  "description": "Pulo de corda"
}
```
