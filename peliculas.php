<?php
    require_once 'conexion.php';
    require_once 'peliculas.class.php';

    // Evitar error de CORS
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: Content-Type");

    // Función para responder con JSON y código de estado HTTP
    function respuestaJson($statusCode, $response) {
        http_response_code($statusCode);
        echo json_encode($response);
        exit();
    }

    // Verificar el método de la solicitud
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $peliculas = new Peliculas();
        $datos = $peliculas->listarPeliculasSinPaginar(1);
       // Retornar los datos
        respuestaJson(200, $datos);
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        // Insertar una nueva película
        $peliculas = new Peliculas();
        $postBody = file_get_contents("php://input");
        $datosArray = $peliculas->insertarPelicula($postBody);
        // Retornar la respuesta
        respuestaJson(201, 'Pelicula insertada correctamente');
    }
?>
