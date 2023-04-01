<?php
require_once __DIR__ . '/../packages/fpdf185/templates.php';

class PDFService {
    public function createInvoicePDF($invoiceId, $order, $userInfo){
        $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
        $pdf->AddPage();
        $pdf->addSociete( "The Festival",
                        "Grote Markt 22\n" .
                        "2011 RD Haarlem\n");
        $pdf->fact_dev( "Invoice: ". $invoiceId, "" );
        $pdf->addDate(date("d-m-y"));
        $pdf->addClientAdresse($userInfo->name. "\n". $userInfo->address. "\n". $userInfo->zipcode. " ". $userInfo->city. "\n". $userInfo->country. "\n");
        $cols=array( "TICKET"    => 100,
                    "QUANTITY"  => 23,
                    "PER TICKET"     => 30,
                    "TOTAL"      => 37 );
        $pdf->addCols( $cols);
        $cols=array("TICKET" => "L",
                    "QUANTITY" => "C",
                    "PER TICKET" => "R",
                    "TOTAL" => "R");
        $pdf->addLineFormat( $cols);
        $pdf->addLineFormat($cols);

        $y = 109;

        foreach ($order->order_items as $orderItem) {
            $line = array( "TICKET"    => $orderItem->ticket->event_name. " - ". $orderItem->ticket->event_item_name. " - ". $orderItem->ticket->persons. " Person",
                        "QUANTITY"  => $orderItem->quantity,
                        "PER TICKET"     => EURO . " ". number_format($orderItem->price / $orderItem->quantity, 2),
                        "TOTAL"      =>  EURO . " ". number_format($orderItem->price, 2) );
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
        }

        $pdf->addTVAs( $order->total, $order->subtotal, $order->vat);
        $pdf->addCadreEurosFrancs();
        return $pdf->Output('S', __DIR__ . '/../pdf/invoice-'. $order->id .'.pdf');   //save file
        //return __DIR__ . '/../pdf/invoice-'. $order->id .'.pdf';
    }
    
    public function createTicketsPDF($tickets, $orderId, $userInfo){
        $pdf = new PDF_Ticket( 'P', 'mm', 'A4' );

        foreach ($tickets as $ticket) {
            $pdf->AddPage();
            $pdf->addInformation($ticket->event_item_name,
            $ticket->event_name . "\n" .
            "For ". $ticket->persons . " person(s)\n\n" .
            "Start: ". date_format( date_create($ticket->start), "F j, Y, H:i"). "\n".
            "End: ". date_format(date_create($ticket->end), "F j, Y, H:i"). "\n");
            $pdf->addLocationInformation("Location", $ticket->location . "  \n");
            $pdf->addClientAdresse($userInfo->name. "\n". $userInfo->address. "\n". $userInfo->zipcode. " ". $userInfo->city. "\n". $userInfo->country. "\n");
            $pdf->addQRBox();
        }
        
        $pdf->Output('F', __DIR__ .'/../pdf/tickets-'. $orderId .'.pdf');        
        return __DIR__ . '/../pdf/tickets-'. $orderId .'.pdf';
    }
}