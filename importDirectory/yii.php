<?php

class Yii extends YiiBase
{
    /**
     * import a directory and its all sub-directories
     * the alias format can be "application.models" or "application.models.*"
     * 
     * @param string $alias the directory alias
     * @return boolean if the path of directory can be found, the method will
     * return false, otherwise it will return true
     */
    public static function importDirectory($alias)
    {
        if(strpos($alias, '.*') !== false) {
            $alias = substr($alias, 0, strlen($alias) - 2);
        }
        $path = self::getPathOfAlias($alias);
        if(is_dir($path) === false) {
            return false;
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
        return true;
    }
    
    /**
     * a better import method, it will auto call importDirectory if the alias is
     * a directory
     * NOTE: if you don't like it and want to use the official import method, you
     * can just remove it or rename it like "importAll"
     * 
     * @param string $alias
     * @param boolean $forceInclude
     * @return string the class name or the directory that this alias refers to
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