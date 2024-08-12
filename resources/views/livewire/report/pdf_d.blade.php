<html lang="en">

<head>
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Aplicar estilo a la tabla */
        body {
            width: 100%;
            font-family: 'Roboto', sans-serif;
            color: rgb(55 65 81);
            font-size: 12px;
            line-height: 1.5;
            letter-spacing: 0.2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Estilo para las cabeceras */
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr.total-row td {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding: 20px 0;">
                    <div style="color:#0e909a; font-size: 16px; font-weight: bold;">INVOICE</div>
                    <div style="font-weight: bold;">Nabella Transportation LLC</div>
                    <div>192 Winding Creek Dr</div>
                    <div>Troutman, NC 28166</div>
                </td>
                <td style="padding: 20px 0;">
                    <div>&nbsp;</div>
                    <div class="text-gray-700">mchavez@nabellatransportation.com</div>
                    <div>+1 (704) 495-1619</div>
                    <div>https://nabellatransportation.com</div>
                </td>
                <td style="padding: 20px 0;">
                    <img src="{{ public_path('assets/img/logo_nabella.png') }}" width="100" height="100">
                </td>
            </tr>
        </table>

        <div style="background-color: #ecf6f7; font-size: 12px; padding: 20px;">
            <h2 class="font-bold">Bill To:</h2>
            <div class="text-gray-700"> Novant Health Rowan Medical Center</div>
            <div class="text-gray-700"> 123 Main St.</div>
            <div class="text-gray-700"> Anytown, USA 12345</div>
            <hr style="border: none; border-top: 1px dashed #d4d7dc; margin: 1rem 0;">
            <h2 class="font-bold">Invoice details</h2>
            <div class="text-gray-700">Invoice no: 1316</div>
            <div class="text-gray-700">Terms: Net 15</div>
            <div class="text-gray-700">Invoice date: {{ Carbon\Carbon::parse(today())->format('m/d/Y') }}</div>
            <!-- carbon date mas 15 dias -->
            <div class="text-gray-700">Due date: {{ Carbon\Carbon::parse(today()->addDays(15))->format('m/d/Y') }}</div>
        </div>

        <div class="invoice-items">
            <table width="100%">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Product or service Description</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>08/08/2024</td>
                    <td>WHEELCHAIR. Pick up: 612 Mocksville Avenue, Salisbury, NC, USA. Drop off: 615 Varnadore Rd, Salisbury, NC, USA. Out of Hours charge applied. 23.6 miles round trip.</td>
                    <td>$234.4</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>08/07/2024</td>
                    <td>WHEELCHAIR. Pick up: 612 Mocksville Avenue, Salisbury, NC, USA. Drop off: 612 China Grove Hwy, Rockwell, NC, USA. Saturdays charge applied. 22.2 miles round trip.</td>
                    <td>$183.8</td>
                </tr>
            </table>
        </div>

        <div class="total">
            <p>Total: $418.2</p>
        </div>

        <div class="footer">
            <p>Payment is due within 30 days. Late payments are subject to fees.</p>
            <p>Please make checks payable to Your Company Name and mail to: 123 Main St., Anytown, USA 12345</p>
        </div>
    </div>
</body>

</html>