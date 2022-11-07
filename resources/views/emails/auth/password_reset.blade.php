<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mật khẩu mới</title>
    <style>
        #mail {
            margin: 10px 20px;
        }
    </style>
</head>

<body>
    <div id="mail">
        <p>Xin chào <b>{{ $user->name }}</b>,</p>
        <p>Yêu cầu tạo lại mật khẩu của bạn đã được xử lý.</p>
        <p>Mật khẩu mới cho tài khoản <b>{{ $user->username }}</b> là: {{ $password }}</p>
        <p>Trân trọng cảm ơn!</p>
        <p><a href="{{ config('app.web_host') }}">{{ config('app.name') }}</a></p>
    </div>
</body>

</html>
