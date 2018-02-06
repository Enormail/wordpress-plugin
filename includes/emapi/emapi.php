<?php
// Load the required files
require_once dirname(__FILE__).'/exception.php';
require_once dirname(__FILE__).'/rest.php';
require_once dirname(__FILE__).'/base.php';
require_once dirname(__FILE__).'/account.php';
require_once dirname(__FILE__).'/contacts.php';
require_once dirname(__FILE__).'/lists.php';
require_once dirname(__FILE__).'/forms.php';
require_once dirname(__FILE__).'/mailings.php';

/**
 * The API Wrapper class
 *
 * This class mainly acts as wrapper for the different subclasses
 * in the Enormail API
 * 
 * @package Enormail API
 * @version 1.0
 * @author Enormail
 */
class EMAPI {
    
    protected $key = '';
    
    protected $transport = null;
    
    protected $format = 'json';
    
    /**
	 * The constructor
	 * 
	 * @access  public
	 * @return  nill
	 */
    public function __construct($key, $format = 'json')
    {
        // Set key
        $this->key = $key;
        // Set response type
        $this->format = (in_array($format, array('json', 'xml', 'php'))) ? $format : 'json';
        // Set transport
        $this->transport = new EM_Rest($this->key);
    }
    
    /**
	 * Tests the API connection
	 * 
	 * @access  public
	 * @return  bool
	 */
    public function test()
    {
        return $this->transport->get('/ping.'.$this->format);
    }
    
    /**
	 * Get
	 * 
	 * @access  public
	 * @return  object (requested subclass of API)
	 */
    public function __get($name)
    {
        $class = 'EM_'.ucfirst(strtolower(trim($name)));
        
        if (!class_exists($class))
        {
            throw new EM_API_Exception('Requested class not found: '.$class);
        }
        
        $instance = new $class($this->transport);
        
        $instance->format = $this->format;
        
        return $instance;
    }
    
}