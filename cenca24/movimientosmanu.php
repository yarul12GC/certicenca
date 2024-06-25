<?php
include 'startSession.php';
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/media/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="assets/styles.css">
    <title>Movimientos de manufactura</title>
</head>
<body>
    <header>
    <?php include 'vistas/cabeza.php'; ?>
    </header>

    <section class="contenedor">
    <h3><strong>Movimientos Manufactura</strong></h3>
    <?php

            if (isset($_GET['mensaje'])) {
                $mensaje = $_GET['mensaje'];
                if ($mensaje === "exito") {
                    echo "<div id='mensaje' class='alert alert-success'>El movimiento se ha actualizado correctamente.</div>";
                } elseif ($mensaje === "error") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al actualizar el movimiento.</div>";
                } elseif ($mensaje === "exito_registro") {
                    echo "<div id='mensaje' class='alert alert-success'>El nuevo movimiento se ha registrado correctamente.</div>";
                } elseif ($mensaje === "error_registro") {
                    echo "<div id='mensaje' class='alert alert-danger'>Error al registrar el nuevo movimiento.</div>";
                }

                // Agrega el script JavaScript
                echo "<script>
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 2000);
          </script>";
            }
            ?>
    <button type="button" class="nuevo" data-bs-toggle="modal" data-bs-target="#exampleModal">Registar Movimiento</button>

    <table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Nombre del Material</th>
            <th>Consolidado Movimientos</th>
            <th>Cantidad de Entrada</th>
            <th>Cantidad de Salida</th>
            <th>Faltantes</th>
            <th>Sobrantes</th>
            <th>Consumo Real</th>
            <th>Monto en Dólares</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include('conexion.php');
        $consulta = "SELECT m.InterfaseMovimientoID, m.ConsolidadoMovimientos, e.Cantidad AS CantidadEntrada, s.Cantidad AS CantidadSalida, 
                            m.Faltantes, m.Sobrantes, ma.DescripcionMaterial, m.ConsumoReal, m.MontoTotalDolares 
                     FROM interfasemovimientos m
                     INNER JOIN interfaseentradas e ON m.InterfaseEntradaID = e.InterfaseEntradaID
                     INNER JOIN interfasesalidas s ON m.InterfaseSalidaID = s.InterfaseSalidaID
                     INNER JOIN materiales ma ON m.MaterialID = ma.MaterialID";
        $resultado = mysqli_query($conn, $consulta);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>{$fila['DescripcionMaterial']}</td>";
            echo "<td>{$fila['ConsolidadoMovimientos']}</td>";
            echo "<td>{$fila['CantidadEntrada']}</td>";
            echo "<td>{$fila['CantidadSalida']}</td>";
            echo "<td>{$fila['Faltantes']}</td>";
            echo "<td>{$fila['Sobrantes']}</td>";
            echo "<td>{$fila['ConsumoReal']}</td>";
            echo "<td>{$fila['MontoTotalDolares']}</td>";
            echo "<td>";
            echo "<button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editarModal{$fila['InterfaseMovimientoID']}'>";
            echo "<img src='assets/media/editar.png' width='15px' height='15px'>";
            echo "</button>";
            echo "<button type='button' class='btn btn-danger btn-sm' onclick='confirmarEliminar({$fila['InterfaseMovimientoID']})'>";
            echo "<img src='assets/media/eliminar.png' width='15px' height='15px'>";
            echo "</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>




    </section>

    <footer>
    <?php include 'vistas/footer.php'; ?>
    </footer>
    <!-- Button trigger modal -->

<!-- Modal registro -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Movimiento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post" action="moviregis.php">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ConsolidadoMovimientos">Consolidado de Movimientos</label>
                                <input type="text" class="form-control" id="ConsolidadoMovimientos" name="ConsolidadoMovimientos">
                            </div>
                            <div class="form-group">
                                <label for="material">Material</label>
                                <select class="form-control" name="MaterialID" id="material">
                                    <option value="">Seleccione un material</option>
                                    <?php
                                    include('conexion.php');
                                    $consulta_materiales = "SELECT MaterialID, DescripcionMaterial FROM materiales";
                                    $resultado_materiales = mysqli_query($conn, $consulta_materiales);
                                    while ($fila = mysqli_fetch_assoc($resultado_materiales)) {
                                        echo "<option value=\"{$fila['MaterialID']}\">{$fila['DescripcionMaterial']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="producto">Producto</label>
                                <select class="form-control" name="ProductoID" id="producto">
                                    <option value="">Seleccione un producto</option>
                                    <?php
                                    $consulta_producto = "SELECT ProductoID, DescripcionProducto FROM productos";
                                    $resultado_producto = mysqli_query($conn, $consulta_producto);
                                    while ($fila = mysqli_fetch_assoc($resultado_producto)) {
                                        echo "<option value=\"{$fila['ProductoID']}\">{$fila['DescripcionProducto']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="InterfaseEntradaID">Entrada</label>
                                <select class="form-control" name="InterfaseEntradaID" id="entrada">
                                    <option value="">Seleccione una entrada</option>
                                    <?php
                                    include('conexion.php');
                                    $consulta_entradas = "SELECT e.InterfaseEntradaID, CONCAT(m.DescripcionMaterial, ' - ', e.Cantidad) AS DescripcionEntrada 
                                                        FROM interfaseentradas e
                                                        INNER JOIN materiales m ON e.MaterialID = m.MaterialID
                                                        ORDER BY m.DescripcionMaterial";
                                    
                                    $resultado_entradas = mysqli_query($conn, $consulta_entradas);
                                    while ($fila = mysqli_fetch_assoc($resultado_entradas)) {
                                        echo "<option value=\"{$fila['InterfaseEntradaID']}\">{$fila['DescripcionEntrada']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="InterfaseSalidaID">Salida</label>
                                <select class="form-control" name="InterfaseSalidaID" id="salida">
                                    <option value="">Seleccione una salida</option>
                                    <?php
                                    include('conexion.php');
                                    
                                    // Consulta para obtener las salidas con su descripción de material
                                    $consulta_salidas = "SELECT s.InterfaseSalidaID, CONCAT(m.DescripcionMaterial, ' - ', s.Cantidad) AS DescripcionSalida 
                                                        FROM interfasesalidas s
                                                        INNER JOIN materiales m ON s.MaterialID = m.MaterialID
                                                        ORDER BY m.DescripcionMaterial";
                                    
                                    $resultado_salidas = mysqli_query($conn, $consulta_salidas);
                                    
                                    // Iterar sobre los resultados y mostrarlos en el select
                                    while ($fila = mysqli_fetch_assoc($resultado_salidas)) {
                                        echo "<option value=\"{$fila['InterfaseSalidaID']}\">{$fila['DescripcionSalida']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                                <label for="faltantes">Faltantes</label>
                                <input type="number" class="form-control" id="faltantes" name="Faltantes">
                            </div>
                            <div class="form-group">
                                <label for="sobrantes">Sobrantes</label>
                                <input type="number" class="form-control" id="sobrantes" name="Sobrantes" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mermas">Mermas</label>
                                <input type="number" class="form-control" id="mermas" name="Mermas">
                            </div>
                            <div class="form-group">
                                <label for="consumoReal">Consumo Real</label>
                                <input type="number" class="form-control" id="ConsumoReal" name="ConsumoReal" readonly>
                            </div>
                            <div class="form-group">
                                <label for="DescripcionMercancia">Descripción de Mercancía</label>
                                <input type="text" class="form-control" id="DescripcionMercancia" name="DescripcionMercancia">
                            </div>
                            <div class="form-group">
                                <label for="UnidadMedida" class="form-label">Unidad de Medida Comercialización:</label>
                                <select name="UnidadMedida" class="form-select" required>
                                    <option value="" disabled selected style="text-align: center;">----Seleccionar----</option>
                                    <option value="KG">Kilogramo (KG)</option>
                                    <option value="GR">Gramo (GR)</option>
                                    <option value="L">Litro (L)</option>
                                    <option value="M3">Metro cúbico (M3)</option>
                                    <option value="M">Metro (M)</option>
                                    <option value="CM">Centímetro (CM)</option>
                                    <option value="M2">Metro cuadrado (M2)</option>
                                    <option value="CM2">Centímetro cuadrado (CM2)</option>
                                    <option value="PZA">Pieza (PZA)</option>
                                    <option value="DZ">Docena (DZ)</option>
                                    <option value="MLL">Millar (MLL)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="CantidadMercancia">Cantidad de Mercancía Ocupada</label>
                                <input type="number" class="form-control" id="CantidadMercancia" name="CantidadMercancia">
                            </div>
                            <div class="form-group">
                                <label for="ValorUnitarioDolares">Valor Unitario en Dólares</label>
                                <input type="number" class="form-control" id="ValorUnitarioDolares" name="ValorUnitarioDolares" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="MontoTotalDolares">Monto Total en Dólares</label>
                                <input type="number" class="form-control" id="MontoTotalDolares" name="MontoTotalDolares" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="FechaRecuperacion">Fecha de Recuperación</label>
                                <input type="date" class="form-control" id="FechaRecuperacion" name="FechaRecuperacion">
                            </div>
                            <div class="form-group">
                                <label for="IdentificadorSistemaCorporativo">Identificador de Sistema Corporativo</label>
                                <input type="text" class="form-control" id="IdentificadorSistemaCorporativo" name="IdentificadorSistemaCorporativo">
                            </div>
                            <div class="form-group">
                                <label for="ContribuyenteID">Contribuyente</label>
                                <select class="form-control" name="ContribuyenteID" required>
                                    <option value="">Seleccione un contribuyente</option>
                                    <?php
                                    $consulta_contribuyentes = "SELECT ContribuyenteID, DenominacionRazonSocial FROM contribuyente";
                                    $resultado_contribuyentes = mysqli_query($conn, $consulta_contribuyentes);
                                    while ($fila = mysqli_fetch_assoc($resultado_contribuyentes)) {
                                        echo "<option value=\"{$fila['ContribuyenteID']}\">{$fila['DenominacionRazonSocial']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>





<?php
        $consultar_movimientos = "SELECT * FROM interfasemovimientos";
        $query = mysqli_query($conn, $consultar_movimientos);

        while ($row1 = mysqli_fetch_assoc($query)) {
        ?>
                <!-- Modal -->
                <div class="modal fade" id="editarModal<?php echo $row1['InterfaseMovimientoID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" style="max-width: 90vw;">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Salidas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="post" action="editarmovi.php">
                        <div class="row">
                        <input type="hidden" class="form-control" id="InterfaseMovimientoID" name="InterfaseMovimientoID"value="<?php echo $row1['InterfaseMovimientoID']; ?>">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ConsolidadoMovimientos">Consolidado de Movimientos</label>
                                    <input type="text" class="form-control" id="ConsolidadoMovimientos" name="ConsolidadoMovimientos"value="<?php echo $row1['ConsolidadoMovimientos']; ?>">
                                </div>
                                <div class="form-group">
                                        <label for="material">Material</label>
                                        <select class="form-control" name="MaterialID">
                                            <option value="">Seleccione un material</option>
                                            <?php
                                            $consulta_materiales = mysqli_query($conn, "SELECT MaterialID, DescripcionMaterial FROM materiales");

                                            while ($datos = mysqli_fetch_array($consulta_materiales)) {
                                            ?>
                                                <option value="<?php echo $datos['MaterialID']; ?>" <?php echo ($datos['MaterialID'] == $row1['MaterialID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['DescripcionMaterial']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="producto">Producto</label>
                                        <select class="form-control" name="ProductoID">
                                            <option value="">Seleccione un producto</option>
                                            <?php
                                            $consulta_producto = mysqli_query($conn, "SELECT ProductoID, DescripcionProducto FROM productos");

                                            while ($datos = mysqli_fetch_array($consulta_producto)) {
                                            ?>
                                                <option value="<?php echo $datos['ProductoID']; ?>" <?php echo ($datos['ProductoID'] == $row1['ProductoID']) ? 'selected' : ''; ?>>
                                                    <?php echo $datos['DescripcionProducto']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="entrada">Entrada</label>
                                    <select class="form-control" id="InterfaseEntradaID" name="InterfaseEntradaID">
                                        <?php
                                        include('conexion.php');
                                        $consulta_entradas = "SELECT e.InterfaseEntradaID, CONCAT(m.DescripcionMaterial, ' - ', e.Cantidad) AS DescripcionEntrada 
                                                            FROM interfaseentradas e
                                                            INNER JOIN materiales m ON e.MaterialID = m.MaterialID
                                                            ORDER BY m.DescripcionMaterial";                                

                                        $resultado_entradas = mysqli_query($conn, $consulta_entradas);
                                        // Agrega una opción oculta por defecto si es necesario
                                        echo "<option hidden value=''>Seleccionar una entrada</option>";
                                        while ($fila = mysqli_fetch_assoc($resultado_entradas)) {
                                            $selected = ($fila['InterfaseEntradaID'] == $row1['InterfaseEntradaID']) ? 'selected' : '';
                                            echo "<option value=\"{$fila['InterfaseEntradaID']}\" $selected>{$fila['DescripcionEntrada']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="InterfaseSalidaID">Salida</label>
                                    <select class="form-control" name="InterfaseSalidaID" id="salida">
                                        <option value="">Seleccione una salida</option>
                                        <?php
                                        include('conexion.php');
                                        
                                        // Consulta para obtener las salidas con su descripción de material
                                        $consulta_salidas = "SELECT s.InterfaseSalidaID, CONCAT(m.DescripcionMaterial, ' - ', s.Cantidad) AS DescripcionSalida 
                                                            FROM interfasesalidas s
                                                            INNER JOIN materiales m ON s.MaterialID = m.MaterialID
                                                            ORDER BY m.DescripcionMaterial";
                                        
                                        $resultado_salidas = mysqli_query($conn, $consulta_salidas);
                                        
                                        // Iterar sobre los resultados y mostrarlos en el select
                                        while ($fila = mysqli_fetch_assoc($resultado_salidas)) {
                                            $selected = ($fila['InterfaseSalidaID'] == $row1['InterfaseSalidaID']) ? 'selected' : '';
                                            echo "<option value=\"{$fila['InterfaseSalidaID']}\" $selected>{$fila['DescripcionSalida']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                    <label for="faltantes">Faltantes</label>
                                    <input type="number" class="form-control" id="faltantes" name="Faltantes" value="<?php echo $row1['Faltantes']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="sobrantes">Sobrantes</label>
                                    <input type="number" class="form-control" id="sobrantes" name="Sobrantes" readonly value="<?php echo $row1['Sobrantes']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="mermas">Mermas</label>
                                    <input type="number" class="form-control" id="mermas" name="Mermas" value="<?php echo $row1['Mermas']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="consumoReal">Consumo Real</label>
                                    <input type="number" class="form-control" id="ConsumoReal" name="ConsumoReal" readonly value="<?php echo $row1['ConsumoReal']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="DescripcionMercancia">Descripción de Mercancía</label>
                                    <input type="text" class="form-control" id="DescripcionMercancia" name="DescripcionMercancia" value="<?php echo $row1['DescripcionMercancia']; ?>">
                                </div>
                                <div class="form-group">
                                <label for="unidad_medida" class="form-label">Unidad de Medida Comercialización:</label>
                                <select name="UnidadMedida" class="form-select" required>
                                <option hidden value="<?php echo $row1['UnidadMedida']; ?> " required> <?php echo $row1['UnidadMedida']; ?></option>
                                    <option value="KG">Kilogramo (KG)</option>
                                    <option value="GR">Gramo (GR)</option>
                                    <option value="L">Litro (L)</option>
                                    <option value="M3">Metro cúbico (M3)</option>
                                    <option value="M">Metro (M)</option>
                                    <option value="CM">Centímetro (CM)</option>
                                    <option value="M2">Metro cuadrado (M2)</option>
                                    <option value="CM2">Centímetro cuadrado (CM2)</option>
                                    <option value="PZA">Pieza (PZA)</option>
                                    <option value="DZ">Docena (DZ)</option>
                                    <option value="MLL">Millar (MLL)</option>
                                </select>
                            </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CantidadMercancia">Cantidad de Mercancía Ocupada</label>
                                    <input type="number" class="form-control" id="CantidadMercancia" name="CantidadMercancia" value="<?php echo $row1['CantidadMercancia']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ValorUnitarioDolares">Valor Unitario en Dólares</label>
                                    <input type="number" class="form-control" id="ValorUnitarioDolares" name="ValorUnitarioDolares" step="0.01" value="<?php echo $row1['ValorUnitarioDolares']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="MontoTotalDolares">Monto Total en Dólares</label>
                                    <input type="number" class="form-control" id="MontoTotalDolares" name="MontoTotalDolares" step="0.01"value="<?php echo $row1['MontoTotalDolares']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="FechaRecuperacion">Fecha de Recuperación</label>
                                    <input type="date" class="form-control" id="FechaRecuperacion" name="FechaRecuperacion"value="<?php echo $row1['FechaRecuperacion']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="IdentificadorSistemaCorporativo">Identificador de Sistema Corporativo</label>
                                    <input type="text" class="form-control" id="IdentificadorSistemaCorporativo" name="IdentificadorSistemaCorporativo"value="<?php echo $row1['IdentificadorSistemaCorporativo']; ?>">
                                </div>
                                <div class="form-group">
                                         <label for="ContribuyenteID">Contribuyente:</label>
                                         <select class="form-control" required="required" name="ContribuyenteID">

                                             <?php
                                                $contribuyente = mysqli_query($conn, "SELECT ContribuyenteID, DenominacionRazonSocial, ClaveRFC FROM contribuyente");

                                                while ($datos = mysqli_fetch_array($contribuyente)) {
                                                ?>
                                                 <option value="<?php echo $datos['ContribuyenteID']; ?>" <?php echo ($row1['ContribuyenteID'] == $datos['ContribuyenteID']) ? 'selected' : ''; ?>>
                                                     <?php echo $datos['DenominacionRazonSocial']; ?> - RFC: <?php echo $datos['ClaveRFC']; ?>
                                                 </option>

                                             <?php
                                                }
                                                ?>
                                         </select>
                                     </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                    </div>
                    </div>
                </div>
                </div>
                <?php
                }
                ?>
</div>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Obtener elementos de entrada y salida
    var entradaSelect = document.getElementById("entrada");
    var salidaSelect = document.getElementById("salida");
    var consumoRealInput = document.getElementById("ConsumoReal");
    var sobrantesInput = document.getElementById("sobrantes");
    var mermasInput = document.getElementById("mermas");
    var valorUnitarioInput = document.getElementById("ValorUnitarioDolares");
    var montoTotalInput = document.getElementById("MontoTotalDolares");

    // Agregar evento onchange a los select de entrada y salida
    entradaSelect.addEventListener("change", function() {
        calcularConsumoReal();
        calcularSobrantes();
        calcularMontoTotal();
    });
    salidaSelect.addEventListener("change", function() {
        calcularConsumoReal();
        calcularSobrantes();
        calcularMontoTotal();
    });
    mermasInput.addEventListener("input", function() {
        calcularConsumoReal();
        calcularSobrantes();
        calcularMontoTotal();
    });
    valorUnitarioInput.addEventListener("input", function() {
        calcularMontoTotal();
    });

    function calcularConsumoReal() {
        var cantidadEntrada = parseFloat(entradaSelect.options[entradaSelect.selectedIndex].text.split(' - ')[1]);
        var cantidadSalida = parseFloat(salidaSelect.options[salidaSelect.selectedIndex].text.split(' - ')[1]);
        var mermas = parseFloat(mermasInput.value) || 0;
        var consumoReal = cantidadEntrada - cantidadSalida + mermas;
        consumoRealInput.value = consumoReal;
    }

    function calcularSobrantes() {
    var cantidadEntrada = parseFloat(entradaSelect.options[entradaSelect.selectedIndex].text.split(' - ')[1]);
    var cantidadSalida = parseFloat(salidaSelect.options[salidaSelect.selectedIndex].text.split(' - ')[1]);
    var mermas = parseFloat(mermasInput.value) || 0;
    var consumoReal = cantidadEntrada - cantidadSalida + mermas;
    var sobrante = cantidadEntrada - consumoReal;
    if (sobrante < 0) {
        var nuevaMerma = Math.abs(sobrante);
        mermasInput.value = nuevaMerma;
        consumoRealInput.value = consumoReal + nuevaMerma;
        sobrantesInput.value = 0;
    } else {
        sobrantesInput.value = sobrante;
    }
}


    function calcularMontoTotal() {
        var consumoReal = parseFloat(consumoRealInput.value) || 0;
        var valorUnitario = parseFloat(valorUnitarioInput.value) || 0;
        var montoTotal = consumoReal * valorUnitario;
        montoTotalInput.value = montoTotal.toFixed(2);
    }
});

</script>