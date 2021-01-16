<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Plat;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeInterface;


class PlatController extends AbstractController
{
    /**
     * @Route("/plat", name="plat")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }
     /**
     * @Route("/layout", name="layout")
       
     */
    public function layout(){
        return $this->render('layout.html.twig');
    }
    

    public function menu()
    {
       
        return $this->render('menu.html.twig');
          
       
    }


    /**
    * @route("/ajoutplat" , name="ajoutplat")
    */
   public function ajout (Request $request )
   {
        if($request->isMethod('POST'))
        {
        $nom = $request->request->get('nom');
        $description = $request->request->get('description');
        $photo = $request->request->get('photo',FileType::class,[

        // unmapped means that this field is not associated to any entity property
        'mapped' => false,

        // make it optional so you don't have to re-upload the PDF file
        // every time you edit the Product details
        'required' => false,

        // unmapped fields can't define their validation using annotations
        // in the associated entity, so you can use the PHP constraint classes
        'constraints' => [
            new File([
                'maxSize' => '1024k',
                'mimeTypes' => [
                    'application/jpg',
                    'application/png',
                ],
                'mimeTypesMessage' => 'Please upload a valid  document',
            ])
        ],
    ])->getData();
    if ($photo) {
        $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $photo->move(
                $this->getParameter('upload_dir'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        $plat->setImage($newFilename);
    }
 $p= $this->getDoctrine()->getManager();
        $plat = new Plat();
        $plat->setImage($photo); 
        $plat->setNom($nom);
        $plat->setDescription($description); 
        $img=$plat->getImage();
    // ... persist the $product variable or any other work
 


        //$img=$photo->getImage();
        //$file = $request->file('input_img');
       //$filename = rand(11111, 99999) . '.' . $photo->getClientOriginalExtension();
       // $request->file('photo')->move("upload_dir", $filename);
       
        //$fileName = md5(uniqid()).'.'.$img->guessExtension(); 
        //$img->move($this->getParameter('upload_dir'), $fileName); 
        
        $p->persist($plat);
        $p->flush();
        //return new Response("User photo is successfully uploaded.");
      
        }
        return $this->render('plat/ajouter.html.twig');
   }
  

 //afficher la page de modification du plat et remplir les champs
    /**
     * @Route("modifplat/{id}", name="modifplat")
     */
    public function modificationplat(Request $request,$id)
    
    {
        $p=$this->getDoctrine()->getManager();
        $repo=$p->getRepository( Plat::class);
        $plat =$repo->find($id);
        return $this->render('plat/modifplat.html.twig', [
            'plat' => $plat,
        ]);
     
    } 
       //afficher les données d'un plat
    /**
     * @Route("/detailsplat/{id}", name="detailsplat")
     */
    public function detailsplat(Request $request,$id)
    
    {
        $p=$this->getDoctrine()->getManager();
        $repo=$p->getRepository( Plat::class);
        $listeplat =$repo->find( $id);
        return $this->render('plat/detailsplat.html.twig', [
            'plat' => $listeplat,
        ]);
    } 

    
      //pour modifier un plat
    /**
     * @route("/modif" , name="modif")
     */
    public function modif (Request $request )
    {
        $params = $request->query->all();
        $id = $request->get('id');
        $nom = $request->get('nom');
        $description = $request->get('description');
        $photo = $request->get('photo');
        
        $em = $this->getDoctrine()->getRepository(Plat::class)->find($id);
        $entity=$this->getDoctrine()->getManager();
        $em->setNom($nom);
        $em->setDescription($description);
        $em->setPhoto($photo);
        
        $entity->persist($em);
        $entity->flush();
        return $this->redirectToRoute("listplat");    
    } 

   //pour afficher la liste des plats dans le dashboard de l'admin
    /**
     * @Route("listplat", name="listplat")
     */
    public function listplat(Request $request)
    
    {
        $p=$this->getDoctrine()->getManager();
        $repo=$p->getRepository( Plat::class);
        $listplat =$repo->findAll();
        return $this->render('plat/listplat.html.twig', [
            'plats' => $listplat,
        ]);
    }
   
  
      //pour supprimer une tâche
    /**
     * @Route("deleteplat/{id}", name="deleteplat")
     */
    public function delete(Request $request,$id) {
        $wantedUser = $this->getDoctrine()->getRepository(Plat::class)->find($id);
        if (!$wantedUser) {
            throw $this->createNotFoundException("User with id ".id." not found in the database !");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($wantedUser);
        $entityManager->flush();
        return($this->redirectToRoute('listplat'));
    }
}


