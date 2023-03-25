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
        $modified_at = date('Y-m-d H:i:s');

        $sql = "UPDATE order_payment SET status = :status, modified_at = :modified_at WHERE order_id = :order_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
    }

    function addPayLater($orderId, $id)
    {
        $modified_at = date('Y-m-d H:i:s');

        $sql = "UPDATE order_payment SET pay_later_id = :id, modified_at = :modified_at WHERE order_id = :order_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
    }

    function handlePayLater($id, $status)
    {
        $modified_at = date('Y-m-d H:i:s');

        $sql = "UPDATE order_payment SET status = :status, modified_at = :modified_at WHERE pay_later_id = :id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    function getPaymentAccountInfo($orderId)
    {
        $sql = "SELECT * FROM order_payment WHERE order_id = :order_id LIMIT 1";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getOrderIdByPaymentLink($id) {
        $sql = "SELECT order_id as id FROM order_payment WHERE pay_later_id = :id LIMIT 1";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
}