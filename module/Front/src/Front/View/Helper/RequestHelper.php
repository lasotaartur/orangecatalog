<?php 

namespace Front\View\Helper;
use \Zend\View\Helper\AbstractHelper;

class RequestHelper extends AbstractHelper
{
    /**
     *
     * @var \Zend\Http\Request
     */
    protected $request;
    
    //get Request
    public function setRequest($request)
    {
        $this->request = $request;    
    }
    
    /**
     * 
     * @return \Zend\Http\Request
     */
    public function getRequest()
    {
        return $this->request;    
    }
    
    public function __invoke()
    {
        return $this->getRequest()->getServer()->get('QUERY_STRING');     
    }
}
