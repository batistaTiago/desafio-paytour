# Desafio Paytour - Solucao por Tiago Batista

Para rodar o sistema, deve-se seguir os passos definidos no arquivo `initial-setup.sh`.

Para rodar os testes: `docker-compose exec php bash -c "php artisan config:clear && ./vendor/bin/phpunit ./tests"` (podendo passar a flag `--testdox` opcionalmente);

Para acessar a aplicação, deve-se utilizar a URL: http://localhost:8002. A porta exposta, por padrão, é a 8002 mas isso pode ser configurado no arquivo docker-compose.yml, dentro do serviço nginx.

Estou incluindo, dentro da pasta `src`, o arquivo `.env`, que inclui todas as variáveis de ambientes necessárias para rodar o sistema. Nele, estão as credenciais para conectar no banco local que usei para o desenvolvimento (as mesmas que estão definidas no arquivo `docker-compose.yml`, dentro do serviço mysql). O nome do banco em questão foi 'paytour', mas pode ser ajustado conforme a preferência.

Obs: para o envio de email funcionar corretamente, deve-se preencher as variaveis relacionadas ao serviço de emails.