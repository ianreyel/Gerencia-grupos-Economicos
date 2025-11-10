# 🚀 Projeto de Gestão de Colaboradores e Unidades

Este projeto é um sistema de gestão de recursos humanos e unidades, desenvolvido com **Laravel 10+** e **Livewire 3**. O foco está na implementação de **CRUDs**, **Relatórios**, **Exportação para Excel**, e um robusto **Controle de Acesso (Policies)** e **Auditoria**.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

---

## 🎯 Requisitos Implementados

O projeto atende integralmente a todos os requisitos funcionais solicitados:

| Requisito | Funcionalidade | Detalhe |
| :--- | :--- | :--- |
| **2.a, 2.b, 2.c** | CRUD Completo | Criação, Leitura, Atualização e Deleção para **Grupo Econômico**, **Bandeira**, **Unidade** e **Colaborador**. |
| **2.d** | Relatório Geral | Componente Livewire para **Relatório de Colaboradores** com filtros por Grupo, Bandeira e Unidade. |
| **2.e** | Auditoria e Histórico | Implementação do `laravel-auditing` para registrar todas as operações de **CREATE, UPDATE, DELETE** nos Models. |
| **2.f** | Controle de Acesso (RBAC) | Segurança baseada em **Policies** do Laravel, restringindo operações de modificação **apenas a usuários administradores (`is_admin = 1`)**. |
| **2.g** | Exportação para Excel | Funcionalidade integrada ao Relatório Geral para exportação dos dados filtrados no formato `.xlsx`. |

---

## ⚙️ Guia de Instalação Local (Ambiente XAMPP)

Este guia assume que você está utilizando o **XAMPP** para gerenciar o ambiente Apache e MySQL.

### 1. Requisitos Prévios

| Ferramenta | Necessidade |
| :--- | :--- |
| **XAMPP** | Servidor Apache e MySQL. |
| **PHP** | Versão 8.1 ou superior. |
| **Composer** | Gerenciador de dependências PHP. |
| **Node.js & NPM** | Para gerenciar e compilar assets front-end. |

### 2. Instalação de Dependências

1.  **Crie um projeto Laravel e clone o repositório** na pasta `htdocs` e navegue até o diretório do projeto, pode ser realizada a subistituição dos respectivos arquivos pelos do repositorio
    ```bash
    cd c:\xampp\htdocs\ 
    composer create-project laravel/laravel nome-do-seu-projeto
    ```

3.  **Instale as dependências PHP** (Composer), incluindo as bibliotecas de Auditoria e Excel:
    ```bash
    # Dependências padrões
    composer install
    
    # Instala a biblioteca de Auditoria (OwenIt\Auditing)
    composer require owen-it/laravel-auditing
    
    # Instala a biblioteca de Exportação para Excel (Maatwebsite\Excel)
    composer require maatwebsite/excel
    ```

4.  **Instale e compile os assets Front-end** (NPM):
    ```bash
    npm install
    npm run dev
    ```

### 3. Configuração do Ambiente e Banco de Dados

1.  O arquivo de ambiente (`.env`), vem por padrão na instalação do laravel via composer ele ja vem configurado por padrão para o XAMPP, caso não conecte no seu banco configure suas credenciais no mesmo (usuario e senha).


2.  Crie o banco de dados executando a migração:
    ```bash
    php artisan migrate
    ```

3.  **Ajustes Adicionais de Banco de Dados:**
    * Existe um arquivo neste repositorio chamado `alteracoes Banco de dados.txt`, **execute o conteúdo deste arquivo diretamente no MySQL/PHPMyAdmin** para garantir a funcionalidade do sistema, pois nele esta armazenado as tabelas adicionais do projeto.

### 4. Configuração do Usuário Administrador (Segurança)

O sistema de segurança exige que a permissão de administração seja definida diretamente no banco de dados.

1.  Acesse a aplicação e realize o **registro** de um novo usuário.
2.  Acesse o **PHPMyAdmin** ou o cliente SQL.
3.  Vá para a tabela **`users`**.
4.  Localize o seu usuário e **altere o valor da coluna `is_admin` de `0` para `1`**.

Após esta etapa, o usuário terá acesso total (CRUD, Auditoria e Relatórios) ao sistema.

### 5. Executar a Aplicação

Inicie o servidor local do Laravel:

```bash
php artisan serve
```
Em caso de duvida no item 1 pode se acompanhar o video a baixo que mostra a instalação padrão do Laravel:
https://www.youtube.com/watch?v=f8Dd1GJFZJk&t=1s

