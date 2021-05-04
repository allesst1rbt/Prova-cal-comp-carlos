# Prova-cal-comp-carlos
## observaçôes:
### 1-Projeto requisitado  pela cal-comp
### 2-Tenha o docker instalado, se não tiver e caso queira, siga os passos abaixo
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
### 1-Adentre a pasta principal pelo terminal e digite docker-compose up -d --build, com isso tanto o back quanto o front seram startados
### 2-Eu bindei o vue no http://localhost:5001/
### 3-A api foi bindada no http://localhost:8080/
### 4-Para subir as tabelas caso elas não tenham subido você tera que executar docker exec -it prova-cal-comp-carlos_app_1 cd back  && php artisan migrate
### 5-O mysql foi colocado na porta 3099
