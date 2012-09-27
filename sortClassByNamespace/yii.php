<?php

class Yii extends YiiBase
{
    private static $_includePaths=array();

    public static function import($alias,$forceInclude=false)
    {
        if(($pos=strrpos($alias,'.'))===false) {
            return parent::import($alias, $forceInclude);
        }

        $className=(string)substr($alias,$pos+1);
        $isClass=$className!=='*';

        if(($path=self::getPathOfAlias($alias))!==false && !$isClass) {
            array_unshift(self::$_includePaths,$path);
        }
        
        return parent::import($alias, $forceInclude);
	}
    
    public static function autoload($className)
    {
        if(($pos=strrpos($className, '\\')) !== false) {
            $realClassName = substr($className, $pos+1);
        } else {
            return false;
        }
        $classDirectory = str_replace('\\', DIRECTORY_SEPARATOR, ltrim(substr($className, 0, $pos), '\\'));
        foreach(self::$_includePaths as $path) {
            $classFile=$path.DIRECTORY_SEPARATOR.strtolower($classDirectory)
                .DIRECTORY_SEPARATOR.$realClassName.'.php';
            if(is_file($classFile)) {
                include($classFile);
                if(YII_DEBUG && basename(realpath($classFile))!==$realClassName.'.php')
                    throw new CException(Yii::t('yii','Class name "{class}" does not match class file "{file}".', array(
                        '{class}'=>$className,
                        '{file}'=>$classFile,
                    )));
                break;
            }
        }
        return class_exists($className,false) || interface_exists($className,false);
    }
}

Yii::registerAutoloader(array('Yii', 'autoload'));