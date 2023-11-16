<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Form\CommentType;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{   private $em;
    private $movieRep;
    public function __construct(EntityManagerInterface $em,MovieRepository $movieRep){
        $this->em=$em;
        $this->movieRep=$movieRep;
        
    }

    #[Route('/', name: 'movies')]
    public function index():Response
    { 
        
        $movies=$this->movieRep->findAll();
        //$movie->$rep->find(6) select * from movie where id=5
        // $movies=$rep->findBy([],['id'=>"ASC"]); select * from movie where ORDRED BY ID ASC OR DESC
        //$movies=$rep->findOneBy(['id'=>5,'title'=>"xyz"],['id'=>"ASC"]); find one element wich match conditions
        //$movies=$rep->count(['id'=>5]); count element where id=5
        //$movies=$rep->getClassName(); get the entity class name
      

        return $this->render('Movies/index.html.twig',['movies'=>$movies]);
    }
    
    #[Route('/movies/show/{id}', methods: ['GET','POST'], name: 'show_movie')]
    public function show($id,Request $request):Response
    { 
        
        $movie=$this->movieRep->find(['id'=>$id]);
        //$movie->$rep->find(6) select * from movie where id=5
        // $movies=$rep->findBy([],['id'=>"ASC"]); select * from movie where ORDRED BY ID ASC OR DESC
        //$movies=$rep->findOneBy(['id'=>5,'title'=>"xyz"],['id'=>"ASC"]); find one element wich match conditions
        //$movies=$rep->count(['id'=>5]); count element where id=5
        //$movies=$rep->getClassName(); get the entity class name
        $comment=new Comment();
        $form=$this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid())
        { $comment->setCreatedAt(new \DateTimeImmutable())
            ->setMovie($movie)
            ->setAuthor($this->getUser());

            $this->em->persist($comment);
            $this->em->flush();
            return $this->redirectToRoute('movies');
        }
        return $this->render('Movies/show.html.twig',['movie'=>$movie,'commentForm'=>$form->createView()]);
    }


    #[Route('/movies/create',  name: 'create_movie')]
    public function createMovie(Request $request):Response{
        $movie=new Movie();
        $form=$this->createForm(MovieFormType::class, $movie);
        
         $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $Newmovie= $form->getData();
            $imgPath=$form->get('imagePath')->getData();
            if($imgPath){
                $newFileName=uniqid().'.'. $imgPath->guessExtension();
                try {
                    $imgPath->move($this->getParameter('kernel.project_dir').'/public/uploads', $newFileName
                );
                }
                catch(FileException $error){
                    return new Response($error->getMessage());
                }
                $Newmovie->setImagePath('/uploads/'.$newFileName);
              
            }
            $this->em->persist($Newmovie);
            $this->em->flush();
            return $this->redirectToRoute('movies');

        }
       
        return $this->render('Movies/create.html.twig',['form'=>$form->createView()]);
    }






    #[Route('/movies/edit/{id}',  name: 'edit_movie')]
    public function editMovie(Request $request, $id):Response{
        $movie=$this->movieRep->find(['id'=>$id]);
        $form=$this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid())
        {
            
            $imgPath=$form->get('imagePath')->getData();
            if($imgPath){
                $this->getParameter('kernel.project_dir').$movie->getImagePath();
                $newFileName=uniqid(). '.' . $imgPath->guessExtension();
                try {
                    $imgPath->move($this->getParameter('kernel.project_dir').'/public/uploads', $newFileName
                );
                }
                catch(FileException $error){
                    return new Response($error->getMessage());
                }
                $movie->setImagePath('/uploads/'. $newFileName);
           
            }

            $this->em->persist($movie);
            $this->em->flush();
            return $this->redirectToRoute('movies');

        }
       
        return $this->render('Movies/edit.html.twig',['movie'=>$movie,
        'form'=>$form->createView()]);
    }






    #[Route('/movies/delete/{id}',methods:['GET','DELETE'],  name: 'delete_movie')]
    public function deleteMovie(Request $request, $id):Response{
            $movie=$this->movieRep->find(['id'=>$id]);
            $this->em->remove($movie);
            $this->em->flush();
            return $this->redirectToRoute('movies');
    }
}
