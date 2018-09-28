<?php

namespace Master\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/master-2")
 */
// use Doctrine\Tests\Common\Annotations\Fixtures\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MasterTrainingBundle:Default:index.html.twig');
    }
    
    public function registerUserAction($name, $age, $role) {
        $responseMsg = sprintf("Rejestracja uzytkownika o nazwie %s (wiek: %d, rola w systemie: %s)", $name, $age, $role);
        return new \Symfony\Component\HttpFoundation\Response($responseMsg);
    }
    
    public function simple1Action() {
        return new \Symfony\Component\HttpFoundation\Response("simple 1");
    }
    
    public function simple2Action() {
        return new \Symfony\Component\HttpFoundation\Response("simple 2");
    }
    
    /**
     * @Route(
     *      "/register-tester/{name}-{age}-{role}",
     *      name="master_training_registerTester",
     *      defaults={"role"="units"},
     *      requirements={"age"="\d+", "role"="units|functional"}
     *  )
     *  
     *  @Method({"GET"})
     */
    public function registerTesterAction($name, $age, $role) {
        $responseMsg = sprintf("Rejestracja uzytkownika o nazwie %s (wiek: %d, rola w systemie: %s)", $name, $age, $role);
        return new \Symfony\Component\HttpFoundation\Response($responseMsg);
    }
    
    /**
     * @Route("/anno")
     *
     */
    public function anno2Action() {
        return new \Symfony\Component\HttpFoundation\Response("adnotacja 2");
    }
    
    /**
     * @Route("/anno")
     * 
     */
    public function anno1Action() {
        return new \Symfony\Component\HttpFoundation\Response("adnotacja 1");
    }
    
    /**
     * @Route("/generate-url")
     *
     */
    public function generateUrlAction() {
        $rspMsg = $this->generateUrl("master_training_registerUser", [
            "name" => "Marcin",
            "age" => 52,
            "country" => "Poland"
        ], true);
        return new \Symfony\Component\HttpFoundation\Response($rspMsg);
    }
    
    /**
     * @Route(
     *      "/debugging",
     *      name="master_training_debugging"
     * )
     *
     */
    public function debuggingAction() {
        return new \Symfony\Component\HttpFoundation\Response('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>debugging</title></head><body><h3>debugging</h3></body></html>');
    }
   
    
}
