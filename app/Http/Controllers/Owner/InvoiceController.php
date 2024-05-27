<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrderFood;
use App\Models\Order;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends Controller
{

    public function printRecipe($orderId)
    {

        $data['customerOrderFood'] = CustomerOrderFood::getCustomerOrders($orderId);

        return view('owner.pos.printRecipe', $data);
    }


    // public function generateInvoice($orderId)
    // {
    //     // Fetch order details using $orderId

    //     $order = Order::findOrFail($orderId);
    //     $customerOrderFood = $order->foods; // Assuming there's a relationship defined in the Order model
        
    //     // Pass order data to the view
    //     $data = [
    //         'order' => $order,
    //         'customerOrderFood' => $customerOrderFood,
    //     ];

    //     // Generate PDF
    //     $pdf = $this->generatePdf('invoice', $data);

    //     // Download PDF
    //     return $pdf->download('invoice.pdf');
    // }

    private function generatePdf($view, $data)
    {
        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $pdf->setOptions($options);

        $html = view($view, $data)->render();
        $pdf->loadHtml($html);

        $pdf->setPaper('A4', 'portrait');

        $pdf->render();

        return $pdf;
    }
}
