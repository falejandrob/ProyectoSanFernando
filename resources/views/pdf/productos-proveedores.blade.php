<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja de pedido</title>
    <style>
        @page{
            margin:5cm 1cm 2cm 1cm;
        }
        #header{
            position: fixed;
            top:-4cm;
            left:0cm;
            bottom: 1cm;
            width: 100%;
        }
        #info{
            margin-top: -1cm;
        }
        #container{
            width: 100%;
        }
        .page-break {
            page-break-after: always;
        }
        table {
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
<div id ="header">
    <table>
        <tbody>
        <tr>
            <td rowspan="3"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/logo.png')))}}"
                                 style="width: 100%"></td>
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
            <td><div class="page-break"></div></td>
        </tr>
        </tbody>
    </table>
</div>

<div id="info">
    <br>
    <span>PROFESOR/A QUE REALIZA EL PEDIDO: <strong>{{$user->nombre}} {{$user->apellidos}}</strong></span><br>
    <span>FECHA DEL PEDIDO: <strong>{{ now()->format('d/m/Y') }}</strong></span><br>
    <span>FECHA PARA LA QUE SE SOLICITA EL PEDIDO: <strong>{{$dateTimeJustification['expectedDate']}}</strong></span><br>
    <span>HORA PARA LA QUE SE SOLICITA EL PEDIDO: <strong>{{$dateTimeJustification['expectedTime']}}</strong></span><br>
    <span>JUSTIFICACION: <strong>{{$dateTimeJustification['justification']}}</strong></span><br><br>
</div>

<div id="container">
    <h2>Productos por Categoría</h2>
    <table>
        <thead>
        <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>I</th>
            <th>R</th>
            <th>Observación</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categoryOrder as $categoria)
            @if(isset($categoryMap[$categoria]))
                <tr style="text-align: center" class="hover">
                    <td style="background: #E7E7E7"><strong>{{ $categoria }}</strong></td>
                    <td style="background: #E7E7E7"></td>
                    <td style="background: #E7E7E7"></td>
                    <td style="background: #E7E7E7"></td>
                    <td style="background: #E7E7E7"></td>
                </tr>
                @foreach($categoryMap[$categoria] as $producto)
                    <tr style="text-align: center" class="hover">
                        <td>{{ $producto->name }}</td>
                        <td>{{ $producto->qty }} ud</td>
                        <td></td>
                        <td></td>
                        <td>{{ $producto->options->observacion }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
    <div style="page-break-after: always;"></div>
    <h2>Productos por Proveedor</h2>
    <table>
        <thead>
        <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Observación</th>
        </tr>
        </thead>
        <tbody>
        @foreach($proveedoresMap as $proveedor)
            @if(count($proveedor['productos']) > 0)
                <tr style="text-align: center" class="hover">
                    <td style="background: #E7E7E7"><strong>{{ $proveedor['nombre'] }}</strong></td>
                    <td style="background: #E7E7E7"></td>
                    <td style="background: #E7E7E7"></td>
                </tr>
                @foreach($proveedor['productos'] as $producto)
                    <tr style="text-align: center" class="hover">
                        <td>{{ $producto->name }}</td>
                        <td>{{ $producto->qty }} ud</td>
                        <td>{{ $producto->options->observacion }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
</div>
<script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(420, 92, "Pág. $PAGE_NUM/$PAGE_COUNT", $font, 12);
            ');
        }
	</script>
</body>
</html>
