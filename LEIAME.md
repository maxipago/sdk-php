## Introdução ##

Esta biblioteca PHP visa facilitar a integração com a API da **maxiPago! Smart Payments**. Nossa plataforma permite aos lojistas virtuais aceitarem pagamentos em diversos países da América Latina e nos EUA e inclui funcionalidades como Cobrança Recorrente Automática, Pagamentos com 1-Clique, Estornos Online, Conciliação de Cartões de Crédito e Ferramentas Anti-Fraude. Se quiser saber mais sobre a **maxiPago!** visite [www.maxipago.com](http://www.maxipago.com/).

Esta biblioteca traz todas as funcionalidades atualmente disponívels na plataforma e ela pode ser copiada e usada livremente por Lojas e desenvolvedores.

Para ter uma visão mais aprofundada da nossa API baixe nossa documentação, [disponível aqui](http://www.maxipago.com/docs/maxiPago_API_Ultima.pdf). Se você está procurando por uma solução de página hospedada ("hosted payment page"), por favor veja a seção _**smartPages!**_.


## Tipos de transação ##

* **Autorização:** verifica se o cartão de crédito usado é válido (número, CVV e data de validade) e se o comprador possui limite suficiente para a compra.

* **Captura:** confirma a autorização feita para aquele pedido e completa a transação. Se a transação nunca for capturada o Estabelecimento não receberá o dinheiro e o comprador não será cobrado.

>*Separar a autorização e a captura em dois momentos diferentes é uma ótima maneira de checar se você tem os produtos em estoque ou fazer uma análise de fraude, e ainda assim garantir o pagamento.*

* **Venda Direta:** combina a autorização e a captura em uma mesma chamada. Ao usar a requisição de Venda Direta você estará fazendo uma autorização no cartão do cliente e imediatamente capturando o valor total.

* **Void:**: cancela uma captura antes do fechamento do lote final do dia. Aqui o dinheiro não troca de mãos. Você só pode cancelar a venda até às 23h59 do dia da captura.

* **Estorno:** reverte uma transação de cartão de crédito, debitando o valor do Estabelecimento e devolvendo-o ao comprador. O estorno é uma operação financeira e, por esta razão, pode demorar alguns dias para serem aprovados por algumas processadoras.

* **Recorrente:** agenda uma transação de cartão de crédito para ser cobrada em um intervalo específico, definido pelo lojista.

* **Armazenar Cartão:** guarda um cartão em nosso sistema e devolve um token único, que pode ser usado em novas transações. **Isto permite a implantação de pagamentos com 1-clique no seu site.**

* **Boleto:** Transações feitas com Boleto funcionam de forma diferente das transações com cartão de crédito. Aqui geramos um boleto e retornamos uma URL para comprador que dá acesso ao boleto. Ela pode ser acessada a qualquer momento antes do vencimento do boleto e até 60 dias após o vencimento.

## Installação e configuração ##

A biblioteca foi testada no **PHP 5.1.6 e acima** e consiste dos seguintes arquivos:

```
  /lib/  
  |-- maxiPago.php  
  |-- maxipago  
    |-- maxiPagoRequest.php  
    |-- maxiPagoRequestBase.php  
    |-- maxiPagoResponseBase.php  
    |-- maxiPagoServiceBase.php  
    |-- maxiPagoTransaction.php  
    |-- maxiPagoXmlHandler.php
```


Copie **/lib/maxipago/** para seu servidor. No seu código, inclua o arquivo **maxiPago.php**, que checa os requisitos mínimos e inclui os demais arquivos necessários:

```php
	require_once "./lib/maxiPago.php";
```

Agora, crie um novo object da classe maxiPago:

```php
	$maxiPago = new maxiPago;
```

## Ambiente e Credenciais ##

Para poder enviar requisições você precisará de Credenciais válidas. Você pode conseguí-las com nosso Suporte.

A **maxiPago!** oferece um ambiente de teste (*"sandbox"*) totalmente funcional para simular as transações. Você precisa definir o ambiente para enviar as transações, o que pode ser feito enviando **"TEST"** ou **"LIVE"**:
		
Para definir as credenciais e o ambiente usado:

```php
	$maxiPago->setCredentials("100", "merchant_key");
	$maxiPago->setEnvironment("TEST");
```

## Logs e Modo Debug ##

Em Junho de 2013 [o KLogger de Kenny Katzgrau](https://github.com/katzgrau/KLogger) foi adicionado à esta biblioteca, permitindo que os lojistas logassem a requisição e resposta das transações cumprindo as regras do PCI.

Para habilitar o log use o método **setLogger()** e se certifique que o diretório escolhido tem as permissões corretas. O nível de log padrão é INFO:

```php
    $maxiPago->setLogger(dirname(__FILE__).'/logs','INFO');
```

O Modo Debug imprime os XMLs de requisição e resposta para que você possa facilmente identificar problemas na chamada. Para habilitar o debug use o método **setDebug()**:

```php
	$maxiPago->setDebug(true);
```

## Requisição ##

Para mandar uma requisição para a **maxiPago!** você precisa chamar um dos métodos listados abaixo, passando um array com os parâmetros, como por exemplo:

```php
	$data = array(
		"processorID" => "1",
		"referenceNum" => "ORDER2937283",
		"chargeTotal" => "10.00",
		"number" => "4111111111111111",
		"expMonth" => "07",
		"expYear" => "2017",
		"cvvNumber" => "123"
	);
	
	$maxiPago->creditCardAuth($data);
```

## Resposta ##

Há métodos para resgatar cada parte da resposta. Contudo, você também pode chamar o método **getResult()** para recuperar todos os campos da resposta em um array:

```
	print_r($maxiPago->getResult());
	
	Array
	(
	    [authCode] => 123456
	    [orderID] => 0AF90437:013CC42DDE87:F5D0:01E1101A
	    [referenceNum] => ORD29328493
	    [transactionID] => 422570
	    [transactionTimestamp] => 1312156800
	    [responseCode] => 0
	    [responseMessage] => AUTHORIZED
	    [avsResponseCode] =>
	    [cvvResponseCode] =>
	    [processorCode] => A
	    [processorMessage] => APPROVED
	    [errorMessage] => 
	)
```

## Todos os métodos de requisição ##


#####Transações de Cartão de Crédito#####
* Autorização: **creditCardAuth()**
* Captura: **creditCardCapture()**
* Venda Direta (Autorização + Captura): **creditCardSale()** 
* Salvar cartão automaticamente: **creditCardAuth()** ou **creditCardSale()**
* Cancelamento (*Void*): **creditCardVoid()**
* Estorno: **creditCardRefund()** 
 
#####Transações Recorrentes#####
* Criar nova recorrência: **createRecurring()**
* Cancelar uma recorrência: **cancelRecurring()**
 
#####Transações de Boleto#####
* Criar boleto: **boletoSale()**

#####Relatórios#####
* Sondar uma transação: **pullReport()**
* Sondar uma lista de transações: **pullReport()**
* Paginar a lista de transações: **pullReport()** 
* Sondar um relatório pendente: **pullReport()**
 
#####Cadastro de Cliente / Salvar Cartão#####
* Criar um perfil: *(um perfil precisa ser criado antes de salvar um cartão)* **addProfile()**
* Atualizar um perfil: **updateProfile()** 
* Remover um perfil: **deleteProfile()**
* Adicionar um cartão de crédito: **addCreditCard()**
* Remover um cartão de crédito: **deleteCreditCard()**

## Todos os métodos de resposta ##


#####Validação da chamada#####
* Verifica se houve algum erro na chamada: **isErrorResponse()**
* Verificar se a chamada foi bem sucedida: **isTransactionResponse()**

#####Principais méthodos de resposta#####
* Traz o Código de Resposta (transações/vendas): **getResponseCode()**
* Traz o Código de Autorização, se houver: **getAuthCode()**
* Traz o Order ID criado: **getOrderID()**
* Traz o Transaction ID criado: **getTransactionID()**
* Traz a URL do Boleto *(somente Brasil)*: **getBoletoUrl()**
* Traz o Código da Adquirente: **getProcessorCode()**
* Traz o Numero de Referência da Adquirente: **getProcessorReferenceNumber()**
* Traz o TID da Adquirente: **getProcessorTransactionID()**
* Traz todos os campos da resposta: **getResult()**

#####Outros métodos de resposta#####
* Traz a resposta do AVS *(somente EUA)*: **getAvsResponseCode()**
* Traz o Comando usado na chamada: **getCommand()**
* Traz o Customer ID criado: **getCustomerId()**
* Traz a resposta do CVV: *(somente EUA)* **getCvvResponseCode()**
* Traz o score da análise de fraude: **getFraudScore()**
* Traz a mensagem de resposta: **getMessage()**
* Traz o número de páginas do relatório: **getNumberOfPages()**
* Traz a página atual do relatório: **getPageNumber()**
* Traz o token da página do relatório: **getPageToken()**
* Traz um array com as transações listadas: **getReportResult()**
* Traz a data/hora do relatório: **getTime()**
* Traz o Token criado para o Cartão de Crédito: **getToken()**
* Traz o número de transações no relatório: **getTotalNumberOfRecords()**
* Traz o Unix time da transação: **getTransactionTimestamp()**

## Documentação e Suporte ##

[A documentação completa da API da **maxiPago!** pode ser encontrada aqui](http://www.maxipago.com/docs/maxiPago_API_Ultima.pdf).

Nossa equipe de suporte está à disposição para ajudá-lo com quaisquer assunto, seja sobre funcionalidades de nossa plataforma ou sobre pagamentos em geral. Eles estão disponíveis para clientes e não-clientes no endereço suporte [@] maxipago [.] com.

## Licença ##

Biblioteca de integração para o **Gateway de Pagamento maxiPago!**     
**_Copyright (C) 2013, maxiPago!_**

Este programa é um software livre; você pode redistribui-lo e/ou modifica-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença, ou (na sua opnião) qualquer versão.

Este programa é distribuido na esperança que possa ser  util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU junto com este programa, se não, visite <http://www.gnu.org/licenses/>.
