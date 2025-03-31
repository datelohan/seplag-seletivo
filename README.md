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
# API de Lotacoes, Cidades, Enderecos e Unidades

Esta API permite gerenciar as lotações de pessoas em unidades, as cidades, os endereços e as unidades. Todas as requisições exigem autenticação, portanto, é necessário enviar um token no cabeçalho da requisição:

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
  "data": [...],
  "links": {...},
  "meta": {...}
}
```

---

### 2. Listar todas as cidades
**GET** `/cidades`

#### Parâmetros opcionais:
- `per_page` (integer, default: 10) - Número de itens por página.

#### Exemplo de resposta:
```json
{
  "data": [...],
  "links": {...},
  "meta": {...}
}
```

---

### 3. Listar todos os endereços
**GET** `/enderecos`

#### Parâmetros opcionais:
- `per_page` (integer, default: 10) - Número de itens por página.

#### Exemplo de resposta:
```json
{
  "data": [...],
  "links": {...},
  "meta": {...}
}
```

---

### 4. Criar um novo endereço
**POST** `/enderecos`

#### Corpo da requisição (JSON):
```json
{
  "end_tipo_logradouro": "Rua",
  "end_logradouro": "Paulista",
  "end_numero": "1000",
  "cid_id": 1
}
```

#### Resposta de sucesso:
```json
{
  "end_id": 1,
  "end_tipo_logradouro": "Rua",
  "end_logradouro": "Paulista",
  "end_numero": "1000",
  "cid_id": 1,
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:34:56Z"
}
```

---

### 5. Listar todas as unidades
**GET** `/unidades`

#### Parâmetros opcionais:
- `per_page` (integer, default: 10) - Número de itens por página.

#### Exemplo de resposta:
```json
{
  "data": [...],
  "links": {...},
  "meta": {...}
}
```

---

### 6. Criar uma nova unidade
**POST** `/unidades`

#### Corpo da requisição (JSON):
```json
{
  "unid_nome": "Departamento de TI",
  "unid_sigla": "DTI"
}
```

#### Resposta de sucesso:
```json
{
  "unid_id": 1,
  "unid_nome": "Departamento de TI",
  "unid_sigla": "DTI",
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:34:56Z"
}
```

---

### 7. Buscar uma unidade específica
**GET** `/unidades/{unidade}`

#### Exemplo de resposta:
```json
{
  "unid_id": 1,
  "unid_nome": "Departamento de TI",
  "unid_sigla": "DTI",
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:34:56Z"
}
```

---

### 8. Atualizar uma unidade
**PUT/PATCH** `/unidades/{unidade}`

#### Corpo da requisição (JSON):
```json
{
  "unid_nome": "Departamento de Tecnologia da Informação",
  "unid_sigla": "DTI"
}
```

#### Exemplo de resposta:
```json
{
  "unid_id": 1,
  "unid_nome": "Departamento de Tecnologia da Informação",
  "unid_sigla": "DTI",
  "created_at": "2024-03-30T12:34:56Z",
  "updated_at": "2024-03-30T12:45:00Z"
}
```

---

### 9. Deletar uma unidade
**DELETE** `/unidades/{unidade}`

#### Resposta de sucesso:
```json
{
  "message": "Unidade deletada com sucesso"
}
```

---

### 10. Listar servidores efetivos
**GET** `/servidores-efetivos`

#### Parâmetros opcionais:
- `per_page` (integer, default: 10) - Número de itens por página.

#### Exemplo de resposta:
```json
{
  "data": [...],
  "links": {...},
  "meta": {...}
}
```

---

### 11. Buscar servidor efetivo por unidade
**GET** `/servidores-efetivos/unidade/{unid_id}`

#### Exemplo de resposta:
```json
[
  {
    "nome": "João Silva",
    "idade": 45,
    "unidade_lotacao": "Departamento de TI"
  }
]
```

---

### 12. Buscar endereço funcional de um servidor
**GET** `/servidores-efetivos/endereco/{nome}`

#### Exemplo de resposta:
```json
[
  {
    "nome_servidor": "João Silva",
    "unidade": "Departamento de TI",
    "tipo_logradouro": "Rua",
    "logradouro": "Paulista",
    "numero": "1000"
  }
]
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
