<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $offeringLetter->code }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .table{width:100%;max-width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#b8daff}.table-hover .table-primary:hover{background-color:#9fcdff}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#9fcdff}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#d6d8db}.table-hover .table-secondary:hover{background-color:#c8cbcf}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#c8cbcf}.table-success,.table-success>td,.table-success>th{background-color:#c3e6cb}.table-hover .table-success:hover{background-color:#b1dfbb}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#b1dfbb}.table-info,.table-info>td,.table-info>th{background-color:#bee5eb}.table-hover .table-info:hover{background-color:#abdde5}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#abdde5}.table-warning,.table-warning>td,.table-warning>th{background-color:#ffeeba}.table-hover .table-warning:hover{background-color:#ffe8a1}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffe8a1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f5c6cb}.table-hover .table-danger:hover{background-color:#f1b0b7}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f1b0b7}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-hover .table-light:hover{background-color:#ececf6}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#c6c8ca}.table-hover .table-dark:hover{background-color:#b9bbbe}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#b9bbbe}.table-active,.table-active>td,.table-active>th{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#212529;border-color:#32383e}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#212529}.table-dark td,.table-dark th,.table-dark thead th{border-color:#32383e}.table-dark.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{background-color:rgba(255,255,255,.075)}@media (max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-sm>.table-bordered{border:0}}@media (max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-md>.table-bordered{border:0}}@media (max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-lg>.table-bordered{border:0}}@media (max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive>.table-bordered{border:0}
    </style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; vertical-align:middle; text-align:center;">
                <img src="{{ public_path('image/kop.png') }}" alt="" style="width: 70%; margin-right: 50px;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                <h3 style="text-decoration: underline; font-weight: bold; margin-top: 30px; letter-spacing: 1.5px;">PENAWARAN HARGA</h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                {{ 'No: '.$offeringLetter->code }}
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
                <div style="margin-top: 20px;">
                    <p style="font-size: 13pt; margin-left: 40px; float: left; width: 50%;">
                        {{ Str::upper($offeringLetter->office->name) }}
                    </p>
                    <p style="font-size: 13pt; margin-right: 40px; float: right;">
                        {{ 'Jakarta, '.indonesianDate($offeringLetter->created_at) }}
                    </p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
                <div style="margin-top: 30px; margin-left: 40px;">
                    {{ 'Attn: '.$offeringLetter->attendance }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
                <div style="margin: 40px 40px 0 40px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 40%">Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offeringLetter->offeringLetterItems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="font-size: 11pt;">{{ Str::upper($item->vendorItem->name) }}</td>
                                    <td>{{ $item->quantity. ' Pcs' }}</td>
                                    <td style="text-align: right;">{{ number_format($item->retail_price_per_item) }}</td>
                                    <td style="text-align: right;">{{ number_format($item->total_price_per_item) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right;">
                                    <b>
                                        Total :
                                    </b>
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($offeringLetter->total_price) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">
                                    <b>
                                        PPN 11% :
                                    </b>
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($offeringLetter->total_vat) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">
                                    <b>
                                        Grand Total :
                                    </b>
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($offeringLetter->grand_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div style="margin-left: 20px; padding-top: 20px; padding-bottom: 20px;">
                                        {!! str_replace('&nbsp;', '', html_entity_decode($offeringLetter->note)) !!}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
                <div style="margin-top: 30px; margin-left: 60px;">
                    <span style="margin-left: 20px;">Hormat Saya,</span> <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span style="margin-left: 20px;">
                        {{ $offeringLetter->sales_manager }}
                    </span>
                    <br>
                    {{ '(+62) '.$offeringLetter->sales_manager_phone }}
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
