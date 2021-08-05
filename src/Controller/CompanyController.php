<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Inventory;
use App\Repository\InventoryRepository;
use App\Entity\Licence;
use App\Repository\LicenceRepository;
use App\Form\InventoryType;
use App\Form\LicenceType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
        
  
}
