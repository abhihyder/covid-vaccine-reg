<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www..w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www..w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html charset=utf-8" />
    <meta http-equiv="X-UA-Compatibe" content="IE=edge" />
    <title>Vaccine Notification</title>

</head>

<body>

    <h3>Dear {{ $registration->user->name }},</h3>

    <p>
        Your vaccination is scheduled for <strong>{{ \Carbon\Carbon::parse($registration->scheduled_date)->format('l, F jS, Y') }}
        </strong> at the following center:
    </p>

    <p>
        <strong>Center Name:</strong> {{ $registration->vaccineCenter->name }}<br>
        <strong>Address:</strong> {{ $registration->vaccineCenter->address }}
    </p>

    <p>
        Please visit the center on the scheduled date.
    </p>

    <p>Thank you for registering!</p>


</body>

</html>