<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
session_start();
session_regenerate_id();

if (isset($_SESSION['username'])) 
{
    return true;
} 
else
{
    return false;
    exit;
}
?>
