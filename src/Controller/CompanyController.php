<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Email;
use App\Entity\Licence;
use App\Entity\Product;
use App\Form\EmailType;
use App\Entity\Category;
use App\Entity\Inventory;
use App\Form\LicenceType;
use App\Form\ProductType;
use App\Entity\Transaction;
use App\Form\InventoryType;
use App\Form\TransactionType;
use App\Repository\UserRepository;
use App\Repository\EmailRepository;
use App\Repository\LicenceRepository;
use App\Repository\ProductRepository;
use App\Repository\InventoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
  
    /**
     * @Route("/", name="company")
     */
    public function index(EmailRepository $rep,InventoryRepository $repo, LicenceRepository $repoo, TransactionRepository $repooo,ProductRepository $repoooo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $Inventorys = $repo->findOldItems();
        $Licences = $repoo->findOldLicences();
        $Transactions=$repooo->findRecentTransactions();
        $Products=$repoooo->findLowQuality();
        $Emails=$rep->findNewReports();
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
            'inventorys' => $Inventorys,
            'licences' => $Licences,
            'transactions'=>$Transactions,
            'products'=>$Products,
           'emails'=>$Emails
        ]);
    }
    /**
 * @Route("/company/users", name="users")
 */
public function usersList(TransactionRepository $rep,UserRepository $repo,Request $request,PaginatorInterface $paginator)
{ 
    $Transactions =$rep->findAll();
    $Data = $repo->findAll();
    $Users=$paginator->paginate(
 $Data,
 $request->query->getInt('page',1),
 10  );
    return $this->render('company/users.html.twig', [
        'users' => $Users,
        'transactions' => $Transactions

    ]);
}

  


  
     /**
     * @Route("/company/inventory", name="company_inventory")
     */
    public function inventory(InventoryRepository $repo,Request $request,PaginatorInterface $paginator ){
       
        $Data = $repo->findAll();
        $Inventorys=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/inventory.html.twig', [
            'controller_name' => 'CompanyController',
            'inventorys'=> $Inventorys
        ]);
    }
     /**
     * @Route("/company/licence", name="company_licence")
     */
    public function licence(LicenceRepository $repo,Request $request,PaginatorInterface $paginator ){
       
        $Data = $repo->findAll();
        $Licences=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/licence.html.twig', [
            'controller_name' => 'CompanyController',
            'licences'=> $Licences
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
    public function product(ProductRepository $repo,Request $request,PaginatorInterface $paginator ){
       
        $Data = $repo->findAll();
        $Products=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/product.html.twig', [
            'controller_name' => 'CompanyController',
            'products'=> $Products
        ]);
    }
/**
     * @Route("/company/email", name="company_email")
     */
    public function email(EmailRepository $repo,Request $request,PaginatorInterface $paginator ){
       
        $Data = $repo->findAll();
        $Emails=$paginator->paginate(
     $Data,
     $request->query->getInt('page',1),
     10


        );
        return $this->render('company/email.html.twig', [
            'controller_name' => 'CompanyController',
            'emails'=> $Emails
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
     */
    public function showlicence(Licence $licence){
       
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
     * 
     */
    public function deleteEmail(Email $email){

        $em =$this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        return $this->redirectToRoute('company_email');
        $this->addFlash('success', 'email Deleted!');
        
            }
  
}
