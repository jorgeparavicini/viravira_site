<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";
echo "w";
SQLManager::userExists("hue");
echo false;