<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>{{ $data['name'] }}</p>
    <p>{{ $data['email'] }}</p>
    <p>Firma</p>
    <!-- descomentar si se usa la ruta del archivo en disco -->
    <!-- <img src="{{-- route('user.sign',['filename'=>$data['filename']]) --}}" alt="" width="300" height="150" /> -->
    <img src="{{ $data['filename'] }}" alt="" width="300" height="150" />
</body>
</html>
