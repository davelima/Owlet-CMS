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
namespace Controller;

use \View\View;

/**
 * Controller Class
 *
 * @author David Lima
 * @copyright 2014, David Lima
 * @namespace Controller
 * @version r1.0.1
 * @license Apache 2.0
 */
class Controller
{

    /**
     * The View to be loaded
     *
     * @var string
     */
    private $view;

    /**
     * The Model to seek
     *
     * @var string
     */
    private $model;

    /**
     * The action to run on model
     *
     * @var string
     */
    private $action;

    /**
     * Sets the view string (model/action) and load it
     *
     * @see \View\View::load()
     */
    public function __construct()
    {
        $this->model = (isset($_GET['model']) ? ucfirst($_GET['model']) : 'Dashboard');
        $this->action = (isset($_GET['action']) ? strtolower($_GET['action']) : 'dashboard');
        $this->view = "$this->model/$this->action";
        $model = "Model\\" . $this->model;
        $action = $this->action;
        View::load($this->view);
        /*
         * Set the "active" menu item on the sidebar
         */
echo <<<SCRIPT
<script type="text/javascript">
$(document).ready(function(){
    showEnabledPage("{$this->model}");
});
</script>
SCRIPT;
    }
}