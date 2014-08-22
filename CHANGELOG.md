# CHANGELOG

## 22/08/2014
### Atualização no módulo Blog (v1.0.3)
+ Inclusão do método getRSS(), que retorna os posts do blog formatados em XML para RSS Feeds
+ Criação do arquivo /blogrss.php para visualização do RSS
+ Atualização das configurações do blog em config.xml
+ Implementação da API de senhas do PHP 5.5 para versões inferiores.

## 21/08/2014
### Melhorias no módulo Blog
+ Melhoria no campo *Tags* do módulo Blog. Agora as tags conhecidas são exibidas logo abaixo do input e podem ser clicadas
+ Correção no código de armazenamento de tags

## 14/08/2014
### Remoção de arquivos de teste e implementação de nova extensão
+ Arquivos de teste em templates/Examples removidos
+ Extensão Weather implementada (previsão do tempo)

## 13/08/2014
### Implementação do indicador de pagina ativa no menu da sidebar
+ Atualização do Controller principal (v1.0 > v1.0.1)

## 13/08/2014
### Atualizações diversas
+ Remoção do arquivo admin/js/devoops.min.js
+ Atualização da extensão Mailer (v dev1.0 > v1.0)
+ Documentação revisada
+ Atualização do módulo Blog (v1.0.1 > v1.0.2)
  + Ativação da função de disparo de e-mail notificativo para assinantes do Mailing

## 13/08/2014
### Atualização do módulo Blog (v1.0 > v1.0.1)
Bug corrigido:
+ Ao publicar/salvar um post, as tags do mesmo não eram armazenadas;

## 12/08/2014
### Versão inicial implementada

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

#### Extensões de terceiros disponíveis nesta versão
+ PagSeguro
+ PHPImageWorkshop
+ PHPMailer
+ SimpleCaptcha

#### Extensões nativas disponíveis nesta versão
+ Buscador de CEPs (CEP)
+ Gerenciador de arquivos (Files)
+ Buscador de avatares do Gravatar (Gravatar)
+ Enviador de e-mails (Mailer - facilita o trabalho com o PHPMailer)
+ Notificações no CMS (Messages)
+ Gerenciador de hashes (Security)
+ Gerenciador de strings (Strings)
