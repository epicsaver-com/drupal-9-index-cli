<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt files in the "core" directory.
 */

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

$dir = __DIR__;
$arg1 = "";
if (!empty($argv[1])) {
  $arg1 = $argv[1];
}

$autoloader = require_once 'autoload.php';

$kernel = new DrupalKernel('prod', $autoloader);
if (empty($argv[1])) {
  die("EMPTY ARGUMENTS");
}

$_SERVER['REQUEST_URI'] = $arg1;
$_SERVER['DOCUMENT_ROOT'] = __DIR__;
$_SERVER['CONTEXT_DOCUMENT_ROOT'] = __DIR__;
$_SERVER['HTTP_HOST']       = 'default';
$_SERVER['PHP_SELF']        = '/index-cli.php';
$_SERVER['REMOTE_ADDR']     = '127.0.0.1';
$_SERVER['SERVER_SOFTWARE'] = NULL;
$_SERVER['REQUEST_METHOD']  = 'GET';
$_SERVER['QUERY_STRING']    = '';
$_SERVER['HTTP_USER_AGENT'] = 'console';
$_SERVER['CONTEXT_PREFIX'] = '';

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
