<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitation to Join QAMS</title>
    <style>
        :root {
            --primary-color: #212529;
            --tertiary-color: #dee2e6;
            --quaternary-color: #084298;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--primary-color);
            /* --bs-body-bg */
            color: var(--tertiary-color);
            /* --bs-body-color */
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--primary-color);
            border: 1px solid #495057;
            border-radius: 8px;
        }

        .card {
            border: none;
        }

        .card-header {
            background-color: #5C8374;
            color: var(--tertiary-color);
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 20px;
            color: var(--primary-color);

        }

        .card-footer {
            background-color: #00ABE4;
            /* --bs-dark-bg-subtle */
            padding: 10px;
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            color: var(--primary-color);

            /* --bs-dark-text-emphasis */
        }

        .btn-success {
            background-color: #66ff66;
            /* --bs-success-text-emphasis */
            color: #212529;
            /* --bs-body-bg */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .btn-success:hover {
            background-color: #009900;
            /* --bs-success-border-subtle */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>You're Invited by {{ $host }}</h2>
            </div>
            <div class="card-body">
                <p>Hello,</p>
                <p>You have been invited to join <strong>{{ $organisation }}</strong> Organisation on QAMS. Click the
                    link below to
                    accept the invitation:</p>
                <a href="{{ $link }}" class="btn-success">View Invitation</a>
                <p class="mt-3">If you have any questions, feel free to contact us.</p>
                <p>Thank you,<br>The QAMS Team</p>
            </div>
            <div class="card-footer">
                &copy; {{ date('Y') }} QAMS. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>
