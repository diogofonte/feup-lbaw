# ER: Requirements Specification Component

> Oferecer aos adultos, uma alternativa mais prática e inovadora de adquirir artigos de moda de qualidade.

---

## A1: About Fashion

>O sistema da About Fashion está a ser desenvolvido por uma pequena equipa de futuros engenheiros como um produto direcionado a utilizadores que queiram visualizar e/ou adquirir artigos da marca a partir da Internet.
>
>O nosso objetivo principal resume-se ao desenvolvimento de um *site* para a venda de roupa, acessórios e calçado, direcionado a adultos. Esta plataforma permite aos utilizadores estar facilmente a par dos artigos/promoções disponíveis no momento. Será possível gerir utilizadores, adicionar produtos e promoções e tratar da logística comercial do ponto de vista administrativo. Do ponto de vista do cliente será possível ver produtos em que poderá estar interessado, realizar compras *online* e gerir todos os seus dados presentes na sua conta. Será necessária uma equipa de administradores para gerir o sistema e certificar o seu bom funcionamento.
>
>Os intervenientes no sistema estão separados em grupos com diferentes permissões. Estes grupos incluem:
>
> - os técnicos responsáveis pela manutenção do sistema e gestão das contas dos utilizadores;
> - os colaboradores responsáveis pela parte comercial, como, por exemplo, adição de produtos, promoções, gestão de encomendas, etc.;
> - os utilizadores autenticados e não autenticados que usufruirão do sistema.
>
>Para navegação do sistema, será possível procurar por produtos através de uma barra de pesquisa e/ou por um menu que contém as diferentes categorias de artigos. Esta navegação está acessível a todos os utilizadores.
>
>O produto final irá providenciar fácil utilização e uma experiência agradável ao utilizador. Os padrões de acessibilidade serão cumpridos para não restringir os utilizadores e haverá portabilidade entre dispositivos e sistemas operativos. Existirá bastante cuidado com a segurança das credenciais e informações pessoais.

---

## A2: Actors and User stories
### 1. Actors

>![](https://i.imgur.com/ZZhdoKa.png)
><center>(Figura 1: Atores da About Fashion)</center><br>
>
>|Identificador|Descrição|
>|---|---|
>|Utilizador|Utilizador genérico. Tem acesso aos produtos e respetiva descrição, *reviews* feitas por outros utilizadores (autenticados) e às informações da empresa. Além disso, pode adicionar itens ao carrinho e geri-lo|
>|Utilizador Autenticado|Pessoa autenticada que, para além das interações com o sistema herdadas da sua classe mais genérica (utilizador), consegue ver o seu perfil (e editá-lo), o histórico de compras e notificações pessoais. Também consegue adicionar artigos aos favoritos e removê-los da lista, apagar a conta, finalizar a compra, obter informações das encomendas pendentes e avaliar os produtos que adquiriu|
>|Utilizador Não Autenticado|Pessoa não autenticada que, para além das interações com o sistema herdadas da sua classe mais genérica (utilizador), consegue registar-se no sistema, entrar na sua conta (caso possua uma) e recuperar o acesso|
>|Administrador|Pessoa autenticada responsável pela gestão do sistema|
>|Técnico|Administrador responsável pela parte técnica do sistema, gestão dos utilizadores/administradores dos sistemas e resolução dos *reports*|
>|Colaborador|Administrador responsável pela parte comercial. Pode adicionar, alterar ou remover artigos e respetivas promoções. Também tem acesso a estatísticas e ao histórico de compras dos utilizadores autenticados|
>|API Banco|API externa responsável pela comunicação com o banco e eventuais pagamentos| 
><center>(Tabela 1: Descrição dos atores da About Fashion)</center><br>


### 2. User Stories


#### 2.1 Utilizador

>|Identificador|Nome|Prioridade|Descrição|
>|---|---|---|---|
>|US01|Resultado exato da pesquisa|Elevada|Como utilizador, quero ter um resultado exato da procura que efetuei, para conseguir aceder ao produto que pretendo de forma eficaz|
>|US02|Pesquisa de texto completo|Elevada|Como utilizador, quero ter a possibilidade de escrever bastante texto, para poder identificar melhor o artigo que procuro|
>|US03|Ver lista de produtos|Elevada|Como utilizador, quero ver os produtos disponíveis no sistema, para poder ver a oferta de artigos da marca|
>|US04|Ver detalhes do produto|Elevada|Como utilizador, quero ver os detalhes de um produto, para obter mais informações sobre o artigo da marca|
>|US05|Adicionar produto ao carrinho|Elevada|Como utilizador, quero adicionar um produto ao carrinho, para fazer a encomenda do mesmo|
>|US06|Gerir carrinho|Elevada|Como utilizador, quero gerir o meu carrinho, para poder remover produtos que já não pretenda encomendar|
>|US07|Procurar produtos|Elevada|Como utilizador, quero pesquisar por produtos no sistema, para poder encontrar um artigo de forma mais fácil e direta|
>|US08|Pesquisa em múltiplos atributos|Média|Como utilizador, quero poder pesquisar por algo e ter um resultado sobre múltiplos atributos, para conseguir ter acesso a vários produtos que se identifiquem com a minha pesquisa|
>|US09|Filtros de pesquisa|Média|Como utilizador, quero poder filtrar a minha pesquisa, para poder aceder a produtos que vão mais de encontro ao que pretendo|
>|US10|Formulários de ajuda|Média|Como utilizador, quero ter a possibilidade de enviar um formulário de ajuda, para poder esclarecer as minhas dúvidas ou resolver possíveis problemas que possa ter|
>|US11|Mensagens de erro contextuais|Média|Como utilizador, quero receber uma mensagem de erro, para saber se há algum problema com a plataforma|
>|US12|Ajuda contextual|Média|Como utilizador, quero receber ajuda indicada para o meu problema, para assim poder resolvê-lo de forma mais eficaz e rápida|
>|US13|Página *About US*|Média|Como utilizador, quero aceder a uma página com informação da About Fashion, para conhecer mais acerca da marca e dos seus objetivos|
>|US14|Funcionalidades principais|Média|Como utilizador, quero saber quais são as funcionalidades principais presentes no *site*, para perceber e saber mais acerca da plataforma|
>|US15|Contactos|Média|Como utilizador, quero ter acesso aos contactos da About Fashion, para poder resolver algum problema ou esclarecer-me quanto a algum assunto|
>|US16|Ver menu de categorias|Média|Como utilizador, quero ver todas as categorias de artigos da marca, para ter a possibilidade de escolher uma em específico e filtrar a minha procura por um artigo|
>|US17|Ver *reviews* do produto|Média|Como utilizador, quero ver as avaliações/opiniões de um produto, para ter conhecimento da opinião de outros utilizadores que já compraram o artigo em que estou interessado|
>|US18|Ordenação de resultados|Baixa|Como utilizador, quero poder ordenar os resultados da minha pesquisa, para assim decidir a ordem pela qual me aparecem no ecrã|
><center>(Tabela 2: User stories do Utilizador)</center><br>


#### 2.2. Utilizador Não Autenticado

>|Identificador|Nome|Prioridade|Descrição|
>|---|---|---|---|
>|US19|Entrar na conta|Elevada|Como utilizador não autenticado, quero fazer *log in* no sistema, para ter acesso a informação priveligiada e às minhas informações pessoais (endereços, encomendas e estados das mesmas, lista de favoritos, vouchers, etc)|
>|US20|Criar conta|Elevada|Como utilizador não autenticado, quero registar-me no sistema, para poder efetuar a minha encomenda e posteriormente ter acesso às vantagens de possuir uma conta|
>|US21|Recuperar password|Média|Como utilizador não autenticado, quero recuperar a minha password, para assim conseguir voltar a ter acesso à minha conta|
><center>(Tabela 3: User stories do Utilizador Não Autenticado)</center><br>

#### 2.3. Utilizador Autenticado

>|Identificador|Nome|Prioridade|Descrição|
>|---|---|---|---|
>|US22|Sair da conta|Elevada|Como utilizador autenticado, quero fazer *log out* no sistema, para poder sair do *site* em segurança ou iniciar sessão com outra conta|
>|US23|Ver histórico de compras|Elevada|Como utilizador autenticado, quero ver o meu histórico de compras no sistema, para encontrar um artigo que encomendei da última vez de forma mais fácil e rápida|
>|US24|Ver perfil|Elevada|Como utilizador autenticado, quero ver o meu perfil registado no sistema, para ter a possibilidade de verificar se todas as minhas informações pessoais estão corretas|
>|US25|Editar perfil|Elevada|Como utilizador autenticado, quero editar o meu perfil, para modificar os meus dados pessoais|
>|US26|Finalizar pedido|Elevada|Como utilizador autenticado, quero finalizar o meu pedido, para poder encomendar os artigos que se encontram no carrinho|
>|US27|Possuir foto de perfil|Média|Como utilizador autenticado, quero ter a possibilidade de adicionar uma foto de perfil à minha conta, para ter um perfil mais detalhado e completo|
>|US28|Apagar conta|Média|Como utilizador autenticado, quero remover a minha conta do sistema, para que eu possa deixar de estar resgistado no sistema|
>|US29|Ver notificações pessoais|Média|Como utilizador autenticado, quero ver as minhas notificações pessoais, para estar a par de todas as novidades/promoções|
>|US30|Adicionar artigo à lista de favoritos|Média|Como utilizador autenticado, quero adicionar um produto à minha lista de favoritos, para poder guardar o artigo e mais tarde encomendá-lo|
>|US31|Gerir lista de favoritos|Média|Como utilizador autenticado, quero gerir que produtos possuo na lista de favoritos, para ter apenas artigos que gosto no momento na lista|
>|US32|*Review* de artigo adquirido|Média|Como utilizador autenticado, quero registar no sistema uma *review* de um produto que adquiri e utilizei, para expor a minha avaliação/opinião do artigo|
>|US33|Editar *review*|Média|Como utilizador autenticado, quero editar a minha *review* de um certo produto, para poder modificar algo que escrevi|
>|US34|Remover *review*|Média|Como utilizador autenticado, quero apagar a minha *review*, para deixar de partilhar a minha opinião e avaliação sobre o produto no sistema|
>|US35|Seguir encomenda|Média|Como utilizador autenticado, quero seguir a minha encomenda no sistema, para ter noção de quanto tempo falta para a sua receção|
>|US36|Cancelar encomenda|Média|Como utilizador autenticado, quero cancelar a minha encomenda na plataforma, para poder alterar a minha decisão de compra|
>|US37|Notificação - Pagamento aprovado|Média|Como utilizador autenticado, quero receber uma notificação quando o pagamento for aprovado, para saber quando foi feita a cobrança do valor e esperar pela entrega da encomenda|
>|US38|Notificação - Mudança de estado de encomenda|Média|Como utilizador autenticado, quero ser notificado quando a minha encomenda mudar de estado, para ter noção de quanto tempo falta para receber o produto que pedi|
>|US39|Notificação - Produto na lista de favoritos disponível|Média|Como utilizador autenticado, quero receber uma notificação quando um produto em que tenho interesse esteja disponível, para conseguir encomendar o artigo antes de deixar de haver *stock* novamente|
>|US40|Notificação - Mudança de preço do artigo no carrinho de compras|Média|Como utilizador autenticado, quero ser notificado se o preço de um dos artigos que tenho no carrinho for alterado, para não encomendar algo que custe mais do valor que pretendo gastar|
>|US41|Recomendações de produtos|Baixa|Como utilizador autenticado, quero receber recomendações de produtos, para encontrar artigos que devo gostar sem estar à procura|
>|US42|Gerir vários métodos de pagamento|Baixa|Como utilizador autenticado, quero gerir os métodos de pagamento que tenho associados à minha conta, para ter à disposição diversas formas de pagamento de forma fácil e direta|
>|US43|Reportar *review*|Baixa|Como utilizador autenticado, quero reportar avaliações, para alertar o sistema de uma avaliação/opinião inapropriada|
><center>(Tabela 4: User stories do Utilizador Autenticado)</center><br>

#### 2.5 Administrador

>|Identificador|Nome|Prioridade|Descrição|
>|---|------|---|---|
>|US44|Possuir conta|Média|Como administrador, quero possuir uma conta, para poder explorar e gerir o sistema e resolver possíveis problemas|
>|US45|Iniciar sessão|Média|Como administrador, eu quero fazer *log in* com a minha conta, para ter acesso às minhas funções e permissões.
>|US46|Terminar sessão|Média|Como administrador, eu quero fazer *log out* do sistema, para que seja possível sair da plataforma em segurança e/ou iniciar sessão com outra conta.
><center>(Tabela 5: User stories do Administrador)</center><br>

#### 2.4. Colaborador

>|Identificador|Nome|Prioridade|Descrição|
>|---|---|---|---|
>|US47|Adicionar artigo|Média|Como colaborador, quero adicionar um produto no sistema, para que o artigo da marca seja disponibilizado aos clientes no *site*|
>|US48|Gerir a informação dos produtos|Média|Como colaborador, quero ter controlo sobre as informações dos produtos, para poder modificar a descrição dos artigos disponibilizados no sistema|
>|US49|Gerir o *stock* dos produtos|Média|Como colaborador, quero ter controlo sobre o *stock* de um artigo no sistema, para poder alterá-lo consoante a disponibilidade do armazém e da fábrica|
>|US50|Gerir as categorias de artigos|Média|Como colaborador, quero ter controlo sobre as categorias de produtos no sistema, para poder adicionar ou remover alguma categoria|
>|US51|Ver histórico de compras dos utilizadores|Média|Como colaborador, quero ter acesso ao histórico de compras dos utilizadores, para poder verificar que artigos foram adquiridos recentemente e conseguir analisar estatísticas|
>|US52|Controlar o estado das encomendas|Média|Como colaborador, quero ter controlo sobre o estado das encomendas, para poder informar os clientes do processo dos seus pedidos|
>|US53|Ver estatísticas de vendas|Baixa|Como colaborador, quero ver as estatísticas das vendas da marca, para informar a About Fashion em que produtos deva investir mais ou menos e ter dados para analisar o rendimento da empresa|
>|US54|Gerir descontos de artigos|Baixa|Como colaborador, quero ter controlo sobre os descontos aplicados aos produtos, para poder adicionar/remover/modificar as promoções de um ou mais artigos|
><center>(Tabela 6: User stories do Colaborador)</center><br>

#### 2.5. Técnico

>|Identificador|Nome|Prioridade|Descrição|
>|---|---|---|---|
>|US55|Administrar contas de utilizadores (pesquisar, ver, editar, criar)|Elevada|Como administrador técnico, quero ter acesso completo às contas dos utilizadores, para poder gerir e resolver possíveis problemas que os utilizadores tenham com elas|
>|US56|Bloquear contas de utilizadores|Média|Como técnico, quero bloquear a conta de um utilizador, para o impedir de fazer alguma encomenda no sistema|
>|US57|Desbloquear contas de utilizadores|Média|Como administrador técnico, quero desbloquear a conta de um utilizador, para o permitir fazer avaliações de artigos|
>|US58|Eliminar contas de utilizadores|Média|Como técnico, quero apagar contas de utilizadores, para poder remover contas de clientes que foram inapropriados|
>|US59|Gerir *reports*|Baixa|Como administrador técnico, quero gerir *reports*, para poder modificar o sistema consoante algum aviso de um utilizador|
><center>(Tabela 7: User stories do Técnico)</center><br>

### 3. Supplementary Requirements
#### 3.1. Business rules

>|Identificador|Nome|Descrição|
>|---|---|---|
>|BR01|Eliminação de conta de utilizador|Depois de uma conta ser apagada, a sua informação partilhada (comentários, avaliações, gostos) é mantida mas de forma anónima|
>|BR02|*Reviews*|Apenas é permitido fazer uma avaliação a um produto a um utilizador autenticado que tenha adquirido um exemplar|
>|BR03|Contas de administradores|Contas de administradores são independentes das contas dos utilizadores. Não é possível fazer uma compra com uma conta de administrador|
>|BR04|Gostos nas próprias *reviews*|Um utilizador não pode gostar da própria *review*, apenas *reviews* dadas por outros utilizadores|
>|BR05|Conflitos de datas|Para evitar conflitos de datas, as datas de encomendas terão que ser mais antigas que as datas de expedição dos artigos, e por sua vez, as datas de expedição terão que ser mais antigas que as datas de entrega|
><center>(Tabela 8: About Fashion business rules)</center><br>

#### 3.2. Technical requirements

>|Identificador|Nome|Descrição|
>|---|---|---|
>|**TR01**|**Aplicação *web***|**O sistema deve ser implementado na forma de aplicação *web* com páginas dinâmicas (HTML5, JavaScript, CSS3 e PHP). <br> É de grande importância que o sistema da About Fashion seja acessível a partir de qualquer sítio e de qualquer aparelho eletrónico, sem necessidade de instalar uma aplicação. São adotadas tecnlogias *web standard***|
>|**TR02**|**Segurança**|**O sistema deve garantir a proteção da informação de todos os utilizadores, fazendo a encriptação das suas credenciais e informações pessoais privadas. <br> Como o sistema lida com informações pessoais privadas e métodos de pagamento, é crítico existir várias proteções para não permitir fuga de dados e posteriormente divulgação. Para conseguirmos atingir este objetivo, será desenvolvido um algortimo de encriptação para estes dados mais significativos e de grande valor**|
>|**TR03**|**Robustez**|**O sistema deve estar preparado para lidar e continuar a funcionar quando ocorrerem erros durante o tempo de execução. <br> Este ponto também é de grande importânica para a plataforma da About Fashion, porque por exemplo, um pagamento não pode ficar a meio, tem que ser dado como concluído ou por processar. O sistema terá que guardar pequenas capturas do processo da encomenda, para que nenhum dado seja perdido**|
>|TR04|*Performance*|O sistema deve ter tempos de resposta mais curtos que 2 segundos para garantir a atenção do utilizador|
>|TR05|Escalabilidade|O sistema deve estar preparado para lidar com o crescimento do número de utilizadores e as suas ações|
>|TR06|Acessibilidade|O sistema deve garantir que todos possam aceder às páginas, independentemente de terem ou não alguma deficiência e do *browser* que utilizam|
>|TR07|Capacidade de serviço|O sistema deve conseguir responder a todos os utilizadores do sistema (mesmo em sobrecarga) enquanto cumpre todos os objetivos de desempenho|
>|TR08|Portabilidade|O sistema deve conseguir cumprir todos os objetivos de desempenho em diferentes aparelhos eletrónicos e sistemas operativos|
><center>(Tabela 9: About Fashion technical requirements)</center><br>


#### 3.3. Restrictions

>|Identificador|Nome|Descrição|
>|---|---|---|
>|R01|Prazo final|O sistema deve estar pronto para ser usado em meados de Dezembro|
><center>(Tabela 10: About Fashion restrictions)</center><br>

---

## A3: Information Architecture

>Com a apresentação do *sitemap* e dos *wireframes* será possível ter uma breve representação da arquitetura de informação do sistema da About Fashion. Os objetivos principais são os seguintes:
> - Identificar, descrever e descobrir novas condições para os utilizadores;
> - Testar várias formas de disposição dos elementos nas páginas;
> - Identificar as páginas que farão parte da plataforma.

### 1. Sitemap

> O *sitemap* define a maneira como a informação do sistema é organizada em diversas páginas.
> O sistema da About Fashion está organizado em quatro áreas principais:
> - páginas de administrador, onde os técnicos e os colaboradores podem realizar as suas funções (*Admin Pages*);
> - páginas estáticas, onde pode ser encontrada informação genérica relativa ao sistema (*Static Pages*);
> - páginas de produtos, usadas para explorar toda a coleção de artigos da plataforma e gerir o carrinho de compras (*Items Pages*);
> - páginas do utilizador, onde este pode gerir os seus dados e consultar informações sobre encomendas (*User Pages*).
> 
>![](https://i.imgur.com/ArHo1hM.png)
><center>(Figura 2: About Fashion sitemap)</center><br>

### 2. Wireframes

> Um conjunto de *wireframes* permite definir funcionalidades e a disposição do conteúdo em algumas páginas principais do sistema.
> Os *wireframes* para as páginas "Home", "User Profile", "Product Details" e "Products Catalog" do sistema da About Fashion são apresentados nas figuras 3, 4, 5 e 6, respetivamente.

#### UI01: Home
>![](https://i.imgur.com/WRGMI5N.png)
><center>(Figura 3: Home (UI01) wireframe)</center><br>
>    
> - 1: Menu para aceder ao catálogo de produtos por categorias
> - 2: Lupa para aceder diretamente à barra de pesquisa e procurar pelo que pretender
> - 3: Zona de notificações
> - 4: Ícone para aceder à página do perfil
> - 5: Ícone para aceder à lista de favoritos
> - 6: Zona para aceder ao carrinho de compras e funcionalidades do mesmo
> - 7: Promoção a decorrer no momento
> (Nota: Os pontos 3, 4 e 5 requerem autenticação do utilizador)

#### UI17: User Profile
>![](https://i.imgur.com/q8fOR8E.png)
><center>(Figura 4: User Profile (UI17) wireframe)</center><br>
>
> - 1: *Breadcrumbs* para ajudar o utilizador na navegação
> - 2: Zona de encomendas (gestão/acompanhamento de encomendas em progresso, histórico e detalhes de encomendas terminadas)
> - 3: Zona com a lista de favoritos do utilizador
> - 4: *Reviews* escritas pelo utilizador
> - 5: Ícone que ativa a edição dos dados pessoais
> - 6: Foto de perfil do utilizador
> - 7: Opção de apagar/eliminar a conta
> (Nota: Esta página e páginas derivadas desta, necessitam de autenticação)

#### UI12: Product Details Page
>![](https://i.imgur.com/A6zgn4J.png)
><center>(Figura 5: Product Details (UI12) wireframe)</center><br>
>
> - 1: Foto do produto em questão
> - 2: Ícone para poder adicionar o artigo à lista de favoritos (requer autenticação do utilizador)
> - 3: Zona de apresentação das *reviews* atribuídas ao produto (dadas por outros utilizadores e/ou pelo próprio)

#### UI11: Products Catalog Page
>![](https://i.imgur.com/76FCYq8.png)
><center>(Figura 6: Products Catalog (UI11) wireframe)</center><br>
>
> - 1: Zona de filtros para poder facilitar na procura do artigo que é pretendido
> - 2: Zona de ordenação para ser possível escolher a forma e ordem de como são apresentados os artigos

---

## Revision history

Mudanças feitas à primeira submissão:

1) retirou-se o *user storie* 41 - Gerir *vouchers* - prioridade baixa - "Como utilizador autenticado, quero ver e gerir os *vouchers* que tenho disponíveis no momento, para saber quando devo fazer uma encomenda e conseguir aproveitar os descontos"; A numeração dos *user stories* seguintes foi alterada devido à eliminação deste ponto. (18/10/2022)

---

GROUP2251, 18/10/2022

* Membro 1 - Alexandre Correia, up202007042@edu.fe.up.pt
* Membro 2 - Ana Sofia Costa, up202007602@edu.fe.up.pt
* Membro 3 - Daniel Rodrigues, up202006562@edu.fe.up.pt
* Membro 4 - Diogo Fonte, up202004175@edu.fc.up.pt (Editor)
