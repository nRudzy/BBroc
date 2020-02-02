<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion", methods={"GET", "POST"})
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('accueil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/inscription", name="inscription", methods={"GET", "POST"})
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('accueil');
        }

        $utilisateur = new Utilisateur();
        $form = $this->createForm(RegisterType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($em->getRepository(Utilisateur::class)->emailAlreadyUsed($utilisateur->getEmail())) {
                $this->addFlash('error', "Cette adresse mail est déjà utilisée pour un autre compte");
            } else {
                $password = $encoder->encodePassword($utilisateur, $form->get('plainPassword')->getData());
                $utilisateur->setPassword($password);

                $utilisateur->generateEmailKey();

                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();

                // TODO: Service d'envoi de mail pour valider l'adresse mail
//                $this->get('app.service.mailer')->registerEmail($utilisateur);

                $this->addFlash('success', "Votre compte a bien été créé, un email vient de vous être envoyé afin de confirmer votre adresse mail");

                return $this->redirectToRoute('accueil');
            }
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
