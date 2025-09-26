<?php

session_start();

if (!isset($_SESSION["empleados"])) {
    $_SESSION["empleados"] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST["nombre"];
    $salarioBase = $_POST["salario"];
    $empleados = [];

    $afp = $salarioBase * 0.075;
    $iss = $salarioBase * 0.03;
    $renta = $salarioBase * 0.03;

    $salarioNeto = round($salarioBase - ($afp + $iss + $renta), 2);
    $salario = 0;
    $tramo = "";

    if ($salarioNeto >= 0.01 && $salarioNeto <= 472.00) {

        $salarioNeto = $salarioNeto - ($salarioNeto * 0.10);
        $salario = "$" . round(($salarioNeto + 17.67), 2);
        $tramo = "Tramo I";
    } elseif ($salarioNeto >= 472.01 && $salarioNeto <= 895.24) {

        $salarioNeto = $salarioNeto - ($salarioNeto * 0.20);
        $salario = "$" . round(($salarioNeto + 17.67), 2);
        $tramo = "Tramo II";
    } elseif ($salarioNeto >= 895.25 && $salarioNeto <= 2038.20) {

        $salarioNeto = $salarioNeto - ($salarioNeto * 0.10);
        $salario = "$" . round(($salarioNeto + 60.00), 2);
        $tramo = "Tramo III";
    } else {
        $salarioNeto = $salarioNeto - ($salarioNeto * 0.30);
        $salario = "$" . round(($salarioNeto + 288.57), 2);
        $tramo = "Tramo IV";
    }

    $_SESSION["empleados"][] = [$_POST["nombre"], $_POST["salario"], $iss, $afp, $renta, $salario, $tramo];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ejercicio 2</title>
</head>

<body>

    <div class="caja">

        <form action="" method="post">

            <h2>Ingreso de datos</h2>

            <input type="text" name="nombre" id="nombre" required placeholder="Nombre del empleado"><br><br>

            <input type="number" name="salario" id="salario" step="0.01" required placeholder="Salario base del empleado">

            <button type="submit">Calcular</button>
        </form>
    </div>

    <div class="caja">

        <table>
            <caption>Datos</caption>

            <thead>
                <th>Empleado</th>
                <th>Salario base</th>
                <th>ISS</th>
                <th>AFP</th>
                <th>Renta</th>
                <th>Monto a pagar</th>
                <th>Tramo</th>
            </thead>

            <tbody>

                <?php foreach ($_SESSION["empleados"] as $empleado) : ?>

                    <?php if ($empleado[6] === "Tramo I") : ?>

                        <tr>
                            <td class="tramo1"><?= $empleado[0]; ?></td>
                            <td class="tramo1"><?= $empleado[1]; ?></td>
                            <td class="tramo1"><?= $empleado[2]; ?></td>
                            <td class="tramo1"><?= $empleado[3]; ?></td>
                            <td class="tramo1"><?= $empleado[4]; ?></td>
                            <td class="tramo1"><?= $empleado[5]; ?></td>
                            <td class="tramo1"><?= $empleado[6]; ?></td>
                        </tr>

                    <?php elseif ($empleado[6] === "Tramo II") : ?>

                        <tr>
                            <td class="tramo2"><?= $empleado[0]; ?></td>
                            <td class="tramo2"><?= $empleado[1]; ?></td>
                            <td class="tramo2"><?= $empleado[2]; ?></td>
                            <td class="tramo2"><?= $empleado[3]; ?></td>
                            <td class="tramo2"><?= $empleado[4]; ?></td>
                            <td class="tramo2"><?= $empleado[5]; ?></td>
                            <td class="tramo2"><?= $empleado[6]; ?></td>
                        </tr>

                    <?php elseif ($empleado[6] === "Tramo III") : ?>

                        <tr>
                            <td class="tramo3"><?= $empleado[0]; ?></td>
                            <td class="tramo3"><?= $empleado[1]; ?></td>
                            <td class="tramo3"><?= $empleado[2]; ?></td>
                            <td class="tramo3"><?= $empleado[3]; ?></td>
                            <td class="tramo3"><?= $empleado[4]; ?></td>
                            <td class="tramo3"><?= $empleado[5]; ?></td>
                            <td class="tramo3"><?= $empleado[6]; ?></td>
                        </tr>

                    <?php else : ?>

                        <tr>
                            <td class="tramo4"><?= $empleado[0]; ?></td>
                            <td class="tramo4"><?= $empleado[1]; ?></td>
                            <td class="tramo4"><?= $empleado[2]; ?></td>
                            <td class="tramo4"><?= $empleado[3]; ?></td>
                            <td class="tramo4"><?= $empleado[4]; ?></td>
                            <td class="tramo4"><?= $empleado[5]; ?></td>
                            <td class="tramo4"><?= $empleado[6]; ?></td>
                        </tr>



                    <?php endif; ?>

                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
</body>

</html>