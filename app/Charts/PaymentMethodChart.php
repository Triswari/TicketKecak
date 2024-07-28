<?php

namespace App\Charts;

use App\Models\Booking;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PaymentMethodChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    } 
   
    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $paymentMethod = Booking::get();
        $dataPayment = [
            $paymentMethod->where('payment_method', 'Cash')->count(),
            $paymentMethod->where('payment_method', 'Card')->count(),
            $paymentMethod->where('payment_method', 'Qris')->count(),
            $paymentMethod->where('payment_method', 'Transfer')->count(),
            $paymentMethod->where('payment_method', 'GlobalTix')->count(),
            $paymentMethod->where('payment_method', 'Hotel')->count(),
        ];
        $label = [
            'Cash',
            'Card',
            'Qris',
            'Transfer',
            'GlobalTix',
            'Hotel',
        ];
        return $this->chart->pieChart()
            ->setTitle('Payment Method')
            ->setSubtitle(date('Y'))
            ->addData($dataPayment)
            ->setLabels($label);
    }
}