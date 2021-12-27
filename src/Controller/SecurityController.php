<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Form\ForgottenPasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\UserData;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, UserData $userData) 
    {
        $user = new User();
        $user->setAvatar('basicAvatar.png');
        $form = $this->createForm(RegisterType::class, $user)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // SERVICE UserData
            $userData->userRegistration($user);
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
    public function userAccount(Request $request, UserData $userData)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user,)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // SERVICE UserData
            $userData->uploadAvatar($user);
            return $this->redirectToRoute('user_account');
        }

        return $this->render("security/account.html.twig", [
            'user' => $user,
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirm_account/{token}", name="confirm_account")
     */
    public function confirmAccount(User $user, UserData $userData)
    {
        // SERVICE UserData
        $userData->accountActivator($user);
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/forgotten_password", name="forgotten_password")
     */
    public function forgottenPassword(Request $request, UserData $userData)
    {
        $form = $this->createForm(ForgottenPasswordType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Fetching data
            $data = $form->getData();
            // SERVICE UserData
            $userData->checkUser($data);
            return $this->redirectToRoute('app_login');
        }

        return $this->render("security/forgottenPassword.html.twig", [
            'forgottenPasswordForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reset_password/{resetToken}", name="reset_password")
     */
    public function resetPassword(User $user, Request $request, UserData $userData)
    {
        $form = $this->createForm(ResetPasswordType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('resetPassword')->getData();
            // SERVICE UserData
            $userData->resetToken($user, $newPassword);
            return $this->redirectToRoute('app_login');
        }

        return $this->render("security/resetPassword.html.twig", [
            'resetPasswordForm' => $form->createView(),
        ]);
    }
}
