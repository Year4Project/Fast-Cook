<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="{{ asset('admin/img/logo.png') }}">
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
            <div class="logo">Restaurant <span>{{ $getOrderDetails->restaurant->name }}</span></div>
            <div class="title">Receipt</div>
            <div class="inv-number">
                <h3>Invoice#</h3>
                <h4>{{ $getOrderDetails->ordernumber }}</h4>
            </div>
            <div class="inv-date">
                <h3>Date</h3>
                <h4>{{ date('d/m/Y', strtotime($getOrderDetails->created_at)) }}</h4>
            </div>

            <div class="billing-detail">
                <p>Billing to</p>
                <p>{{ $getOrderDetails->restaurant->name }}</p>
                <p><span>Contact: </span>{{ $getOrderDetails->restaurant->user->phone }}</p>
                <p><span>Email: </span>{{ $getOrderDetails->restaurant->user->email }}</p>
                <p><span>Address: </span>{{ $getOrderDetails->restaurant->address }}</p>
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
                @foreach ($getOrderDetails->foods as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->pivot->quantity }}</td>
                        <td>
                            @if ($item->currency === 'KHR')
                                {{ number_format($item->price, 2) }}
                                ៛
                            @else
                                {{ number_format($item->price, 2) }}
                                $
                            @endif
                        </td>
                        @php
                            $subtotal = $item->pivot->quantity * $item->price;
                            $total += $subtotal;
                            $totalQuantity += $item->pivot->quantity;
                        @endphp
                        <td>
                            @if ($item->currency === 'KHR')
                                {{ number_format($subtotal, 2) }}
                                ៛
                            @else
                                {{ number_format($subtotal, 2) }}
                                $
                            @endif
                        </td>
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
                <p>
                    @if ($item->currency === 'KHR')
                        {{ number_format($total, 2) }}
                        $
                    @else
                        {{ number_format($total * 4100, 2) }}
                        ៛
                    @endif
                </p>
            </div>
            <div class="tax">
                <p>សរុបចុងក្រោយ</p>
                <p>Grand Total(USD): </p>
                <p>
                    @if ($item->currency === 'KHR')
                        {{ number_format($total / 4100, 2) }}
                        $
                    @else
                        {{ number_format($total, 2) }}
                        $
                    @endif
                </p>
            </div>

            {{-- @php
                $amount = $customerOrder->payment->amount;
                $currency = $customerOrder->payment->currency;
                $usd = 0;
                $khr = 0;

                $changeKHR = $amount - $total;

                if ($currency === 'USD') {
                    $usd = $amount;
                } elseif ($currency === 'KHR') {
                    $khr = $amount;
                }
            @endphp

            @php
                $changeKHR = $amount - $total * 4100; // Change in Riel
                $changeUSD = $amount - $total; // Change in USD
            @endphp --}}


            <div class="rec1">
                <p>ប្រាក់ទទួល</p>
                <p>Recived(Riel): </p>
                {{-- <p>$ {{ $usd }}</p> --}}
                <p></p>
            </div>
            <div class="rec">
                <p>ប្រាក់ទទួល</p>
                <p>Recived(USD): </p>
                <p>$0.00</p>
                {{-- <p>{{ number_format($khr) }} ៛</p> --}}
            </div>

            <div class="total">
                <p>ប្រាក់អាប់:</p>
                <p>Change(Riel): </p>
                <p>0.00៛</p>
                {{-- <p>{{ number_format($changeKHR, 2) }} ៛</p> --}}
            </div>
            <div class="total">
                <p>ប្រាក់អាប់:</p>
                <p>Change(USD): </p>
                <p>$0.00</p>
                {{-- <p>$ {{ number_format($changeKHR / 4100, 2) }}</p> --}}
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
