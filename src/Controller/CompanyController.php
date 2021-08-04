<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Inventory;
use App\Repository\InventoryRepository;
use App\Form\InventoryType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company")
     */
    public function index(): Response
    {
       
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController'
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home(){

        return $this->render('company/home.html.twig');
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
     * @Route("/company/inventory/edit/{id}", name="inventory_edit",method{"GET","POST"})
    
     */
    /*public function edit(Request $request,$id){
       
            $inventory=new Inventory();
       $inventory= $this->getDoctrine()->getRepository(Inventory::class)->find($id);
   
              $form=$this->createForm(InventoryType::class,$inventory);
              $form->handleRequest($request);
   
              if($form->isSubmitted()&& $form->isValid()){
                 
                  
                      $entityManager=$this->getDoctrine()->getManager();
                     
                  $entityManager->flush();
   
                   return $this->redirectToRoute('company_inventory');
                  
              }
   
              return $this->render('company/editInventory.html.twig',[
               'formInventory'=> $form->CreateView()
              // 'editMode'=>$form->getId() !== null
   
              ]);
       }*/
     /**
     * @Route("/company/inventory/{id}", name="inventory_show")
     */
    public function show(Inventory $inventory){
       
        return $this->render('company/showinventory.html.twig', [
           
            'inventory'=> $inventory
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
//return $this->render('company/inventory.html.twig');
//return new Response("Euipment deleted");

    }

    /*
       
       
        $inventory=$this->getDoctrine()->getRepository(Inventory::class)->find($id);
         
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($inventory);
        $entityManager->flush();
$response= new Response();
$response->send();
    }
*/

}
