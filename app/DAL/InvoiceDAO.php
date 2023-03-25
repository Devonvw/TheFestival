<?php
require_once __DIR__ . '/../DAL/Database.php';

class InvoiceDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }

    function addInvoiceToOrder($orderId, $invoicePDF)
    {
        $sql = "INSERT INTO order_invoice (order_id, file) VALUES (:order_id, :file);";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindValue(':file', $invoicePDF);
        $stmt->execute();
        return $this->DB::$connection->lastInsertId();
    }

    function getInvoice($orderId)
    {
        $sql = "SELECT * FROM order_invoice WHERE order_id = :order_id;";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $invoice = $stmt->fetchObject();
        if (!$invoice) throw new Exception("This order doesn't have an invoice.", 1);
        $invoice->file = base64_encode($invoice->file);
        return $invoice;
    }
}