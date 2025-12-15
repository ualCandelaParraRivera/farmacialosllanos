<?php

require __DIR__  . '/vendor/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ASluQE8pQPTJA9GtfFMg3I3EdXssslkTsEhC7WP86lX7ifgcEg-OYKyh9aLtmoZJ68gfJw2k1GpuFS1K',     // ClientID
        'ENdDRjDYpulvJ_qzFGf1r_UIeF-DsIC8HYWwGR404BnAo9Muy8f5wbUdDEMYzWySo97o2nu0rpRC_tz-'      // ClientSecret
    )
);

$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal('1.00');
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl("https://example.com/your_redirect_url.html")
    ->setCancelUrl("https://example.com/your_cancel_url.html");

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
    echo $payment;

    echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getData();
}