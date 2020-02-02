<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserAdminController
 *
 * @package AppBundle\Controller
 *
 * @Route("/admin/utilisateur", methods={"GET", "POST"})
 *
 * @Security("is_granted('ROLE_ADMIN')")
 */
class UserAdminController extends AbstractController
{
    /**
     * @Route("s/{page}", name="admin-utilisateurs", defaults={"page": 1}, requirements={"page": "\d+"})
     *
     * @param UtilisateurRepository $repo
     * @param                       $page
     *
     * @return Response
     */
    public function index(UtilisateurRepository $repo, $page)
    {
        $adapter = new DoctrineORMAdapter($repo
            ->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.nom')
        );

        $pager = new Pagerfanta($adapter);
        $pager->setCurrentPage($page);

        return $this->render('admin/utilisateur/index.html.twig', [
            'pager' => $pager,
        ]);
    }

    /**
     * @Route("/editer/{id}", name="admin-utilisateurs_editer")
     *
     * @param Utilisateur   $utilisateur
     * @param Request       $request
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function edit(Utilisateur $utilisateur, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur)
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer les modifications',
                'attr'  => [
                    'class' => 'btn btn-success pull-left',
                ],
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                'attr'  => [
                    'class'          => 'btn btn-secondary pull-right',
                    'formnovalidate' => 'formnovalidate',
                ],
            ]);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            // Si le bouton d'annulation est cliqué

            return $this->redirectToRoute('admin-utilisateurs');
        }

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            // Si le bouton de validation est cliqué

            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('admin-utilisateurs');
        }

        return $this->render('admin/utilisateur/edit.html.twig', [
            'form'        => $form->createView(),
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="admin-utilisateurs_supprimer")
     *
     * @param Utilisateur   $utilisateur
     * @param Request       $request
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function delete(Utilisateur $utilisateur, Request $request, ObjectManager $manager)
    {
        $form = $this->createFormBuilder()
            ->add('submit', SubmitType::class, [
                'label' => 'Supprimer',
                'attr'  => [
                    'class' => 'btn btn-danger pull-left',
                ],
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                'attr'  => [
                    'class'          => 'btn btn-secondary pull-right',
                    'formnovalidate' => 'formnovalidate',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            // Si le bouton d'annulation est cliqué

            return $this->redirectToRoute('admin-utilisateurs_editer', [
                'id' => $utilisateur->getIdUtilisateur(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            // Si le bouton de validation est cliqué

            $manager->remove($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('admin-utilisateurs');
        }


        return $this->render('admin/utilisateur/delete.html.twig', [
            'form'        => $form->createView(),
            'utilisateur' => $utilisateur,
        ]);
    }
}