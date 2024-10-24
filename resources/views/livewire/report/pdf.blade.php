<html lang="en">

<head>
    <title>Invoice</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            color: #374151;
            font-size: 12px;
            line-height: 1.5;
            letter-spacing: 0.2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Estilo para las cabeceras */
        th,
        td.border-bottom {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" padding: 50px 40px 20px;">
            <tr>
                <td>
                    <div style="color:#0e909a; font-size: 16px; font-weight: bold;">INVOICE</div>
                    <div style="font-weight: bold;">Nabella Transportation LLC</div>
                    <div>192 Winding Creek Dr</div>
                    <div>Troutman, NC 28166</div>
                </td>
                <td>
                    <div>&nbsp;</div>
                    <div>mchavez@nabellatransportation.com</div>
                    <div>+1 (704) 495-1619</div>
                    <div>https://nabellatransportation.com</div>
                </td>
                <td>
                    <img src="{{ public_path('assets/img/logo_nabella.png') }}" width="100" height="100">
                </td>
            </tr>
        </table>

        <div style="background-color: #ecf6f7; font-size: 12px; padding: 40px;">
            <div style="font-weight: bold;">Bill To:</div>
            <div> {{ $facility->name }}</div>
            <div> {{ $facility->address }}</div>
            <hr style="border: none; border-top: 1px dashed #d4d7dc; margin: 1rem 0;">
            <div style="font-weight: bold;">Invoice details</div>
            <div>Invoice no: 1316</div>
            <div>Terms: {{ $terms }}</div>
            <div>Invoice date: {{ Carbon\Carbon::parse(today())->format('m/d/Y') }}</div>
            <div>Due date: {{ Carbon\Carbon::parse(today()->addDays($day_terms))->format('m/d/Y') }}</div>
        </div>

        <table width="100%" style="font-size: 10px; padding: 20px 40px; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="width: 2%;">#</th>
                    <th style="width: 8%;">Date</th>
                    <th style="width: 25%;">Product or service</th>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 15% !important; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp

                @foreach($data as $item)
                <tr>
                    <td class="border-bottom" style="padding: 10px;">{{ $counter }}.</td>
                    <td class="border-bottom" style="padding: 10px;">{{ Carbon\Carbon::parse($item['date'])->format('m/d/Y') }}</td>
                    <td class="border-bottom" style="font-weight: bold; padding: 10px;">{{ $item['patient_name'] }}</td>
                    <td class="border-bottom" style="padding: 10px;">{{ $item['description'] }}</td>
                    <td class="border-bottom" style="padding: 10px; text-align: right;">${{ number_format($item['amount'], 2) }}</td>
                </tr>
                @php
                $counter++;
                @endphp
                @endforeach
                <tr class="total-row">
                    <td colspan="5" class="border-bottom" style="padding: 10px; text-align: right; font-size: 15px; font-weight: bold;">
                        Total <span style=" font-size: 25px; padding-left: 10px;">${{ number_format($total, 2) }}</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="footer" style="padding: 20px 40px;">
            <p>Payment is due within 30 days. Late payments are subject to fees.</br>
                Please make checks payable to Your Company Name and mail to:</br>
                123 Main St., Anytown, USA 12345</p>
        </div>
    </div>
</body>

</html>