# 🎬 PlataformaFilme

Aplicação web para gerenciamento de filmes, desenvolvida como projeto pessoal para praticar e integrar tecnologias de **frontend, backend, banco de dados e APIs**.

## 🚀 Tecnologias

### Backend
- PHP
- Laravel
- MySQL
- Docker
- REST API
- Hashids

### Frontend
- Vue.js
- Quasar Framework
- JavaScript

### Ferramentas
- Git
- GitHub
- Docker Compose

## 📌 Funcionalidades

- Cadastro de filmes
- Listagem de filmes
- Consulta de filmes
- Atualização de filmes
- Exclusão de filmes
- Upload de capas
- Comunicação entre frontend e backend através de API REST
- Identificação dos filmes utilizando Hashids

## 🏗️ Estrutura do projeto

```text
PlataformaFilme/
├── beck/       # Backend - Laravel
└── front/      # Frontend - Vue + Quasar
```

## ⚙️ Como executar

### Backend

Entre na pasta do backend:

```bash
cd beck
```

Instale as dependências:

```bash
composer install
```

Configure o arquivo `.env` a partir do `.env.example`:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Suba os containers:

```bash
docker compose up -d
```

Execute as migrations:

```bash
php artisan migrate
```

### Frontend

Entre na pasta do frontend:

```bash
cd front
```

Instale as dependências:

```bash
npm install
```

Execute o projeto:

```bash
npm run dev
```

## 🎯 Objetivo

Este projeto está sendo desenvolvido como forma de aprendizado, com o objetivo de colocar em prática conceitos de desenvolvimento web, criação e consumo de APIs, banco de dados, Docker, Git e desenvolvimento de interfaces.

## 👨‍💻 Autor

**Jorge Ferreira da Silva Júnior**

Estudante de Ciência da Computação na UFMG.
