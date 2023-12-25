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

As branchs criadas nesse projeto, foram dividas com a execução de uma branch por atividade e algumas branchs extras para ajustes de bugs ou sintaxe do projetos

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

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### Endpoints - Rotas Exercícios

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

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### S05 - Listagem de exercícios

```http
  GET /api/exercises
```

Exemplo de retorno JSON

```http
{
    "id": 8,
    "description": "Pulo de corda"
  },
  {
    "id": 6,
    "description": "Supino reto"
  }
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### S06 - Deleção de exercícios

```http
  DELETE /api/exercises/:id
```

| Response Status | Descrição                                                                            |
| :-------------- | :----------------------------------------------------------------------------------- |
| `204`           | sucesso                                                                              |
| `409`           | em caso de não ser permitido deletar por haver treinos vinculados ao id do exercício |
| `403`           | em caso do id do exercício criado, não foi criado pelo usuário autenticado           |
| `404`           | em caso do id do exercício não existir no banco de dados                             |

### Endpoints - Rotas Estudantes

### S07 - Cadastro de Estudantes

```http
  POST /api/students
```

| Parâmetro      | Tipo     | Descrição                                                    |
| :------------- | :------- | :----------------------------------------------------------- |
| `id`           | `int`    | **Autoincremental**. Chave primaria                          |
| `name`         | `string` | **Obrigatório**. Nome do estudante                           |
| `email`        | `string` | **Único**. Email do estudante                                |
| `date_birth`   | `date`   | **Opcional**. Data de aniversário do estudante               |
| `cpf`          | `string` | **Único**. Cpf do estudante                                  |
| `contact`      | `string` | Contato do estudante                                         |
| `user_id`      | `int`    | **Autoincremental**. Id do usuário que cadastrou o estudante |
| `city`         | `string` | **Opcional**. Cidade do estudante                            |
| `neighborhood` | `string` | **Opcional**. Bairro do estudante                            |
| `number`       | `string` | **Opcional**. Número da casa do estudante                    |
| `street`       | `string` | **Opcional**. Rua do endereço do estudante                   |
| `state`        | `string` | **Opcional**. Estado                                         |
| `cep`          | `string` | **Opcional**. Cep do estudante                               |
| `complement`   | `string` | **Opcional**. Complemento do endereço                        |

Exemplo de solicitação JSON

```http
  {
  "name": "José da silva",
  "email": "jose@gmail.com",
  "date_birth": "1978-02-20",
  "cpf": "024.892.560-11",
  "contact": "+55 51 99999-1234",
  "cep": "96810-174",
  "street": "Vinte e oito de setembro",
  "state": "RS",
  "neighborhood": "Centro",
  "city": "Santa cruz do sul",
  "complement": "Ao lado da loja pingo",
  "number": "1686"
}
```

| Response Status | Descrição                                        |
| :-------------- | :----------------------------------------------- |
| `201`           | sucesso                                          |
| `400`           | dados inválidos                                  |
| `403`           | em caso de atingir o limite de cadastro do plano |

### S08 - Listagem de Estudantes

```http
  GET /api/students
```

Exemplo de retorno JSON

```http
{
    "id": 26,
    "name": "Bruno Tavares",
    "email": "bruno@gmail.com",
    "date_birth": "1978-02-20",
    "cpf": "024.892.560-00",
    "contact": "+55 51 99999-9943",
    "user_id": 28,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
  {
    "id": 24,
    "name": "Eduardo Teixeira",
    "email": "Eduardo@gmail.com",
    "date_birth": "1978-02-20",
    "cpf": "024.892.560-35",
    "contact": "+55 51 99999-9910",
    "user_id": 28,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
  {
    "id": 21,
    "name": "Fellipe Teixeira",
    "email": "fellipe@gmail.com",
    "date_birth": "1978-02-20",
    "cpf": "024.892.560-10",
    "contact": "+55 51 99999-9990",
    "user_id": 32,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
  {
    "id": 25,
    "name": "Joana Severo",
    "email": "joana@gmail.com",
    "date_birth": "1978-02-20",
    "cpf": "024.892.560-96",
    "contact": "+55 51 99999-9900",
    "user_id": 28,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
  {
    "id": 14,
    "name": "João dias",
    "email": "joao@gmail.com",
    "date_birth": "1978-02-15",
    "cpf": "024.892.560-90",
    "contact": "+55 51 99999-9997",
    "user_id": 28,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "MG",
    "cep": "96810-230",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
  {
    "id": 27,
    "name": "José da silva",
    "email": "jose@gmail.com",
    "date_birth": "1978-02-20",
    "cpf": "024.892.560-11",
    "contact": "+55 51 99999-1234",
    "user_id": 35,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
  {
    "id": 11,
    "name": "Marcio Haeser",
    "email": "marcio@gmail.com",
    "date_birth": "1978-02-10",
    "cpf": "024.892.560-60",
    "contact": "+55 51 99999-9999",
    "user_id": 28,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  }
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### S09 - Deleção de estudante (Soft delete)

```http
  DELETE /api/students/:id
```

| Response Status | Descrição                                                                  |
| :-------------- | :------------------------------------------------------------------------- |
| `204`           | sucesso                                                                    |
| `403`           | em caso do id do exercício criado, não foi criado pelo usuário autenticado |
| `404`           | em caso do id do exercício não existir no banco de dados                   |

### S10 - Atualização de um estudante

```http
  PUT /api/students/:id
```

Exemplo de solicitação JSON

```http
  {
  {
  "state": "MG",
  "cep": "96810-230"
}
}
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### S13 - Listagem de UM Estudante

```http
  GET /api/students/:id
```

Exemplo de retorno JSON

```http
{
    "id": 26,
    "name": "Bruno Tavares",
    "email": "bruno@gmail.com",
    "date_birth": "1978-02-20",
    "cpf": "024.892.560-00",
    "contact": "+55 51 99999-9943",
    "user_id": 28,
    "city": "Santa cruz do sul",
    "neighborhood": "Centro",
    "number": "1686",
    "street": "Vinte e oito de setembro",
    "state": "RS",
    "cep": "96810-174",
    "complement": "Ao lado da loja pingo",
    "deleted_at": null
  },
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### Endpoints - Rotas Treinos

### S11 - Cadastro de Treino

```http
  POST /api/workouts
```

| Parâmetro      | Tipo    | Descrição                                                                     |
| :------------- | :------ | :---------------------------------------------------------------------------- |
| `id`           | `int`   | **Autoincremental**. Chave primaria                                           |
| `student_id`   | `int`   | **Autoincremental**. Id do estudante cadastrado                               |
| `exercise_id`  | `int`   | **Autoincremental**. Id do exercicio cadastrado                               |
| `repetitions`  | `int`   | Número de repetições do exercício                                             |
| `weight`       | `decim` | Peso definido para o exerício                                                 |
| `break_time`   | `int`   | Tempo de descanso                                                             |
| `day`          | `enum`  | Valores: 'SEGUNDA', 'TERCA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO' |
| `observations` | `text`  | **Opcional**. Observação                                                      |
| `time`         | `int`   | Tempo de exercício                                                            |

Exemplo de solicitação JSON

```http
  {
  "exercise_id": 6,
  "student_id": 14,
  "repetitions": 5,
  "weight": 15.5,
  "break_time": 1,
  "day": "QUARTA",
  "observations": "",
  "time": 10
}
```

| Response Status | Descrição                                                                            |
| :-------------- | :----------------------------------------------------------------------------------- |
| `201`           | sucesso                                                                              |
| `400`           | dados inválidos                                                                      |
| `409`           | em caso de não ser permitido deletar por haver treinos vinculados ao id do exercício |

### S12 - Listagem de Treinos do Estudante

```http
  GET /api/students/:id/workouts
```

Exemplo de retorno JSON

```http
{
   "student_id": 14,
  "student_name": "João dias",
  "workouts": {
    "SEGUNDA": [],
    "TERCA": [
      {
        "exercise_id": 6,
        "repetitions": 10,
        "weight": "50.00",
        "break_time": 1,
        "time": 10
      }
    ],
    "QUARTA": [
      {
        "exercise_id": 6,
        "repetitions": 5,
        "weight": "15.50",
        "break_time": 1,
        "time": 10
      }
    ],
    "QUINTA": [],
    "SEXTA": [],
    "SABADO": [
      {
        "exercise_id": 6,
        "repetitions": 10,
        "weight": "50.00",
        "break_time": 1,
        "time": 10
      }
    ],
    "DOMINGO": []
  }
  },
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

### S14 - Exportação de PDF

GET /api/students/export?id=

Exemplo de retorno do PDF
![PDF do treino do estudante](/public/images/pdf_treino_estudante.png)

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

## Projeto final do Módulo 2 : LAB 365 - DevinHouse: Turma Zucchetti

### Autor

| Gabriel Metzdorf Valadão :: [@GabrielmValadao](https://github.com/GabrielmValadao)|
