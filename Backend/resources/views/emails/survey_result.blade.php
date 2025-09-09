<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Survey Form</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f8fa; padding: 20px;">

<div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <!-- Header -->
    <div style="background-color: #4f46e5; color: white; padding: 20px; text-align: center;">
        <h2 style="margin: 0;">Kết quả khảo sát</h2>
    </div>

    <!-- Content -->
    <div style="padding: 30px; color: #333;">
        <p>Hello,</p>
        <p>You was invited to join this survey</p>
        <p>To view is, press this buuton, please !!!:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}"
               style="background-color: #4f46e5; color: white; text-decoration: none; padding: 15px 25px; border-radius: 5px; display: inline-block; font-weight: bold;">
                Link to view survey
            </a>
        </div>

        <p>If you can't get the link in btn, you will copy this link and search it i=on the broswer:</p>
        <p style="word-break: break-all;"><a href="{{ $url }}" style="color: #4f46e5;">{{ $url }}</a></p>

        <p>Thank you!</p>
    </div>

    <!-- Footer -->
    <div style="background-color: #f1f1f1; color: #555; text-align: center; padding: 15px; font-size: 12px;">
        &copy; {{ date('Y') }} Copyright.
    </div>
</div>
</body>
</html>
