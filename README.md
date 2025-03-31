# API SEPLAG

API REST desenvolvida com Laravel 11 para gerenciamento de servidores efetivos.

## Requisitos

- Docker
- Docker Compose
- Git

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/api-seplag-laravel.git
cd api-seplag-laravel
```

2. Inicie os containers Docker:
```bash
docker-compose up -d
```

4. Instale as dependências do Laravel:
```bash
docker-compose exec seplag-app composer install
```

5. Gere a chave da aplicação: caso necessario
```bash
docker-compose exec app php artisan key:generate
```


6. Execute as migrações:
```bash
docker-compose exec seplag-app php artisan migrate
```

8. Crie o bucket no MinIO:
```bash
docker-compose exec minio mc alias set myminio http://localhost:9000 minioadmin minioadmin
docker-compose exec minio mc mb myminio/seplag1
```

## Endpoints da API

### Autenticação
![image](https://github.com/user-attachments/assets/c0c12712-85e5-4aa9-8a77-a284cdb6afc9)

- `POST /api/register` - Registro de usuário
- `POST /api/login` - Login
- `POST /api/logout` - Logout


### Servidores Efetivos

- `GET /api/servidores` - Listar servidores
- `GET /api/endereco_funcional` - Buscar servidor por Endereço Funcional
- `POST /api/servidores` - Criar servidor
- `GET /api/servidores/{id}` - Visualizar servidor
- `PUT /api/servidores/{id}` - Atualizar servidor
- `DELETE /api/servidores/{id}` - Excluir servidor

### Upload de Imagens incompleto,devido ao tempo curto não consegui implementar o envio de imagens para bucket, porém o container foi iniciado

- `POST /api/upload` - Upload de imagem
- `GET /api/upload/{filename}` - Obter URL temporária

## Testando a API



1. Use o Postman, Insomnia ou curl para testar os endpoints:

```bash
# Registro
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password"}'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

2. Configure o Insomnia desta maneira :
  Headers:
  Accept : application/json
  Authorization: Bearer TOKEN

3. EXEMPLOS DE TESTE DA API :
`AA{ "name": "Lohan Date",
	"email":"datelohan@email.com",
"password":"123456789"}` - Envie um POST PARA : 
http://127.0.0.1:8000/api/login retornará seu token
![image](https://github.com/user-attachments/assets/a48c731d-8b27-4009-a097-6c4f4bf7da07)
você ira utilizar esse token, em outras aplicações enviando no Header da requisição
   
## Desenvolvimento

- Laravel 11
- PostgreSQL
- MinIO (S3)
- JWT Authentication
- Docker

## Autor

[Lohan Date]
[datelohan@gmail.com]
[datelohan] 
