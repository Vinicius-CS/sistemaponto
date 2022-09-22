# Sistema Ponto
Sistema de ponto com cadastro de colaboradores e registro de entrada/saída em PHP, HTML, CSS e JavaScript.

## Requisitos

 - MariaDB 10.4.24
 - PHP 8.1.6^
 - [Xampp 8.1.6](https://www.apachefriends.org/pt_br/download.html)

## Configuração

 - Clone o repositório
 - Importe a SQL disponível em [backend/sistema_ponto.sql](https://github.com/Vinicius-CS/sistemaponto/blob/main/backend/sistema_ponto.sql)
 - Configure a conexão com o banco de dados em [backend/connection.php](https://github.com/Vinicius-CS/sistemaponto/blob/main/backend/connection.php)
 - Configure o arquivo .env em [frontend/.env](https://github.com/Vinicius-CS/sistemaponto/blob/main/frontend/.env), alterando `localhost` pelo IP do servidor

## Login
|Nome|E-Mail|Senha|Habilitado|Administrador|
|--|--|--|--|--|
|`Administrador`|`administrador@sistemaponto.com`|`admin`|`Sim`|`Sim`|
|`Colaborador 1`|`colaborador1@sistemaponto.com`|`123`|`Não`|`Não`|
|`Colaborador 2`|`colaborador2@sistemaponto.com`|`123`|`Sim`|`Não`|
|`Colaborador 3`|`colaborador3@sistemaponto.com`|`123`|`Não`|`Sim`|
