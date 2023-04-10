<?php
require_once __DIR__ . '/../DAL/InvoiceDAO.php';

class InvoiceService {
    public function getInvoice($orderId) {
        if (!$orderId) throw new Exception("Please specify an order id.", 1);

        $dao = new InvoiceDAO();
        return $dao->getInvoice($orderId);
    }
}
?>