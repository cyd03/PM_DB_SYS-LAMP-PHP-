<?php
$mysevername ="localhost";
$myusername ="root";
$mypassword ="031203cYd?";
$mydbname = 'exp_4';
$mysqli = new mysqli($mysevername,$myusername,$mypassword,$mydbname);
if($mysqli->connect_errno)
{
    die($mysqli->connect_error);
}
$mysqli->set_charset('utf-8');