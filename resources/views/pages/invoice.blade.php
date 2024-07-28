<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <link rel="stylesheet" href="/assets/css/invoice.css" type="text/css" media="all" />
</head>

<body>
  <div>
    <div class="py-4">
      <div class="px-14 py-6">
        <table class="w-full border-collapse border-spacing-0">
          <tbody>
            <tr>
              <td class="w-full align-top">
                <div>
                  <img src="/img/kecak_barong_nusa_dua_logo.png" class="h-12" />
                </div>
              </td>

              <td class="align-top">
                <div class="text-sm">
                  <table class="border-collapse border-spacing-0">
                    <tbody>
                      <tr>
                        <td class="border-r pr-4">
                          <div>
                            <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                            <p class="whitespace-nowrap font-bold text-main text-right">{{ Carbon\Carbon::parse($tanggalSekarang)->format('F j, Y') }}</p>
                          </div>
                        </td>
                        
                        <td class="pl-4">
                          <div>
                            <p class="whitespace-nowrap text-slate-400 text-right">Invoice #</p>
                            <p class="whitespace-nowrap font-bold text-main text-right">TP-00{{ $data->id_booking }}</p>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="bg-slate-100 px-14 py-6 text-sm">
        <table class="w-full border-collapse border-spacing-0">
          <tbody>
            <tr>
              <td class="w-1/2 align-top">
                <div class="text-sm text-neutral-600">
                  <p class="font-bold">From:</p>
                  <p>Kecak & Barong Dance Show The Nusa Dua</p>
                  <p>Indonesia Tourism Development Corporation</p>
                  <p>Kuta Selatan</p>
                  <p>Badung</p>
                  <p>Bali</p>
                </div>
              </td>
              <td class="w-1/2 align-top text-right">
                <div class="text-sm text-neutral-600">
                  <p class="font-bold">To:</p>
                  <p>{{ $data->name }}</p>
                  <p>{{ $data->nationality }}</p>
                  <p>{{ $data->hostelry }}</p>
                  <!-- <p>Paradise, 43325</p>
                  <p>United States</p> -->
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="px-14 py-10 text-sm text-neutral-700">
        <table class="w-full border-collapse border-spacing-0">
          <thead>
            <tr>
              <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
              <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Product details</td>
              <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Price</td>
              <!-- <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Qty.</td> -->
              <!-- <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Discount</td> -->
              <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Qty.</td>
              <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Subtotal</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border-b py-3 pl-3">1.</td>
              <td class="border-b py-3 pl-2">Kecak & Barong Dance Show Ticket</td>
              <td class="border-b py-3 pl-2 text-right">Rp{{ number_format($data->price_ticket, 0, ',', '.') }}</td>
              <!-- <td class="border-b py-3 pl-2 text-center">1</td> -->
              <!-- <td class="border-b py-3 pl-2 text-center">20%</td> -->
              <td class="border-b py-3 pl-2 text-right">{{ $data->qty_ticket }}</td>
              <td class="border-b py-3 pl-2 pr-3 text-right">Rp{{ number_format($data->totalPayment_ticket, 0, ',', '.') }}</td>
            </tr>
            
            <!-- <tr>
              <td class="border-b py-3 pl-3">2.</td>
              <td class="border-b py-3 pl-2">Bintang (Drink)</td>
              <td class="border-b py-3 pl-2 text-right">Rp50.000</td>
              <td class="border-b py-3 pl-2 text-right">1</td>
              <td class="border-b py-3 pl-2 pr-3 text-right">Rp50.000</td>
            </tr> -->
            <tr>
              <td colspan="7">
                <table class="w-full border-collapse border-spacing-0">
                  <tbody>
                    <tr>
                      <td class="w-full"></td>
                      <td>
                        <table class="w-full border-collapse border-spacing-0">
                          <tbody>
                            <tr>
                              <td class="bg-main p-3">
                                <div class="whitespace-nowrap font-bold text-white">Total:</div>
                              </td>
                              <td class="bg-main p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-white">Rp{{ number_format($data->totalPayment_ticket, 0, ',', '.') }}</div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="px-14 text-sm text-neutral-700">
        <p class="text-main font-bold">PAYMENT DETAILS</p>
        <p>QRIS</p>
        <p>KECAKTAKSU ARTSTAGE ITDC</p>
        <p>NMID: ID2023252063607</p>
        <p>A01</p>
        <img src="/img/qris.jpeg" class="h-13" />
      </div>

      <div class="px-14 py-10 text-sm text-neutral-700">
        <p class="text-main font-bold">Notes</p>
        <p class="italic">This invoice has been paid in full via {{ $data->payment_method }}</p>
        </dvi>

        <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
          Kecak & Barong The Nusa Dua
          <span class="text-slate-300 px-2">|</span>
          www.itdc.co.id
          <span class="text-slate-300 px-2">|</span>
          (0361) 771010
        </footer>
      </div>
    </div>
      <script type="text/javascript">
        window.print();
      </script>
</body>

</html>
