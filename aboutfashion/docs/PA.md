# PA: Product and Presentation

>Oferecer aos adultos, uma alternativa mais prática e inovadora de adquirir artigos de moda de qualidade.

## A9: Product

>O produto desenvolvido pela nossa equipa consiste num *site* de venda *online* de vestuário, calçado e acessórios para adulto. Foi utilizada a *framework* Laravel para o desenvolvimento da aplicação e utilizamos bootstrap, em complemento, para o *frontend* da aplicação.

### 1. Installation

>Link para a versão final presente no repositório Git do grupo está disponivel [aqui](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/tree/PA).
>
>Comando Docker para iniciar a imagem disponível no Container Registry do Git do grupo, que utiliza a base de dados de produção:
```
docker run -it -p 8000:80 --name=lbaw2251 -e DB_DATABASE="lbaw2251" -e DB_SCHEMA="lbaw2251" -e DB_USERNAME="lbaw2251" -e DB_PASSWORD=xxJlDZqv git.fe.up.pt:5050/lbaw/lbaw2223/lbaw2251
```
```
docker exec -it lbaw2251 bash
```
```
root@2804d54698c0:/# tail -f /var/log/nginx/error.log    # follow the errors
root@2804d54698c0:/# tail -f /var/log/nginx/access.log   # follow the accesses
```
### 2. Usage

> URL para o produto: http://lbaw2251.lbaw.fe.up.pt

#### 2.1. Administration Credentials

> Administration URL: <strong>/admin-panel</strong>.
> 
> Primeiro é necessário efetuar *login* em <strong>/admin-panel/login</strong> e depois é feito o redirecionamento para <strong>/admin-panel</strong>.
>
>| Type | E-mail | Password |
>| ---- | ------ | -------- |
>| Collaborator | kgrishanov2@twitter.com | teste12345 |
>| Technician | up202006562@up.pt | teste12345 |

#### 2.2. User Credentials

>| Type | E-mail | Password |
>| ---- | ------ | -------- |
>| example account | mmonkman0@sfgate.com | teste12345 |

### 3. Application Help
> No login e registo de novos dos utilizadores existem mensagens de ajuda e orientação para o utilizador durante o preenchimento dos campos pretendidos. Alguns exemplos são os seguintes:
> - Preenchimento de campos no login
> ![](https://i.imgur.com/HvabTS5.png)
> 
> - Preenchimento de campos no register
> ![](https://i.imgur.com/hgf50Zo.png)
>
> - Preenchimentos de campos na criação de uma morada
> ![](https://i.imgur.com/tfZ2IDu.png)
>
> Caso algum utilizador necessite de ajuda, existe uma página *help* onde poderá consultar as respostas às perguntas mais frequentes. Também existe a possibilidade de enviar uma questão através do formulário abaixo.
>
> ![](https://i.imgur.com/WOJFHxp.png)
> 
> Describe where help has been implemented, pointing to working examples.  

### 4. Input Validation

> Com o objetivo de validar os inputs do utilizadpr foram criados algoritmos do lado do cliente antes de enviar para o servidor.
![](https://i.imgur.com/QUoGZMJ.png)

![](https://i.imgur.com/elHF3NK.png)

> Em relação ao lado do servidor, o Laravel inclui uma ampla variedade de regras de validação que podem ser aplicadas aos dados, concentrando-se na função validate.Sendo assim, a nível do servidor verificamos também os inputs do utilizador com este método.  

![](https://i.imgur.com/uuPDGaA.png)


### 5. Check Accessibility and Usability

> Accessibility: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/blob/development/pdfs/Checklist_de_Acessibilidade.pdf  
> Usability: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/blob/development/pdfs/Checklist_de_Usabilidade.pdf  

### 6. HTML & CSS Validation

> Não conseguimos proceder à validação do HTML e do CSS.
>
> Provide the results of the validation of the HTML and CSS code using the following tools. Include the results as PDF files in the group's repository. Add individual links to those files here.
>   
> HTML: https://validator.w3.org/nu/  
> CSS: https://jigsaw.w3.org/css-validator/  

### 7. Revisions to the Project

> Desde a etapa de especificação de requisitos foram feitas as seguintes alterações ao projeto:
>- Eliminação da user story: Gerir pagamentos;
>- Eliminação da user story: Gerir vouchers.

### 8. Web Resources Specification

Tendo em conta que o último relatório ficou muito extenso devido ao tamanho do ficheiro `a7_openapi.yaml`, decidimos apresentar apenas a parte introdutória. O ficheiro `a9_openapi.yaml` completo encontra-se em https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/blob/development/aboutfashion/docs/a9_openapi.yaml. 

```yaml
openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW About Fashion Web API'
  description: 'Web Resources Specification (A7) for About Fashion'

servers:
  - url: http://lbaw2251.fe.up.pt/
    description: Production server

externalDocs:
  description: Find more info here.
  url: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/wikis/

tags:
  - name: 'M01: Authentication'
  - name: 'M02: Personal Profile'
  - name: 'M03: Administration'
  - name: 'M04: Products and Promotions'
  - name: 'M05: Orders and Wishlist'
  - name: 'M06: Reviews and Reports'
  - name: 'M07: Pages'
...
```

### 9. Implementation Details

#### 9.1. Libraries Used

> [Notifications](https://laravel.com/docs/9.x/notifications):
> - Utilizado para enviar notificações para os utilizadores (como por exemplo quando um produto desejado pelo utilizador baixou de preço).
> 
> [Response](https://laravel.com/docs/9.x/responses):
> - Utilizado para gerir repostas do servidor aos pedidos dos clientes.
> 
> [Auth](https://laravel.com/docs/9.x/authentication):
> - Utilizado para autenticar utilizadores e admins, gerindo as suas sessões no *web site*.
> 
> [Validator](https://laravel.com/docs/9.x/validation):
> - Utilizado para validar informações fornecidas pelo utilizador em campos de preenchimento quando se faz um registo de novo utilizador, criação de uma morada, novo produto, etc.
> 
> [Redirect](https://laravel.com/docs/9.x/redirects):
> - Utilizado no redirecionamento entre diversas páginas, como por exempplo no depois do preenchimento de formulários de criação ou edição de produtos. 

#### 9.2 User Stories

>|US Identifier|Name|Module|Priority|Team Members|State|
>|---|---|---|---|---|---|
>|US13|Página *About US*|M07: Pages|Média|**Sofia**|100%|
>|US14|Funcionalidades principais|M07: Pages|Média|**Sofia**|100%|
>|US15|Contactos|M07: Pages|Média|**Sofia**|100%|
>|US28|Apagar conta|M02: Personal Profile|Média|**Alexandre, Daniel**|100%|
>|US11|Mensagens de erro contextuais|M07: Pages|Média|**Daniel, Sofia**|100%|
>|US12|Ajuda contextual|M07: Pages|Média|**Daniel, Sofia**|100%|
>|US43|Gerir vários métodos de pagamento|M02: Personal Profile|Baixa|**Alexandre, Daniel**|100%|
>|US45|Admin - Possuir conta|M03: Administration|Média|**Daniel**|100%|
>|US46|Admin - Iniciar sessão|M03: Administration|Média|**Daniel**|100%|
>|US47|Admin - Terminar sessão|M03: Administration|Média|**Daniel**|100%|
>|US16|Ver menu de categorias|M04: Products and Promotions|Média|**Sofia, Daniel**|100%|
>|US57|Bloquear contas de utilizadores|M03: Administration|Média|**Diogo, Daniel**|100%|
>|US58|Desbloquear contas de utilizadores|M03: Administration|Média|**Diogo, Daniel**|100%|
>|US59|Eliminar contas de utilizadores|M03: Administration|Média|**Diogo, Daniel**|100%|
>|US09|Filtros de pesquisa|M04: Products and Promotions|Média|**Sofia**|100%|
>|US35|Seguir encomenda|M05: Orders and Wishlists|Média|**Alexandre**|100%|
>|US21|Recuperar password|M01: Authentication|Média|**Daniel**|100%|
>|US08|Pesquisa em múltiplos atributos|M04: Products and Promotions|Média|**Sofia, Daniel**|100%|
>|US27|Possuir foto de perfil|M02: Personal Profile|Média|**Alexandre**|100%|
>|US17|Ver *reviews* do produto|M06: Reviews and Reports|Média|**Sofia**|100%|
>|US52|Ver histórico de compras dos utilizadores|M05: Orders and Wishlists|Média|**Diogo**|100%|
>|US30|Adicionar artigo à lista de favoritos|M05: Orders and Wishlists|Média|**Daniel, Sofia**|100%|
>|US34|Remover *review*|M06: Reviews and Reports|Média|**Alexandre**|100%|
>|US55|Gerir descontos de artigos|M04: Products and Promotions|Baixa|**Diogo**|100%|
>|US51|Gerir as categorias de artigos|M04: Products and Promotions|Média|**Diogo**|100%|
>|US31|Gerir lista de favoritos|M05: Orders and Wishlists|Média|**Daniel, Sofia**|100%|
>|US18|Ordenação de resultados|M04: Products and Promotions|Baixa|**Sofia, Daniel**|100%|
>|US32|*Review* de artigo adquirido|M06: Reviews and Reports|Média|**Alexandre, Daniel**|100%|
>|US33|Editar *review*|M06: Reviews and Reports|Média|**Alexandre, Daniel**|100%|
>|US10|Formulários de ajuda|M07: Pages|Média|**Daniel, Sofia**|100%|
>|US49|Gerir a informação dos produtos|M04: Products and Promotions|Média|**Diogo**, Alexandre|100%|
>|US48|Adicionar artigo|M04: Products and Promotions|Média|**Diogo, Alexandre**|100%|
>|US53|Controlar o estado das encomendas|M05: Orders and Wishlists|Média|**Diogo**|100%|
>|US36|Cancelar encomenda|M05: Orders and Wishlists|Média|**Daniel, Sofia**|100%|
>|US60|Gerir *reports*|M06: Reviews and Reports|Baixa|**Diogo, Daniel**|100%|
>|US29|Ver notificações pessoais|M02: Personal Profile|Média|**Sofia, Daniel**|100%|
>|US37|Notificação - Pagamento pendente|M02: Personal Profile|Média|**Daniel**|100%
>|US38|Notificação - Mudança de estado de encomenda|M02: Personal Profile|Média|**Daniel**|100%|
>|US39|Notificação - Produto na lista de favoritos disponível|M02: Personal Profile|Média|**Daniel**|100%
>|US40|Notificação - Mudança de preço do artigo no carrinho de compras|M02: Personal Profile|Média|**Daniel**|100%
>|US50|Gerir o *stock* dos produtos|M04: Products and Promotions|Média|**Diogo, Daniel**|100%|
>|US44|Reportar *review*|M06: Reviews and Reports|Baixa|**Diogo**|80%|
>|US54|Ver estatísticas de vendas|M03: Administration|Baixa|--|0%|
>|US42|Recomendações de produtos|M02: Personal Profile|Baixa|--|0%|
>|US54|Ver estatísticas de vendas|M03: Administration|Baixa|--|0%|

---

## A10: Presentation
 
> Neste artefacto é apresentado o produto desenvolvido, bem como uma pequena descrição das funcionalidades principais do sistema.

### 1. Product presentation

>O nosso produto trata-se de um *web site* de venda de roupa, acessórios e calçado, direcionado a adultos. Esta plataforma permite aos utilizadores estar facilmente a par dos artigos/promoções disponíveis no momento. Do ponto de vista do cliente é possível ver produtos em que poderá estar interessado, realizar compras online e gerir todos os seus dados presentes na sua conta. Já em termos administrativos, é possível gerir utilizadores, adicionar produtos e promoções e tratar da logística comercial. É necessária uma equipa de administradores para gerir o sistema e certificar o seu bom funcionamento.
>
>
> URL para produto final: http://lbaw2251.lbaw.fe.up.pt
> (Acesso restrito com a utilização da VPN FEUP)


### 2. Video presentation

![](https://i.imgur.com/hbv1xoK.jpg)

Link para o vídeo da demo: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/blob/development/video%20demo/video_demo.mp4

---

## Revision history

- 04/12/2022 - foi feita uma base para o desenvolvimento do artefacto PA.
- 15/12/2022 a 02/01/2023 - a tabela de progresso dos *user stories* foi alterada durante este intervalo de tempo em concordância com o desenvolvimento das funcionalidades do produto.
- 03/01/2023 - foi introduzido o open_api alterado para o produto final; foram incluídas as secções *aplication help*, *input validation*, *check accessibility and usability*, *HTML & CSS validation*; foram indicadas todas as alterações que foram feitas ao produto e por final foram adicionados os elementos da secção da apresentação, tais como, pequena introdução para contextualização e video da demo.

---

GROUP2251, 03/01/2023

* Membro 1 - Alexandre Correia, up202007042@edu.fe.up.pt (Editor)
* Membro 2 - Ana Sofia Costa, up202007602@edu.fe.up.pt
* Membro 3 - Daniel Rodrigues, up202006562@edu.fe.up.pt
* Membro 4 - Diogo Fonte, up202004175@edu.fc.up.pt