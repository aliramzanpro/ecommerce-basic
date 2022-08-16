<?php

namespace App\Controller;
use App\User\Entity;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
    $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/password", name="account_password")
     */
    public function index(Request $request,  UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $notification = null;
        $form = $this->createForm(ChangePasswordType::class, $user);
        // soumission du formulaire
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $old_pwd = $form->get('old_password')->getData();

            if ($hasher->isPasswordValid($user, $old_pwd)) {

                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user ,$new_pwd);
                
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "Votre Mot de passe a bien été modifier";
        }else{
                $notification = "Votre Mot de passe n'a pas été modifier";
        }
    }
    return $this->render('account/password.html.twig',[
        'form' => $form->createView(),
        'notification' => $notification
]);
}
}