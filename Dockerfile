# Usa a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Copia todos os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Habilita o módulo de reescrita (caso precise no futuro)
RUN a2enmod rewrite

# Expõe a porta 80 para a web
EXPOSE 80
