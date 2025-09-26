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
        'giro'      => '',
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
        'formaPago'       => 'EFECTIVO', // EFECTIVO | TARJETA | TRANSFERENCIA
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

for ($i = 0; $i < 4; $i++) {
    if ($factura["items"][$i]["tipoTributo"] == "GRAVADO") {
        $sub_gravado += $factura["items"][$i]["cantidad"] * $factura["items"][$i]["precioUnitario"];
    } else {
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
        <caption>Cálculos</caption>

        <thead>
            <th>Producto</th>
            <th>Calculo importe</th>
            <th>Condicion tributaria</th>
        </thead>

        <tbody>
            <tr>
                <?php for ($i = 0; $i < 4; $i++) : ?>
            <tr>
                <td><?= $factura["items"][$i]["descripcion"] ?></td>
                <td><?= "$" . $factura["items"][$i]["cantidad"] * $factura["items"][$i]["precioUnitario"] ?></td>
                <td><?= $factura["items"][$i]["tipoTributo"] ?></td>
            </tr>
        <?php endfor; ?>
        </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>Subtotal GRAVADO</td>
                <td><?= "$" . $sub_gravado; ?></td>
                <td><?= "$" . round($sub_gravado + ($sub_gravado * 0.13), 2) . " (Incluyendo IVA)"; ?></td>
            </tr>

            <tr>
                <td>Subtotal EXENTO</td>
                <td></td>
                <td> <?= "$" . $sub_exento ?></td>
            </tr>

            <tr>
                <td>Cargos adicionales</td>
                <td style="background-color: blue;"><?= $factura["cargos"][0]["descripcion"]; ?></td>
                <td><?= "$" . $factura["cargos"][0]["monto"]; ?></td>
            </tr>

            <tr>
                <td>Subtotal general</td>
                <td></td>
                <td><?= "$" . $sub_exento + $sub_gravado; ?></td>
            </tr>

            <tr>
                <td>Total descuentos</td>
                <td></td>
                <td><?= "$0.00" ?></td>
            </tr>

            <tr>
                <td>Total de IVA a pagar</td>
                <td></td>
                <td><?= "$" . round(($sub_exento + $sub_gravado) * 0.13, 2); ?></td>
            </tr>

            <tr style="background-color: cornflowerblue; color: black;">
                <td>Total a Pagar</td>
                <td></td>
                <td style="background-color: rgb(43, 42, 42); color: white;"><?= "$" . ($sub_exento + $sub_gravado) + round(($sub_exento + $sub_gravado) * 0.13, 2); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="caja">

        <table>
            <caption>Detalles de factura</caption>

            <tr>
                <td style="background-color: yellow;"></td>
                <td>Nombre</td>
                <td>NIT</td>
                <td>NRC</td>
                <td>Giro</td>
                <td>Dirección</td>
                <td>Telefóno</td>
                <td>Email</td>

            </tr>
            <tr>
                <th>EMISOR</th>
                <?php foreach ($factura["emisor"] as $detalle) : ?>
                    <td><?= $detalle; ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <th>RECEPTOR</th>
                <?php foreach ($factura["receptor"] as $detalle) : ?>
                    <td><?= $detalle; ?></td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <th>SERIE</th>
                <td colspan="7"><?= $factura["encabezado"]["serie"]; ?></td>
            </tr>

            <tr>
                <th>NÚMERO</th>
                <td colspan="7"><?= $factura["encabezado"]["numero"]; ?></td>
            </tr>

            <tr>
                <th>FECHA</th>
                <td colspan="7"><?= $factura["encabezado"]["fechaEmision"]; ?></td>
            </tr>

            <tr>
                <th>MONEDA</th>
                <td colspan="7"><?= $factura["encabezado"]["moneda"]; ?></td>
            </tr>

            <tr>
                <th>CONDICIÓN</th>
                <td colspan="7"><?= $factura["encabezado"]["condicionPago"]; ?></td>
            </tr>

            <tr>
                <th>FORMA DE PAGO</th>
                <td colspan="7"><?= $factura["encabezado"]["formaPago"]; ?></td>
            </tr>
        </table>
    </div>
</head>

<body>

</body>

</html>