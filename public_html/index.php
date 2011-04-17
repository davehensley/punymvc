<?php
/**
 * PunyMVC: A very, very lightweight MVC framework
 *
 * PHP version 5
 *
 * Copyright (c) 2011 Dave Hensley
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:

 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author Dave Hensley <davehensley@gmail.com>
 * @copyright Dave Hensley 2011
 * @link http://dave.ag/an-mvc-framework-in-799-bytes/
 * @package PunyMVC
 * @version 1.0
 */

function load_view($controller, $action, $vars) {
	if (is_file("views/$controller/$action.php")) {
		ob_start();
		include "views/$controller/$action.php";
		$content = ob_get_contents();
		ob_end_clean();
	}

	return isset($content) ? $content : '';
}

function render_page($content, $layout) {
	if (isset($layout)) {
		include "layouts/$layout.php";
	} else {
		echo $content;
	}
}

include 'config/config.php';
$baseDirectoryLength = strlen(dirname($_SERVER['PHP_SELF']));
$parsedURI = explode('/', substr($_SERVER['REDIRECT_URL'], ($baseDirectoryLength > 1) ? $baseDirectoryLength + 1 : 1));

if (!($controller = $parsedURI[0])) {
	include 'pages/index.php';
	exit();
} elseif (!preg_match('/\W/', $controller . isset($parsedURI[1]) ? isset($parsedURI[1]) : '') && is_file("controllers/$controller.php")) {
	include "controllers/$controller.php";
	$controllerClass = $controller . 'Controller';
	$action = isset($parsedURI[1]) && !empty($parsedURI[1]) ? $parsedURI[1] : 'index';

	if (class_exists($controllerClass) && in_array($action, get_class_methods($controllerClass))) {
		$controllerObject = new $controllerClass;
		$content = load_view($controller, $action, $controllerObject->$action(array_slice($parsedURI, 2)));
		render_page($content, isset($controllerObject->layout) ? $controllerObject->layout : null);
		exit();
	}
}

header('HTTP/1.1 404 Not Found');
include 'pages/404.php';
