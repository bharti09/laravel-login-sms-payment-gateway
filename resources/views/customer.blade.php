<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Data</title>
</head>
<body>
    <table border="1">
        <thead>
            <th>
                <td>Name</td>
                <td>Address</td>
                <td>Action</td>
            </th>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->customer_id}}</td>
                <td>{{ $customer->name}}</td>
                <td>{{ $customer->address}}</td>
                <td>
                    <span><a href="{{url('/customer/edit/'.$customer->customer_id)}}">Edit</a><span>
                    <span><a onclick="return confirm('Are you sure?')" href="{{url('/customer/delete/'.$customer->customer_id)}}">Delete</a><span>
                </td>
            </tr>   
            @endforeach
        </tbody>
    </table>
</body>
</html>