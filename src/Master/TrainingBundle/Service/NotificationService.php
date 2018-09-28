<?php
namespace Master\TrainingBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class NotificationService
{
    private $session;
    
    function __construct(Session $session){
        $this->session = $session;
    }
    
    public function addMessage($type, $message) 
    {
        $this->session->getFlashBag()->add($type, $message);
    }
    
    public function addSuccess($message)
    {
        $this->addMessage("success", $message);
    }
    
    public function addError($message)
    {
        $this->addMessage("danger", $message);
    }
    
    
    
    
}

