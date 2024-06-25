<?php
include 'startSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <footer>
    <?php include 'vistas/cabeza.php'; ?>

    </footer>

    <section class="contenedor">
        <h3><strong>Reporte de Ajustes</strong></h3><br>
            <br>
        <a href='Excelajuste.php' class='nuevo'>
            <i class='fas fa-file-excel mr-1'></i> Generar Reporte
        </a>
            <br>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>TipoAjuste</th>
                    <th>Nombre del Material</th>
                    <th>Fraccion Arancelaria</th>
                    <th>Cantidad de Entrada</th>
                    <th>Cantidad de Salida</th>
                    <th>Faltantes</th>
                    <th>Mermas</th>
                    <th>Consumo Total con Ajuste</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conexion.php');
                $consulta = "SELECT
                m.DescripcionMaterial,
                m.FraccionArancelaria,
                ie.Cantidad AS CantidadEntrada,
                isal.Cantidad AS CantidadSalida,
                im.Faltantes,
                im.Mermas,
                im.ConsumoReal,
                CASE
                    WHEN im.Faltantes > 0 THEN 'Ajuste por Faltantes'
                    WHEN im.Mermas > 0 THEN 'Ajuste por Mermas'
                    ELSE 'Sin ajuste'
                END AS TipoAjuste
            FROM
                interfasemovimientos im
            LEFT JOIN
                materiales m ON im.MaterialID = m.MaterialID
            LEFT JOIN
                interfaseentradas ie ON im.InterfaseEntradaID = ie.InterfaseEntradaID
            LEFT JOIN
                interfasesalidas isal ON im.InterfaseSalidaID = isal.InterfaseSalidaID
            GROUP BY
                m.MaterialID;";

                $resultado = mysqli_query($conn, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                        <td><?= $fila['TipoAjuste'] ?></td>
                        <td><?= $fila['DescripcionMaterial'] ?></td>
                        <td><?= $fila['FraccionArancelaria'] ?></td>
                        <td><?= $fila['CantidadEntrada'] ?></td>
                        <td><?= $fila['CantidadSalida'] ?></td>
                        <td><?= $fila['Faltantes'] ?></td>
                        <td><?= $fila['Mermas'] ?></td>
                        <td><?= $fila['ConsumoReal'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


    </section>

    <header>
    <?php include 'vistas/footer.php'; ?>

    </header>
</body>
</html>