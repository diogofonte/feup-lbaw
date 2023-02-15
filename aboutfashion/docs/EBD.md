# EBD: Database Specification Component

> Oferecer aos adultos, uma alternativa mais prática e inovadora de adquirir artigos de moda de qualidade.

## A4: Conceptual Data Model

> O modelo de dados conceptual (utilizamos um diagrama UML para a sua representação) identifica e descreve todas as identidades que vão ser essenciais no sistema. Também serão representadas todas as relações entre estas identidades, os atributos de cada uma e as restrições aplicadas a alguns destes. O que não é possível representar no diagrama, é apresentado como uma *business rule*.

### 1. Class diagram

>![](https://i.imgur.com/TS4hSJJ.png)

### 2. Additional Business Rules

>|Identificador|Descrição|
>|---|---|
>|BR01|O utilizador apenas pode fazer uma avaliação de um produto, caso este esteja presente numa das suas encomendas.|
>|BR02|Quando um utilizador elimina a sua conta, as *reviews* efetuadas por ele passam a ter um autor anónimo.|
>|BR03|A tabela Order é também usada para guardar o estado do carrinho de compras. Por este motivo há possibilidade de uma Order não ter nenhuma tabela Details (guarda o produto escolhido, o tamanho, a cor e a quantidade) associada, porque o carrinho está, inicialmente ou a uma dada altura, vazio. No entanto, se uma Order possuir o atributo state com outro valor, exceto 'Shopping Cart', necessita de ter pelo menos uma tabela Details associada, um Address e um Cart.|
>|BR04|Um utilizador apenas pode dar *like* em *reviews* dadas por outros utilizadores.|
>|BR05|Um utilizador não pode reportar a sua *review*|

## A5: Relational Schema, validation and schema refinement

> O objetivo do modelo relacional é mapear todas as identidades e relações presentes no modelo conceptual. Neste modelo conseguimos ter uma forma mais clara de apresentar as identidades (como uma relação), os seus atributos, *primary keys*, *foreign keys* e todas as restrições impostas, que podem ser: NOT NULL, UNIQUE, CHECK e DEFAULT.

### 1. Relational Schema


>|Relation reference|Relation Compact Notation|
>|---|---|
>|R01|image(__id__, file **UK** **NN**)|
>|R02|authenticated_user(__id__, first_name **NN**, last_name **NN**, email **UK** **NN**, password **NN**, birth_date, gender, blocked **NN** **DF** FALSE, id_image → image)|
>|R03|admin(__id__, first_name **NN**, last_name **NN**, email **UK** **NN**, password **NN**, birth_date, gender, id_image → image, role **NN** **CK** role **IN** Admin Role Types)|
>|R04|notification(__id__, type **NN** **CK** type **IN** Notification Types, message **NN**, date **NN**)|
>|R05|admin_notification(__id_admin__ **NN** → admin, __id_notification__ **NN** → notification)|
>|R06|user_notification(__id_user__ **NN**→ authenticated_user, __id_notification__ **NN** → notification)|
>|R07|card(__id__, nickname , name **NN**, number **UK** **NN**, month **NN**, year **NN**, code **NN**, id_user → authenticated_user)|
>|R08|country(__id__, name **UK** **NN**)|
>|R09|address(__id__, name **NN**, company, nif, street **NN**, number **NN**, apartment, note, id_country **NN** → country, id_user **NN**→ authenticated_user)|
>|R10|category(__id__, name **NN**, id_super_category → category)|
>|R11|product(__id__, name **UK** **NN**, description, price **NN** **CK** price > 0, id_category **NN** → category)|
>|R12|product_image(__id_product__ **NN** → product, __id_image__ **NN** → image)|
>|R13|wishlist(__id_user__ **NN** → authenticated_user, __id_product__ **NN** → product)|
>|R14|review(__id__, evaluation **NN** **CK** evaluation > 0 AND evaluation <= 5, title **NN**, description **NN**, date **NN** id_user → authenticated_user, id_product **NN** → product)|
>|R15|like(__id_user__ **NN** → authenticated_user, __id_review__ **NN** → review)
>|R16|report(__id__, description **NN**, resolved **NN** **DF** FALSE, report_date **NN**, id_user → authenticated_user, id_review → review)|
>|R17|promotion(__id__, discount **NN** **CK** discount > 0 AND discount < 100, start_date **NN**, final_date **NN** **CK** final_date > start_date)|
>|R18|promotion_product(__id_promo__ **NN** → promotion, __id_product__ **NN** → product)|
>|R19|size(__id__, name **UK** **NN**)|
>|R20|color(__id__, name **UK** **NN**)|
>|R21|stock(stock **NN** **CK** stock >= 0, __id_product__ **NN** → product, __id_size__ **NN** → size, __id_color__ **NN** → color)|
>|R22|details(quantity **NN** **CK** quantity > 0, __id_product__ **NN** → product, __id_size__ **NN** → size, __id_color__ **NN** → color)|
>|R23|order(__id__, state **NN** **DF** 'Shopping Cart' **CK** state **IN** Order State Types, date **NN**, id_user → authenticated_user, id_adress → adress, id_card → card)|
>|R24|order_details(__id_order__ **NN** → order, __id_details__ **NN** → details)|
>
>**Legenda:**
>1) NN = NOT NULL
>2) UK = UNIQUE
>3) CK = CHECK
>4) DF = DEFAULT
>
>**Justificação da generalização Person para Admin ou AuthenticatedUser**
>Optamos pela estratégia *object-oriented* porque a generalização é *disjoint*, ou seja, cada objeto apenas pertence a uma sub-árvore e terão associações diferentes. Assim conseguimos eliminar a super classe e associar as tabelas de uma forma mais eficaz.

### 2. Domains

>|Domain Name|Domain Specification|
>|---|---|
>|Admin Role Types|ENUM('Collaborator', 'Technician')|
>|Order State Types|ENUM('Shopping Cart', 'Pending', 'In Progress', 'Completed', 'Cancelled')|
>|Notification Types|ENUM('New Promotion', 'New Collection', 'Recommended Product', 'Change in Order State', 'Payment accept', 'Product in Wishlist Available', 'Price Change of Item in Shopping Cart', 'Order', 'Report', 'Other')|

### 3. Schema validation

>|**TABLE R01**|image|
>|---|---|
>|**Keys**|{id}, {file}|
>|**Functional Dependencies:**||
>|FD0101|id → {file}|
>|FD0102|file → {id}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R02**|authenticated_user|
>|---|---|
>|**Keys**|{id}, {email}|
>|**Functional Dependencies:**||
>|FD0201|id → {first_name, last_name, email, password, birth_date, gender, blocked, id_image}|
>|FD0202|email → {first_name, last_name, id, password, birth_date, gender, blocked, id_image}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R03**|admin|
>|---|---|
>|**Keys**|{id}, {email}|
>|**Functional Dependencies:**||
>|FD0301|id → {first_name, last_name, email, password, birth_date, gender, id_image, role}|
>|FD0302|email → {id, first_name, last_name, password, birth_date, gender, id_image, role}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R04**|notification|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD0401|id → {type, message, date}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R05**|admin_notification|
>|---|---|
>|**Keys**|{id_admin, id_notification}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R06**|user_notification|
>|---|---|
>|**Keys**|{id_user, id_notification}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R07**|card|
>|---|---|
>|**Keys**|{id}, {number}, {code}|
>|**Functional Dependencies:**||
>|FD0701|id → {nickname, name, number, month, year, code, id_user}|
>|FD0702|number → {nickname, name, id, month, year, code, id_user}|
>|FD0703|code → {nickname, name, number, month, year, id, id_user}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R08**|country|
>|---|---|
>|**Keys**|{id}, {name}|
>|**Functional Dependencies:**||
>|FD0801|id → {name}|
>|FD0802|name → {id}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R09**|address|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD0901|id → {name, company, nif, street, number, apartment, note, id_country, id_user}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R10**|category|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD1001|id → {name, id_super_category}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R11**|product|
>|---|---|
>|**Keys**|{id}, {name}|
>|**Functional Dependencies:**||
>|FD1101|id → {name, description, price, id_category}|
>|FD1102|name → {id, description, price, id_category}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R12**|product_image|
>|---|---|
>|**Keys**|{id_product, id_image}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R13**|wishlist|
>|---|---|
>|**Keys**|{id_user, id_product}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R14**|review|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD1401|id → {evaluation, title, description, date, id_user, id_product}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R15**|like|
>|---|---|
>|**Keys**|{id_user, id_review}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R16**|report|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD1601|id → {description, resolved, report_date, id_user, id_review}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R17**|promotion|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD1701|id → {discount, start_date, final_date}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R18**|promotion_product|
>|---|---|
>|**Keys**|{id_promo, id_product}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R19**|size|
>|---|---|
>|**Keys**|{id}, {name}|
>|**Functional Dependencies:**||
>|FD1901|id → {name}|
>|FD1902|name → {id}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R20**|color|
>|---|---|
>|**Keys**|{id}, {name}|
>|**Functional Dependencies:**||
>|FD2001|id → {name}|
>|FD2002|name → {id}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R21**|stock|
>|---|---|
>|**Keys**|{id_product, id_size, id_color}|
>|**Functional Dependencies:**||
>|FD2101|id_product, id_size, id_color → {stock}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R22**|details|
>|---|---|
>|**Keys**|{id_product, id_size, id_color}|
>|**Functional Dependencies:**||
>|FD2201|id_product, id_size, id_color → {quantity}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R23**|order|
>|---|---|
>|**Keys**|{id}|
>|**Functional Dependencies:**||
>|FD2301|id → {state, date, id_user, id_adress, id_card}|
>|**NORMAL FORM**|BCNF|
>
>|**TABLE R24**|order_details|
>|---|---|
>|**Keys**|{id_order, id_details}|
>|**Functional Dependencies:**|none|
>|**NORMAL FORM**|BCNF|
>
>####  **Justificação:**
>Como todas as relações estão na forma normal de Boyce Codd, quer dizer que o modelo relacional cumpre também com a BCNF. Por esta razão, não há necessidade de normalizar o esquema relacional.

---

## A6: Indexes, triggers, transactions and database population

> Esta secção serve para demonstrar tudo o que é relacionado com a base de dados em si. É referido no ínicio a quantidade esperada de dados de cada tipo e o crescimento de cada um. Depois abordamos os índices que implementamos de forma a organizar alguns dos dados da nossa base de dados, para assim conseguirmos aceder a conteúdos importantes de forma rápida e mais eficaz. Apresentamos *triggers* e *user defined functions* que definimos para garantir o bom funcionamento, manutenção e cumprimento das nossas *business rules*, acima referidas. Por final, são descritas as *transactions* essenciais para o sistema da About Fashion.

### 1. Database Workload

>|**Relation reference**|**Relation Name**|**Order of magnitude**|**Estimated growth**|
>|---|---|---|---|
>|R01|image|10k (*tens of thousands*)|10 (tens)/day|
>|R02|authenticated_user|10k (tens of thousands)|10/day|
>|R03|admin|100|no growth|
>|R04|notification|10k|100 (hundreds)/day|
>|R05|admin_notification| 1k (thousands)|100/day|
>|R06|user_notification|10k|100/day|
>|R07|card|10k|10/day|
>|R08|country|100|no growth|
>|R09|address|10k|10/day|
>|R10|category|10|no growth|
>|R11|product|1k|1/day|
>|R12|product_image|1k|1/day|
>|R13|wishlist|1k|10/day|
>|R14|review|1k|10/day|
>|R15|like|1k|10/day|
>|R16|report|100 (hundreds)|1(units)/day|
>|R17|promotion|10|1/month|
>|R18|promotion_product|100|10/month|
>|R19|size|1|no growth|
>|R20|color|1|no growth|
>|R21|stock|10k|1/day|
>|R22|details|1k|10/day|
>|R23|order|1k|10/day|
>|R24|order_details|1k|10/day|

### 2. Proposed Indexes

#### 2.1. Performance Indexes
 
>|**Index**|IDX01|
>|---|---|
>|**Relation**|order|
>|**Attribute**|id_user|
>|**Type**|B-tree|
>|**Cardinality**|Média|
>|**Clustering**|Sim|
>|**Justification**|Ao implementar um índice do tipo *B-tree* na tabela order com o atributo id_user, conseguimos ordenar as encomendas por utilizador, ou seja, conseguimos aceder a todas as encomendas realizadas por um certo utilizador de uma forma mais rápida e eficiente.|
>
>**SQL code:**
```
CREATE INDEX user_order_idx ON user_order USING btree (id_user);
CLUSTER user_order USING user_order_idx;
```
>|**Index**|IDX02|
>|---|---|
>|**Relation**|stock|
>|**Attribute**|id_product|
>|**Type**|Hash|
>|**Cardinality**|Alta|
>|**Clustering**|Não|
>|**Justification**|A tabela 'stock' é frequentemente utilizada para obter a disponibilidade de produtos específicos. A filtragem é feita através da igualdade entre os respetivos id's, sendo assim, o tipo hash é o que se enquadra melhor neste caso.|
>
>**SQL code:**
```
CREATE INDEX product_stock_idx ON stock USING hash (id_product);
```
>|**Index**|IDX03|
>|---|---|
>|**Relation**|promotion|
>|**Attribute**|final_date|
>|**Type**|B-tree|
>|**Cardinality**|Média|
>|**Clustering**|Não|
>|**Justification**|A tabela 'promotion' é frequentemente acedida para alocar/desalocar certas promoções a alguns artigos. Como uma das informações principais de uma promoção é a sua data de fim, para além da percentagem de desconto, utilizamos o tipo de índice *B-tree*, porque nos permite consultar os intervalos de datas de forma mais rápida.|
>
>**SQL code:**
```
CREATE INDEX final_date_promo_idx ON promotion USING btree (final_date);
```
>|**Index**|IDX04|
>|---|---|
>|**Relation**|authenticated_user|
>|**Attribute**|first_name|
>|**Type**|B-tree|
>|**Cardinality**|Alta|
>|**Clustering**|Não|
>|**Justification**|Um índice do tipo *B-tree* implementado na relação authenticated_user utilizando o atributo first_name, é ótimo para organizar os utilizadores pelo primeiro nome. Assim já possuimos os dados significativamente organizados e torna a pesquisa pelos utilizadores mais rápida.|
>
>**SQL code:**
```
CREATE INDEX user_first_name_idx ON authenticated_user USING btree (first_name);
```

#### 2.2. Full-text Search Indexes 

>|**Index**|IDX04|
>|---|---|
>|**Relation**|product|
>|**Attribute**|name, description|
>|**Type**|GIN|
>|**Clustering**|Não|
>|**Justification**|A implementação deste índice tem como objetivo assegurar recursos de pesquisa de texto completo, a serem utilizados em produtos com determinados nomes e/ou descrições. No índice, foi dada maior importância ao campo do nome do produto e o tipo escolhido para a sua criação foi GIN, uma vez que os campos indexados não serão modificados frequentemente.|
>
>**SQL code:**
```
-- Função para utilização do trigger
CREATE FUNCTION product_search()
RETURNS TRIGGER AS 
$$ BEGIN
    IF TG_OP = 'INSERT' 
    THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) 
        THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
        END IF;
    END IF;
    RETURN NEW;
END; $$
LANGUAGE plpgsql;
    
-- Trigger para suportar o índice
CREATE TRIGGER product_search_update
BEFORE INSERT OR UPDATE ON product
FOR EACH ROW
EXECUTE PROCEDURE product_search();

-- Índice
CREATE INDEX search_idx ON product USING GIN (tsvectors);
```

### 3. Triggers and User Defined Functions
 
>|**Trigger**|TRIGGER01|
>|---|---|
>|**Description**|Trigger para dar suporte à implementação do INDEX04 (que é um Full-Text Search Index)|
>
>**SQL code:**
```
CREATE FUNCTION product_search()
RETURNS TRIGGER AS 
$$ BEGIN
    IF TG_OP = 'INSERT' 
    THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) 
        THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
        END IF;
    END IF;
    RETURN NEW;
END; $$
LANGUAGE plpgsql;
    
CREATE TRIGGER product_search_update
BEFORE INSERT OR UPDATE ON product
FOR EACH ROW
EXECUTE PROCEDURE product_search();
```
>|**Trigger**|TRIGGER02|
>|---|---|
>|**Description**|Verificar se um utilizador já comprou o produto antes de fazer uma review|
>|**Justification**|Um utilizador apenas tem a possibilidade de fazer uma *review* a um produto que tenha anteriormente adquirido, ou seja, a um produto que esteja presente numa das suas encomendas. Este trigger garante que a *business rule* 1 é cumprida.|
>
>**SQL code:**
```
CREATE FUNCTION check_review_privileges()
RETURNS TRIGGER AS
$$ BEGIN
    IF NOT EXISTS (SELECT *
            FROM (SELECT DISTINCT id_user, id_product, id_size, id_color
            FROM user_order, order_details, details
            WHERE user_order.id = order_details.id_order AND 
            order_details.id_details = details.id
            ORDER BY id_user, id_product, id_size, id_color) AS user_purchases
            WHERE NEW.id_user = user_purchases.id_user 
            AND NEW.id_product = user_purchases.id_product)
    THEN
        RAISE EXCEPTION 'An item can only be reviewed if it has been purchased';
    END IF;
    RETURN NEW;
END; $$
LANGUAGE plpgsql;

CREATE TRIGGER before_review_insert
BEFORE INSERT ON review
FOR EACH ROW
EXECUTE PROCEDURE check_review_privileges();
```
>|**Trigger**|TRIGGER03|
>|---|---|
>|**Description**|Ao apagar a conta de um utilizador, toda a informação partilhada (encomendas, gostos, reviews) deve ser mantida no sistema|
>|**Justification**|Precisamos de um trigger para garantir estes acontecimentos, porque não podemos perder informações como encomendas, *likes* e *reviews*. Estas terão que ter um autor *null* de forma a conseguirmos manter os dados que precisamos, sem continuar a armazenar a informação das pessoas que decidiram eliminar a conta. Este trigger garante que a *business rule* 2 é cumprida.|
>
>**SQL code:**
```
CREATE FUNCTION delete_user_information()
RETURNS TRIGGER AS
$$ BEGIN
    UPDATE report SET id_user = NULL WHERE id_user = OLD.id_user;
    UPDATE review SET id_user = NULL WHERE id_user = OLD.id_user;
    UPDATE user_like SET id_user = NULL WHERE id_user = OLD.id_user;
    DELETE FROM wishlist WHERE id_user = OLD.id_user;
    UPDATE user_order SET id_user = NULL,
                          id_address = NULL,
                          id_card = NULL
                          WHERE id_user = OLD.id_user;
    RETURN OLD;
END; $$
LANGUAGE plpgsql;

CREATE TRIGGER delete_user_account
AFTER DELETE ON authenticated_user
FOR EACH ROW
EXECUTE PROCEDURE delete_user_information();
```
>|**Trigger**|TRIGGER04|
>|---|---|
>|**Description**|Verificar se uma order com estado diferente de "Shopping Cart" tem todos os parâmetros preenchidos|
>|**Justification**|Como a tabela Order também é utilizada para representar o carrinho de compras quando possui o estado 'Shopping Cart', então temos que garantir que todos os parâmetros necessários para os restantes estados não são nulos quando esta tem um estado diferente. Este trigger garante que a *business rule* 3 é cumprida.|
>
>**SQL code:**
```
CREATE FUNCTION order_parameters()
RETURNS TRIGGER AS
$$ BEGIN
    IF (OLD.state = 'Shopping Cart' AND NEW.state <> 'Shopping Cart')
    THEN
        IF NEW.id_user IS NULL OR NEW.id_address IS NULL OR NEW.id_card IS NULL
        THEN
            RAISE EXCEPTION 'Order must have an user, an address and a card';
        END IF;
    END IF;
    RETURN NEW;
END; $$
LANGUAGE plpgsql;

CREATE TRIGGER check_order_parameters
BEFORE UPDATE ON user_order
FOR EACH ROW
EXECUTE PROCEDURE order_parameters();
```
>|**Trigger**|TRIGGER05|
>|---|---|
>|**Description**|O utilizador não pode meter um *like* na própia review|
>|**Justification**|Um utilizador não tem permissões para gostar da própria *review*, se não estaria a sobrevalorizar a sua opinião/avaliação. Este trigger garante que a *business rule* 4 é cumprida.|
>
>**SQL code:**
```
CREATE FUNCTION check_like_privileges()
RETURNS TRIGGER AS
$$ BEGIN
    IF EXISTS (SELECT id_user
               FROM review
               WHERE id_review = NEW.id_review AND id_user = NEW.id_user)
    THEN
        RAISE EXCEPTION 'A user cannot like his own review';
    END IF;
    RETURN NEW;
END; $$
LANGUAGE plpgsql;

CREATE TRIGGER before_like_insert
BEFORE INSERT ON user_like
FOR EACH ROW
EXECUTE PROCEDURE check_like_privileges();
```
>|**Trigger**|TRIGGER06|
>|---|---|
>|**Description**|Um utilizador não pode reportar a sua review|
>|**Justification**|Um utilizador não tem forma de reportar a sua *review*, porque em vez de o fazer pode editá-la para ir de encontro ao seu pensamento atual. Este trigger garante que a *business rule* 5 é cumprida.|
>
>**SQL code:**
```
CREATE FUNCTION check_report_privileges()
RETURNS TRIGGER AS
$$ BEGIN
    IF EXISTS (SELECT id_user
               FROM review
               WHERE id_review = NEW.id_review AND id_user = NEW.id_user)
    THEN
        RAISE EXCEPTION 'A user cannot report his own review';
    END IF;
    RETURN NEW;
END; $$
LANGUAGE plpgsql;

CREATE TRIGGER before_report_insert
BEFORE INSERT ON report
FOR EACH ROW
EXECUTE PROCEDURE check_report_privileges();
```
>|**User Defined Function**|UDF01|
>|---|---|
>|**Description**|Verificar o stock dos produtos no momento da adição ao carrinho|
>|**Justification**|Esta função permite verificar se existe *stock* do produto pretendido, para assim poder ser adicionado ao carrinho sem conflitos.|
>
>**SQL code:**
```
CREATE FUNCTION check_stock(Product details)
RETURNS INTEGER AS
$$ BEGIN
    IF Product.quantity = 0 THEN
        RAISE EXCEPTION 'Product out of stock';
    END IF;
    RETURN 1;
END; $$
LANGUAGE plpgsql;
```
>|**User Defined Function**|UDF02|
>|---|---|
>|**Description**|Adicionar um artigo ao carrinho|
>|**Justification**|Esta função permite adicionar um produto ao carrinho de compras, quando existe *stock* do mesmo.|
>
>**SQL code:**
```
CREATE FUNCTION add_product_to_cart(Cart user_order, Product details)
RETURNS user_order AS
$$ BEGIN
  IF (Cart.state = 'Shopping Cart') THEN
    IF check_stock(Product) = 1 THEN
        INSERT INTO order_details VALUES (Cart.id, Product.id);
    ELSE
        RAISE EXCEPTION 'Error adding product to cart';
    END IF;
  ELSE
      RAISE EXCEPTION 'Error adding product to cart';
  END IF;
  RETURN Cart;
END; $$
LANGUAGE plpgsql;
```
>|**User Defined Function**|UDF03|
>|---|---|
>|**Description**|Remover um artigo ao carrinho|
>|**Justification**|Esta função permite ao utilizador remover do carrinho de compras um produto que já não deseja.|
>
>**SQL code:**
```
CREATE FUNCTION remove_product_from_cart(Cart user_order, Product details)
RETURNS user_order AS
$$ BEGIN
    IF Cart.state = 'Shopping Cart' THEN
        DELETE FROM order_details WHERE id_order = Cart.id AND id_details = Product.id;
        RETURN Cart;
    ELSE
        RAISE EXCEPTION 'Error removing product from cart';
    END IF;
END; $$
LANGUAGE plpgsql;
```
>|**User Defined Function**|UDF04|
>|---|---|
>|**Description**|Aceder ao preço de um produto com a promoção aplicada|
>|**Justification**|Com esta função é possível ver o preço final do produto com o desconto da respetiva promoção aplicado.|
>
>**SQL code:**
```
CREATE FUNCTION product_price_with_promotion(Product product, Promotion promotion)
RETURNS NUMERIC AS
$$ BEGIN
    RETURN Product.price * (1 - Promotion.discount);
END; $$
LANGUAGE plpgsql;
```

### 4. Transactions

>|Transaction|TRAN01|
>|---|---|
>|Description|Checkout do carrinho|
>|Justification|De forma a manter a consistência da base de dados durante o checkout do carrinho, será preciso efeturar uma transaction de modo a atualizar o stock do produto depois de este ser associado a um cart. O nível de isolamento é REPEATABLE READ, pois queremos aceder à base de dados num estado anterior ao inicio da transaction.|
>|Isolation level|REPEATABLE READ|
>
>**SQL code:**
```
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO details(id, quantity, id_product, id_size, id_color)
VALUES ($id_details, $quantity, $id_product, $id_size, $id_color);

SELECT add_product_to_cart($id_order, $details);

-- Remove products from the stock
FROM (
    SELECT id_order, id_product, quantity, color, size
    FROM details INNER JOIN order_details
    ON details.id = order_details.id_details
    WHERE id_order = $id_order
) AS order_products
WHERE stock.id_product = order_products.id_product AND 
      stock.size = order_products.size AND 
      stock.color = order_products.color AND
      stock.stock >= order_products.quantity;
SET stock = stock - quantity;

END TRANSACTION;
```
>|Transaction|TRAN02|
>|---|---|
>|Description|Cancelar uma encomenda|
>|Justification|Para cancelar uma encomenda é preciso uma *transaction* para cobrir as alterações que devem ser feitas no *stock* e nas encomendas do utilizador. Para isso tem que se garantir que estas operações são realizadas no mesmo estado da base de dados. Assim o nível de isolamento prentendido será REPEATABLE READ.|
>|Isolation level|REPEATABLE READ|
>
>**SQL code:**
```
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Delete order row
UPDATE user_order
SET status="Cancelled"
WHERE id=$id_order;

-- Restore the products from the cancelled order
UPDATE stock
SET stock = stock + quantity 
FROM (
    SELECT id_order, id_product, quantity, color, size
    FROM details INNER JOIN order_details
    ON details.id = order_details.id_details
    WHERE id_order = $id_order
) AS order_products(id_order, id_product, quantity, color, size)
WHERE stock.id_product = order_products.id_product AND
      stock.size = order_products.size AND 
      stock.color = order_products.color;

SELECT remove_product_from_cart($id_order, $details);

END TRANSACTION;
```
>|Transaction|TRAN03|
>|---|---|
>|Description|Adicionar um artigo|
>|Justification|Para manter a integridade e consistência da base de dados é necessária uma *transaction* para adicionar um novo artigo e garantir que todo o código executa sem erros. O nível de isolamento é REPEATABLE READ, porque ao inserir um novo produto, apenas se deve ter em conta o estado da base de dados antes da *transaction* começar.|
>|Isolation level|REPEATABLE READ|
>
>**SQL code:**
```
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Insert product
INSERT INTO product (id, name, description, price, id_category)
VALUES ($id_product, $name, $description, $price, $id_category);

-- Insert image
INSERT INTO image (id, file)
VALUES ($id_image, $file);

-- Insert the product image
INSERT INTO product_image(id_product, id_image) 
VALUES ($id_product, $id_image);

-- Insert product color if not exists
IF NOT EXISTS (SELECT * FROM color WHERE name=$name_color)
BEGIN
    INSERT INTO color (id, name)
    VALUES ($id, $name);
END

-- Insert product size if not exists
IF NOT EXISTS (SELECT * FROM size WHERE name=$name_size)
BEGIN
    INSERT INTO size (id, name)
    VALUES ($id, $name_size);
END

-- Insert the new product in stock
INSERT INTO stock (stock, id_product, id_size, id_color) 
VALUES (1, $id_product, $id_size, $id_color)
ON DUPLICATE KEY UPDATE
  stock = stock + 1;

END TRANSACTION;

```
>|Transaction|TRAN04|
>|---|---|
>|Description|Remover um artigo|
>|Justification|Ao remover um artigo temos de o apagar de várias tabelas, como o stock, product e também a sua imagem. Desta forma, é preciso uma transaction para remover um artigo, e para que transactions concurrentes não interferiram nesta operação será utilizado o nível de isolamento REPEATABLE READ.|
>|Isolation level|REPEATABLE READ|
>
>**SQL code:**
```
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Delete product images
DELETE FROM product_image
WHERE id_product = $id_product;

DELETE FROM image
WHERE id IN (SELECT id FROM image WHERE id=$id_image);

-- Delete the product from stock
DELETE FROM stock
WHERE id_product = $id_product

-- Delete product
DELETE FROM product
WHERE id=$id_product

END TRANSACTION;
```

## Annex A. SQL Code

### A.1. Database schema

![](https://i.imgur.com/0fxtCb2.png)
![](https://i.imgur.com/gzxC1Mh.png)
![](https://i.imgur.com/bhXnXc8.png)
![](https://i.imgur.com/9tqpZHq.png)
![](https://i.imgur.com/GdU7Shm.png)
![](https://i.imgur.com/T2AR1q9.png)
![](https://i.imgur.com/Tw0Ui6n.png)
![](https://i.imgur.com/0Vb1lGr.png)
![](https://i.imgur.com/oa6eG5z.png)
![](https://i.imgur.com/fgCsDGn.png)
![](https://i.imgur.com/kZObRbh.png)
![](https://i.imgur.com/Z7cqowA.png)
![](https://i.imgur.com/Sn2HIcC.png)

### A.2. Database population

![](https://i.imgur.com/w6o3hAh.png)
![](https://i.imgur.com/iTE4iaY.png)
![](https://i.imgur.com/krQRUn9.png)
![](https://i.imgur.com/pHkcrqC.png)
![](https://i.imgur.com/OqewxSX.png)
![](https://i.imgur.com/n0VbszF.png)
![](https://i.imgur.com/5hqBfeZ.png)
![](https://i.imgur.com/yYl8vUW.png)
![](https://i.imgur.com/GJRlIVr.png)
![](https://i.imgur.com/jjHOqxR.png)
![](https://i.imgur.com/UzWvoDe.png)
![](https://i.imgur.com/LypUIMB.png)
![](https://i.imgur.com/AT6VFbJ.png)
![](https://i.imgur.com/p2Nz7Fk.png)
![](https://i.imgur.com/f50G1Yx.png)
![](https://i.imgur.com/2RA6GAX.png)
![](https://i.imgur.com/5SagheC.png)
![](https://i.imgur.com/yO5sQ9I.png)
![](https://i.imgur.com/Dc41ohf.png)
![](https://i.imgur.com/d2YtjSW.png)
![](https://i.imgur.com/S7YoGpt.png)
![](https://i.imgur.com/12WWkqH.png)
![](https://i.imgur.com/0gJAJTe.png)
![](https://i.imgur.com/4m93fyH.png)

---

## Revision history

(não aplicável de momento)

---

GROUP2251, 26/10/2022

* Membro 1 - Alexandre Correia, up202007042@edu.fe.up.pt
* Membro 2 - Ana Sofia Costa, up202007602@edu.fe.up.pt
* Membro 3 - Daniel Rodrigues, up202006562@edu.fe.up.pt (Editor)
* Membro 4 - Diogo Fonte, up202004175@edu.fc.up.pt