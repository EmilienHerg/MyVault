<?php
// Si la variable existe dans l'environnement (Docker), on la prend.
// Sinon, on garde une valeur de secours (pour le dev local sans Docker).
$key = getenv('ENCRYPTION_KEY');
if ($key === false) {
    // Fallback ou erreur explicite
    die("Erreur critique : La clé de sécurité ENCRYPTION_KEY est introuvable.");
}
define('ENCRYPTION_KEY', $key);
