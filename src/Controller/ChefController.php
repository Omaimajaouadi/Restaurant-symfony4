<?php

namespace App\Controller;
use App\Entity\Chef;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeInterface;
class ChefController extends AbstractController
{
    /**
     * @Route("/chef", name="chef")
     */
    public function index(): Response
    {
        return $this->render('chef/index.html.twig', [
            'controller_name' => 'ChefController',
        ]);
    }
    /**
    * @route("/ajoutchef" , name="ajoutchef")
    */
   public function ajoutchef(Request $request )
   {
        if($request->isMethod('POST'))
        {

        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $photo = $request->request->get('photo');
        $adresse = $request->request->get('adresse');
        $date_rec = $request->request->get('date');
        $telephone = $request->request->get('telephone');
        $c = $this->getDoctrine()->getManager();
        $chef = new Chef();
        $chef->setNom($nom);
        $chef->setPrenom($prenom);
        $chef->setImage($photo);
        $chef->setAdresse($adresse);
        $chef->setTelephone($telephone);
        $chef->setDateRecrutement($date_rec);
        $c->persist($chef);
        $c->flush();
      
        }
        return $this->render('chef/ajouterchef.html.twig');
   }
  
  //afficher la page de modification du freelancer et remplir les champs
    /**
     * @Route("/modificationchef/{id}", name="modificationchef")
     */
    public function modificationchef(Request $request,$id)
    
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Chef::class);
        $listetache =$repo->find( $id);
        return $this->render('chef/modifchef.html.twig', [
            'chef' => $listetache,
        ]);
    } 
       //afficher les données d'un chef
    /**
     * @Route("/detailschef/{id}", name="detailschef")
     */
    public function detailschef(Request $request,$id)
    
    {
        $c=$this->getDoctrine()->getManager();
        $repo=$c->getRepository( Chef::class);
        $listechef =$repo->find( $id);
        return $this->render('chef/detailschef.html.twig', [
            'chef' => $listechef,
        ]);
    } 

    
      //pour modifier un chef
    /**
     * @route("/modifchef11" , name="modifchef11")
     */
    public function modifchef (Request $request )
    {
      
            $params = $request->query->all();
            $id = $request->get('id');
            $nom = $request->request->get('nom');
            $prenom = $request->get('prenom');
            $adresse = $request->get('adresse');
            $img = $request->get('photo');
            $date = $request->get('date');
            $tel = $request->get('telephone');
            $em = $this->getDoctrine()->getRepository(Chef::class)->find($id);
            $entity=$this->getDoctrine()->getManager();
            $em->setNom($nom);
            $em->setPrenom($prenom);
            $em->setAdresse($adresse);
            $em->setTelephone($tel);
            $em->setImage($img);
            $em->setDateRecrutement($date);
            $entity->persist($em);
            $entity->flush();
            return $this->redirectToRoute("listchef");    
        } 
    

   //pour afficher la liste des chefs dans le dashboard de l'admin
    /**
     * @Route("listchef", name="listchef")
     */
    public function listchef(Request $request)
    
    {
        $c=$this->getDoctrine()->getManager();
        $repo=$c->getRepository( Chef::class);
        $listchef =$repo->findAll();
        return $this->render('chef/listchef.html.twig', [
            'chefs' => $listchef,
        ]);
    }
   
  
      //pour supprimer un chef
    /**
     * @Route("deletechef/{id}", name="deletechef")
     */
    public function delete(Request $request,$id) {
        $wantedUser = $this->getDoctrine()->getRepository(Chef::class)->find($id);
        if (!$wantedUser) {
            throw $this->createNotFoundException("User with id ".id." not found in the database !");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($wantedUser);
        $entityManager->flush();
        return($this->redirectToRoute('listchef'));
    }
}


