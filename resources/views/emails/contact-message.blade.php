<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Contact Message</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin: 0 0 16px;">New portfolio contact message</h2>

    <p style="margin: 0 0 8px;">
        <strong>Name:</strong> {{ $name }}
    </p>
    <p style="margin: 0 0 8px;">
        <strong>Email:</strong> {{ $email }}
    </p>
    <p style="margin: 0;">
        <strong>Message:</strong><br>
        {{ $user_message }}
    </p>
</body>
</html>

