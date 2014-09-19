# Owlet CMS
#### v1.0.5
##### PHP >= 5.4.0


**Versão 1.0.5**

Agora você pode habilitar o envio de notificações por e-mail a partir do módulo "Blog" a cada nova publicação.
Esta funcionalidade vem por padrão desabilitada por questões de desempenho e pode ser habilitada dentro de "Blog" > "Configurações" no painel.

A partir da versão 1.0.5 os assinantes do mailing precisarão realizar o cadastro em duas etapas: cadastrar o e-mail e confirmar clicando no link que o sistema envia para o e-mail em questão. Além disso, os e-mails enviados pelo módulo "Mailer" que tiverem a opção "showUnsubscribeLink" incluirão um link para descadastramento do usuário do Mailing.

---

**Versão 1.0.4**

Na versão 1.0.4, você pode facilmente dar um setup inicial no CMS seguindo o passo-a-passo:
+ Defina suas variáveis de banco de dados em src/Lib/Data.php
+ Acesse o link /install para dar início a instalação automática do sistema. Você poderá configurar facilmente dados de e-mail e a conta do administrator root
+ Pronto! Seu CMS está pronto e configurado para uso :)

---

Owlet é um CMS de código aberto em PHP. Utiliza MVC e foi escrito de forma a viabilizar a extensão de bibliotecas, permitindo criar instalações personalizadas e leves.

Esta versão já possui alguns módulos pré-escritos (você pode alterá-los, removê-los ou escrever novos como bem entender).

O front-end do CMS foi criado com Bootstrap 3, baseado no tema DevOOPS (http://devoops.me/handmade/1/)


#### Módulos disponíveis nesta versão
+ Administrators (gerencia contas e sessões de administradores)
+ Banners
+ Blog
+ BlogViews (extensão ao Blog, funciona como um contador de pageviews)
+ Categories (extensão ao Blog, funciona como um organizador de categorias)
+ Comments (extensão ao Blog, funciona como um gerenciador de comentários)
+ Tags (extensão ao Blog, funciona como um gerenciador de tags)
+ Mailing
+ Messages
+ Users (gerencia contas e sessões de usuários)
+ Tickets (gerenciador de chamados online)
+ RSS (leitor de RSS Feeds)

Além dos módulos, o Owlet utiliza algumas extensões externas:

#### Extensões de terceiros disponíveis nesta versão
+ PagSeguro
+ PHPImageWorkshop
+ PHPMailer
+ SimpleCaptcha
+ Password Hashing API (implementação para versões inferiores ao PHP 5.5)
+ SimplePie

#### Extensões nativas disponíveis nesta versão
+ Buscador de CEPs (CEP)
+ Gerenciador de arquivos (Files)
+ Buscador de avatares do Gravatar (Gravatar)
+ Enviador de e-mails (Mailer - facilita o trabalho com o PHPMailer)
+ Notificações no CMS (Messages)
+ Gerenciador de hashes (Security)
+ Gerenciador de strings (Strings)

O objetivo das extensões nativas é facilitar o desenvolvimento e a integração com bibliotecas e webservices externos.

A documentação das classes está disponível em /doc.

Para reportar qualquer bug ou sugerir qualquer melhoria, favor entrar em contato com dave@blogdodave.com.br
