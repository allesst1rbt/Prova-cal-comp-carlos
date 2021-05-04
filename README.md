# Prova-cal-comp-carlos
## observaçôes:
### 1-Projeto requisitado  pela cal-comp
### 2-Crie o  back/.env passando as configurações  presentes no back/.env.example
# Ultilizando com o docker:
## Instalando o docker:
### Windows:
#### 1-Primeiro instale o wsl na sua maquina https://docs.microsoft.com/pt-br/windows/wsl/install-win10
#### 2-Segundo  instale o docker na sua maquina https://docs.docker.com/engine/install/
### Unbutu:
#### 1-https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04-pt
### Manjaro:
#### 1-https://linuxconfig.org/manjaro-linux-docker-installation
# Ultilizando a aplicação:
### 1-Como mencionado acima crie o .env dentro da pasta back e copie as informações do .env.example para ele 
### 2-Adentre a pasta principal pelo terminal e digite docker-compose up -d --build, com isso tanto o back quanto o front seram startados
### 3-Faça as migrations da tabela caso você não queira executar o sql da pasta DUMP, docker exec -it prova-cal-comp-carlos_app_1 php artisan migrate
