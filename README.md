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
- `GET /api/endereco_funcional/{nome_funcionario}` - Buscar servidor por Endereço Funcional
- `POST /api/servidores` - Criar servidor
- `GET /api/servidores/{id}` - Visualizar servidor
- `PUT /api/servidores/{id}` - Atualizar servidor
- `DELETE /api/servidores/{id}` - Excluir servidor

### Servidores Temporários

- `GET /api/servidores_temporarios` - Listar servidores
- `POST /api/servidores_temporarios` - Criar servidor
- `GET /api/servidores_temporarios/{id}` - Visualizar servidor
- `PUT /api/servidores_temporarios/{id}` - Atualizar servidor
- `DELETE /api/servidores_temporarios/{id}` - Excluir servidor

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
# API de Lotacoes

Esta API permite gerenciar as lotações de pessoas em unidades. Todas as requisições exigem autenticação, portanto, é necessário enviar um token no cabeçalho da requisição:

**Cabeçalho obrigatório:**
```yaml
Authorization: Bearer {seu_token_aqui}
```

## Endpoints

### 1. Listar todas as lotações
**GET** `/lotacoes`

#### Parâmetros opcionais:
- `per_page` (integer, default: 10) - Número de itens por página.

#### Exemplo de resposta:
```json
{
  "data": [
    {
      "pes_id": 1,
      "unid_id": 2,
      "lot_data_lotacao": "2024-01-01",
      "lot_data_remocao": "2025-01-01",
      "lot_portaria": "Portaria 123",
      "created_at": "2024-03-30T12:34:56Z",
      "updated_at": "2024-03-30T12:34:56Z",
      "url": "http://seusite.com/lotacoes/1"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

### 2. Criar uma nova lotação
**POST** `/lotacoes`

#### Corpo da requisição (JSON):
```json
{
  "pes_id": 1,
  "uni_id": 2,
  "lot_data_lotacao": "2024-01-01",
  "lot_data_remocao": "2025-01-01",
  "lot_portaria": "Portaria 123"
}
```

#### Resposta de sucesso:
```json
{
  "pes_id": 1,
  "uni_id": 2,
  "lot_data_lotacao": "2024-01-01",
  "lot_data_remocao": "2025-01-01",
  "lot_portaria": "Portaria 123",
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:34:56Z"
}
```

---

### 3. Buscar uma lotação específica
**GET** `/lotacoes/{lotacao}`

#### Exemplo de resposta:
```json
{
  "pes_id": 1,
  "unid_id": 2,
  "lot_data_lotacao": "2024-01-01",
  "lot_data_remocao": "2025-01-01",
  "lot_portaria": "Portaria 123",
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:34:56Z",
  "url": "http://seusite.com/lotacoes/1"
}
```

---

### 4. Atualizar uma lotação
**PUT/PATCH** `/lotacoes/{lotacao}`

#### Corpo da requisição (JSON):
```json
{
  "pes_id": 1,
  "uni_id": 2,
  "lot_data_lotacao": "2024-02-01",
  "lot_data_remocao": "2025-02-01",
  "lot_portaria": "Portaria 456"
}
```

#### Exemplo de resposta:
```json
{
  "pes_id": 1,
  "unid_id": 2,
  "lot_data_lotacao": "2024-02-01",
  "lot_data_remocao": "2025-02-01",
  "lot_portaria": "Portaria 456",
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:45:00Z",
  "url": "http://seusite.com/lotacoes/1"
}
```

---

### 5. Deletar uma lotação
**DELETE** `/lotacoes/{lotacao}`

#### Resposta de sucesso:
```json
{
  "message": "Lotação deletada com sucesso"
}
```

   
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
