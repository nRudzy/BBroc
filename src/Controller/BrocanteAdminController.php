<?php

namespace App\Controller;

use App\Entity\Brocante;
use App\Entity\Emplacement;
use App\Entity\Participer;
use App\Entity\Place;
use App\Form\BrocanteType;
use App\Form\PlaceType;
use App\Repository\BrocanteRepository;
use App\Repository\EmplacementRepository;
use App\Repository\PlaceRepository;
use App\Service\Base64Encoder;
use Doctrine\Common\Persistence\ObjectManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BrocanteAdminController
 *
 * @package AppBundle\Controller
 *
 * @Route("/admin/brocante", methods={"GET", "POST"})
 *
 * @Security("is_granted('ROLE_ADMIN')")
 */
class BrocanteAdminController extends AbstractController
{
    /**
     * @Route("s/{page}", name="admin-brocantes", defaults={"page": 1}, requirements={"page": "\d+"})
     *
     * @param BrocanteRepository $repo
     * @param                    $page
     *
     * @return Response
     */
    public function index(BrocanteRepository $repo, $page)
    {
        $adapter = new DoctrineORMAdapter($repo
            ->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.date', 'DESC')
        );

        $pager = new Pagerfanta($adapter);
        $pager->setCurrentPage($page);

        return $this->render('admin/brocante/index.html.twig', [
            'pager' => $pager,
        ]);
    }


    /**
     * @Route("s/suggestion/{page}", name="admin-brocantes-suggest", defaults={"page": 1}, requirements={"page": "\d+"})
     *
     * @param BrocanteRepository $repo
     * @param                    $page
     *
     * @return Response
     */
    public function index_suggest(BrocanteRepository $repo, $page)
    {
        $bb = $repo->findBy(array('suggestion' => true));

        // On créé le pager
        $adapter = new ArrayAdapter($bb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setCurrentPage($page);

        return $this->render('admin/brocante/suggestions.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    /**
     * @Route("/creer", name="admin-brocante_creer")
     *
     * @param Request               $request
     * @param ObjectManager         $manager
     * @param Base64Encoder         $encoder
     *
     * @param EmplacementRepository $emplacementRepository
     *
     * @return RedirectResponse|Response
     */
    public function createBrocante(Request $request, ObjectManager $manager, Base64Encoder $encoder, EmplacementRepository $emplacementRepository)
    {
        $brocante = new Brocante();
        $brocante->setSuggestion(false);

        $form = $this->createForm(BrocanteType::class, $brocante)
            ->add('places', CollectionType::class, [
                // mapped = false pour ne pas l'inclure dans l'entité Brocante ce qui déclencherait une erreur
                'mapped'        => false,
                'required'      => false,
                'label'         => "Places",
                'entry_type'    => PlaceType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => true,
                'allow_delete'  => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer la brocante',
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

            return $this->redirectToRoute('admin-brocantes');
        }

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            // Si le bouton de validation est cliqué
            // On récupère le fichier
            $tmpfname = $form['image']->getData();

            if ($tmpfname) {
                $base64 = $encoder->encode($tmpfname);
                $brocante->setImage($base64);
            } else {
                $brocante->setImage(null);
            }

            $places = $form['places']->getData();

            foreach ($places as $place) {
                $nbPlaces = (int)$place['nbPlaces'];
                $taillePlace = $place['taillePlace'];
                $prixPlace = $place['prixPlace'];

                for ($i = 0; $i < $nbPlaces; $i++) {
                    $newPlace = new Place();

                    $emplacement = $emplacementRepository->findOneBy(['surface' => $taillePlace]);

                    if (!$emplacement) {
                        $emplacement = new Emplacement();
                        $emplacement->setSurface($taillePlace);

                        $manager->persist($emplacement);
                        $manager->flush();
                    }

                    $newPlace->setIdEmplacement($emplacement);
                    $newPlace->setPrix($prixPlace);
                    $newPlace->setDisponible(true);

                    $manager->persist($newPlace);

                    $brocante->addPlace($newPlace);
                }
            }

            $manager->persist($brocante);
            $manager->flush();

            return $this->redirectToRoute('admin-brocantes_consulter', [
                'id' => $brocante->getIdBrocante(),
            ]);
        }

        return $this->render('admin/brocante/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editer/{id}", name="admin-brocante_editer")
     *
     * @param Brocante              $brocante
     * @param Request               $request
     * @param ObjectManager         $manager
     * @param Base64Encoder         $encoder
     * @param PlaceRepository       $placeRepository
     * @param EmplacementRepository $emplacementRepository
     *
     * @return RedirectResponse|Response
     */
    public function editBrocante(Brocante $brocante, Request $request, ObjectManager $manager, Base64Encoder $encoder, PlaceRepository $placeRepository, EmplacementRepository $emplacementRepository)
    {
        // Récupération de l'image de la brocante pour l'utiliser lors de la validation du formulaire
        $old_image = $brocante->getImage();

        $places = $placeRepository->findPlacesOfBrocanteGroupBySize($brocante);

        $form = $this->createForm(BrocanteType::class, $brocante)
            ->add('isImage', CheckboxType::class, [
                // mapped = false pour ne pas l'inclure dans l'entité Brocante ce qui déclencherait une erreur
                'mapped'   => false,
                'required' => false,
                'label'    => "Souhaitez-vous modifier l'image de la brocante ?",
            ])
            ->add('places', CollectionType::class, [
                // mapped = false pour ne pas l'inclure dans l'entité Brocante ce qui déclencherait une erreur
                'mapped'        => false,
                'required'      => false,
                'label'         => "Places",
                'entry_type'    => PlaceType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => true,
                'allow_delete'  => true,
            ])
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

            return $this->redirectToRoute('admin-brocantes_consulter', [
                'id' => $brocante->getIdBrocante(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            // Si le bouton de validation est cliqué

            if ($form['isImage']->getViewData() == 1) {
                // Si on a cliqué sur la modification d'image

                // On récupère le fichier
                $tmpfname = $form['image']->getData();

                if ($tmpfname) {
                    // Si on a un fichier

                    // On encode l'image en base64
                    $base64 = $encoder->encode($tmpfname);

                    // On renseigne l'image dans la brocante
                    $brocante->setImage($base64);
                } else {
                    // Si on a pas de fichier

                    // On met à null l'image de la brocante
                    $brocante->setImage(null);
                }
            } else {
                // Si on a pas cliqué sur la modification d'image

                // On remet l'ancienne image
                $brocante->setImage($old_image);
            }

            $places = $form['places']->getData();

            foreach ($places as $place) {
                $nbPlaces = (int)$place['nbPlaces'];
                $taillePlace = $place['taillePlace'];
                $prixPlace = $place['prixPlace'];

                for ($i = 0; $i < $nbPlaces; $i++) {
                    $newPlace = new Place();

                    $emplacement = $emplacementRepository->findOneBy(['surface' => $taillePlace]);

                    if (!$emplacement) {
                        $emplacement = new Emplacement();
                        $emplacement->setSurface($taillePlace);

                        $manager->persist($emplacement);
                        $manager->flush();
                    }

                    $newPlace->setIdEmplacement($emplacement);
                    $newPlace->setPrix($prixPlace);
                    $newPlace->setDisponible(true);

                    $manager->persist($newPlace);

                    $brocante->addPlace($newPlace);
                }
            }

            $manager->persist($brocante);
            $manager->flush();

            return $this->redirectToRoute('admin-brocantes_consulter', [
                'id' => $brocante->getIdBrocante(),
            ]);
        }

        return $this->render('admin/brocante/edit.html.twig', [
            'form'     => $form->createView(),
            'brocante' => $brocante,
            'places'   => $places,
        ]);
    }

    /**
     * @Route("/suggestion/{id}", name="admin-brocante_suggestion_editer")
     *
     * @param Brocante              $brocante
     * @param Request               $request
     * @param ObjectManager         $manager
     * @param Base64Encoder         $encoder
     * @param PlaceRepository       $placeRepository
     * @param EmplacementRepository $emplacementRepository
     *
     * @return RedirectResponse|Response
     */
    public function editSuggestionBrocante(Brocante $brocante, Request $request, ObjectManager $manager, Base64Encoder $encoder, PlaceRepository $placeRepository, EmplacementRepository $emplacementRepository)
    {
        // Récupération de l'image de la brocante pour l'utiliser lors de la validation du formulaire
        $old_image = $brocante->getImage();

        $form = $this->createForm(BrocanteType::class, $brocante)
            ->add('isImage', CheckboxType::class, [
                // mapped = false pour ne pas l'inclure dans l'entité Brocante ce qui déclencherait une erreur
                'mapped'   => false,
                'required' => false,
                'label'    => "Souhaitez-vous modifier l'image de la brocante ?",
            ])
            ->add('places', CollectionType::class, [
                // mapped = false pour ne pas l'inclure dans l'entité Brocante ce qui déclencherait une erreur
                'mapped'        => false,
                'required'      => false,
                'label'         => "Places",
                'entry_type'    => PlaceType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => true,
                'allow_delete'  => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider la suggestion',
                'attr'  => [
                    'class' => 'btn btn-success pull-left',
                ],
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Supprimer la suggestion',
                'attr'  => [
                    'class'          => 'btn btn-danger pull-right',
                    'formnovalidate' => 'formnovalidate',
                ],
            ]);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            // Si le bouton d'annulation est cliqué

            // On supprime la brocante
            $manager->remove($brocante);
            $manager->flush();

            return $this->redirectToRoute('admin-brocantes-suggest');
        }

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            // Si le bouton de validation est cliqué

            if ($form['isImage']->getViewData() == 1) {
                // Si on a cliqué sur la modification d'image

                // On récupère le fichier
                $tmpfname = $form['image']->getData();

                if ($tmpfname) {
                    // Si on a un fichier

                    // On encode l'image en base64
                    $base64 = $encoder->encode($tmpfname);

                    // On renseigne l'image dans la brocante
                    $brocante->setImage($base64);
                } else {
                    // Si on a pas de fichier

                    // On met à null l'image de la brocante
                    $brocante->setImage(null);
                }
            } else {
                // Si on a pas cliqué sur la modification d'image

                // On remet l'ancienne image
                $brocante->setImage($old_image);
            }

            // On retire que c'est une suggestion
            $brocante->setSuggestion(false);

            $places = $form['places']->getData();

            foreach ($places as $place) {
                $nbPlaces = (int)$place['nbPlaces'];
                $taillePlace = $place['taillePlace'];
                $prixPlace = $place['prixPlace'];

                for ($i = 0; $i < $nbPlaces; $i++) {
                    $newPlace = new Place();

                    $emplacement = $emplacementRepository->findOneBy(['surface' => $taillePlace]);

                    if (!$emplacement) {
                        $emplacement = new Emplacement();
                        $emplacement->setSurface($taillePlace);

                        $manager->persist($emplacement);
                        $manager->flush();
                    }

                    $newPlace->setIdEmplacement($emplacement);
                    $newPlace->setPrix($prixPlace);
                    $newPlace->setDisponible(true);

                    $manager->persist($newPlace);

                    $brocante->addPlace($newPlace);
                }
            }

            $manager->persist($brocante);
            $manager->flush();

            return $this->redirectToRoute('admin-brocantes_consulter', [
                'id' => $brocante->getIdBrocante(),
            ]);
        }

        return $this->render('admin/brocante/edit_suggestion.html.twig', [
            'form'     => $form->createView(),
            'brocante' => $brocante,
        ]);
    }

    /**
     * @Route("/consulter/{id}", name="admin-brocantes_consulter")
     *
     * @param Brocante        $brocante
     * @param PlaceRepository $placeRepository
     * @param                 $id
     *
     * @return Response
     */
    public function show(Brocante $brocante, PlaceRepository $placeRepository, $id)
    {

        $places = $placeRepository->findPlacesOfBrocanteGroupBySize($brocante);
        $choices = [];

        foreach ($places as $place) {
            $value = $place["surface"] . "_" . $place["0"]->getPrix() . "_" . $place["2"];
            $key = "Place de " . $place["surface"] . "m² à " . $place["0"]->getPrix() . "€ (" . $place["2"] . " disponibles)";

            $choices[$key] = $value;
        }

        $new_participe = new Participer();
        $new_participe->setIdBrocante($brocante);

        $p_repo = $this->getDoctrine()->getRepository(Participer::class);
        $nb_participants = $p_repo->countParticipants($id);

        $userParticipe = false;
        $role = null;
        $place = null;

        if ($this->getUser()) {
            $user = $this->getUser();
            $new_participe->setIdUtilisateur($user);

            foreach ($user->getParticipers() as $participe) {
                if ($participe->getIdBrocante()->getIdBrocante() == $brocante->getIdBrocante()) {
                    $userParticipe = true;
                    $role = $participe;

                    $place = $placeRepository->findPlaceByBrocanteAndUser($brocante, $user);
                }
            }
        }

        return $this->render('admin/brocante/show.html.twig', [
            'brocante'        => $brocante,
            'nb_participants' => $nb_participants,
            'userParticipe'   => $userParticipe,
            'role'            => $role,
            'place'           => $place,
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="admin-brocantes_supprimer")
     *
     * @param Brocante      $brocante
     * @param Request       $request
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function delete(Brocante $brocante, Request $request, ObjectManager $manager)
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

            return $this->redirectToRoute('admin-brocante_editer', [
                'id' => $brocante->getIdBrocante(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            // Si le bouton de validation est cliqué

            $manager->remove($brocante);
            $manager->flush();

            return $this->redirectToRoute('admin-brocantes');
        }


        return $this->render('admin/brocante/delete.html.twig', [
            'form'     => $form->createView(),
            'brocante' => $brocante,
        ]);
    }
}