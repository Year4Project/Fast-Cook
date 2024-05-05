<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
    <link rel="stylesheet" href="{{ asset('admin/css/invoice.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
</head>

<body class="bg-secondary">
    <div class="wrapper">
        <div class="border-design top">
            <div class="c1"></div>
            <div class="c2"></div>
            <div class="c3"></div>
            <div class="c4"></div>
            <div class="c5"></div>
        </div>
        <div class="invoice-header">
            <div class="logo">Restaurant <span>{{ $customerOrder->restaurant->name }}</span></div>
            <div class="title">Receipt</div>
            <div class="inv-number">
                <h3>Invoice#</h3>
                <h4>{{ $customerOrder->ordernumber }}</h4>
            </div>
            <div class="inv-date">
                <h3>Date</h3>
                <h4>{{ date('d/m/Y', strtotime($customerOrder->created_at)) }}</h4>
            </div>

            <div class="billing-detail">
                <p>Billing to</p>
                <p>{{ $customerOrder->restaurant->name }}</p>
                <p><span>Contact: </span>{{ $customerOrder->restaurant->user->phone }}</p>
                <p><span>Email: </span>{{ $customerOrder->restaurant->user->email }}</p>
                <p><span>Address: </span>{{ $customerOrder->restaurant->address }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <td>No.</td>
                    <td>name</td>
                    <td>Qty</td>
                    <td>Price</td>
                    <td>Amount</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $totalQuantity = 0;
                @endphp
                {{-- @foreach ($customerOrder->orderItems as $item) --}}
                @foreach ($customerOrder->orderItems as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->food->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->food->price, 2) }}</td>
                        @php
                            $subtotal = $item->quantity * $item->food->price;
                            $total += $subtotal;
                            $totalQuantity += $item->quantity;
                        @endphp
                        <td>${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <p>{{ $totalQuantity }}</p>
                    </td>
                    <td>ឯកតា</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="sub">
                <p>សរុបចុងក្រោយ</p>
                <p>Grand Total(Riel): </p>
                <p>${{ number_format($total * 4100, 2) }}</p>
            </div>
            <div class="tax">
                <p>សរុបចុងក្រោយ</p>
                <p>Grand Total(USD): </p>
                <p>${{ number_format($total, 2) }}</p>
            </div>
            
            <?php
                $amount = $customerOrder->payment->amount;
                $currency = $customerOrder->payment->currency;
                $usd = 0;
                $khr = 0;
                
                if($currency === 'USD') {
                    $usd = $amound;
                } elseif($currency === 'KHR') {
                    $khr = $amound;
                } else {
                    
                }
                ?>
            <div class="rec1">
                <p>ប្រាក់ទទួល</p>
                <p>Recived(Riel): </p>
                <p>${{ $usd }}</p>
            </div>
            <div class="rec">
                <p>ប្រាក់ទទួល</p>
                <p>Recived(USD): </p>
                {{-- {{ dd($customerOrderFood) }} --}}
                {{-- {{ dd($customerOrder->payment_usd) }} --}}

                <p>{{ $khr }}៛</p>
            </div>

            

            <div class="total">
                <p>ប្រាក់អាប់:</p>
                <p>Change(Riel): </p>
                <p>$0.00</p>
            </div>
        </div>

        <div class="message">
            <p>Thank You For Supporting Local Business!</p>
        </div>


        <div class="border-design bottom">
            <div class="c1"></div>
            <div class="c2"></div>
            <div class="c3"></div>
            <div class="c4"></div>
            <div class="c5"></div>
        </div>
    </div>
</body>

</html>
