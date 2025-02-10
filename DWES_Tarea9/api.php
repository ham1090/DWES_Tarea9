<?php
/**
 * Obtiene datos de la API de países y los muestra en formato HTML.
 *
 * @return void
 */
function obtenerDatosAPI() {
    $url = "https://restcountries.com/v3.1/all"; // NUEVA API

    // Iniciar cURL
    $ch = curl_init();

    // Configurar cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "<p>Error en la solicitud: " . curl_error($ch) . "</p>";
        curl_close($ch);
        return;
    }

    curl_close($ch);

    // Decodificar JSON
    $data = json_decode($response, true);

    if (!is_array($data)) {
        echo "<p>No se encontraron datos.</p>";
        return;
    }

    echo "<ul>";
    foreach ($data as $pais) {
        $nombre = $pais['name']['common'] ?? "Desconocido";
        $capital = isset($pais['capital']) ? implode(", ", $pais['capital']) : "No tiene";
        $poblacion = number_format($pais['population'] ?? 0);
        $bandera = $pais['flags']['png'] ?? "";

        echo "<li>
                <img src='{$bandera}' alt='{$nombre}' style='width:30px; vertical-align: middle;'> 
                <strong>{$nombre}</strong> - Capital: {$capital} - Población: {$poblacion}
              </li>";
    }
    echo "</ul>";
}

// Ejecutar la función
obtenerDatosAPI();
?>
