<?php 
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tache;
 
class inscriptionController extends AbstractController
{
    
    
    /**
     * @Route("/ins" ,name="ins");
    */
    public function number()
    {
        
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository( Repas::class);
        $listRepass =$repo->findAll();
        return $this->render('repas/index.html.twig',[
            'repass' => $listRepass,
        ]);
    }

    
}
?>
