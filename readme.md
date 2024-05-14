# Projeto Mercado

Este é um projeto Mercado que consiste em um aplicativo web com um backend em PHP e um banco de dados PostgreSQL. O zip do front-end em React também está presente na pasta raíz.

## Instalação

1. **Instalar Dependências**: Na pasta raiz do projeto, execute o seguinte comando para instalar as dependências do PHP usando o Composer:

```bash
composer install
```

2. **Executar o Backend**: Na pasta raiz do projeto PHP (backend), execute o seguinte comando para iniciar o servidor embutido do PHP:

```bash
php -S localhost:8080
```

3. **Restaurar Banco de Dados**: Na pasta raiz do projeto, você encontrará o arquivo `mercado.backup`. Execute o seguinte comando para restaurar o banco de dados a partir deste arquivo:

```bash
pg_restore.exe -h localhost -p 5432 -U postgres -d mercado C:\Users\Leonardo\Desktop\mercado\mercado.backup
```

## Uso

Após seguir as etapas de instalação acima, você pode acessar o aplicativo web através do navegador, digitando `http://localhost:8080/?url=api/produto/` na barra de endereços.
