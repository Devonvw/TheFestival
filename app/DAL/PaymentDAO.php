<?php
require_once __DIR__ . '/../DAL/Database.php';

class PaymentDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }

    function createPayment($orderId, $id, $paymentAccountInfo) {
        $sql = "INSERT INTO order_payment (order_id, mollie_id, status, email, name, country, city, address, zipcode) VALUES (:order_id, :mollie_id, '', :email, :name, :country, :city, :address, :zipcode);";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':mollie_id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindValue(':email', $paymentAccountInfo["email"], PDO::PARAM_STR);
        $stmt->bindValue(':name', $paymentAccountInfo["name"], PDO::PARAM_STR);
        $stmt->bindValue(':country', $paymentAccountInfo["country"], PDO::PARAM_STR);
        $stmt->bindValue(':city', $paymentAccountInfo["city"], PDO::PARAM_STR);
        $stmt->bindValue(':address', $paymentAccountInfo["address"], PDO::PARAM_STR);
        $stmt->bindValue(':zipcode', $paymentAccountInfo["zipcode"], PDO::PARAM_STR);
        $stmt->execute();
    }

    function updatePaymentStatus($orderId, $status)
    {
        $sql = "UPDATE order_payment SET status = :status WHERE order_id = :order_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
    }

}