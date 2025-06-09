<?php
require_once 'config.php';
try {
$pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
throw new PDOException($e->getMessage(), (int) $e->getCode());
}
$imageId = $_GET['id'] ?? 0;
$stmt = $pdo->query("SELECT photo FROM trading WHERE id = " . $imageId);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if ($image && !empty($image['photo'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($image['photo']);
        
        header("Content-Type: $mimeType");
        
        ob_clean();
        echo $image['photo'];
        exit;
    }
?>