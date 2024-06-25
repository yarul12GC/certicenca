<head>
<link rel="shortcut icon" href="../media/locenca.png" type="image/x-icon" />
</head>
<body>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/carga.css">
<div id="loading-container">
    <img id="loading-gif" src="../media/cargando.gif" alt="Cargando...">
    <br>
    <br>
    <p id="loading-message">Cargando...</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    // Tu script personalizado para manejar la carga de la página
    document.addEventListener("DOMContentLoaded", function () {
        // Simula la carga durante 2 segundos
        setTimeout(() => {
            // Oculta el contenedor de carga y muestra el contenido principal
            document.getElementById("loading-container").style.display = "none";
            document.getElementById("content").style.display = "block";
        }, 2000); // 2000 milisegundos = 2 segundos (puedes ajustar este valor)
    });
</script>

</body>

