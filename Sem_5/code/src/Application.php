<?php

namespace Geekbrains\Application1;

class Application {

    private const APP_NAMESPACE = 'Geekbrains\Application1\Controllers\\';

    private string $controllerName;
    private string $methodName;


    public function run() : string {
        $routeArray = explode('/', $_SERVER['REQUEST_URI']);

        if(isset($routeArray[1]) && $routeArray[1] != '') {
            $controllerName = $routeArray[1];
        }
        else{
            $controllerName = "page";
        }

        $this->controllerName = Application::APP_NAMESPACE . ucfirst($controllerName) . "Controller";

        if(class_exists($this->controllerName)){
            // пытаемся вызвать метод
            if(isset($routeArray[2]) && $routeArray[2] != '') {
                $methodName = $routeArray[2];
            }
            else {
                $methodName = "index";
            }

            $this->methodName = "action" . ucfirst($methodName);

            if(method_exists($this->controllerName, $this->methodName)){
                $controllerInstance = new $this->controllerName();
                //$method = $this->methodName;
                //return $controllerInstance->$method();
                return call_user_func_array(
                    [$controllerInstance, $this->methodName],
                    []
                );
            }
            else {
                return "Метод не существует";
            }
        }
        else{
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
            die();
/*            return "Класс $this->controllerName не существует";*/
/*            $this->controllerName = Application::APP_NAMESPACE . "ErrorController";
            $this->methodName = "actionError";
            $controllerInstance = new $this->controllerName();
            return call_user_func_array(
                [$controllerInstance, "$this->methodName"],
                []
            );
            */
        }
    }

    public function render(array $pageVariables) {
        
    }
}