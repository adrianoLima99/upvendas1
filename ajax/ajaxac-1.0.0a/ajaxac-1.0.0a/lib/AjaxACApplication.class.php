<?php
    /**
     * Copyright 2005-06 Zervaas Enterprises (www.zervaas.com.au)
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     *     http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     *
     * @package AjaxAC
     */

    define('AJAXAC_VERSION', '1.0-alpha');

    /**
     * The different levels of debugging
     */
    define('AJAXAC_DEBUG_NONE', 0);
    define('AJAXAC_DEBUG_CORE_ERROR', 1 << 0);

    define('AJAXAC_DEBUG_ERROR_ALL', AJAXAC_DEBUG_CORE_ERROR);
    define('AJAXAC_DEBUG_ALL', -1);

    /**
     * The base class for all AjaxAC applications. Contains a wide range of functionality
     * for handling requests, subrequest, attaching actions/events/widgets/etc.. as well
     * as generating subrequest URL's and piecing together application JavaScript code.
     * This class should never been instantiated directly, as it won't do anything. Instead,
     * specific applications should extend this class, creating widgets + their events, as
     * well as actions + handlers for sub-requests
     *
     * @author  Quentin Zervaas
     * @access  Public
     */
    class AjaxACApplication
    {
        /**
         * The default character set to use for returned subrequest
         * data. Used only if not specified in the application config
         */
        var $_defaultCharset = 'UTF-8';


        /**
         * AjaxACApplication
         *
         * Constructor. Sets up the base actions, as well as installing
         * the application configuration
         *
         * @access  public
         * @param   array   $config     The application configuration, containing key/name pairs
         */
        function AjaxACApplication($config = array())
        {
            if (!is_array($config))
                $config = array($config);

            $this->_config = $config;

            // try and set the charset value if it hasn't been specified in $config
            $this->setConfigValue('charset', $this->_defaultCharset, false);

            // parameter to set the script name. If this is empty then the current
            // script name will be auto-detected
            $this->setConfigValue('url.script_name', '', false);

            // parameter to store sub-request action in. If empty it is specified like
            // index.php/someaction, other it is like index.php?action=someaction
            $this->setConfigValue('url.action_parameter', '', false);

            // parameter to determine whether or not to send the content-length header
            // which may break multi-byte encodings
            // @todo Find a way to send correct content length with multi-byte encodings
            $this->setConfigValue('js.send_content_length', true, false);


            // various debugging parameters
            $this->setConfigValue('debug.level', AJAXAC_DEBUG_NONE, false);
            $this->setConfigValue('debug.log_file', 'ajaxac.log', false);
        }


        /**
         * handleAction
         *
         * Handle a subrequest. This determines if the request action exists, and if
         * so, then performs if, using the passed on params and request data
         *
         * @access  package
         * @param   string  $action         The action name. The callback will be action_$action
         * @param   array   $params         A 0-indexed array containing each request path element after the action.
         *                                  For example, /path/to/ajaxac/actionname/param1/param2
         * @param   array   $requestData    The '$_GET' data from the request
         */
        function handleAction($action = null, $params = array(), $requestData = array())
        {
            $this->_params = $params;
            $this->_requestData = $requestData;
            $callback = 'action_' . $action;
            if (method_exists($this, $callback)) {
                $this->$callback();
            }
        }


        /**
         * getApplicationUrl
         *
         * Generates the application URL, for the specified action. This is used
         * to generate the request file for XMLHttp sub-requests
         *
         * @access  package
         * @todo    Add extra options for more path/request params
         * @param   string  $action     The action to generate the URL for. Must be a valid action
         * @return  string              The generated application URL
         */
        function getApplicationUrl($action = '')
        {
            if (!isset($this->_web_path)) {
                $this->_web_path = $this->getConfigValue('url.script_name');
                if (strlen($this->_web_path) == 0)
                    $this->_web_path = $_SERVER['SCRIPT_NAME'];
            }

            $ret = $this->_web_path;

            if (strlen($action) > 0 && $this->actionExists($action)) {
                $actionParameter = $this->getConfigValue('url.action_parameter');
                if (strlen($actionParameter) == 0)
                    $ret = $this->_web_path . '/' . $action;
                else
                    $ret = $this->_web_path . '?' . $actionParameter . '=' . $action;
            }

            return $ret;
        }


        /**
         * handleRequest
         *
         * Fetches parameters + options from the current request (be it the main
         * request or a sub-request), and hands it to the application for handling
         *
         * @todo    Allow for extra parameters when action store in GET variable
         * @access  public
         */
        function handleRequest()
        {
            $actionParameter = $this->getConfigValue('url.action_parameter');
            if (strlen($actionParameter) == 0) {
                $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
                $params = array_filter(explode('/', $path));

                $action = count($params) > 0 ? array_shift($params) : '';
            }
            else {
                $action = isset($_GET[$actionParameter]) ? $_GET[$actionParameter] : '';
                $params = array();
            }

            $this->handleAction($action, $params, $_GET);
        }


        /**
         * registerActions
         *
         * @access protected
         *
         * Register one or more actions, to be handled using a callback
         * named something like action_actionName(). Takes an arbitrary
         * number of parameters.
         */
        function registerActions()
        {
            foreach (func_get_args() as $action) {
                $action = trim($action);
                if (strlen($action) > 0)
                    $this->_actions[] = $action;
            }
        }


        /**
         * actionExists
         *
         * Returns whether or not an action exists
         *
         * @access  protected
         * @return  bool        True if the action exists, false if not
         */
        function actionExists($action)
        {
            return in_array($action, $this->_actions);
        }


        /**
         * getParam
         *
         * Retrieve a parameter from the user request. You can choose to return
         * some default value if the parameter is null or not set
         *
         * @access  protected
         * @param   string  $key        The name of the param to return
         * @param   mixed   $default    A default value to return if the key doesn't exist or is null
         * @return  mixed               The fetched or default value
         */
        function getParam($key, $default = null)
        {
            if (!array_key_exists($key, $this->_params) || is_null($this->_params[$key]))
                return $default;
            return $this->_params[$key];
        }


        /**
         * getRequestValue
         *
         * Retrieve a parameter from the user request. You can choose to return
         * some default value if the parameter is null or not set
         *
         * @access  protected
         * @param   string  $key        The name of the request value to return
         * @param   mixed   $default    A default value to return if the key doesn't exist or is null
         * @return  mixed               The fetched or default value
         */
        function getRequestValue($key, $default = null)
        {
            if (!array_key_exists($key, $this->_requestData) || is_null($this->_requestData[$key]))
                return $default;
            return $this->_requestData[$key];
        }


        /**
         * setConfigValue
         *
         * Add a parameter to the config. You can optionally choose to set it only
         * if it doesn't already exist using the force parameter
         *
         * @access  protected
         * @param   string  $key        The name of the config value to set
         * @param   mixed   $val        The value to set
         * @param   bool    $force      True to set the value no matter, false to set if doesn't exist
         * @return  bool                True if value set, false if not (can only return false if $force is false or $key is empty)
         */
        function setConfigValue($key, $val, $force = true)
        {
            if (strlen($key) > 0 && ($force || !array_key_exists($key, $this->_config))) {
                $this->_config[$key] = $val;
                return true;
            }
            return false;
        }


        /**
         * getConfigValue
         *
         * Retrieve a parameter from the application config. You can choose to return
         * some default value if the parameter is null or not set
         *
         * @access  protected
         * @param   string  $key        The name of the config value to return
         * @param   mixed   $default    A default value to return if the key doesn't exist or is null
         * @return  mixed               The fetched or default value
         */
        function getConfigValue($key, $default = null)
        {
            if (!isset($this->_config) || !array_key_exists($key, $this->_config) || is_null($this->_config[$key]))
                return $default;
            return $this->_config[$key];
        }


        /**
         * sendResponseData
         *
         * Send some data back as a response to a HTTP subrequest. Can be in various
         * data formats, each of which treat the data different and send headers
         * accordingly. The script exits after this method is called.
         *
         * @todo    Cache control functionality
         * @todo    Move actual data output / headers into separate section so can be used elsewhere
         * @param   string  $type       The type of data being sent
         * @param   mixed   $data       The data to return
         */
        function sendResponseData($type, $data)
        {
            $type = strtolower($type);

            // check if there's a handler for this data type. if not
            // just assume it's plain text and send the data as is with a text/plain
            // mime type.
            $callback = 'response_' . $type;

            if (method_exists($this, $callback)) {
                $response = $this->$callback($data);

                // the returned data should be an array with a 'mime' elements
                // and a 'data' element. if not an array, then the returned data
                // is output. if no mime type found then text/plain is used

                if (is_array($response)) {
                    if (isset($response['mime']))
                        $mime = $response['mime'];

                    if (isset($response['data']))
                        $data = $response['data'];
                    else
                        $data = '';
                }
                else {
                    $mime = 'text/plain';
                    $data = $response;
                }
            }
            else
                $mime = 'text/plain';

            // create array of all headers to be output
            $headers = array('Content-type: ' . $this->getContentType($mime),
                             'Content-length: ' . strlen($data));


            // output each http header
            foreach ($headers as $header)
                header($header);

            echo $data;
            exit;
        }


        /**
         * response_xml
         *
         * Outputs XML data. Assumes it is receiving well-formed XML
         *
         * @param   mixed   $data       The data to return
         * @return  array               A reponse type array, with mime and data elements
         */
        function response_xml($data)
        {
            return array('mime' => 'text/xml',
                         'data' => $data);
        }


        /**
         * response_jsarray
         *
         * Handle the jsarray response type
         *
         * @param   mixed   $data       The data to return
         * @return  array               A reponse type array, with mime and data elements
         */
        function response_jsarray($data)
        {
            return array('mime' => 'text/javascript',
                         'data' => $this->_phpArrayToJs($data));
        }

        /**
         * _phpArrayToJs
         *
         * Helper function for jsarray response type
         */
        function _phpArrayToJs($arr)
        {
            $items = array();

            foreach ($arr as $k => $v) {
                if (is_array($v))
                    $items[] = $this->_phpArrayToJs($v);
                else if (is_int($v))
                    $items[] = $v;
                else
                    $items[] = "'" . $this->escapeJs($v) . "'";
            }

            return '[' . join(',', $items) . ']';
        }


        /**
         * escapeJs
         *
         * Make a string JavaScript-safe so errors are not generated. This code was
         * shamelessly borrowed from Smarty
         *
         * @access  protected
         * @param   string  $str    The string to escape
         * @return  string          The escaped string
         */
        function escapeJs($str)
        {
            // borrowed from smarty
            return strtr($str, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));
        }


        /**
         * escapeXml
         *
         * Make a string XML safe so all entities are correctly transposed to
         * produce valid XML. This should be used inside attributes and for CDATA
         *
         * @access  protected
         * @param   string  $str    The string to escape
         * @return  string          The escaped string
         */
        function escapeXml($str)
        {
            static $trans;
            if (!isset($trans)) {
                $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                foreach ($trans as $key => $value)
                    $trans[$key] = '&#'.ord($key).';';
                // dont translate the '&' in case it is part of &xxx;
                $trans[chr(38)] = '&';
            }
            return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,4};)/","&#38;" , strtr($str, $trans));
        }


        /**
         * getContentType
         *
         * Determine the full content type value for the given mime type. At this
         * stage this involves appending the appropriate charset definition for
         * text/* mime types
         *
         * @param   string  $type   The mime type to rewrite
         * @return  string          The rewritten mime type
         */
        function getContentType($type)
        {
            $type = trim($type);
            if (preg_match('|^text/|i', $type)) {
                $charset = $this->getConfigValue('charset', $this->_defaultCharset);
                $type .= '; charset=' . $charset;
            }
            return $type;
        }


        /**
         * debug
         *
         * Write a debug message to the application log file, if the debug level
         * matches the runtime debug level
         *
         * @param   int     $level  The debug level this message is for
         * @param   string  $str    The string to write to the debug file
         */
        function debug($level, $str)
        {
            if (($level & $this->getConfigValue('debug.level')) && !$this->getConfigValue('debug.abort')) {
                if (!isset($this->_debug_fp)) {
                    $this->_debug_fp = @fopen($this->getConfigValue('debug.log_file'), 'a+');
                    if (!$this->_debug_fp) {
                        $this->setConfigValue('debug.abort', true);
                        return;
                    }
                    fwrite($this->_debug_fp, "\n\n\n\n\n[" . date('Y-m-d H:i:s') . "] -- MARK --\n");
                }
                fwrite($this->_debug_fp, '[' . date('Y-m-d H:i:s') . '] ' . $str . "\n");
            }
        }
    }
?>