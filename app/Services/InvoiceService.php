<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    public function generatePDF(Order $order)
    {
        $pdf = PDF::loadView('pdf.invoice', [
            'order' => $order,
            'company' => [
                'name' => 'ISI BURGER',
                'address' => '123 Rue de la Restauration',
                'city' => '75000 Paris',
                'phone' => '01 23 45 67 89',
                'email' => 'contact@isiburger.com',
            ]
        ]);

        return $pdf->stream("facture-{$order->id}.pdf");
    }
} 