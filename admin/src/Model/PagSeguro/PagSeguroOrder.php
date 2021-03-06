<?php
/**
 ************************************************************************
Copyright [2014] [David Lima]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
************************************************************************
*/
namespace Model\PagSeguro;

use \Lib\Data;

/**
 * Generate and retrieve PagSeguro orders
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Model\PagSeguro
 * @uses \Lib\Data
 * @version r1.1
 * @license Apache 2.0
 */
class PagSeguroOrder extends \Model\Base
{

    /**
     * Table to save data
     */
    const TABLE = "pagseguroorders";

    /**
     * Directory of the PagSeguroLibrary.php file
     */
    const PAGSEGURO_LIBRARY_DIR = "../../Extensions/PagSeguroLibrary";

    /**
     * Base URL of PagSeguro notification server
     */
    const PAGSEGURO_NOTIFICATION_CHECK_URL = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/";

    /**
     * Possible properties
     *
     * @var array
     */
    public $properties = array(
        "reference" => null,
        "items" => null,
        "customer" => null,
        "description" => null,
        "link" => null,
        "pagsegurocode" => null
    );

    /**
     * PagSeguro's statuses dictionary
     *
     * @var array
     */
    public $transactionStatuses = array(
        1 => "Aguardando Pagamento",
        2 => "Em Análise",
        3 => "Pago",
        4 => "Pago",
        5 => "Em disputa",
        6 => "Devolvido",
        7 => "Cancelado"
    );

    /**
     * \PagSeguroLibrary instance
     *
     * @staticvar \PagSeguroLibrary
     */
    public static $pagseguro;

    /**
     * PagSeguroConfig instance
     *
     * @staticvar PagSeguroConfig
     */
    public static $pagseguroconfig;

    /**
     * \PagSeguroAccountCredentials instance
     *
     * @staticvar \PagSeguroAccountCredentials
     */
    public static $credentials;

    /**
     * Requires the PagSeguroLibrary.php file and hidrate all variables
     */
    public function __construct()
    {
        require_once (__DIR__ . "/" . self::PAGSEGURO_LIBRARY_DIR . "/PagSeguroLibrary.php");
        self::$pagseguro = \PagSeguroLibrary::init();
        self::$pagseguroconfig = new PagSeguroConfig();
        self::$pagseguroconfig = self::$pagseguroconfig->getById(1);
        self::$credentials = new \PagSeguroAccountCredentials(self::$pagseguroconfig->getEmail(), self::$pagseguroconfig->getToken());
    }

    /**
     * Return a link to user make the payment
     *
     * @return Ambigous <string, boolean, mixed>
     */
    public function getPaymentLink()
    {
        $paymentRequest = new \PagSeguroPaymentRequest();
        
        $this->setReference(\Extensions\Strings::randomString(32));
        $paymentRequest->setSender($this->getCustomer()
            ->getName(), $this->getCustomer()
            ->getEmail(), $this->getCustomer()
            ->getAreaCode(), $this->getCustomer()
            ->getPhone());
        $paymentRequest->setShippingAddress($this->getCustomer()
            ->getCEP(), $this->getCustomer()
            ->getAddress(), $this->getCustomer()
            ->getNumber(), $this->getCustomer()
            ->getAddressComplement(), $this->getCustomer()
            ->getNeighborhood(), $this->getCustomer()
            ->getCity(), $this->getCustomer()
            ->getState(), $this->getCustomer()
            ->getCountry());
        $paymentRequest->setCurrency("BRL");
        $paymentRequest->setShippingType(3);
        $paymentRequest->setReference($this->getReference());
        $paymentRequest->setNotificationURL($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/pagseguronotifications.php");
        foreach ($this->getItems() as $item) {
            $paymentRequest->addItem($item['id'], $item['title'], $item['quantity'], $item['value']);
        }
        return $paymentRequest->register(self::$credentials);
    }

    /**
     * Check a notification code received by PagSeuguro and update order information
     *
     * @param string $notificationCode            
     */
    public function checkNotification($notificationCode)
    {
        $url = self::PAGSEGURO_NOTIFICATION_CHECK_URL . "$notificationCode?email=" . self::$pagseguroconfig->getEmail() . "&token=" . self::$pagseguroconfig->getToken();
        $ch = curl_init($url);
        curl_setopt($ch, \CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, 0);
        $info = new \SimpleXMLElement(curl_exec($ch));
        $object = $this->getByColumn("reference", $info->reference);
        if (count($object)) {
            $object = $object[0];
            $object->setStatus($info->status);
            $object->setPagSeguroCode($info->code);
            
            if ($info->status == 3) {
                $customer = unserialize($this->getCustomer());
                $items = unserialize($this->getItems());
                
                $defaultSubject = "Pagamento aprovado - pedido #{$object->getId()}";
                
                $mailToCustomer = new \Extensions\Mailer();
                $mailToCustomer->message = <<<MESSAGE
<p>Olá, {$customer->getName()}, o pagamento do pedido #{$object->getId()} foi aprovado!</p>
<p>Dados do pedido:</p>
<h3>Produto(s):</h3>
MESSAGE;
                $totalValue = 0;
                foreach ($items as $item) {
                    $sumValue = $item['quantity'] * $item['value'];
                    $totalValue += $sumValue;
                    $sumValue = number_format($sumValue, 2, ".", "");
                    $value = number_format($item['value'], 2, ".", "");
                    $mailToCustomer->message .= "<p>" . $item['quantity'] . "x " . $item['title'] . " - ({$sumValue}) - Vl. Unitário: {$value}</p>";
                }
                $mailToCustomer->message .= "<hr>Valor total: R$" . number_format($totalValue, 2, ".", "");
                $mailToCustomer->recipient = array(
                    "email" => $customer->getEmail(),
                    "name" => $customer->getName()
                );
                
                $config = \Extensions\Config::get();
                $config = $config->mailer;
                
                $notification = new Messages();
                $notification->setName("Admin @ módulo de pagamentos");
                $notification->setEmail($config->receiver);
                $notification->setPhone($customer->getAreaCode() . $customer->getPhone());
                $notification->setSubject($defaultSubejct);
                $notification->setBody($mailToCustomer->message);
                $notification->setIsRead(false);
                $notification->Save();
            }
            $object->Save();
        }
    }

    /**
     * Implementation of Save method
     *
     * @see \Model\Base::Save()
     */
    public function Save()
    {
        $required = array(
            "items" => "Itens",
            "customer" => "Dados do comprador"
        );
        $this->validateData($required);
        parent::Save();
    }

    /**
     * Return information about a order
     *
     * @return array
     */
    public function getOrderInfo()
    {
        $arrayItems = unserialize($this->getItems());
        $customer = unserialize($this->getCustomer());
        $items = array();
        $amount = 0;
        foreach ($arrayItems as $item) {
            $items[] = $item['quantity'] . "x " . $item['title'];
            $amount += ($item['value'] * $item['quantity']);
        }
        $items = implode(",", $items);
        
        $amount = number_format($amount, 2, ".", "");
        
        $info = array(
            "items" => $items,
            "customer" => $customer,
            "amount" => $amount
        );
        
        return $info;
    }

    /**
     * Implementation of validateData method
     *
     * @param array $required            
     * @see \Model\Base::validateData()
     */
    protected function validateData(array $required)
    {
        $this->items = serialize($this->items);
        $this->customer = serialize($this->customer);
        if (! $this->reference) {
            $this->reference = \Extensions\Strings::randomString(32);
        }
        if (! $this->status) {
            $this->status = 1;
        }
        parent::validateData($required);
    }
}