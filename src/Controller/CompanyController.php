<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Entity\Email;
use App\Entity\Licence;
use App\Entity\Product;
use App\Form\EmailType;
use App\Entity\Category;
use App\Entity\Inventory;
use App\Form\LicenceType;
use App\Form\ProductType;
use App\Entity\UserSearch;
use App\Entity\EmailSearch;
use App\Entity\Transaction;
use App\Form\InventoryType;
use App\Form\UserSearchType;
use App\Entity\LicenceSearch;
use App\Form\EmailSearchType;
use App\Form\TransactionType;
use App\Entity\PropertySearch;
use App\Entity\InventorySearch;
use App\Form\LicenceSearchType;
use App\Form\ResetPasswordType;
use App\Form\PropertySearchType;
use App\Form\InventorySearchType;
use App\Repository\UserRepository;
use App\Repository\EmailRepository;
use App\Repository\LicenceRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Form\FormError;
use App\Repository\InventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CompanyController extends AbstractController
{
  
    /**
     * @Route("/", name="company")
     */
    public function index(UserRepository $re,EmailRepository $rep,\Swift_Mailer $mailer ,InventoryRepository $repo, LicenceRepository $repoo, TransactionRepository $repooo,ProductRepository $repoooo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isGranted('ROLE_ADMIN')) {
            //l'utilisateur à les droits admin
            $today=new \DateTime();
       
            
            $lics=$repoo->findAll();
            foreach($lics as $lic){
    $expiration=$lic->getExpirationDate();
    
                if($lic->getExpirationDate() <= $today){
                    $message = (new \Swift_Message($lic->getId()))
                    ->setFrom('samirtondo@gmail.com')
                    ->setTo('hedibenkhouja3@gmail.com')
                    
                    ->setBody('This Licence %d has expired ',$lic->getId());
                   
                    
                 
                
                $mailer->send($message);
                }
               // dump($id);
            }
            $producs=$repoooo->findAll();
        foreach($producs as $produc){
$null=$produc->getQuantity();

            if($null == 0){
                $message = (new \Swift_Message($produc->getReference()))
                ->setFrom('samirtondo@gmail.com')
                ->setTo('hedibenkhouja3@gmail.com')
                
                ->setBody('This Product is runing out of stock ');
               
                
             
            
            $mailer->send($message);
            }
           // dump($id);
        }
         }
        $Inventorys = $repo->findOldItems();
        $inventorys = $repo->findAll();
        $Users = $re->findAll();
        $Licences = $repoo->findOldLicences();
        $Transactions=$repooo->findRecentTransactions();
        
        $transactions=$repooo->findAll();
        $Products=$repoooo->findLowQuality();
        
        $products=$repoooo->findAll();
        $Emails=$rep->findNewReports();
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
            'inventorys' => $Inventorys,
            'licences' => $Licences,
            'transactions'=>$Transactions,
            
            'Transactions'=>$transactions,
            'products'=>$Products,
            'Products'=>$products,
           'emails'=>$Emails,
           'Inventorys' => $inventorys,
           'User'=>$Users
        ]);
    }
    /**
 * @Route("/company/users", name="users")
 */
public function usersList(TransactionRepository $rep,UserRepository $repo,Request $request,PaginatorInterface $paginator)
{ 
    $Transactions =$rep->findAll();
    $search= new UserSearch();
    //filter form
    $form=$this->createForm(UserSearchType::class,$search);
    $form->handleRequest($request);

     $Data = $repo->findAllVisibleQuery($search);
    $Users=$paginator->paginate(
 $Data,
 $request->query->getInt('page',1),
 10  );
    return $this->render('company/users.html.twig', [
        'users' => $Users,
        'transactions' => $Transactions,
        'form'=> $form->createView()


    ]);
}

  


  
     /**
     * @Route("/company/inventory", name="company_inventory")
     */
    public function inventory(InventoryRepository $repo,Request $request,PaginatorInterface $paginator ){
       
        $search= new InventorySearch();
    //filter form
    $form=$this->createForm(InventorySearchType::class,$search);
    $form->handleRequest($request);

     $Data = $repo->findAllVisibleQuery($search);
        $Inventorys=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/inventory.html.twig', [
            'controller_name' => 'CompanyController',
            'inventorys'=> $Inventorys,
            
            'form'=> $form->createView()
        ]);
    }
     /**
     * @Route("/company/licence", name="company_licence")
     * @IsGranted("ROLE_ADMIN")
     */
    public function licence(LicenceRepository $repo,Request $request,PaginatorInterface $paginator,\Swift_Mailer $mailer ){
        
       
        $search= new LicenceSearch();
        //filter form
        $form=$this->createForm(LicenceSearchType::class,$search);
        $form->handleRequest($request);
 
         $Data = $repo->findAllVisibleQuery($search);
        
       
        $Licences=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/licence.html.twig', [
            'controller_name' => 'CompanyController',
            'licences'=> $Licences,
            
            'form'=> $form->createView()
        ]);
    }
    
      /**
     * @Route("/company/transaction", name="company_transaction")
     */
    public function transaction(TransactionRepository $repo,Request $request,PaginatorInterface $paginator ){
       
        $Data = $repo->findAll();
        $Transactions=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     5


        );
        return $this->render('company/transaction.html.twig', [
            'controller_name' => 'CompanyController',
            'transactions'=> $Transactions
        ]);
    }
  /**
     * @Route("/company/product/transaction/{id}", name="company_product_transaction")
     */
    public function transactionProduct(int $id,Request $request,PaginatorInterface $paginator ){
        $Transactions = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id)->getTransactions();
        $Reference = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id)->getReference();
       // $Transactions = $repo->findBy();
     
        return $this->render('company/showProductTransactions.html.twig', [
            'controller_name' => 'CompanyController',
            'transactions'=> $Transactions,
            'reference'=>$Reference
        ]);
    }
    /**
     * @Route("/company/user/transaction/{id}", name="company_user_transaction")
     * @IsGranted("ROLE_ADMIN")
     */
    public function transactionUser(int $id,Request $request,PaginatorInterface $paginator ){
        $Transactions = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id)->getTransactions();
        $Username = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id)->getUsername();
       // $Transactions = $repo->findBy();
     
        return $this->render('company/showUserTransactions.html.twig', [
            'controller_name' => 'CompanyController',
            'transactions'=> $Transactions,
            'username'=>$Username
        ]);
    }
     /**
     * @Route("/company/product", name="company_product")
     */
    public function product(ProductRepository $repo,Request $request,PaginatorInterface $paginator,\Swift_Mailer $mailer ){
       $search= new PropertySearch();
       
       //filter form
       $form=$this->createForm(PropertySearchType::class,$search);
       $form->handleRequest($request);

        $Data = $repo->findAllVisibleQuery($search);
        
        $Products=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/product.html.twig', [
            'controller_name' => 'CompanyController',
            'products'=> $Products,
            'form'=> $form->createView()
        ]);
    }
/**
     * @Route("/company/email", name="company_email")
     * @IsGranted("ROLE_ADMIN")
     */
    public function email(EmailRepository $repo,Request $request,PaginatorInterface $paginator ){
              
        $search= new EmailSearch();
    //filter form
    $form=$this->createForm(EmailSearchType::class,$search);
    $form->handleRequest($request);

     $Data = $repo->findAllVisibleQuery($search);
        $Emails=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/email.html.twig', [
            'controller_name' => 'CompanyController',
            'emails'=> $Emails,
            'form'=> $form->createView(),
        ]);
    }
     /**
     * @Route("/company/inventory/new", name="inventory_new")
     * @Route("/company/inventory/{id}/edit", name="inventory_edit")
     */
    public function form(Inventory $inventory = null , Request $request,EntityManagerInterface $manager){
     if (!$inventory){
         $inventory=new Inventory();
     }

           $form=$this->createForm(InventoryType::class,$inventory);
           $form->handleRequest($request);

           if($form->isSubmitted()&& $form->isValid()){
               if(!$inventory->getId()){
                   $inventory->setCreatedAt(new \DateTimeImmutable());
               }
               $manager->persist($inventory);
               $manager->flush();

                return $this->redirectToRoute('inventory_show',['id'=> $inventory->getId()]);
               }
           

           return $this->render('company/createInventory.html.twig',[
            'formInventory'=> $form->CreateView(),
           'editMode'=>$inventory->getId() !== null

           ]);
    }

 /**
     * @Route("/company/licence/new", name="licence_new")
     * @Route("/company/licence/{id}/edit", name="licence_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function formlicence(Licence $licence = null , Request $request,EntityManagerInterface $manager){
        if (!$licence){
            $licence=new Licence();
        }
   
              $form=$this->createForm(LicenceType::class,$licence);
              $form->handleRequest($request);
   
              if($form->isSubmitted()&& $form->isValid()){
                  if(!$licence->getId()){
                      $licence->setCreatedAt(new \DateTimeImmutable());
                  }
                  $manager->persist($licence);
                  $manager->flush();
   
                   return $this->redirectToRoute('licence_show',['id'=> $licence->getId()]);
                  }
              
   
              return $this->render('company/createLicence.html.twig',[
               'formLicence'=> $form->CreateView(),
              'editMode'=>$licence->getId() !== null
   
              ]);
       }
       /**
     * @Route("/company/product/new", name="product_new")
     * @Route("/company/product/{id}/edit", name="product_edit")
     */
    public function formproduct(Product $product = null , Request $request,EntityManagerInterface $manager){
        if (!$product){
            $product=new product();
        }
   
              $form=$this->createForm(ProductType::class,$product);
              $form->handleRequest($request);
   
              if($form->isSubmitted()&& $form->isValid()){
                  if(!$product->getId()){
                      $product->setCreatedAt(new \DateTimeImmutable());
                  }
                  $manager->persist($product);
                  $manager->flush();
   
                   return $this->redirectToRoute('product_show',['id'=> $product->getId()]);
                  }
              
   
              return $this->render('company/createProduct.html.twig',[
               'formproduct'=> $form->CreateView(),
              'editMode'=>$product->getId() !== null
   
              ]);
       }
       /**
     * @Route("/company/transaction/new/{id}", name="transaction_new")
     
     */
    public function formtransaction(User $user,Transaction $transaction = null , Request $request,EntityManagerInterface $manager){
        if (!$transaction){
            $transaction=new Transaction();
           
        }
       
              $form=$this->createForm(TransactionType::class,$transaction);
              $form->handleRequest($request);
   
              if($form->isSubmitted()&& $form->isValid()){
                  $transaction->setUser($user);
                  if(!$transaction->getId()){
              
                     $id=$transaction->getProduct()->getId();
                 $product = $this->getDoctrine()
                                 ->getRepository(Product::class)
                                 ->find($id );

                                 if ($product) {
                                     if($transaction->getType()=='Input'){
                                   $product->setQuantity($product->getQuantity()+$transaction->getquantity())
                                    ;
                                
                                
                                }elseif($transaction->getType()=='Output'){
                                    if($transaction->getquantity()>$product->getQuantity()){
                                        $product->setQuantity(0);
                                    }else{
                                        $product->setQuantity($product->getQuantity()-$transaction->getquantity());
                                    
                                    }
                                    }
                                }              
                  
                      $transaction->setCreatedAt(new \DateTimeImmutable());
                 
                  }
                  $manager->persist($transaction);
                  $manager->flush();
   
                   return $this->redirectToRoute('company_transaction');
                  }
              
   
              return $this->render('company/createTransaction.html.twig',[
               'formTransaction'=> $form->CreateView()
   
              ]);
       }
           /**
     * @Route("/company/email/new/{id}", name="email_new")
     * @IsGranted("ROLE_USER")
     
     */
    public function formemail(User $user,Email $email = null , Request $request,EntityManagerInterface $manager,\Swift_Mailer $mailer ){
        if (!$email){
            $email=new Email();
           
        }
       
              $form=$this->createForm(EmailType::class,$email);
              $form->handleRequest($request);
   
              if($form->isSubmitted()&& $form->isValid()){
                  $email->setUser($user);
                  $email->setEmail($user->getEmail());
                          
        $message = (new \Swift_Message($email->getSubject()))
        ->setFrom('samirtondo@gmail.com')
        ->setTo('hedibenkhouja3@gmail.com')
    
        ->setBody( $email->getContent() );
     
    
    $mailer->send($message);
                  if(!$email->getId()){
                      $email->setCreatedAt(new \DateTimeImmutable());
                 
                  }
                  $manager->persist($email);
                  $manager->flush();
                  $this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );
                   return $this->redirectToRoute('company');
                }
              
   
              return $this->render('company/createEmail.html.twig',[
               'formEmail'=> $form->CreateView()
   
              ]);
       }
     /**
     * @Route("/company/inventory/{id}", name="inventory_show")
     */
    public function show(Inventory $inventory){
       
        return $this->render('company/showinventory.html.twig', [
           
            'inventory'=> $inventory
        ]);


    }
     /**
     * @Route("/company/licence/{id}", name="licence_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function showlicence(Licence $licence,\Swift_Mailer $mailer ){
        
        return $this->render('company/showLicence.html.twig', [
           
            'licence'=> $licence
        ]);


    }
   /**
     * @Route("/company/product/{id}", name="product_show")
     */
    public function showproduct(Product $product){
       
        return $this->render('company/showProduct.html.twig', [
           
            'product'=> $product
        ]);


    }
      /**
     * @Route("/company/email/{id}", name="email_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function showemail(Email $email){
       
        return $this->render('company/showEmail.html.twig', [
           
            'email'=> $email
        ]);


    }
    /**
     * @Route("/company/inventory/delete/{id}", name="inventory_delete")
     * 
     */
    public function deleteinventory(Inventory $inventory){

$em =$this->getDoctrine()->getManager();
$em->remove($inventory);
$em->flush();
return $this->redirectToRoute('company_inventory');
$this->addFlash('success', 'Article Created! Knowledge is power!');

    }
/**
     * @Route("/company/licence/delete/{id}", name="licence_delete")
     * @IsGranted("ROLE_ADMIN")
     * 
     */
    public function deletelicence(Licence $licence){

        $em =$this->getDoctrine()->getManager();
        $em->remove($licence);
        $em->flush();
        return $this->redirectToRoute('company_licence');
        $this->addFlash('success', 'Licence Deleted!');
        
            }
        /**
     * @Route("/company/transaction/delete/{id}", name="transaction_delete")
     * @IsGranted("ROLE_ADMIN")
     * 
     */
    public function deletetransaction(Transaction $transaction){

        $em =$this->getDoctrine()->getManager();
        $em->remove($transaction);
        $em->flush();
        return $this->redirectToRoute('company_transaction');
        $this->addFlash('success', 'Transaction Deleted!');
        
            }
            
          /**
     * @Route("/company/user/delete/{id}", name="user_delete")
     * @IsGranted("ROLE_ADMIN")
     * 
     */
    public function deleteUser(User $user){

        $em =$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('users');
        $this->addFlash('success', 'user Deleted!');
        
            }

                /**
     * @Route("/company/email/delete/{id}", name="email_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteEmail(Email $email){

        $em =$this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        return $this->redirectToRoute('company_email');
        $this->addFlash('success', 'email Deleted!');
        
            }
  
          /**
     * @Route("/company/user/resetPassword", name="password_reset")
     */
            public function editAction(Request $request,UserPasswordEncoderInterface $passwordEncoder)

    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

    	$form = $this->createForm(ResetPasswordType::class, $user);

    	$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password_reset')['plainPassword']));

            // Si l'ancien mot de passe est bon

         //   if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {

              //  $newEncodedPassword = $passwordEncoder->encodePassword($user, $request->request->get('password_reset')['plainPassword']);

               // $user->setPassword($newEncodedPassword);

                

                $em->persist($user);

                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('company');

          /*} else {

                $form->addError(new FormError('Ancien mot de passe incorrect'));

            }*/

        }

    	

    	return $this->render('company/ResetPassword.html.twig', array(

    		'form' => $form->createView(),

    	));
}
}
/* {
if($request->isMethod('POST')){
    	$em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        if($request->request->get('pass1')== $request->request->get('pass2')){
$user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('pass')));

$em->flush();
$this->addFlash('message','passwords changed');
return $this->redirectToRoute('company');
        }else{
            $this->addFlash('error','passwords not identical');
        }
       
}
             return $this->render('company/ResetPassword.html.twig');
                    
    
            
    
      

    }*/