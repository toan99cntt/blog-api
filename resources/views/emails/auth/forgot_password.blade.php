<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yêu cầu tạo lại mật khẩu</title>
    <style>
        #mail {
            margin: 10px 20px;
        }
    </style>
</head>

<body>
    <div id="mail">
        <p>Xin chào <b>{{ $user->name }}</b>,</p>
        <p>Bạn hoặc ai đó đã yêu cầu tạo lại mật khẩu cho tài khoản <b>{{ $user->email }}</b> vào ngày
            {{ $passwordReset->updated_at->format('d') }} tháng {{ $passwordReset->updated_at->format('m') }},
            {{ $passwordReset->updated_at->format('Y') }} lúc {{ $passwordReset->updated_at->format('H:i') }} (UTC+07). </p>
        <p>Thiết bị: {{ $info['device'] }}</p>
        <p>Địa chỉ IP: {{ $info['ip'] }}</p>
        <p><b>Nếu bạn đã làm điều này</b>, thực hiện nhấn vào liên kết phía dưới để tạo lại mật khẩu.</p>
        <p><b>Nếu bạn không làm điều này</b>, vui lòng bỏ qua email này.</p>
        <p><a href="{{ $url }}">Liên kết tạo lại mật khẩu</a> (<i>Liên kết có hiệu lực trong vòng
                {{ $urlLifeTime }} phút kể từ khi bạn nhận được thông báo này</i>)</p>
        <p>Trân trọng cảm ơn!</p>
        <p><a href="{{ config('app.web_host') }}">{{ config('app.name') }}</a></p>
    </div>
</body>

</html>
