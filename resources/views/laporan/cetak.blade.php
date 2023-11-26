<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        @section('title', ''.$transaksi->invoices_number  )

        <title>@yield('title') | Rental Sepeda Rysafi</title>

        <style>
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                font-size: 16px;
                line-height: 24px;
                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box img .lunas {

            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td {
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .invoice-box.rtl {
                direction: rtl;
                font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }

            .invoice-box.rtl table {
                text-align: right;
            }

            .invoice-box.rtl table tr td:nth-child(2) {
                text-align: left;
            }
        </style>
    </head>
    @if($transaksi->status == 'Selesai')
    <body>
        <div class="invoice-box">
            
            <img src="{{asset('img/logo/lunas.png')}}" style="width: 60%; position: absolute; opacity: 0.2; left: 20%" />

            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="{{asset('img/logo/logo2.png')}}" style="width: 40%; max-width: 300px" />
                                </td>

                                <td>
                                    Invoice : <strong>{{$transaksi->invoices_number}}</strong><br />
                                    Tanggal Sewa : {{Carbon\Carbon::parse($transaksi->tgl_sewa)->format('d F Y')}}<br />
                                    Tanggal Kembali : {{Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d F Y')}}<br />
                                    Kembali Pada : {{Carbon\Carbon::parse($transaksi->dikembalikan_pada)->format('d F Y')}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td>
                                    <strong>DITERBITKAN OLEH<br /></strong>
                                    Rysafi Rental Sepeda<br />
                                    Jl. Brawijaya No. 94,<br />
                                    Kecamatan Pare
                                </td>

                                <td>
                                    <strong>UNTUK<br /></strong>
                                    {{$transaksi->user->name}}<br />
                                    {{$transaksi->user->email}}<br />
                                    {{$transaksi->user->telepon}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="">
                    <td>Metode Pembayaran : <strong>{{$transaksi->metode_pembayaran}}</strong></td>
                </tr>

                <tr class="heading">

                    <td>Nama Produk</td>

                    <td  style="text-align: left;">Harga per hari</td>

                    <td>Total</td>
                </tr>
                @foreach ($transaksi->productTranscation as $index=>$item)
                <tr class="item">

                    <td>{{$item->product->name}}</td>
                    <td  style="text-align: left;">Rp. {{ number_format($item->product->price,2,',','.') }} x 
                                                ( {{Carbon\Carbon::parse($transaksi->tgl_sewa)
                                                ->diffInDays($transaksi->tgl_kembali)}} Hari )</td>
                    <td>Rp. {{ number_format($item->product->price * Carbon\Carbon::parse($transaksi->tgl_sewa)
                                                ->diffInDays($transaksi->tgl_kembali),2,',','.') }}</td>

                </tr>
                @endforeach
                <tr class="total">
                    <td>Total</td>
                    <td></td>
                    <td style="text-align: left;">Rp. {{ number_format($transaksi->pay,2,',','.') }}</td>
                </tr>
                <tr class="total">
                    <td>Denda</td>
                    <td></td>
                    <td style="text-align: left;"> @if($transaksi->dikembalikan_pada <= $transaksi->tgl_kembali)
                                                -
                                            @else
                                                Rp. {{ number_format($transaksi->total_denda,2,',','.') }}</strong></td>
                                            @endif</td>
                </tr>
                <tr class="total">
                    <td>Denda Kerusakan</td>
                    <td></td>
                    <td style="text-align: left;">
                        Rp. {{ number_format($transaksi->damage_fine,2,',','.') }}</strong></td>
                </tr>
                <tr class="total">
                    <td>Grand Total</td>
                    <td></td>
                    <td style="text-align: left;"><STRONG>Rp. {{ number_format($transaksi->grand_total,2,',','.') }}</STRONG></td>
                </tr>
            </table>
            <br>
            <p style="padding-top: 20px">Invoice ini sah dan diproses oleh komputer.</p>
            <p>Silahkan hubungi Admin apabila kamu membutuhkan bantuan.</p>
        </div>
    </body>
    @else

    <body>
        <div class="invoice-box">
            
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="{{asset('img/logo/logo2.png')}}" style="width: 40%; max-width: 300px" />
                                </td>

                                <td>
                                    Invoice : <strong>{{$transaksi->invoices_number}}</strong><br />
                                    Tanggal Sewa : {{Carbon\Carbon::parse($transaksi->tgl_sewa)->format('d F Y')}}<br />
                                    Tanggal Kembali : {{Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d F Y')}}<br />
                                    Kembali Pada : Belum Kembali
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td>
                                    <strong>DITERBITKAN OLEH<br /></strong>
                                    Rysafi Rental Sepeda<br />
                                    Jl. Brawijaya No. 94,<br />
                                    Kecamatan Pare
                                </td>

                                <td>
                                    <strong>UNTUK<br /></strong>
                                    {{$transaksi->user->name}}<br />
                                    {{$transaksi->user->email}}<br />
                                    {{$transaksi->user->telepon}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="">
                    <td>Metode Pembayaran : <strong>{{$transaksi->metode_pembayaran}}</strong></td>
                </tr>

                <tr class="heading">

                    <td>Nama Produk</td>

                    <td  style="text-align: left;">Harga per hari</td>

                    <td>Total</td>
                </tr>
                @foreach ($transaksi->productTranscation as $index=>$item)
                <tr class="item">

                    <td>{{$item->product->name}}</td>
                    <td  style="text-align: left;">Rp. {{ number_format($item->product->price,2,',','.') }} x 
                                                ( {{Carbon\Carbon::parse($transaksi->tgl_sewa)
                                                ->diffInDays($transaksi->tgl_kembali)}} Hari )</td>
                    <td>Rp. {{ number_format($item->product->price * Carbon\Carbon::parse($transaksi->tgl_sewa)
                                                ->diffInDays($transaksi->tgl_kembali),2,',','.') }}</td>

                </tr>
                @endforeach
                <tr class="total">
                    <td>Total</td>
                    <td></td>
                    <td style="text-align: left;">Rp. {{ number_format($transaksi->pay,2,',','.') }}</td>
                </tr>
                <tr class="total">
                    <td>Denda</td>
                    <td></td>
                    <td style="text-align: left;"> @if($transaksi->dikembalikan_pada <= $transaksi->tgl_kembali)
                                                -
                                            @else
                                                Rp. {{ number_format($transaksi->total_denda,2,',','.') }}</strong></td>
                                            @endif</td>
                </tr>
                <tr class="total">
                    <td>Grand Total</td>
                    <td></td>
                    <td style="text-align: left;">
                        @if($transaksi->status != 'Selesai')
                        -
                        @else
                        <STRONG>Rp. {{ number_format($transaksi->grand_total,2,',','.') }}</STRONG></td>
                        @endif
                </tr>
            </table>
            <br>
            <p style="padding-top: 20px">Invoice ini sah dan diproses oleh komputer.</p>
            <p>Silahkan hubungi Admin apabila kamu membutuhkan bantuan.</p>
        </div>
    </body>
    @endif
</html>

<script type="text/javascript">
  window.print();
</script>
