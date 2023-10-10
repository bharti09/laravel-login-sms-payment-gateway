<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>input-component</title>
</head>
<body>
    <form action="{{ route('customers')}}" method="post">
        @csrf
        <x-input type="text" name="name" label="please enter name" />
        <br>
        <x-input type="text" name="address" label="please enter address" />
        <input type="submit" name="submit">
     </form>
</body>
</html>