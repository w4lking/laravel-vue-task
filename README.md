# Laravel + Vue Task Manager

## 📌 Sobre o Projeto

Este é um sistema de gerenciamento de tarefas. O projeto utiliza **Laravel** no backend com **Vue 3 + Inertia.js** no frontend, oferecendo uma aplicação SPA moderna com recursos para criar, editar e excluir categorias de tarefas.

O objetivo principal é demonstrar habilidades práticas com o stack Laravel + Vue, integrando conceitos de API RESTful, autenticação, rotas protegidas e UI com TailwindCSS e shadcn-vue.

## 🧩 Funcionalidades

- [x] CRUD de categorias de tarefas
- [x] Relacionamento com tarefas (com contagem por categoria)
- [x] Paginação de categorias
- [x] Validação com Form Requests (Laravel)
- [x] Integração com Inertia.js
- [x] Interface moderna com TailwindCSS e shadcn-vue

## 🛠️ Tecnologias Utilizadas

- **Laravel 10** (PHP)
- **Vue 3** + **Composition API**
- **Inertia.js**
- **Vite**
- **TailwindCSS**
- **shadcn-vue**

## 🚀 Como rodar o projeto

```bash
# Clone o repositório
git clone https://github.com/w4lking/laravel-vue-task.git

# Instale as dependências do Laravel
composer install

# Instale as dependências do Node (frontend)
npm install && npm run dev

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Rode as migrações
php artisan migrate

# Inicie o servidor
php artisan serve
