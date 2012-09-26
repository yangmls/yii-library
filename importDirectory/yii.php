<?php

class Yii extends YiiBase
{
    /**
     * import a directory and its all sub-directories
     * the alias format can be "application.models" or "application.models.*"
     * 
     * @param string $alias the directory alias
     * @return string the directory that this alias refers to
     * @throws CException if the alias is invalid
     */
    public static function importDirectory($alias)
    {
        if(strpos($alias, '.*') !== false) {
            $alias = substr($alias, 0, strlen($alias) - 2);
        }
        $path = self::getPathOfAlias($alias);
        if(is_dir($path) === false) {
            throw new CException("the alias {$alias} is invalid");
        }
        parent::import($alias.'.*');
        $dir = opendir($path);
        while(($file = readdir($dir))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
                self::importDirectory($alias.'.'.$file);
            }
        }
        return $path;
    }
    
    /**
     * a better import method that auto calls importDirectory if the alias is
     * a directory
     * NOTE: if you don't like it and want to use the official import method, you
     * can just remove it or rename it like "importAll"
     * 
     * @param string $alias
     * @param boolean $forceInclude
     * @return string the class name or the directory that this alias refers to
     * @throws CException if the alias is invalid
     */
    public static function import($alias,$forceInclude=false)
    {
        if(($pos=strrpos($alias,'.'))===false) {
            return parent::import($alias, $forceInclude);
        }

        $className=(string)substr($alias,$pos+1);
        $isClass=$className!=='*';
        
        if(!$isClass) {
            return self::importDirectory($alias);
        }
        return parent::import($alias, $forceInclude);
    }
}