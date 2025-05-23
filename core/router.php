<?php

    // Permet de récupérer l'ID de l'utilisateur dans l'URL pour les routes comme /admin/suspend-user?id=123
    // et d'appeler la méthode du contrôleur avec cet ID

    // Surcharge de la méthode dispatch pour gérer les routes avec paramètres (ex: ?id=)
    // On modifie la méthode dispatch pour détecter si la route attend un paramètre ID

    class Router {
        private $routes = [];

        public function add($url, $controller, $method) {
            $this->routes[$url] = ['controller' => $controller, 'method' => $method];
        }

        // Surcharge de la méthode dispatch pour gérer les routes avec paramètres (ex: ?id=)
        public function dispatch() {
            $url = $_GET['url'] ?? '/';

            // Recherche exacte
            if (isset($this->routes[$url])) {
                $controllerName = $this->routes[$url]['controller'];
                $methodName = $this->routes[$url]['method'];
                require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
                $controller = new $controllerName();

                // Si un paramètre id est présent dans l'URL, on le passe à la méthode
                if (isset($_GET['id'])) {
                    $controller->$methodName($_GET['id']);
                } else {
                    $controller->$methodName();
                }
                return;
            }

            // Recherche de routes avec paramètres (ex: /admin/suspend-user?id=)
            // On cherche une route qui commence par l'URL sans le paramètre
            $urlPath = strtok($url, '?');
            foreach ($this->routes as $route => $info) {
                // On gère les routes qui se terminent par ?id= (déclarées dans routes/web.php)
                if (strpos($route, '?id=') !== false) {
                    $baseRoute = strstr($route, '?id=', true);
                    if ($baseRoute === false) $baseRoute = $route;
                    if (strpos($url, $baseRoute) === 0 && isset($_GET['id'])) {
                        $controllerName = $info['controller'];
                        $methodName = $info['method'];
                        require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
                        $controller = new $controllerName();
                        $controller->$methodName($_GET['id']);
                        return;
                    }
                }
            }

            // Si aucune route ne correspond
            echo "404 - Page non trouvée";
        }

    }