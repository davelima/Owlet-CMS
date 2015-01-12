<?php
/**
 ************************************************************************
 Copyright [2014] [David Lima]
 
 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at
 
 http://www.apache.org/licenses/LICENSE-2.0
 
 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 ************************************************************************
 */
namespace Extensions;

/**
 * Manage CMS themes
 * This class use data on config file
 *
 * @author David Lima
 * @copyright 2015, David Lima
 * @version r1.0
 * @namespace Extensions
 * @license Apache 2.0
 * @see Config
 */
class Themes
{

    /**
     * The Config object
     *
     * @var \SimpleXMLElement
     * @see Config
     */
    private $config;

    /**
     * Location css theme files
     *
     * @var \DirectoryIterator
     */
    private $themesDir;

    /**
     * Define some settings
     */
    public function __construct()
    {
        $this->config = Config::get();
        $themesDir = __DIR__ . '/../../themes';
        
        if (is_dir($themesDir)) {
            $this->themesDir = new \DirectoryIterator($themesDir);
        } else {
            throw new \Exception("Impossível carregar temas: diretório $themesDir não existe.");
        }
    }

    /**
     * Return the current layout theme
     *
     * @access public
     *        
     * @return string
     */
    public function getCurrentTheme()
    {
        return $theme = $this->config->theming->theme;
    }

    public function listThemes()
    {
        $result = array();
        $results = array();
        
        while ($this->themesDir->valid()) {
            $current = $this->themesDir->current();
            if (! $current->isDot()) {
                $file = $current->getFilename();
                $result['filename'] = substr($file, 0, - 4);
                
                $file = fopen($this->themesDir->getPath() . '/' . $file, 'r');
                
                $lineNumber = 1;
                
                while (! feof($file)) {
                    $line = fgets($file);
                    $lineNumber ++;
                    if ($lineNumber == 3) {
                        $themeName = $line;
                    }
                }
                
                $result['themename'] = $themeName;
                $this->themesDir->next();
                $results[] = $result;
            } else {
                $this->themesDir->next();
                continue;
            }
        }
        return $results;
    }
}