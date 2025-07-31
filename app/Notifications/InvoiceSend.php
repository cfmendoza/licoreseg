<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Models\Sale;

class InvoiceSend extends Notification
{


    protected $sale;
    protected $email;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generar PDF desde la vista
        $pdf = PDF::loadView('ventas::pdf.invoice', ['sale' => $this->sale]);

        return (new MailMessage)
            ->subject('Factura de Venta')
            ->greeting('Hola ' . ($notifiable->name ?? 'cliente') . ',')
            ->line('Adjunto encontrará su factura de venta.')
            ->attachData($pdf->output(), 'factura_' . $this->sale->id . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->line('Gracias por su compra.');
    }

}
