<?php

/*
 *---------------------------------------------------------------
 * APPLICATION FRONT CONTROLLER
 *---------------------------------------------------------------
 *
 * This file is the front controller. It bootstraps the
 * CodeIgniter framework so it can handle the incoming request.
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();

// Location of the framework boot file.
require_once rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is set up, it's time to actually fire
 * up the engine. We start by initializing the Boot class with
 * the paths and the context, then sending the bootstrapped object
 * to handle the request.
 */
CodeIgniter\Boot::bootWeb($paths);
