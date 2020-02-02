<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityConstraints;
use Symfony\Component\Validator\Constraints;

/**
 * Class AccountController
 *
 * @package App\Controller
 *
 * @Route("/mon-compte", methods={"GET"})
 *
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
class AccountController extends AbstractController
{

    /**
     * @Route("", name="mon-compte")
     *
     * @param Request|null $forwardedRequest
     * @param null $wrongForm
     *
     * @return Response
     */
    public function indexAction(Request $forwardedRequest = null, $wrongForm = null)
    {
        $emailForm = $this->createEmailForm();
        $emailForm->get('email')->setData($this->getUser()->getEmail());
        $passwordForm = $this->createPasswordForm();
        $infosForm = $this->createInfosForm($this->getUser());

        switch ($wrongForm) {
            case ('email'):
                $emailForm->handleRequest($forwardedRequest);
                break;
            case ('password'):
                $passwordForm->handleRequest($forwardedRequest);
                break;
            case ('infos'):
                $infosForm->handleRequest($forwardedRequest);
                break;
            default:
                break;
        }

        return $this->render('account/index.html.twig', [
            'emailForm'    => $emailForm->createView(),
            'passwordForm' => $passwordForm->createView(),
            'infosForm'    => $infosForm->createView(),
        ]);
    }

    /**
     * Create the form to change the email linked to the user account
     *
     * @return FormInterface
     */
    private function createEmailForm()
    {
        return $this->get('form.factory')->createNamedBuilder('email')
            ->setAction($this->generateUrl('modif-email'))
            ->add('email', EmailType::class, [
                'label' => "Adresse email",
                'constraints' => [new Constraints\Email()],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer",
                'attr'  => ['class' => "btn btn-success pull-right"],
            ])
            ->getForm();
    }

    /**
     * @Route("/changement-email", name="modif-email", methods={"POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function changeEmailAction(Request $request)
    {
        $form = $this->createEmailForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();

            if ($user->getEmail() == $form->get('email')->getData()) {
                $user->setTmpEmail(null);
                $user->setEmailKey(null);
                $em->flush();

                $this->addFlash('warning', "Cette adresse est déjà votre adresse de contact");
            } elseif (null != $em->getRepository(Utilisateur::class)->findOneBy(['email' => $form->get('email')->getData()])) {
                $this->addFlash('error', "Cette adresse mail est déjà utilisée par un autre compte");
            } else {
                $this->getUser()->setTmpEmail($form->get('email')->getData());
                $this->getUser()->generateEmailKey();
                $em->flush();

                $this->addFlash('success', "Votre demande de changement d'adresse a bien été prise en compte");

                // TODO: service d'envoi de mail
//                $this->get('app.service.mailer')->changeAddressEmail($user);
            }
        } else {
            return $this->forward('AppBundle\Controller\AccountController::indexAction', [
                'forwardedRequest' => $request,
                'wrongForm'        => 'email',
            ]);
        }

        return $this->redirectToRoute('mon-compte');
    }

    /**
     * Creates the form to change the password of the user
     *
     * @return FormInterface
     */
    private function createPasswordForm()
    {
        return $this->get('form.factory')->createNamedBuilder('password')
            ->setAction($this->generateUrl('modif-password'))
            ->add('current', PasswordType::class, [
                'label'       => "Mot de passe actuel",
                'constraints' => [new SecurityConstraints\UserPassword(),],
            ])
            ->add('new', RepeatedType::class, [
                'type'           => PasswordType::class,
                'first_options'  => [
                    'label'       => "Nouveau mot de passe",
                    'constraints' => [new Constraints\Length(['min' => 8, 'minMessage' => "Le mot de passe doit comporter au moins {{ limit }} caractères"]),],
                ],
                'second_options' => [
                    'label' => "Confirmation du nouveau mot de passe",
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer",
                'attr'  => ['class' => "btn btn-success"],
            ])
            ->getForm();
    }

    /**
     * @Route("/changement-mdp", name="modif-password", methods={"POST"})
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return RedirectResponse|Response
     */
    public function changePasswordAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createPasswordForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $user->generateSalt();
            $user->setPassword($encoder->encodePassword($user, $form->get('new')->getData()));
            $this->getDoctrine()->getManager()->flush();

            // TODO: service d'envoi de mail
//            $this->get('app.service.mailer')->changePasswordWarnEmail($user);

            $this->addFlash('success', "Votre mot de passe a bien été modifié");
        } else {
            $this->addFlash('error', "Une erreur est survenue lors de la modification de votre mot de passe, veuillez vérifier le formulaire");

            return $this->forward('AppBundle\Controller\AccountController::indexAction', [
                'forwardedRequest' => $request,
                'wrongForm'        => 'password',
            ]);
        }

        return $this->redirectToRoute('mon-compte');
    }

    /**
     * Creates the form to change the personnal informations of the user
     *
     * @param Utilisateur $user Utilisateur à modifier
     *
     * @return FormInterface
     */
    private function createInfosForm(Utilisateur $user)
    {
        return $this->get('form.factory')->createNamedBuilder('infos', 'Symfony\Component\Form\Extension\Core\Type\FormType', $user)
            ->setAction($this->generateUrl('modif-infos'))
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'attr'  => ['class' => 'text-uppercase'],
            ])
            ->add('prenom', TextType::class, [
                'label' => "Prénom",
                'attr'  => ['class' => 'text-capitalize'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer",
                'attr'  => ['class' => "btn btn-success pull-right"],
            ])
            ->getForm();
    }

    /**
     * @Route("/changement-infos", name="modif-infos", methods={"POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function changeInfosAction(Request $request)
    {
        $form = $this->createInfosForm($this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Vos informations personnelles ont bien été modifiées");
        } else {
            $this->addFlash('error', "Une erreur est survenue lors de la modification de vos informations personnelles");

            return $this->forward('AppBundle\Controller\AccountController::indexAction', [
                'forwardedRequest' => $request,
                'wrongForm'        => 'infos',
            ]);
        }

        return $this->redirectToRoute('mon-compte');
    }
}
