<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Scraping Email</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .email-record {
            position: relative;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: navajowhite;
        }

        .email-record+.email-record {
            margin-top: -40px;
            /* Overlap the next record */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="display-4 mb-4">Scraped Email Data</h1>
        <a href="{{ route('runCommand') }}">Fetch again</a>

        @if (empty($scrapedData))
            <div class="alert alert-info">
                No emails found in the mailbox.
            </div>
        @else
            @foreach ($scrapedData as $data)
                <div class="email-record">
                    <h5>Email Details</h5>
                    <p><strong>Sender:</strong> {{ $data['sender'] }}</p>
                    <p><strong>Receiver:</strong> {{ $data['receiver'] }}</p>
                    <p><strong>Date:</strong> {{ $data['date'] }}</p>
                    <p><strong>Name:</strong> {{ $data['name'] }}</p>
                    @if (!empty($data['dates_with_month_names']))
                        <h5 class="mt-3">Dates With Months</h5>
                        <ul>
                            @foreach ($data['dates_with_month_names'] as $date)
                                <li>{{ $date }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No Dates with Months found</p>
                    @endif
                    @if (!empty($data['property']))
                        <h5 class="mt-3">property name</h5>
                        <ul>
                          {{ 
                            $data['property'] }}
                     
                        </ul>
                    @else
                        <p>No Property found</p>
                    @endif
                    {{-- @if (!empty($data['dates_with_month_names']))
                        <h5 class="mt-3">Dates With Months</h5>
                        <ul>
                            @foreach ($data['dates_with_month_names'] as $dates)
                                <li>{{ $dates }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No Dates found</p>
                    @endif --}}
                </div>
    </div>
    @endforeach
    @endif

    <!-- Add Bootstrap JS scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
