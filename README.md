# Yii Utility Files

## importDirectory

A import method that imports a directory and its all sub-directories, also I add a better import method that merge official method and importDirectory method.

## sortClassByNamespace

if you have many classes in models/components directory and you want to sort them by sub-directories, you can try this.

a class format

    namespace Test;
   
    class Component extends \CComponent
    {
        public function init()
        {
        }
    }

the filename is `Component.php` and its path is `path/to/protected/compoentns/test/Component.php`.

Note: the directory of namespace must be lowercase

import the class

    Yii::import('application.compoentns.*');

use the class

    $component = new \Test\Component;