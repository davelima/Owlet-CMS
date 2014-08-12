<?php
require_once ("../../src/bootstrap.php");
$captcha = new \Extensions\SimpleCaptcha\SimpleCaptcha();
$captcha->CreateImage();