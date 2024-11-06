2016 - 01, 02, 03, 04,     06, 07, 08, 09, 10, 11, 12
2017 - 01,     03, 04, 05, 06, 07, 08, 09
2018 - 01, 02, 03,     05, 06, 07,     09, 10, 11, 12
2019 -     02, 03,         06,         09, 10,     12
2020 - 01, 02, 03, 04,         07, 08, 09, 10, 11
2021 -         03, 04,     06, 07, 08, 09, 10, 11, 12
2022 - 01, 02, 03, 04, 05, 06,     08, 09, 10, 11, 12
2023 -     02, 03, 04,     06,         09, 10, 11, 12
2024 - 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12


[OK] - PUBLIC
09/05/2016 - 11/05/2016: small-trade-manager
18/10/2017 - 01/11/2017: small-trade-manager
12/04/2018 - 26/04/2018: small-trade-manager
05/08/2019 - 23/08/2019: small-trade-manager
01/05/2020 - 14/06/2020: small-trade-manager

17/02/2017 - website-clima
18/01/2019 - website-clima

04/12/2017 - 28/12/2017: sinteemar 0.0 (TEMPLATE)
07/08/2018 - 31/08/2018: sinteemar 1.0
03/04/2019 - 03/05/2019: sinteemar 1.1
09/07/2019 - 30/07/2019: sinteemar 1.2.0 (TEMPLATE)
25/11/2019 - 26/11/2019: sinteemar 1.2.1 (TEMPLATE)
09/09/2020 - 22/09/2020: sinteemar 2.0

07/12/2020 - 11/12/2020: score
25/01/2021 - 01/02/2021: score

05/05/2021 - 05/05/2021: website-dts

11/07/2022 - 20/07/2022: biblia-online
01/01/2023 - 08/01/2023: delphi-utils
12/05/2023 - 14/05/2023: controle-de-estoque-coopertec
11/07/2023 - 10/08/2023: curso-oracle-plsql (TEMPLATE)


[Prontos] - PUBLIC
hcode-store


[Analisar] - PUBLIC
gpea ?
luizamichi (Precisa mudar para CooperBank) ?
freelance-hours ?

[Fechados] - PRIVATE
hss
fusion
sinteemar 3.0 (este é o 4.0)
oracle-utils
biblioteca-pessoal
house-groceries


[Commit]

# 01. Início do projeto
> 2023-02-20T19:00:00
.gitignore .htaccess README.md composer.json env.php index.php

# 02. Classes úteis
> 2023-02-20T20:00:00
db env.php index.php vendor/amichi/php-classes/composer.json vendor/amichi/php-classes/src/Controller.php vendor/amichi/php-classes/DB/SQL.php vendor/amichi/php-classes/HttpException.php vendor/amichi/php-classes/Mailer.php vendor/amichi/php-classes/Modal.php vendor/amichi/php-classes/Page.php vendor/amichi/php-classes/PageAdmin.php vendor/amichi/php-classes/PageMail.php

# 03. Templates HTML
> 2023-02-21T01:00:00
functions.php index.php res views/admin/footer.html views/admin/header.html views/admin/index.html views/email/welcome.html views/footer.html, views/header.html, views/index.html

# 04. CRUD de países
> 2023-02-21T13:40:00
db vendor/amichi/php-classes/src/Controller.php vendor/amichi/php-classes/src/Model/Country.php vendor/amichi/php-classes/src/View/ContryView.php views/admin/countries.html

# 05. CRUD de estados
> 2023-02-21T21:25:00
db index.php vendor/amichi/php-classes/src/Controller/StateController.php vendor/amichi/php-classes/src/Model/State.php vendor/amichi/php-classes/src/View/StateView.php views/admin/states.html

# 06. CRUD de cidades
> 2023-02-22T07:50:00
db index.php vendor/amichi/php-classes/src/Controller/CityController.php vendor/amichi/php-classes/src/Controller/OtherController.php vendor/amichi/php-classes/src/Model/City.php vendor/amichi/php-classes/src/View/CityView.php views/admin/cities.html

# 07. CRUD de tipos de logradouro
> 2023-02-22T19:05:00
db index.php vendor/amichi/php-classes/src/Controller/StreetTypeController.php vendor/amichi/php-classes/src/Model/StreetType.php vendor/amichi/php-classes/src/View/StreetTypeView.php views/admin/street-types.html

# 08. Contato para sugestões/reclamações
> 2023-02-22T21:40:00
db index.php vendor/amichi/php-classes/src/Controller/ContactController.php vendor/amichi/php-classes/src/Model/Contact.php vendor/amichi/php-classes/src/View/ContactView.php views/admin/contacts.html views/contact.html

# 09. Criação de rotas e funcionalidades úteis para o projeto
> 2023-02-23T07:50:00
env.php index.php vendor/amichi/php-classes/src/Controller/OtherController.php vendor/amichi/php-classes/src/Trait/Encoder.php vendor/amichi/php-classes/src/Trait/Formatter.php vendor/amichi/php-classes/src/Trait/Validator.php vendor/amichi/php-classes/src/View/OtherView.php views/admin/configurations.html views/admin/index.html views/error.html

# 10. CRUD de usuários
> 2023-02-23T22:20:00
db functions.php index.php vendor/amichi/php-classes/src/Controller/UserController.php vendor/amichi/php-classes/src/Model/Person.php vendor/amichi/php-classes/src/Model/User.php vendor/amichi/php-classes/src/View/UserView.php views/admin/register.html views/admin/users-create.html views/admin/users-update.html views/admin/users.html

# 11. Login/logout
> 2023-02-24T07:50:00
index.php vendor/amichi/php-classes/src/Controller/UserController.php vendor/amichi/php-classes/src/View/UserView.php views/admin/login.html

# 12. Restrições de acesso
> 2023-02-24T13:20:00
index.php

# 13. Log de atividades
> 2023-02-24T19:50:00
db index.php vendor/amichi/php-classes/src/Controller/UserController.php vendor/amichi/php-classes/src/Model/UserLog.php vendor/amichi/php-classes/src/View/UserView.php views/admin/users-log.html

# 14. Envio de e-mails com PHPMailer
> 2023-02-25T11:15:00
db index.php vendor/amichi/php-classes/src/Controller/MailController.php vendor/amichi/php-classes/src/Model/Mail.php vendor/amichi/php-classes/src/View/MailView.php views/admin/mails.html

# 15. Recuperação de senha
> 2023-02-25T16:55:00

# 16. Alteração de senha
> 2023-02-25T22:00:00

# 17. CRUD de endereços
> 2023-02-26T16:00:00

# 18. CRUD de produtos
> 2023-02-27T07:50:00

# 19. CRUD de categorias
> 2023-02-27T12:55:00

# 20. Produtos x categorias
> 2023-02-27T21:55:00

# 21. Lista de favoritos
> 2023-02-28T07:50:00

# 22. CRUD do carrinho de compras
> 2023-02-28T21:45:00

# 23. Status do pedido
> 2023-03-01T12:25:00

# 24. CRUD de pedidos
> 2023-03-01T20:00:00

# 25. Integração com o PagSeguro e PayPal
> 2023-03-01T21:40:00

# 26. Seção para posts
> 2023-03-05T16:35:00
db functions.php index.php vendor/amichi/php-classes/src/Controller/SubtopicController.php vendor/amichi/php-classes/src/Controller/TopicController.php vendor/amichi/php-classes/src/Controller/TopicTypeController.php ...

# 27. Collection do Postman
> 2023-03-01T22:40:00


**Certificado emitido 01/03/2023, porém a descrição da Udemy está 02/03/2023**


_Fazer uma plataforma com o Erick em que somente é permitida troca de produtos. Você publica uma biciclita e diz que aceita como troca tanto outra bicicleta de menor/maior valor, ou um celular ou outros._


```sh
find . -name "*:Zone.Identifier" -type f -delete

GIT_AUTHOR_DATE="2023-01-30T19:00:00" GIT_COMMITTER_DATE="2023-01-30T19:00:00" git commit -m "Início do projeto"

GIT_AUTHOR_DATE="2023-01-31T20:10:00" GIT_COMMITTER_DATE="2023-01-31T20:10:00" git commit -m "Classes úteis"

GIT_AUTHOR_DATE="2023-02-01T23:40:00" GIT_COMMITTER_DATE="2023-02-01T23:40:00" git commit -m "Templates HTML"




GIT_AUTHOR_DATE="2023-02-02T19:00:00" GIT_COMMITTER_DATE="2023-02-02T19:00:00" git commit -m "CRUD de países"
GIT_AUTHOR_DATE="2023-02-02T20:20:00" GIT_COMMITTER_DATE="2023-02-02T20:20:00" git commit -m "CRUD de estados"
GIT_AUTHOR_DATE="2023-02-02T21:50:00" GIT_COMMITTER_DATE="2023-02-02T21:50:00" git commit -m "CRUD de cidades"
GIT_AUTHOR_DATE="2023-02-02T23:10:00" GIT_COMMITTER_DATE="2023-02-02T23:10:00" git commit -m "CRUD de tipos de logradouro"




GIT_AUTHOR_DATE="2023-02-03T19:15:00" GIT_COMMITTER_DATE="2023-02-03T19:15:00" git commit -m "Contato para sugestões/reclamações"
GIT_AUTHOR_DATE="2023-02-03T20:05:00" GIT_COMMITTER_DATE="2023-02-03T20:05:00" git commit -m "Criação de rotas e funcionalidades úteis para o projeto"




GIT_AUTHOR_DATE="2023-02-04T10:25:00" GIT_COMMITTER_DATE="2023-02-04T10:25:00" git commit -m "CRUD de usuários"
GIT_AUTHOR_DATE="2023-02-04T11:05:00" GIT_COMMITTER_DATE="2023-02-04T11:05:00" git commit -m "Login/logout"
GIT_AUTHOR_DATE="2023-02-04T18:00:00" GIT_COMMITTER_DATE="2023-02-04T18:00:00" git commit -m "Restrições de acesso"

GIT_AUTHOR_DATE="2023-02-05T08:40:00" GIT_COMMITTER_DATE="2023-02-05T08:40:00" git commit -m "Isolamento dos middlewares"




GIT_AUTHOR_DATE="2023-02-08T19:10:00" GIT_COMMITTER_DATE="2023-02-08T19:10:00" git commit -m "Log de atividades"

GIT_AUTHOR_DATE="2023-02-10T18:50:00" GIT_COMMITTER_DATE="2023-02-10T18:50:00" git commit -m "Envio de e-mails com PHPMailer"




GIT_AUTHOR_DATE="2023-02-11T10:00:00" GIT_COMMITTER_DATE="2023-02-11T10:00:00" git commit -m "Recuperação de senha"

GIT_AUTHOR_DATE="2023-02-11T11:30:00" GIT_COMMITTER_DATE="2023-02-11T11:30:00" git commit -m "Alteração de senha"




GIT_AUTHOR_DATE="2023-02-14T23:55:00" GIT_COMMITTER_DATE="2023-02-14T23:55:00" git commit -m "CRUD de endereços"


GIT_AUTHOR_DATE="2023-02-15T21:35:00" GIT_COMMITTER_DATE="2023-02-15T21:35:00" git commit -m "CRUD de produtos"

GIT_AUTHOR_DATE="2023-02-17T20:10:00" GIT_COMMITTER_DATE="2023-02-17T20:10:00" git commit -m "CRUD de categorias"

GIT_AUTHOR_DATE="2023-02-18T08:30:00" GIT_COMMITTER_DATE="2023-02-18T08:30:00" git commit -m "Produtos x categorias"




GIT_AUTHOR_DATE="2023-02-20T23:45:00" GIT_COMMITTER_DATE="2023-02-20T23:45:00" git commit -m "Lista de favoritos"




GIT_AUTHOR_DATE="2023-02-23T22:05:00" GIT_COMMITTER_DATE="2023-02-23T22:05:00" git commit -m "CRUD do carrinho de compras"




GIT_AUTHOR_DATE="2023-02-25T10:55:00" GIT_COMMITTER_DATE="2023-02-25T10:55:00" git commit -m "Status do pedido"

GIT_AUTHOR_DATE="2023-02-25T12:25:00" GIT_COMMITTER_DATE="2023-02-25T12:25:00" git commit -m "CRUD de pedidos"




GIT_AUTHOR_DATE="2023-02-27T18:45:00" GIT_COMMITTER_DATE="2023-02-27T18:45:00" git commit -m "Integração com o PagSeguro e PayPal"




GIT_AUTHOR_DATE="2023-02-28T19:30:00" GIT_COMMITTER_DATE="2023-02-28T19:30:00" git commit -m "Seção para posts"
GIT_AUTHOR_DATE="2023-02-28T19:55:00" GIT_COMMITTER_DATE="2023-02-28T19:55:00" git commit -m "Collection do Postman"


git push -u origin main
git add -f vendor/amichi/
```