# Gerenciador de Registros 🗂️

![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![jQuery](https://img.shields.io/badge/jQuery-3.7-lightgrey)
![Status](https://img.shields.io/badge/Projeto-Estável-brightgreen)

Sistema web completo para cadastro, visualização, edição, exclusão e gerenciamento de registros com suporte a filtros, paginação, exportação e feedback visual dinâmico.



## 🚀 Funcionalidades

- ✅ Cadastro de registros com título, conteúdo e status
- ✅ Visualização detalhada via modal
- ✅ Edição rápida com AJAX
- ✅ Exclusão com confirmação
- ✅ Paginação tradicional com números de página
- ✅ Filtros por palavra-chave e data
- ✅ Exportação em CSV
- ✅ Feedback visual com animações e expiração automática
- ✅ Interface responsiva com Bootstrap 5

---

## 🧰 Requisitos

- PHP 8.1 ou superior  
- MySQL 8.0 ou superior  
- Servidor Apache ou Nginx  
- Navegador moderno com suporte a JavaScript

---

## 📦 Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/seuusuario/gerenciador-registros.git
   ```

2. Importe o banco de dados:
   - Use o arquivo `sql/registrodb_dump.sql` via phpMyAdmin ou terminal MySQL.

3. Configure o acesso ao banco em `db.php`:
   ```php
   $host = 'localhost';
   $db   = 'registrodb';
   $user = 'root';
   $pass = '';
   ```

4. Acesse `index.php` no navegador.

---

## 🗂️ Estrutura de Diretórios

```
gerenciador-registros/
├── index.php
├── gerenciamento.php
├── cadastrar.php
├── editar.php
├── update_status.php
├── delete.php
├── fetch_all.php
├── fetch_ativos.php
├── exportar_csv.php
├── db.php
├── helpers.php
├── assets/
│   ├── css/style.css
│   └── js/
│       ├── spinner.js
│       ├── mensagens.js
│       ├── cadastro.js
│       ├── gerenciamento.js
│       └── filtros.js
└── sql/
    └── registrodb_dump.sql
```

---

## 🛡️ Segurança

- Prepared statements com PDO
- Validação de entrada no backend
- Escapamento de saída com `htmlspecialchars`
- Proteção contra duplicidade de título

---

## 📈 Escalabilidade

- Paginação eficiente para grandes volumes
- Suporte a `LONGTEXT` para conteúdos extensos
- Modularização de scripts para manutenção futura

---

## 📤 Exportação

- Registros podem ser exportados em CSV com um clique
- Compatível com Excel, LibreOffice e Google Sheets

---



> Desenvolvido com ❤️ por DevBadMood

