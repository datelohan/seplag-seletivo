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

2. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

3. Inicie os containers Docker:
```bash
docker-compose up -d
```

4. Instale as dependências do Laravel:
```bash
docker-compose exec app composer install
```

5. Gere a chave da aplicação:
```bash
docker-compose exec app php artisan key:generate
```


6. Execute as migrações:
```bash
docker-compose exec app php artisan migrate
```

8. Crie o bucket no MinIO:
```bash
docker-compose exec minio mc alias set myminio http://localhost:9000 minioadmin minioadmin
docker-compose exec minio mc mb myminio/seplag1
```

## Endpoints da API - todas as rotas
![image](https://github.com/user-attachments/assets/e7a547ee-48b4-4ed3-9a5b-ee47511eac71)
 - para ver mais rotas basta acessar o container, e  rodar o comand php artisan route:list
 - ```bash
   docker exec -it seplag-app bash
   php artisan route:list
```
### Autenticação


- `POST /api/register` - Registro de usuário
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout
- `GET /api/auth/me` - Informações do usuário
- `POST /api/auth/refresh` - Atualizar token

### Servidores Efetivos

- `GET /api/servidores` - Listar servidores
- `POST /api/servidores` - Criar servidor
- `GET /api/servidores/{id}` - Visualizar servidor
- `PUT /api/servidores/{id}` - Atualizar servidor
- `DELETE /api/servidores/{id}` - Excluir servidor

### Upload de Imagens

- `POST /api/upload` - Upload de imagem
- `GET /api/upload/{filename}` - Obter URL temporária

## Testando a API

1. Acesse a documentação da API:
```
http://localhost:8000/api/documentation
```

2. Use o Postman ou curl para testar os endpoints:

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

## Desenvolvimento

- Laravel 11
- PostgreSQL
- MinIO (S3)
- JWT Authentication
- Docker

## Autor

[Seu Nome]
[Seu Email]
[Seu GitHub] 
