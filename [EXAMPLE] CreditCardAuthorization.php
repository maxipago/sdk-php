<?php
// Inclui o arquivo de chamada à maxiPago! //
include_once "maxipago_payment.php";

// Determina as credenciais da loja //
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");

// Versão da API, que pode ser checada aqui. //
define("version", "3.1.1.15");

// URL para envio da transação. Útil para apontar entre os ambientes de Teste e Produção //
define("url", "https://www.url.com.");

// Dados básicos obrigatórios para uma transação //
$data = array(
  "debug" => "1", // Modo debug. Imprime os XMLs de requisição e resposta na tela. //
  "processorID" => "1", // Código da operadora de cartão usada. //
  "referenceNum" => "TestTransaction123", // Número do Pedido. Recomenda-se ser único. //
  "chargeTotal" => "100.00", // Valor do pedido. Decimais separado por ponto ("."). //
  "numberOfInstallments" => "2", // Número de parcelas. Não enviar se for à vista //
  "chargeInterest" => "N", // Cobrança de juros (parcelado loja x cartão). Não enviar se for à vista //
  "bname" => "Fulano de Tal", // Nome do cliente //
  "number" => "5555555555554444", // Número do cartão de crédito //
  "expMonth" => "12", // Mês de vencimento //
  "expYear" => "2020", // Ano de vencimento com 4 dígitos //
  "cvvNumber" => "111", // Código de segurança do cartão //
); 

// Chama a função 'maxipago_payment' passando como Operação uma Venda Direta ("sale") //
$transaction = maxipago_payment("auth", $credentials, $data, version, url);

// Imprime o array de retorno //
print_r($transaction);
?> 