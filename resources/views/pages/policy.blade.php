<!-- resources/views/pages/policy.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Policy Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,0..900;1,0..900&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Montserrat, serif;
            background-color: #ffffff;
        }

        .container {
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        iframe {
            width: 100%;
            height: 800px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <iframe srcdoc="{!! $policy->text !!}"></iframe>
    </div>
</body>

</html>