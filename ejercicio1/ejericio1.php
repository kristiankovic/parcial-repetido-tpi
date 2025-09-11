<?php
$factura = [
    // Datos del emisor (quien factura)
    'emisor' => [
        'nombre'    => 'Ferretería El Roble S.A. de C.V.',
        'nit'       => '0614-290123-101-3',
        'nrc'       => '123456-7',
        'giro'      => 'Comercialización de materiales de construcción',
        'direccion' => 'Av. Central #123, San Miguel, SV',
        'telefono'  => '+503 2660-0000',
        'email'     => 'facturacion@elroble.com.sv',
    ],

    // Datos del receptor (cliente)
    'receptor' => [
        'nombre'    => 'Constructora Los Pinos',
        'nit'       => '0614-120987-102-5',
        'nrc'       => '765432-1',
        'direccion' => 'Col. Escalón, Pasaje 3, San Salvador, SV',
        'telefono'  => '+503 2222-3333',
        'email'     => 'compras@lospinos.sv',
    ],

    // Encabezado de la factura
    'encabezado' => [
        'tipoComprobante' => 'Factura Consumidor Final',  // o 'Crédito Fiscal'
        'serie'           => 'F001',
        'numero'          => '00012345',
        'fechaEmision'    => '2025-09-11',
        'moneda'          => 'USD',
        'condicionPago'   => 'CONTADO', // CONTADO | CREDITO
        'diasCredito'     => 0,         // usar si condicionPago = CREDITO
        'formaPago'       => 'EFECTIVO',// EFECTIVO | TARJETA | TRANSFERENCIA
        'observaciones'   => 'Entrega inmediata. Garantía de fábrica 6 meses.'
    ],

    // Parámetros de cálculo
    'parametros' => [
        'iva'                => 0.13,   // 13%
        'descuentoMaxLinea'  => 0.20    // 20% del importe bruto por línea
    ],

    // Cargos/Descuentos globales (opcionales)
    'cargos' => [
        ['descripcion' => 'Envío a obra', 'monto' => 4.00]
    ],
    'anticipos' => 0.00,

    // Detalle de productos/servicios
    'items' => [
        [
            'codigo'         => 'P-001',
            'descripcion'    => 'Martillo 16oz mango fibra',
            'unidad'         => 'UND',
            'cantidad'       => 3,
            'precioUnitario' => 7.50,
            'descuento'      => 0.50,     // descuento absoluto por unidad (opción A)
            'tipoTributo'    => 'GRAVADO' // GRAVADO | EXENTO
        ],
        [
            'codigo'         => 'P-002',
            'descripcion'    => 'Clavos 2" (caja 500u)',
            'unidad'         => 'CJ',
            'cantidad'       => 2,
            'precioUnitario' => 9.80,
            'descuento'      => 0.00,
            'tipoTributo'    => 'GRAVADO'
        ],
        [
            'codigo'         => 'S-010',
            'descripcion'    => 'Servicio de corte de madera',
            'unidad'         => 'SERV',
            'cantidad'       => 1,
            'precioUnitario' => 6.00,
            'descuento'      => 0.00,
            'tipoTributo'    => 'EXENTO' // No grava IVA
        ],
        [
            'codigo'         => 'P-050',
            'descripcion'    => 'Broca para concreto 3/8"',
            'unidad'         => 'UND',
            'cantidad'       => 4,
            'precioUnitario' => 2.35,
            'descuento'      => 0.20,    // descuento por unidad
            'tipoTributo'    => 'GRAVADO'
        ],
    ]
];

$sub_gravado = 0;
$sub_exento = 0;

for($i = 0; $i < 4; $i++){
    if($factura["items"][$i]["tipoTributo"] == "GRAVADO"){
        $sub_gravado += $factura["items"][$i]["cantidad"] * $factura["items"][$i]["precioUnitario"];
    }

    else{
        $sub_exento += $factura["items"][$i]["cantidad"] * $factura["items"][$i]["precioUnitario"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>

    <table>
        <legend>Calculos</legend>

        <thead>
            <th>Producto</th>
            <th>Calculo importa (precioUnitario * cantidad)</th>
            <th>Condicion tributaria</th>
        </thead>

        <tbody>
            <tr>
                <?php for($i=0; $i < 4; $i++) :?>
                    <tr>
                        <td><?= $factura["items"][$i]["descripcion"] ?></td>
                        <td><?= "$" . $factura["items"][$i]["cantidad"] * $factura["items"][$i]["precioUnitario"]?></td>
                        <td><?= $factura["items"][$i]["tipoTributo"] ?></td>
                    </tr>
                <?php endfor; ?>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>Subtotal GRAVADO</td>
                <td><?= "$" . $sub_gravado; ?></td>
                <td><?= "$" . $sub_gravado + ($sub_gravado*0.13) . " (Incluyendo IVA)"; ?></td>
            </tr>
            
            <tr>
                <td>Subtotal EXENTO</td>
                <td> <?= "$" . $sub_exento ?></td>
            </tr>
        </tfoot>
    </table>
</head>
<body>
    
</body>
</html>