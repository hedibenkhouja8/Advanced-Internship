<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Inventory;
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
    public function inventory(){
        $repo= $this->getDoctrine()->getRepository(Inventory::class);
        $Inventorys = $repo->findAll();
        return $this->render('company/inventory.html.twig', [
            'controller_name' => 'CompanyController',
            'inventorys'=> $Inventorys
        ]);
    }
}
