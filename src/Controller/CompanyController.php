<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Inventory;
use App\Repository\InventoryRepository;
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
    public function inventory(InventoryRepository $repo ){
       
        $Inventorys = $repo->findAll();
        return $this->render('company/inventory.html.twig', [
            'controller_name' => 'CompanyController',
            'inventorys'=> $Inventorys
        ]);
    }
     /**
     * @Route("/company/inventory/create", name="inventory_create")
     */
    public function create(){
        return $this->render('company/createinventory.html.twig');
    }
     /**
     * @Route("/company/inventory/{id}", name="inventory_show")
     */
    public function show(Inventory $inventory){
       
        return $this->render('company/showinventory.html.twig', [
           
            'inventory'=> $inventory
        ]);


    }
}
