<?php

    class Router {
        private $routes = [];

        public function add($url, $controller, $method) {
            $this->routes[$url] = ['controller' => $controller, 'method' => $method];
        }

        public function dispatch() {
            $url = $_GET['url'] ?? '/';
            if (isset($this->routes[$url])) {
                $controllerName = $this->routes[$url]['controller'];
                $methodName = $this->routes[$url]['method'];
                require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
                $controller = new $controllerName();
                $controller->$methodName();
            } else {
                echo "404 - Page non trouvée";
            }
        }
    }