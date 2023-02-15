# EAP: Architecture Specification and Prototype

> Oferecer aos adultos, uma alternativa mais prática e inovadora de adquirir artigos de moda de qualidade.

## A7: Web Resources Specification

> Neste artefacto documentamos a especificação dos recursos *web*. Identificamos os módulos e as permissões necessárias, nas secções 1 e 2, respetivamente. Na secção 3 temos presente o documento a7_openapi.yaml que identifica e especifica os serviços necessários.

### 1. Overview

>|Module Identification|Description|
>|---|---|
>|M01: Authentication|Recursos *Web* associados à autenticação dos utilizadores e administradores. As funcionalidades incluídas neste módulo são as seguintes: *login/logout*, registo de conta e recuperação de acessos à conta.|
>|M02: Personal Profile|Recursos *Web* relacionados com o acesso ao seu perfil de cada utilizador e administrador, incluíndo gestão do mesmo. As funcionalidades incluídas neste módulo são as seguintes: aceder ao perfil individual e alterar as informações pessoais.|
>|M03: Administration|Recursos Web associados à gestão das contas dos utilizadores, à gestão da parte logística/comercial do sistema e todo o tipo de administração. As funcionalidades incluídas neste módulo são as seguintes: acesso a uma lista das contas de utilizadores, pesquisa por utilizadores, visualização e edição das informações de cada utilizador, bloquear/desbloquear contas de utilizador, eliminar contas de utilizadores.|
>|M04: Products and Promotions|Recursos *Web* relacionados com o catálogo de artigos da About Fashion e a gestão de promoções disponíveis. As funcionalidades incluídas neste módulo são as seguintes: catálogo/lista de produtos comercializados, procura por artigos, ver detalhes do produto, editar detalhes do produto (para administrador), eliminar artigos não comercializados (para administrador), ver promoções disponíveis e editar promoções (para administrador).|
>|M05: Orders and Wishlists|Recursos *Web* associados às encomendas e às listas de favoritos dos utilizadores. As funcionalidades incluídas neste módulo são as seguintes: adicionar nova encomenda, alteração do estado de encomendas (incluindo cancelamento), visualização de todas as encomendas, visualização da lista de favoritos, adicionar produto à *wishlist*, remover artigo da *wishlist* e controlo sobre as *wishlists* e encomendas por parte dos administradores, para poderem resolver possíveis problemas.|
>|M06: Reviews and Reports|Recursos *Web* relacionados com as *reviews* e os *reports* dados pelos utilizadores. As funcionalidades incluídas neste módulo são as seguintes: submissão de nova *review* de um produto adquirido, edição das *reviews* feitas, remoção de *review* escrita, submissão de *report*, listagem de *reports* a resolver (para administrador) e conclusão/fecho de *report*.|
>|M07: Pages|Recursos *Web* associados à gestão das páginas de informação estática do sistema. As funcionalidades incluídas neste módulo são as seguintes: visualização das páginas *Home*, *About US*, *Contacts*, *Help* e *Follow us*.|

### 2. Permissions

>|Identifier|Name|Description|
>|---|---|---|
>|PUB|Public|Utilizadores sem privilégios, apenas visitantes|
>|USR|User|Utilizadores autenticados, com conta criada e sessão iniciada|
>|OWN|OWNER|Utilizadores autenticados ou administradores que são donos da informação (e.g. dono do perfil)|
>|COL|Administrator - Collaborator|Administradores do sistema, responsáveis pela área comercial|
>|TEC|Administrator - Technician|Administradores do sistema, responsáveis pela parte técnica|

### 3. OpenAPI Specification

[Link to the `a7_openapi.yaml` file in the group's repository.](https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251/-/blob/main/a7_openapi.yaml)

```yaml
openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW About Fashion Web API'
  description: 'Web Resources Specification (A7) for About Fashion'

servers:
  - url: http://lbaw2251.fe.up.pt
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


paths:
  /login:
    post:
      operationId: R101
      summary: 'R101: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded: 
            schema:
              type: object
              properties:
                email: 
                  type: string
                password: 
                  type: string
              required:
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to home page.'
                  value: '/'
                302Error:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/'

  /admin-panel/login:
    get:
      operationId: R102
      summary: 'R102: Admin Login Form'
      description: 'Provide login form. Access: TEC, COL'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show log-in UI'

    post:
      operationId: R103
      summary: 'R103: Admin Login Action'
      description: 'Processes the admin login form submission. Access: TEC, COL'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email: 
                  type: string
                password:
                  type: string
              required:
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to home page.'
                  value: '/admin-panel'
                302Error:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/admin-panel/login'

  /logout:
    post:
      operationId: R104
      summary: 'R104: Logout Action'
      description: 'Logout the current authenticated user and admins. Access: USR, TEC, COL'
      tags:
        - 'M01: Authentication'
      responses:
        '302':
          description: 'Redirect after processing logout.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful logout. Redirect to home page.'
                  value: '../'

  /register:
    get:
      operationId: R105
      summary: 'R105: Register Form'
      description: 'Provide register form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show UI'

    post:
      operationId: R106
      summary: 'R106: Register Action'
      description: 'Processes the new user registration form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                first_name:
                  type: string
                second_name:
                  type: string
                email:
                  type: string
                picture:
                  type: string
                  format: binary
                password:
                  type: string
                gender:
                  type: string
              required:
                - first_name
                - second_name
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Failure:
                  description: 'Failed authentication. Redirect to register form.'
                  value: '/'

  /users/{id}:
    get:
      operationId: R201
      summary: 'R201: View user profile'
      description: 'Show the personal user profile. Access: OWN, TEC'
      tags:
        - 'M02: Personal Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show view profile UI'
        '403':
          description: 'You do not have permission to view this profile'

    patch:
      operationId: R203
      summary: 'R203: Edit user profile'
      description: 'Edit the personal user profile. Access: OWN' 
      tags:
        - 'M02: Personal Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded: 
            schema:
              type: object
              properties:
                first_name:
                  type: string
                second_name:
                  type: string
                email:
                  type: string
                picture:
                  type: string
                  format: binary
                password:
                  type: string
              required:
                - first_name
                - second_name
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edit. Redirect to user profile.'
                  value: '/users/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to user profile.'
                  value: '/users/{id}'
        '403':
          description: 'You do not have permission to edit this profile.'
    
    delete:
      operationId: R204
      summary: 'R204: Delete user profile'
      description: 'Delete the personal user profile. Access: OWN'
      tags:
        - 'M02: Personal Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful delete. Redirect to home page.'
                  value: '/'
                302Failure:
                  description: 'Failed delete. Redirect to user profile.'
                  value: '/users/{id}'
        '403':
          description: 'You do not have permission to delete this profile.'

  /users/{id}/edit:
    get:
      operationId: R202
      summary: 'R202: Edit user profile form'
      description: 'Show the edit user profile form. Access: OWN'
      tags:
        - 'M02: Personal Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show edit profile UI'
        '403':
          description: 'You do not have permission to edit this profile'
  
  /cards/create:
    get:
      operationId: R205
      summary: 'R205: Create card form'
      description: 'Show the create card form. Access: USR'
      tags:
        - 'M02: Personal Profile'
      responses:
        '200':
          description: 'Ok. Show create card UI'
        '403':
          description: 'You do not have permission to create a card'

    post:
      operationId: R206
      summary: 'R206: Create card action'
      description: 'Processes the create card form submission. Access: USR'
      tags:
        - 'M02: Personal Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                description:
                  type: string
                picture:
                  type: string
                  format: binary
                tags:
                  type: string
              required:
                - title
                - description
                - tags

      responses:
        '302':
          description: 'Redirect after processing the new card information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful create. Redirect to card.'
                  value: '/cards/{id}'
                302Failure:
                  description: 'Failed create. Redirect to create card form.'
                  value: '/cards/create'
        '403':
          description: 'You do not have permission to create a card.'
  
  /cards/{id}:
    patch:
      operationId: R207
      summary: 'R207: Edit card'
      description: 'Edit the card. Access: OWN'
      tags:
        - 'M02: Personal Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded: 
            schema:
              type: object
              properties:
                title:
                  type: string
                description:
                  type: string
                picture:
                  type: string
                  format: binary
                tags:
                  type: string
              required:
                - title
                - description
                - tags

      responses:
        '302':
          description: 'Redirect after processing the new card information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edit. Redirect to card.'
                  value: '/cards/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to card.'
                  value: '/cards/{id}'
        '403':
          description: 'You do not have permission to edit this card.'
    
    delete:
      operationId: R208
      summary: 'R208: Delete card'
      description: 'Delete the card. Access: OWN'
      tags:
        - 'M02: Personal Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the new card information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful delete. Redirect to home page.'
                  value: '/'
                302Failure:
                  description: 'Failed delete. Redirect to card.'
                  value: '/cards/{id}'
        '403':
          description: 'You do not have permission to delete this card.'

  /cards/{id}/edit:
    get:
      operationId: R209
      summary: 'R209: Edit card form'
      description: 'Show the edit card form. Access: OWN'
      tags:
        - 'M02: Personal Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show edit card UI'
        '403':
          description: 'You do not have permission to edit this card'
  
  /address/create:
    get:
      operationId: R210
      summary: 'R210: Create address form'
      description: 'Show the create address form. Access: USR'
      tags:
        - 'M02: Personal Profile'
      responses:
        '200':
          description: 'Ok. Show create address UI'
        '403':
          description: 'You do not have permission to create an address'

    put:
      operationId: R211
      summary: 'R211: Create address action'
      description: 'Processes the create address form submission. Access: USR'
      tags:
        - 'M02: Personal Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                company:
                  type: string
                nif:
                  type: string
                street:
                  type: string
                number:
                  type: integer
                apartment:
                  type: integer
                note:
                  type: string
                country:
                  type: string
              required:
                - name
                - street
                - number
                - country

      responses:
        '302':
          description: 'Redirect after processing the new address information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful create. Redirect to address.'
                  value: '/address/{id}'
                302Failure:
                  description: 'Failed create. Redirect to create address form.'
                  value: '/address/create'
        '403':
          description: 'You do not have permission to create an address.'
  
  /address/{id}:
    patch:
      operationId: R212
      summary: 'R212: Edit address'
      description: 'Edit the address. Access: OWN'
      tags:
        - 'M02: Personal Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded: 
            schema:
              type: object
              properties:
                name:
                  type: string
                company:
                  type: string
                nif:
                  type: string
                street:
                  type: string
                number:
                  type: integer
                apartment:
                  type: integer
                note:
                  type: string
                country:
                  type: string
              required:
                - name
                - street
                - number
                - country

      responses:
        '302':
          description: 'Redirect after processing the new address information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edit. Redirect to address.'
                  value: '/address/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to address.'
                  value: '/address/{id}'
        '403':
          description: 'You do not have permission to edit this address.'
    
    delete:
      operationId: R213
      summary: 'R213: Delete address'
      description: 'Delete the address. Access: OWN'
      tags:
        - 'M02: Personal Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the new address information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful delete. Redirect to home page.'
                  value: '/'
                302Failure:
                  description: 'Failed delete. Redirect to address.'
                  value: '/address/{id}'
        '403':
          description: 'You do not have permission to delete this address.'
  
  /address/{id}/edit:
    get:
      operationId: R214
      summary: 'R214: Edit address form'
      description: 'Show the edit address form. Access: OWN'
      tags:
        - 'M02: Personal Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show edit address UI'
        '403':
          description: 'You do not have permission to edit this address'

  /admin-panel:
    get:
      operationId: R301
      summary: 'R301: Admin Panel'
      description: 'Displays the admin panel. Access: COL,TEC'
      tags:
        - 'M03: Administration'

      responses:
        '200':
          description: 'Admin panel page.'
          content:
            text/html:
              schema:
                type: string
              examples:
                200Success:
                  description: 'Successful request. Displays the admin panel.'
                  value: '<html>...</html>'
                200Error:
                  description: 'Failed request. Redirect to home page.'
                  value: '<html>...</html>'

  /admin-panel/users/{id}:
    delete:
      operationId: R302
      summary: 'R302: Delete user'
      description: 'Delete a user. Access: COL,TEC'
      tags:
        - 'M03: Administration'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful delete. Redirect to admin panel.'
                  value: '/admin-panel'
                302Failure:
                  description: 'Failed delete. Redirect to admin panel.'
                  value: '/admin-panel'
        '403':
          description: 'You do not have permission to delete this profile.'
  
  /admin-panel/users/{id}/block:
    patch:
      operationId: R303
      summary: 'R303: Blocks or Unblocks an user'
      description: 'Block or Unblock an user. Access: COL,TEC'
      tags:
        - 'M03: Administration'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful block. Redirect to admin panel.'
                  value: '/admin-panel'
                302Failure:
                  description: 'Failed block. Redirect to admin panel.'
                  value: '/admin-panel'
        '403':
          description: 'You do not have permission to block this profile.'

  /api/products:
    get:
      operationId: R401
      summary: 'R401: Search Products API'
      description: 'Searches for products and returns the results as JSON. Access: PUB'
      tags:
        - 'M04: Products and Promotions'

      parameters:
        - in: query
          name: id_product
          description: Product ID
          schema:
            type: integer
          required: false
        - in: query
          name: product_name
          description: String to use for full-text search
          schema:
            type: string
          required: false
        - in: query
          name: id_category
          description: Category of the products
          schema:
            type: integer
          required: false
        - in: query
          name: min_classification
          description: Numeric corresponding to the product classification
          schema:
            type: integer
          required: false
        - in: query
          name: min_price
          description: Numeric corresponding to the minimum price of a product
          schema:
            type: integer
          required: false
        - in: query
          name: max_price
          description: Numeric corresponding to the maximum price of a product
          schema:
            type: integer
          required: false

      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    name:
                      type: string
                    price:
                      type: number
                    description: 
                      type: string
                    image:
                      type: array
                      items: 
                        type: string
                    category:
                      type: array
                      items:
                        properties:
                          id:
                            type: integer
                          name:
                            type: string
                    sizes:
                      type: array
                      items:
                        type: object
                        properties:
                          id:
                            type: integer
                          name:
                            type: string
                    colors:
                      type: array
                      items:
                        type: object
                        properties:
                          id:
                            type: integer
                          name:
                            type: string
                    stock:
                      type: array
                      items:
                        type: object
                        properties:
                          id_size:
                            type: integer
                          id_color:
                            type: integer
                          stock:
                            type: integer
                    avg_classification:
                      type: integer
                    promotion:
                      type: object
                      properties:
                        id_promotion:
                          type: integer
                        discount:
                          type: integer
                             
                example:
                  - id: 1
                    name: Zip Up Bomber Jacket
                    description: description of the materials and tips/warnings for washing
                    price: 20
                    image: [https://robohash.org/totamminussunt.png?size=50x50&set=set1, https://robohash.org/inventoreutnulla.png?size=50x50&set=set1]
                    category: [{id: 1, name: Woman}, {id: 2, name: Jackets}]
                    sizes: [{id: 1, name: XS}, {id: 2, name: S}, {id: 3, name: M}]
                    colors: [{id: 1, name: Black}, {id: 2, name: Grey}, {id: 3, name: Red}]
                    stock: [{id_size: 1, id_color: 1, stock: 10},{id_size: 2, id_color: 2, stock: 0},{id_size: 3, id_color: 3, stock: 20}]
                    avg_classification: 3
                    promotion: {id_promotion: 1, id_discount: 10}
              
  /api/products/stock:
    get:
      operationId: R402
      summary: 'R402: Get stock of a product'
      description: 'Returns the stock of a product as JSON. Access: PUB'
      tags:
        - 'M04: Products and Promotions'

      parameters:
        - in: query
          name: id_product
          description: Product ID
          schema:
            type: integer
          required: true
        - in: query
          name: id_size
          description: Size ID
          schema:
            type: integer
          required: true
        - in: query
          name: id_color
          description: Color ID
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: object
                properties:
                  size:
                    type: string
                  color:
                    type: string
                  stock:
                    type: integer
                example:
                  size: M
                  color: Black
                  stock: 10
        '404':
          description: 'Product not found'
        '400':
          description: 'Bad request'


  /products:
    get:
      operationId: R403
      summary: 'R403: List the products'
      description: 'Shows the products that match the applied filters. Uses AJAX. Access: PUB'
      tags:
        - 'M04: Products and Promotions'
      
      responses:
        '200':
          description: 'Ok. Show search products UI'
  
  /products/{id}:
    get:
      operationId: R404
      summary: 'R404: Show Product'
      description: 'Show the product with the index {id}. Access: PUB'
      tags:
        - 'M04: Products and Promotions'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show product UI'
        '404':
          description: "Error. There's not a product with the specified primary key"

  /order/{id}:
    get:
      operationId: R501
      summary: 'R501: Show Order'
      description: 'Show the order with the index {id}. Access: OWN'
      tags:
        - 'M05: Orders and Wishlist'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show order UI'
        '404':
          description: "Error. There's not an order with the specified primary key"
    
  /orders/create:
    get:
      operationId: R502
      summary: 'R502: Create Order'
      description: 'Show the form to create an order. Access: PUB'
      tags:
        - 'M05: Orders and Wishlist'

      responses:
        '200':
          description: 'Ok. Show create order UI'
    post:
      operationId: R503
      summary: 'R503: Create Order'
      description: 'Create an order. Access: PUB'
      tags:
        - 'M05: Orders and Wishlist'

      requestBody:
        content:
          application/json:
            schema:
              type: object
              properties:
                id_user:
                  type: integer
                id_address:
                  type: integer
                id_card:
                  type: integer
                total:
                  type: integer
                products:
                  type: array
                  items:
                    type: object
                    properties:
                      id_product:
                        type: integer
                      id_size:
                        type: integer
                      id_color:
                        type: integer
                      quantity:
                        type: integer 
              example:
                example1:
                  value:
                    id_user: 1
                    id_address: 1
                    id_card: 1
                    total: 100
                    products: [{id_product: 1, id_size: 1, id_color: 1, quantity: 1}, {id_product: 2, id_size: 2, id_color: 2, quantity: 2}]
                example2:
                  value:
                    id_user: 1
                    id_address: 1
                    id_card: 1
                    total: 100
                    products: [{id_product: 1, id_size: 1, id_color: 1, quantity: 1}, {id_product: 2, id_size: 2, id_color: 2, quantity: 2}]
      responses:
        '200':
          description: 'Ok. Order created'
        '400':
          description: 'Bad request'
        '404':
          description: 'Error. User, address, payment or promotion not found'
        '409':
          description: 'Error. Product not found or not enough stock'

  /api/shopping-cart/add:
    post:
      operationId: R504
      summary: 'R504: Add product to shopping cart'
      description: 'Add a product to the shopping cart. Access: PUB'
      tags:
        - 'M05: Orders and Wishlist'

      requestBody:
        content:
          application/json:
            schema:
              type: object
              properties:
                id_product:
                  type: integer
                id_size:
                  type: integer
                id_color:
                  type: integer
                quantity:
                  type: integer
              example:
                id_product: 1
                id_size: 1
                id_color: 1
                quantity: 1
      responses:
        '200':
          description: 'Ok. Product added to shopping cart'
        '400':
          description: 'Bad request'
        '404':
          description: 'Error. Product not found or not enough stock'
        '409':
          description: 'Error. Product not found or not enough stock'

  /api/shopping-cart/remove:
    post:
      operationId: R505
      summary: 'R505: Remove product from shopping cart'
      description: 'Remove a product from the shopping cart. Access: PUB'
      tags:
        - 'M05: Orders and Wishlist'

      requestBody:
        content:
          application/json:
            schema:
              type: object
              properties:
                id_product:
                  type: integer
                id_size:
                  type: integer
                id_color:
                  type: integer
              example:
                id_product: 1
                id_size: 1
                id_color: 1
      responses:
        '200':
          description: 'Ok. Product removed from shopping cart'
        '400':
          description: 'Bad request'
        '404':
          description: 'Error. Product not found or not enough stock'
        '409':
          description: 'Error. Product not found or not enough stock'

  /users/{id}/shopping-cart:
    get:
      operationId: R506
      summary: 'R506: Show shopping cart'
      description: 'Show the shopping cart of the user with the index {id}. Access: OWN'
      tags:
        - 'M05: Orders and Wishlist'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show shopping cart UI'
        '404':
          description: "Error. There's not a user with the specified primary key"

  /api/shopping-cart/checkout:
    post:
      operationId: R507
      summary: 'R507: Checkout shopping cart'
      description: 'Checkout the shopping cart. Access: PUB'
      tags:
        - 'M05: Orders and Wishlist'

      requestBody:
        content:
          application/json:
            schema:
              type: object
              properties:
                id_user:
                  type: integer
                id_address:
                  type: integer
                id_card:
                  type: integer
                total:
                  type: integer
              example:
                id_user: 1
                id_address: 1
                id_card: 1
                total: 100
      responses:
        '200':
          description: 'Ok. Shopping cart checked out'
        '400':
          description: 'Bad request'
        '404':
          description: 'Error. User, address, payment or promotion not found'
        '409':
          description: 'Error. Product not found or not enough stock'

  /:
    get:
      operationId: R701
      summary: 'R701: Home Page'
      description: 'Show home page. Access: PUB'
      tags:
        - 'M07: Pages'
      responses:
        '200':
          description: 'Ok. Show home page'
  
  /about:
    get:
      operationId: R702
      summary: 'R702: About Page'
      description: 'Show about page. Access: PUB'
      tags:
        - 'M07: Pages'
      responses:
        '200':
          description: 'Ok. Show about page'
  
  /contacts:
    get:
      operationId: R703
      summary: 'R703: Contacts Page'
      description: 'Show contacts page. Access: PUB'
      tags:
        - 'M07: Pages'
      responses:
        '200':
          description: 'Ok. Show contacts page'
```

---


## A8: Vertical prototype

>O intuito deste protótipo é implementar as funcionalidades marcadas com prioridade elevada no documento de especificação de requisitos. Foi utilizada a *framework* Laravel para o desenvolvimento da aplicação *web*. Este protótipo foi uma primeira iteração para o desenvolvimento do produto final e serviu-nos para aprender o funcionamento da *framework* em questão.

### 1. Implemented Features

#### 1.1. Implemented User Stories

>|User Story reference|Name|Priority|Description|
>|---|---|---|---|
>|US01|Resultado exato da pesquisa|Elevada|Como utilizador, quero ter um resultado exato da procura que efetuei, para conseguir aceder ao produto que pretendo de forma eficaz|
>|US02 *|Pesquisa de texto completo|Elevada|Como utilizador, quero ter a possibilidade de escrever bastante texto, para poder identificar melhor o artigo que procuro|
>|US03|Ver lista de produtos|Elevada|Como utilizador, quero ver os produtos disponíveis no sistema, para poder ver a oferta de artigos da marca|
>|US04|Ver detalhes do produto|Elevada|Como utilizador, quero ver os detalhes de um produto, para obter mais informações sobre o artigo da marca|
>|US05 *|Adicionar produto ao carrinho|Elevada|Como utilizador, quero adicionar um produto ao carrinho, para fazer a encomenda do mesmo|
>|US06 *|Gerir carrinho|Elevada|Como utilizador, quero gerir o meu carrinho, para poder remover produtos que já não pretenda encomendar|
>|US07|Procurar produtos (foi implementada apenas procura por filtros)|Elevada|Como utilizador, quero pesquisar por produtos no sistema, para poder encontrar um artigo de forma mais fácil e direta|
>|US19|Entrar na conta|Elevada|Como utilizador não autenticado, quero fazer *log in* no sistema, para ter acesso a informação priveligiada e às minhas informações pessoais (endereços, encomendas e estados das mesmas, lista de favoritos, vouchers, etc)|
>|US20|Criar conta|Elevada|Como utilizador não autenticado, quero registar-me no sistema, para poder efetuar a minha encomenda e posteriormente ter acesso às vantagens de possuir uma conta|
>|US22|Sair da conta|Elevada|Como utilizador autenticado, quero fazer *log out* no sistema, para poder sair do *site* em segurança ou iniciar sessão com outra conta|
>|US23|Ver histórico de compras|Elevada|Como utilizador autenticado, quero ver o meu histórico de compras no sistema, para encontrar um artigo que encomendei da última vez de forma mais fácil e rápida|
>|US24|Ver perfil|Elevada|Como utilizador autenticado, quero ver o meu perfil registado no sistema, para ter a possibilidade de verificar se todas as minhas informações pessoais estão corretas|
>|US25|Editar perfil|Elevada|Como utilizador autenticado, quero editar o meu perfil, para modificar os meus dados pessoais|
>|US26 *|Finalizar pedido|Elevada|Como utilizador autenticado, quero finalizar o meu pedido, para poder encomendar os artigos que se encontram no carrinho|
>|US56|Administrar contas de utilizadores (pesquisar, ver, editar, criar)|Elevada|Como administrador técnico, quero ter acesso completo às contas dos utilizadores, para poder gerir e resolver possíveis problemas que os utilizadores tenham com elas|
>
>Nota: os *user stories* que possuem um *, não foram implementados na totalidade.

#### 1.2. Implemented Web Resources

> **Module M01: Authentication**
>
>|Web Resource Reference|URL|
>|---|---|
>|R101: Login Action|POST/login|
>|R102: Admin Login Form|GET/admin-panel/login|
>|R103: Admin Login Action|POST/admin-panel/login|
>|R104: Logout Action|POST/logout|
>|R105: Register Form|GET/register|
>|R106: Register Action|POST/register|
>
> **Module M02: Personal Profile**
>
>|Web Resource Reference|URL|
>|---|---|
>|R201: View user profile|GET/users/{id}|
>|R202: Edit user profile form|GET/users/{id}/edit|
>|R203: Edit user profile|PATCH/users/{id}|
>|R204: Delete user profile|DELETE/users/{id}|
>|R205: Create card form|GET/cards/create|
>|R206: Create card action|POST/cards/create|
>|R207: Edit card|PATCH/cards/{id}|
>|R208: Delete card|DELETE/cards/{id}|
>|R209: Edit card form|GET/cards/{id}/edit|
>|R210: Create address form|GET/address/create|
>|R211: Create address action|PUT/address/create|
>|R212: Edit address|PATCH/address/{id}|
>|R213: Delete address|DELETE/address/{id}|
>|R214: Edit address form|GET/address/{id}/edit|
>
> **Module M03: Administration**
>
>|Web Resource Reference|URL|
>|---|---|
>|R301: Admin Panel|GET/admin-panel|
>|R302: Delete user|DELETE/admin-panel/users/{id}|
>|R303: Blocks or Unblocks an user|PATCH/admin-panel/users/{id}/block|
>
> **Module M04: Products and Promotions**
>
>|Web Resource Reference|URL|
>|---|---|
>|R401: Search Products API|GET/api/products|
>|R402: Get stock of a product|GET/api/products/stock|
>|R403: List the products|GET/products|
>|R404: Show Product|GET/products/{id}|
>
> **Module M05: Orders and Wishlists**
>
>|Web Resource Reference|URL|
>|---|---|
>|R501: Show Order|GET/order/{id}|
>|R502: Create Order|GET/orders/create|
>|R503: Create Order|POST/orders/create|
>|R504: Add product to shopping cart|POST/api/shopping-cart/add|
>|R505: Remove product from shopping cart|POST/api/shopping-cart/remove|
>|R506: Show shopping cart|GET/users/{id}/shopping-cart|
>|R507: Checkout shopping cart|POST/api/shopping-cart/checkout|
>
> **Module M07: Pages**
>
>|Web Resource Reference|URL|
>|---|---|
>|R701: Home Page|GET/|
>|R702: About Page|GET/about|
>|R703: Contacts Page|GET/contacts|

### 2. Prototype

>O **protótipo** está disponível em: https://lbaw2251.lbaw.fe.up.pt
>
>**Credenciais:**
>- **admin** 
>    e-mail: up202006562tec@up.pt
>    password: teste12345
>- **user** 
>    e-mail: daniel-jose2002@live.com.pt
>    password: teste12345
>
>O código fonte está disponível em: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2251

---

## Revision history

- 03/11/2022 - Foram adicionados os módulos dos recursos *Web*.
- 04/11/2022 - Foram adicionadas as permissões e as *user stories* de prioridade alta a serem implementadas.
- 09/11/2022 - Foram adicionados métodos GET e POST ao ficheiro a7_openapi.yaml.
- 14/11/2022 - Passamos a ter 7 módulos em vez de 4, inicialmente.
- 23/11/2022 - O ficheiro a7_openapi.yaml foi alterado de acordo com as routes implementadas. Os recursos web implementados foram listados. As informações do protótipo foram introduzidas.

---

GROUP2251, 24/11/2022

* Membro 1 - Alexandre Correia, up202007042@edu.fe.up.pt
* Membro 2 - Ana Sofia Costa, up202007602@edu.fe.up.pt (Editor)
* Membro 3 - Daniel Rodrigues, up202006562@edu.fe.up.pt
* Membro 4 - Diogo Fonte, up202004175@edu.fc.up.pt