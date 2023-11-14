<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Scraping Email</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <h1>Scraped Emails</h1>
</head>

<body>

    <h1>Extracted Email Data</h1>

    @if (!empty($extractedData))
        <ul>
            @foreach ($extractedData as $data)
                <li>
                  
                    <p>Arrival Date: {{ $data->arrival_date }}</p>
                    <p>Departure Date: {{ $data->departure_date }}</p>
                    <p>Property Name: {{ $data->property_name }}</p>
                    <p>Sender's Email: {{ $data->sender_email }}</p>
             
                </li>
            @endforeach
        </ul>
    @else
        <p>No emails found or no data extracted.</p>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

