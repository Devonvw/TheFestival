<?php
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . '/../service/pdfService.php';

class OrderService {
    public function createOrder($accountId){
        $dao = new OrderDAO();
        $dao->createOrder($accountId);
    }
    public function getOrder($orderId){
        $dao = new OrderDAO();
        $order = $dao->getOrder($orderId);
        $pdf = new PDFService();
        $pdf->createInvoicePDF($order, ["email" => 'devonvanw@gmail.com', "name" => "Devon van Wichen", "country" => "The Netherlands", "city" => "Schagen", "address" => "Eksterstraat 81", "zipcode" => "1742EN"]);
        return $order;
    }
    public function getOrderTickets($orderId){
        $dao = new OrderDAO();
        return $dao->getOrderTickets($orderId);
    }
}