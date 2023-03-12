<?php
require_once __DIR__ . '/../DAL/Database.php';

class PaymentDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }
    function updatePaymentStatus($orderId, $status)
    {
       
    }
}