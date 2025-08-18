<?php 
    $filename = basename($_GET["file"] ?? '');
    $path = __DIR__ . '/../src/uploads/' . $filename; 
    if($filename && file_exists(($path)))
    {
        $mime = mime_content_type($path);
        header("Content-Type: $mime");
        readfile($path);
        exit;
    } else {
        http_response_code(404);
        echo "Image not found.";
    }
?>