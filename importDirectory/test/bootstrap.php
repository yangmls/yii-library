<?php

define('YII_DEBUG', FALSE);
define('YII_ENABLE_EXCEPTION_HANDLER',FALSE);
define('YII_ENABLE_ERROR_HANDLER',FALSE);
require('../../framework/yiilite_without_yii.php');
require('../yii.php');

Yii::createWebApplication(array(
    'basePath'=>__DIR__,
));