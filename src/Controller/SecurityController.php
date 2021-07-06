<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Twig\Environment;
use App\Form\UserType;
use App\Form\RegisterType;
use App\Service\Mailer;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(Environment $twig, Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) 
    {
        $user = new User();
        $user->setAvatar('basicAvatar.png');
        $form = $this->createForm(RegisterType::class, $user)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setToken(Uuid::v4());
            $manager->persist($user);
            $manager->flush();
            $this->mailer->sendEmail($user->getEmail(), $user->getToken());
            $this->addFlash("success", "Inscription réussie ! Allez vérifier votre email avant la connexion.");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){}

    /**
     * @Route("/account", name="user_account")
     */
    public function userAccount(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user,)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $user->getavatarFile();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/users_avatar';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            $uploadedFile->move(
                $destination,
                $newFilename
            );

            $user->setAvatar($newFilename);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_account');
        }

        return new Response($this->twig->render("security/account.html.twig", [
            'user' => $user,
            'userForm' => $form->createView(),
        ]));
    }

    /**
     * @Route("/confirm_account/{token}", name="confirm_account")
     */
    public function confirmAccount(UserRepository $userRepository ,$token, EntityManagerInterface $manager)
    {
        $user = $userRepository->findOneBy(["token" => $token]);
        if($user)
        {
            $user->setToken(null);
            $user->setEnabled(true);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success", "Votre compte est activé !");
            return $this->redirectToRoute('homepage');
        } else {
            $this->addFlash("error", "Ce compte n'existe pas !");
            return $this->redirectToRoute('homepage');
        }
    }
}
