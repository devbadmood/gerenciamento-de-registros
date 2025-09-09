# Gerenciador de Registros

![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![jQuery](https://img.shields.io/badge/jQuery-3.7-lightgrey)
![Trumbowyg](https://img.shields.io/badge/Editor-Trumbowyg-blueviolet)
![Status](https://img.shields.io/badge/Projeto-Estável-brightgreen)

Sistema web completo para cadastro, visualização, edição, exclusão e gerenciamento de registros com suporte a conteúdo rico, filtros, histórico de edições, exportação e gráficos analíticos.

---

## Funcionalidades

- Cadastro de registros com título, conteúdo e status
- **Editor Trumbowyg** com suporte a imagens, HTML e formatação avançada
- Visualização detalhada via modal fullscreen
- Edição com rastreabilidade (salva histórico de alterações)
- Exclusão com confirmação
- Paginação dinâmica via AJAX
- Filtros por palavra-chave e data
- Exportação em CSV e PDF
- Painel com gráficos analíticos (Chart.js)
- Feedback visual com animações e expiração automática
- Interface responsiva com Bootstrap 5

---

## Requisitos

- PHP 8.1 ou superior  
- MySQL 8.0 ou superior  
- Servidor Apache ou Nginx  
- Navegador moderno com suporte a JavaScript

---

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/devbadmood/gerenciamento-de-registros.git
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

## Estrutura de Diretórios

```
gerenciador-registros/
├── index.php
├── gerenciamento.php
├── editar.php
├── delete.php
├── update_status.php
├── fetch_all.php
├── fetch_ativos.php
├── exportar_csv.php
├── exportar_pdf.php
├── painel.php
├── historico_ajax.php
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

## Editor Trumbowyg

O sistema utiliza o [Trumbowyg](https://alex-d.github.io/Trumbowyg/) como editor de texto para os campos de conteúdo, oferecendo:

- Formatação rica (negrito, itálico, listas, cabeçalhos)
- Inserção de imagens com upload direto
- Visualização em HTML
- Plugins adicionais como `resizimg` e `upload`
- Interface leve e responsiva

---

## Segurança

- Prepared statements com PDO
- Validação de entrada no backend
- Escapamento de saída com `htmlspecialchars`
- Proteção contra duplicidade de título
- Sanitização leve de conteúdo HTML

---

## Escalabilidade

- Paginação eficiente para grandes volumes
- Suporte a `LONGTEXT` para conteúdos extensos
- Modularização de scripts para manutenção futura
- Histórico de edições com rastreabilidade por registro

---

## Exportação

- Registros podem ser exportados em:
  - CSV (compatível com Excel, LibreOffice, Google Sheets)

---

## Painel Analítico

- Gráficos dinâmicos com [Chart.js](https://www.chartjs.org/)
- Visualização de registros por dia
- Pronto para expansão com filtros e comparativos

---

## Estrutura do Banco de Dados

### Tabela `registros`

```sql
CREATE TABLE registros (
  id INT NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  conteudo LONGTEXT NOT NULL,
  status ENUM('Ativo','Inativo') DEFAULT 'Ativo',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Tabela `historico_edicoes`

```sql
CREATE TABLE historico_edicoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registro_id INT NOT NULL,
  titulo_anterior TEXT,
  conteudo_anterior LONGTEXT,
  editado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (registro_id) REFERENCES registros(id)
);
```

---

## Próximos passos

- Autenticação de usuários e controle de permissões
- Exportação do histórico em PDF
- Comparação visual entre versões editadas
- Notificações automáticas por e-mail

---
