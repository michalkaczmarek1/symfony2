<?php
namespace Master\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Master\TrainingBundle\Form\Type\RegisterType;


/**
 * @Route("/blog/admin")
 *
 */
class AdminController extends Controller
{
    
    /**
     * @Route(
     *      "/",
     *      name="master_blog_admin_listing"
     * )
     * 
     * @Template
     */
    public function listingAction()
    {
        $repo = $this->getDoctrine()->getRepository("MasterTrainingBundle:Register");
        
        $rows = $repo->findAll();
        
//         $rows = $repo->findBy(array(
//             "sex" => "m"
//         ));

        if($this->get("security.authorization_checker")->isGranted("ROLE_ADMIN")){
            $btns = true;
        } else {
            $btns = false;
        }
        
        //obiekt u�ytkownika
        $user = $this->getUser();
        
        return array(
            "rows" => $rows,
            "btns" => $btns
        );
    }
    
    /**
     * @Route(
     *      "/details/{id}",
     *      name="master_blog_admin_details"
     * )
     *
     * @Template
     */
    public function detailsAction($id) 
    {
        $repo = $this->getDoctrine()->getRepository("MasterTrainingBundle:Register");
        
        $Register = $repo->find($id);
        
        if(null === $Register){
            throw $this->createNotFoundException("Nie znaleziono takiej rejestracji na szkolenie.");
        }
        
        return array(
            "register" => $Register
        );
    }
    
    /**
     * @Route(
     *      "/update/{id}",
     *      name="master_blog_admin_update"
     * )
     *
     * @Template
     */
    public function updateAction(Request $Request, $id)
    {
        $repo = $this->getDoctrine()->getRepository("MasterTrainingBundle:Register");
        
        $Register = $repo->find($id);
        
        if(null === $Register){
            throw $this->createNotFoundException("Nie znaleziono takiej rejestracji na szkolenie.");
        }
        
        $form = $this->createForm(new RegisterType(), $Register);
        
        if($Request->isMethod("POST")){
            $Session = $this->get('session');
            $form->handleRequest($Request);
            
            if($form->isValid()){
                
                //aktualizowanie rekordu
                $em = $this->getDoctrine()->getManager();
                $em->persist($Register);
                $em->flush();
                
                $Session->getFlashBag()->add('success', 'Zaktualizowano rekord.');
                
                return $this->redirect($this->generateUrl("master_blog_admin_details", array(
                    "id" => $Register->getId()
                )));
                
            } else {
                $Session->getFlashBag()->add("danger", "Popraw b��dy formularza");
            }
            
        }
        
        
        
        return array(
            "register" => $Register,
            "form" => $form->createView()
        );
    }
    
    /**
     * @Route(
     *      "/delete/{id}",
     *      name="master_blog_admin_delete"
     * )
     *
     *
     */
    public function deleteAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("MasterTrainingBundle:Register");
        
        $Register = $repo->find($id);
        
        if(null === $Register){
            throw $this->createNotFoundException("Nie znaleziono takiej rejestracji na szkolenie.");
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($Register);
        $em->flush();
        
        $this->get("session")->getFlashBag()->add("success", "Poprawnie usunieto rekord z bazy danych.");
        return $this->redirect($this->generateUrl("master_blog_admin_listing"));
        
        
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
  
}

