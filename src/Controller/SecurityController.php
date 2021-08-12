<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
  /*  public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }*/

     /**
     * @Route("company/registration", name="security_registration")
     */
public function registration(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer ){
$user = new User();
    $form= $this->createForm(RegistrationType::class,$user);
    $form->handleRequest($request);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
   
    $user->setPassword($randomString);
    if($form->isSubmitted()&& $form->isValid()){
        $hash = $encoder->encodePassword($user,$user->getPassword());
       
        $message = (new \Swift_Message('Confirmation Email'))
        ->setFrom('samirtondo@gmail.com')
        ->setTo($user->getEmail())
        ->setBody( $user->getPassword() );
     
    
    $mailer->send($message); $user->setPassword($hash);
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('company');
        
       
        }
        
    return $this->render('security/registration.html.twig',[

        'form'=>$form->createView()
    ]);
}
 /**
     * @Route("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }
     /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){
 
   }




   /**
     * @Route("registration", name="admin_registration")
     */
   /* public function registrationadmin(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer ){
        $user = new User();
      
           
        

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->getForm();
                
            return $this->render('security/registration.html.twig',[
        
                'form'=>$form->createView()
            ]);
        }
*/
   
}




