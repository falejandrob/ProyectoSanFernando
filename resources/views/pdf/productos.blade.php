<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de pedido</title>
    <style>
        table{
            width: 100%;
        }
        table, td, th {
            border: 1px solid #595959;
            border-collapse: collapse;
        }

        td, th {
            padding: 3px;
            width: 30px;
            height: 25px;
        }

        th {
            background: #f0e6cc;
        }

        .even {
            background: #fbf8f0;
        }

        .odd {
            background: #fefcf9;
        }
    </style>
</head>
<body>
<!---->
<table>
    <tbody>
    <tr>
        <td rowspan="3"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/logo.png')))}}" style="width: 100%"></td>
        <td rowspan="3" style="text-align: center">Hoja de pedido</td>
        <td>Documento</td>
        <td>Norma</td>
    </tr>
    <tr>
        <td>DC1231451431</td>
        <td>ISO 9001:2015</td>
    </tr>
    <tr>
        <td>Rev.3</td>
        <td>pag 1/1</td>
    </tr>
    </tbody>
</table>
<br>
<table>
    <thead>
        <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @csrf
        @method("POST")
        @foreach($productos as $producto)
            <tr style="text-align: center" class="hover">
                <td>{{$producto->name}}</td>
                <td>{{$producto->qty}} ud</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
