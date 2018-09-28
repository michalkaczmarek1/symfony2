<?php
namespace Master\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class PagesController extends Controller
{
    /**
     * @Route(
     *      "/about",
     *      name="master_training_aboutPage"
     * )
     * @Template
     */
    public function aboutAction()
    {
//         @Template('MasterTrainingBundle:Pages:aboutPage.html.twig') 
//         return new Response('about');
           $json = [
               'name' => 'buty',
               'size' => '42',
               'price' => '123.23'
           ];
//            return new Response(json_encode($json), Response::HTTP_OK, array(
//                'Content-type' => 'application/json'
//            ) );
        
//            $content = $this->renderView('MasterTrainingBundle:Pages:about.html.twig');
//            return new Response($content);

//             return $this->render('MasterTrainingBundle:Pages:about.html.twig', array(
//                 "name" => "Michal"
//             ));
            
           return array(
               "name" => "Michal"
           );
    }
    
    /**
     * @Route("/go-to-page")
     */
    public function goToPageAction()
    {
//         return $this->redirect("https://eduweb.pl/");
        
        $redirectUrl = $this->generateUrl("master_training_registerTester", array(
            "name" => "Marek",
            "age" => 45
        ));
        
        return $this->redirect($redirectUrl);
    }
    
    /**
     * @Route("/print-header/{title}/{color}")
     * @Template
     */
    public function printHeaderAction($title, $color) 
    {
        return array(
            "title" => $title,
            "color" => $color
        );
    }
    
    /**
     * @Route("/contact")
     * 
     */
    public function contactPageAction() 
    {
        return $this->forward("MasterTrainingBundle:Pages:printHeader", array(
            "title" => "Kontakt",
            "color" => "blue"
        ));
    }
    
    /**
     * @Route("/generate-error")
     *
     */
    public function generateErrorAction()
    {
//         throw $this->createNotFoundException("Nie znaleziono strony");
        
        throw new \Exception('Wystapil bl�d');
        
    }
    
    /**
     * @Route(
     *      "/mastering-request/{name}",
     *      name="master_training_masteringRequest"
     * )
     *
     */
    public function masteringRequestAction(Request $Request, $name) 
    {
        //przestarzały
//         $Request = $this->getRequest();
    //I sposób
//         $Request = $this->get('request');
//         return new Response($Request->get('name'));
        //parametry GET
//         return new Response($Request->query->get('kolor', "blue"));
        //parametry POST
//         return new Response($Request->request->get('size', 123));
    
        return new Response($Request->get('size', 123));
        
    }
    
    /**
     * @Route(
     *      "/read-params"
     * )
     *
     */
    public function readParamsAction() 
    {
        $param = $this->container->getParameter('appApiKey');
        return new Response($param);
    }
    
    
}

