<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>aws upload file test</title>
</head>

<body>


    <form action="{{ route('aws') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <button style="margin-top:10px">Upload File</button>
    </form>
</body>

</html>
