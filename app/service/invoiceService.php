<?php
require_once __DIR__ . '/../DAL/InvoiceDAO.php';

class InvoiceService {
    public function getInvoice($orderId) {
        $dao = new InvoiceDAO();
        return $dao->getInvoice($orderId);
    }
}
?>