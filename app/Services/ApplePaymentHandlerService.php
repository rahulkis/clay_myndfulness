<?php
namespace App\Services;

use App\Exceptions\AppStorePaymentValidationException;
use App\Exceptions\InvalidSecretKeyException;
use Config;
use Exception;
use ReceiptValidator\iTunes\Validator as iTunesValidator;

class ApplePaymentHandlerService
{
    public function verify($receiptBase64Data)
    {
        // validate in production
        $production_response = $this->fetchResponseFromReceipt($receiptBase64Data, iTunesValidator::ENDPOINT_PRODUCTION);
        if ($production_response) {
            return $production_response;
        }
        // validate in sandbox
        return $this->fetchResponseFromReceipt($receiptBase64Data, iTunesValidator::ENDPOINT_SANDBOX);
    }
    private function fetchResponseFromReceipt($receiptBase64Data, $endpoint)
    {

        $validator = new iTunesValidator($endpoint); // Or iTunesValidator::ENDPOINT_SANDBOX if sandbox testing
        try {
            $response     = $validator->setReceiptData($receiptBase64Data)->validate();
            $sharedSecret = Config::get("modules.APP_STORE_KEY"); // Generated in iTunes Connect's In-App Purchase menu
            if (!$sharedSecret) {
                throw new InvalidSecretKeyException("Invalid secret key.");
            }
            $response = $validator->setSharedSecret($sharedSecret)
                ->setReceiptData($receiptBase64Data)
                ->validate(); // use setSharedSecret() if for recurring subscriptions
        } catch (Exception $e) {
            throw new AppStorePaymentValidationException($e->getMessage());
        }

        if ($response->isValid()) {

            $purchases = [];

            foreach ($response->getPurchases() as $purchase) {
                $item                            = [];
                $item['product_id']              = $purchase->getProductId();
                $item['original_purchase_date']  = $purchase['original_purchase_date'];
                $item['transaction_id']          = $purchase->getTransactionId();
                $item['expires_date']            = $purchase['expires_date'];
                $item['expires_date_ms']         = $purchase['expires_date_ms'];
                $item['original_transaction_id'] = $purchase['original_transaction_id'];
                $purchases[]                     = $item;
            }
            $array_cols = array_column($purchases, 'expires_date_ms');
            array_multisort($array_cols, SORT_DESC, $purchases);
            //return the latest purchase
            return $purchases[0];
        } else {
            return false;
        }
    }

}
