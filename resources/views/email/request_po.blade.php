<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$purchase->purchase_code ?? ''}}</title>
</head>
<body>
    <p>{{$purchase->request->name ?? ''}} sudah membuat request silahkan login untuk memberikan approval ke <a href="{{route('approval.show', $purchase->id)}}">sipr.gushcloud.co.id</a></p>
</body>
</html>