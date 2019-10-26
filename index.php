<?php
session_start();

require __DIR__ . '/routes.test.php';

require __DIR__ . '/resolve.php';

routes();

wrapUp();