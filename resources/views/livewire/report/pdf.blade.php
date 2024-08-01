<html lang="en">

<head>
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Aplicar estilo a la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Estilo para las cabeceras */
        th,
        td {
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
    <div style="width: 100%;" class="py-8">
        <div class="grid grid-cols-3 gap-8 mb-8 pt-8 px-10" style="font-size: 12px;">
            <div class="text-gray-700">
                <div class="font-bold text-xl uppercase" style="color:#0e909a; font-size: 16px;">Invoice</div>
                <div class="text-gray-700 font-bold">Nabella Transportation LLC</div>
                <div>192 Winding Creek Dr</div>
                <div>Troutman, NC 28166</div>
            </div>
            <div class="text-gray-700" style="font-size: 12px;">
                <div class="font-bold text-xl uppercase">&nbsp;</div>
                <div class="text-gray-700">mchavez@nabellatransportation.com</div>
                <div>+1 (704) 495-1619</div>
                <div>https://nabellatransportation.com</div>
            </div>
            <div class="flex items-center justify-center">
                <img src="/assets/img/logo_nabella.png" class="w-40 h-40 rounded-full">
            </div>
        </div>
        <div class="border-gray-300 mb-8 px-10 py-4" style="background-color: #ecf6f7; font-size: 12px;"> 
            <h2 class="font-bold">Bill To:</h2>
            <div class="text-gray-700">{{ $service_contract->company }}</div>
            <div class="text-gray-700">{{ $service_contract->address }}</div>
            <div class="text-gray-700">{{ $service_contract->phone }}</div>
            <hr style="border: none; border-top: 1px dashed #d4d7dc; margin: 1rem 0;">
            <h2 class="font-bold">Invoice details</h2>
            <div class="text-gray-700">Invoice no.: 1316</div>
            <div class="text-gray-700">Terms: Net 15</div>
            <div class="text-gray-700">Invoice date: {{ Carbon\Carbon::parse(today())->format('m/d/Y') }}</div>
            <!-- carbon date mas 15 dias -->
            <div class="text-gray-700">Due date: {{ Carbon\Carbon::parse(today()->addDays(15))->format('m/d/Y') }}</div>
        </div>
        <div class="py-4 px-10">
            <table class="w-full text-left mb-8 px-10">
                <thead>
                    <tr>
                        <th class="text-gray-700 p-4" style="width: 2%; font-size: 10px;">#</th>
                        <th class="text-gray-700 p-4" style="width: 5%; font-size: 10px;">Date</th>
                        <th class="text-gray-700 p-4" style="width: 30%; font-size: 10px;">Product or service</th>
                        <th class="text-gray-700 p-4" style="width: 60%; font-size: 10px;">Description</th>
                        <th class="text-gray-700 p-4" style="width: 2% !important; text-align: end; font-size: 10px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td class="px-4 text-gray-700" style="font-size: 10px;">{{ $item->id }}.</td>
                        <td class="px-4 text-gray-700" style="font-size: 10px;">{{ Carbon\Carbon::parse($item->date)->format('m/d/Y') }}</td>
                        <td class="px-4 text-gray-700 font-bold" style="font-size: 10px;">{{ $item->patient_name }}</td>
                        <td class="px-4" style="font-size: 10px;">{{ $item->description }}</td>
                        <td class="px-4 text-gray-700" style="text-align: end; font-size: 10px;">${{ $item->amount }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td class="p-4 text-gray-700" colspan="4"> Total </td>
                        <td class="p-4 text-gray-700 font-bold text-xl ">${{ $total }}</td>
                </tbody>
            </table>
        </div>
        <div class="px-10" style="font-size: 12px;">
            <div class="text-gray-700 mb-2">Payment is due within 30 days. Late payments are subject to fees.</div>
            <div class="text-gray-700 mb-2">Please make checks payable to Your Company Name and mail to:</div>
            <div class="text-gray-700">123 Main St., Anytown, USA 12345</div>
        </div>
    </div>

</body>

</html>