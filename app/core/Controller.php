<?php
require_once 'vendor/autoload.php';
abstract class Controller
    {
        /**
         * Affiche une vue avec des données
         *
         * @param string $viewName Nom du fichier de vue (exemple: 'index.php')
         * @param array $data Données à passer à la vue
         */
        protected function view(string $viewName, array $data = [])
        {
            // Extraire les données pour les rendre accessibles dans la vue
            extract($data);
    
            // Inclure le fichier de vue
            $viewPath = __DIR__ . '/../views/' . $viewName;
            if (file_exists($viewPath)) {
                require $viewPath;
            } else {
                throw new \Exception("La vue {$viewName} est introuvable.");
            }
        }
    
        /**
         * Retourne une réponse JSON
         *
         * @param mixed $data Les données à retourner en JSON
         * @param int $status Code HTTP (par défaut: 200)
         */
        protected function json($data, int $status = 200)
        {
            header('Content-Type: application/json');
            http_response_code($status);
            echo json_encode($data);
            exit();
        }
    
        /**
         * Redirige vers une URL donnée
         *
         * @param string $url URL de redirection
         */
        protected function redirectTo(string $url)
        {
            header("Location: $url");
            exit();
        }
    }
