<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use App\Controller\SecurityController;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        // soumission du formulaire
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            
            //methode pour crypter/hasher les mot des passe 
            //recuperattion et hashage du mdp en la stockant dans la variable $password
            $password = $hasher->hashPassword($user, $user->getPassword());
            //reinjection dans le 'objet user 
            $user->setPassword($password);
            

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        
        
        }
        return $this->render('register/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
