<?php
require_once(dirname(__dir__) . '/vendor/autoload.php');

(new MetaTech\PwsServer\Application(['path' => dirname(__dir__)]))->run();
