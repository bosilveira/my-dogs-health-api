# json-server-base

Esse é o repositório com a base de JSON-Server + JSON-Server-Auth já configurada, feita para ser usada no desenvolvimento das API's nos Capstones do Q2.

## Endpoints

Assim como a documentação do JSON-Server-Auth traz (https://www.npmjs.com/package/json-server-auth), existem 3 endpoints que podem ser utilizados para cadastro e 2 endpoints que podem ser usados para login.

### Cadastro

POST /register <br/>

Este endpoint irá cadastrar o usuário na lista de "Users", sendo que os campos obrigatórios são os de email e password.
Você pode ficar a vontade para adicionar qualquer outra propriedade no corpo do cadastro dos usuários.

### Login

POST /login <br/>
POST /signin

Qualquer um desses 2 endpoints pode ser usado para realizar login com um dos usuários cadastrados na lista de "Users"

### Dogs

POST /dogs

este endpoint é responsavel por adicionar um cachorro, voce precisa do seu id de usuario para cadastrar.

GET /users/:id?\_embed=dogs

este endpoint é responsavel por trazer todas as informações do usuário e os dogs cadastrados.

GET /dogs/:idDog

este endpoint é responsavel por lsitar um dog especifico, voce precisa do id do dog e tambem do token.

PATCH /dogs/:idDog

este endpoint é responsavel por editar as informações do seu dog, voce pode mudar todas as informações ou somente a que desejar. Tenha em mãos o id do dog e seu token.

DELETE /dogs/:idDog

este endpoint é responsavel por deletar um dog especifico, voce precisa passar o id do dog e ter seu token.
