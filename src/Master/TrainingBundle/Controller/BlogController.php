<?php
namespace Master\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Master\TrainingBundle\Helper\Journal\Journal;
use Master\TrainingBundle\Helper\DataProvider;
use Symfony\Component\HttpFoundation\Request;
use Master\TrainingBundle\Form\Type\RegisterType;
use Master\TrainingBundle\Form\Type\ContactType;
use Master\TrainingBundle\Entity\Register;
use Master\TrainingBundle\Entity\Contact;

/**
 *
 * @Route("/blog")
 *
 */
class BlogController extends Controller
{

    /**
     *
     * @Route(
     *      "/",
     *      name="master_blog_index"
     * )
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     *
     * @Route(
     *      "/dziennik",
     *      name="master_dziennik"
     * )
     * @Template
     */
    public function journalAction()
    {
        return array(
            // 'history' => Journal::getHistoryAsArray()
            // 'history' => array()
            'history' => Journal::getHistoryAsObjects()
        );
    }

    /**
     *
     * @Route(
     *      "/kontakt",
     *      name="master_blog_kontakt"
     * )
     * @Template
     */
    public function contactAction(Request $Request)
    {

        /*
         * Imi� i nazwisko - text
         * Email - text (email)
         * Wiadomosc - textarea
         * Zapisz - button
         */
        $Contact = new Contact();

        $Session = $this->get('session');

        $form = $this->createForm(new ContactType(), $Contact);

        $form->handleRequest($Request);

        if ($Request->isMethod('POST')) {
            if ($form->isValid()) {

                // zapisanie do bazy
                $em = $this->getDoctrine()->getManager();
                $em->persist($Contact);
                $em->flush();

                // $Session->getFlashBag()->add('success', 'Twoje zg�oszenie zosta�o zapisane!');
                $this->get('mas_notifications')->addSuccess('Twoje wiadomosć została wysłana!');
            } else {
                // $Session->getFlashBag()->add('danger', 'Popraw b��dy formularza.');
                $this->get('mas_notifications')->addError('Popraw błędy formularza.');
            }
        }

        return array(
            'form' => isset($form) ? $form->createView() : NULL
        );
    }

    /**
     *
     * @Template("MasterTrainingBundle:Blog/widgets:followingWidget.html.twig")
     *
     */
    public function followingWidgetAction()
    {
        return array(
            "list" => DataProvider::getFollowings()
        );
    }

    /**
     *
     * @Template("MasterTrainingBundle:Blog/widgets:walletWidget.html.twig")
     *
     */
    public function walletWidgetAction()
    {
        return array(
            "list" => DataProvider::getWallet()
        );
    }

    /**
     *
     * @Route(
     *      "/ksiega-gosci",
     *      name="master_blog_ksiegaGosci"
     * )
     * @Template
     */
    public function guestBookAction()
    {
        return array(
            "comments" => DataProvider::getGuestBook()
        );
    }

    /**
     *
     * @Route(
     *      "/rejestracja",
     *      name="master_blog_rejestracja"
     * )
     *
     * @Template
     */
    public function registerAction(Request $Request)
    {

        /*
         * Imi� i nazwisko - text
         * Email - text (email)
         * P�e� - radio collection
         * Data urodzenia - select
         * Kraj - select
         * Kurs - select
         * Inwestycje - checkbox collection
         * Uwagi - textarea
         * Potwierdzenie przelewu - file
         * Akceptacja regulaminu - checkbox
         * Zapisz - button
         */
        $Register = new Register();
        // $Register->setName('Jan Kowalski')
        // ->setEmail('jkowal@gmail.com')
        // ->setCountry('PL')
        // ->setCourse('basic')
        // ->setInvest(array('a', 'o'));
        $Session = $this->get('session');

        if (! $Session->has('registered')) {

            $form = $this->createForm(new RegisterType(), $Register);

            $form->handleRequest($Request);

            if ($Request->isMethod('POST')) {
                if ($form->isValid()) {

                    $savePath = $this->get('kernel')->getRootDir() . '/../web/uploads/';
                    $Register->save($savePath);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($Register);
                    $em->flush();

                    $msgBody = $this->renderView('MasterTrainingBundle:Email:base.html.twig', array(
                        'name' => $Register->getName()
                    ));

                    // wysy�ka maila
                    $message = \Swift_Message::newInstance()->setSubject("Potwierdzenie rejestracji")
                        ->setFrom(array(
                        'mi123456ka@gmail.com' => 'Michał Kaczmarek'
                    ))
                        ->setTo(array(
                        $Register->getEmail() => $Register->getName()
                    ))
                        ->setBody($msgBody, "text/html");

                    $this->get('mailer')->send($message);

                    // $Session->getFlashBag()->add('success', 'Twoje zg�oszenie zosta�o zapisane!');
                    $this->get('mas_notifications')->addSuccess('Twoje zgłoszenie zostało zapisane!');
                    $Session->set('registered', true);

                    return $this->redirect($this->generateUrl('master_blog_rejestracja'));
                } else {
                    // $Session->getFlashBag()->add('danger', 'Popraw b��dy formularza.');
                    $this->get('mas_notifications')->addError('Popraw błędy formularza.');
                }
            }
        }

        return array(
            'form' => isset($form) ? $form->createView() : NULL
        );
    }
    
  
}

