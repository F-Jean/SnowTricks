<?php

namespace App\Controller;

use App\Entity\User;
use Twig\Environment;
use App\Form\UserType;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Service\ValidationMail;
use Symfony\Component\Uid\Uuid;
use App\Repository\UserRepository;
use App\Form\ForgottenPasswordType;
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

    public function __construct(Environment $twig, ValidationMail $mailer)
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
    public function confirmAccount(User $user, EntityManagerInterface $manager)
    {
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

    /**
     * @Route("/forgotten_password", name="forgotten_password")
     */
    public function forgottenPassword(Request $request, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ForgottenPasswordType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Fetching data
            $data = $form->getData();
            // we're searching if a user have this email
            $user = $userRepository->findOneByEmail($data['email']);
            // if there is no user
            if(!$user)
            {
                $this->addFlash("error", "Cette adresse n'existe pas !");
                return $this->redirectToRoute('app_login');
            }
            // otherwise generate a token
            $resetToken = Uuid::v4();
            // checking if well written in db ('cause if failed it's useless to send the email)
            try{
                $user->setResetToken($resetToken);
                $manager->persist($user);
                $manager->flush();
            }catch(\Exception $e){
                $this->addFlash("error", "Une erreur est survenue :". $e->getMessage());
                return $this->redirectToRoute('app_login');
            }
            // sending the email
            $this->mailer->sendResetEmail($user->getEmail(), $user->getResetToken());

            $this->addFlash("success", "Un e-mail de réinitialisation de mot de passe vous a été envoyé.");
            return $this->redirectToRoute('app_login');
        }

        return new Response($this->twig->render("security/forgottenPassword.html.twig", [
            'forgottenPasswordForm' => $form->createView(),
        ]));
    }

    /**
     * @Route("/reset_password/{resetToken}", name="reset_password")
     */
    public function resetPassword($resetToken, UserRepository $userRepository, Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ResetPasswordType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // we seach the user corresponding to the token used
            $user = $userRepository->findOneBy(['resetToken' => $resetToken]);
            if(!$user)
            {
                $this->addFlash("error", "Token inconnu !");
                return $this->redirectToRoute('app_login');
            }
        
            $user->setResetToken(null);
            $resetPassword = $encoder->encodePassword($user, $form->get('resetPassword')->getData());
            $user->setPassword($resetPassword);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Le mot de passe a bien été modifié.");
            return $this->redirectToRoute('app_login');
        }

        return new Response($this->twig->render("security/resetPassword.html.twig", [
            'resetPasswordForm' => $form->createView(),
        ]));
    }
}
