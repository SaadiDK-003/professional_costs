<?php
// Site URL
$host = $_SERVER['HTTP_HOST'];
if ($host == 'localhost') {
    $dirPath = 'professional_costs/';
    $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://" . $host . "/" . $dirPath;
    // Database Credentials LOCAL
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PWD', '');
    define('DB', 'professional_costs');
} else {
    $dirPath = 'professional_costs/';
    $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$host."/".$dirPath;
    // Database Credentials LIVE
    define('HOST', 'localhost');
    define('USER', 'saadigamers_flat');
    define('PWD', 'TqyM*itQNGkr');
    define('DB', 'saadigamers_ecom');
}

// Global Usage Variables
define('site_url', $url);
define('website_title', 'Professional Costs');
