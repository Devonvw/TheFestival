<?php
require_once __DIR__ . '/../packages/fpdf185/invoice.php';

class PDFService {
    public function createInvoicePDF($order, $userInfo){
        $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
        $pdf->AddPage();
        $pdf->addSociete( "The Festival",
                        "Grote Markt 22\n" .
                        "2011 RD Haarlem\n");
        $pdf->fact_dev( "Order: ". $order->id, "" );
        $pdf->addDate(date("m-d-y"));
        $pdf->addClientAdresse($userInfo["name"]. "\n". $userInfo["address"]. "\n". $userInfo["zipcode"]. " ". $userInfo["city"]. "\n". $userInfo["country"]. "\n");
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

        $y    = 109;

        foreach ($order->order_items as $orderItem) {
            $line = array( "TICKET"    => $orderItem->ticket->event_name. " - ". $orderItem->ticket->event_item_name. " - ". $orderItem->ticket->persons. " Person",
                        "QUANTITY"  => $orderItem->quantity,
                        "PER TICKET"     => EURO . " ". number_format($orderItem->price / $orderItem->quantity, 2),
                        "TOTAL"      =>  EURO . " ". number_format($orderItem->price, 2) );
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
        }

        $pdf->addCadreTVAs();
                
        // invoice = array( "px_unit" => value,
        //                  "qte"     => qte,
        //                  "tva"     => code_tva );
        // tab_tva = array( "1"       => 19.6,
        //                  "2"       => 5.5, ... );
        // params  = array( "RemiseGlobale" => [0|1],
        //                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
        //                      "remise"         => value,     // {montant de la remise}
        //                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
        //                  "FraisPort"     => [0|1],
        //                      "portTTC"        => value,     // montant des frais de ports TTC
        //                                                     // par defaut la TVA = 19.6 %
        //                      "portHT"         => value,     // montant des frais de ports HT
        //                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
        //                  "AccompteExige" => [0|1],
        //                      "accompte"         => value    // montant de l'acompte (TTC)
        //                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
        //                  "Remarque" => "texte"              // texte
        $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                            array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
        $tab_tva = array( "1"       => 19.6,
                        "2"       => 5.5);
        $params  = array( "RemiseGlobale" => 1,
                            "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                            "remise"         => 0,       // {montant de la remise}
                            "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
                        "FraisPort"     => 1,
                            "portTTC"        => 10,      // montant des frais de ports TTC
                                                        // par defaut la TVA = 19.6 %
                            "portHT"         => 0,       // montant des frais de ports HT
                            "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
                        "AccompteExige" => 1,
                            "accompte"         => 0,     // montant de l'acompte (TTC)
                            "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
                        "Remarque" => "Avec un acompte, svp..." );

        $pdf->addTVAs( $params, $tab_tva, $tot_prods);
        $pdf->addCadreEurosFrancs();
        $pdf->Output('F', __DIR__ . '/../pdf/test.pdf');   //save file
    }
    
}