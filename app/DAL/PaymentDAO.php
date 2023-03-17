<?php
require_once __DIR__ . '/../DAL/Database.php';

class PaymentDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }

    function createPayment($orderId, $id) {
        $sql = "INSERT INTO order_payment (order_id, mollie_id, status) VALUES (:order_id, :mollie_id, '');";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':mollie_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
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