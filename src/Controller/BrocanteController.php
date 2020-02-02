<?php

namespace App\Controller;

use App\Entity\Brocante;
use App\Entity\Participer;
use App\Entity\Villesfr;
use App\Form\BrocanteType;
use App\Form\ParticipeType;
use App\Repository\EmplacementRepository;
use App\Repository\PlaceRepository;
use App\Service\Base64Encoder;
use Doctrine\Common\Persistence\ObjectManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BrocanteController extends AbstractController
{
    /**
     * @Route("/suggerer-brocante", name="suggerer_brocante")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param Base64Encoder $encoder
     *
     * @param EmplacementRepository $emplacementRepository
     *
     * @return RedirectResponse|Response
     */
    public function createBrocante(Request $request, ObjectManager $manager, Base64Encoder $encoder, EmplacementRepository $emplacementRepository)
    {
        $brocante = new Brocante();
        $brocante->setSuggestion(true);

        $form = $this->createForm(BrocanteType::class, $brocante)
            ->add('submit', SubmitType::class, [
                'label' => 'Suggérer la brocante',
                'attr' => [
                    'class' => 'btn btn-success pull-left',
                ],
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                'attr' => [
                    'class' => 'btn btn-secondary pull-right',
                    'formnovalidate' => 'formnovalidate',
                ],
            ]);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            // Si le bouton d'annulation est cliqué

            return $this->redirectToRoute('accueil');
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

            $manager->persist($brocante);
            $manager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('brocante/suggerer.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/brocante/consulter/{id}", name="brocante_show")
     *
     * @param Brocante        $brocante
     * @param Request         $request
     * @param ObjectManager   $manager
     * @param PlaceRepository $placeRepository
     * @param                 $id
     *
     * @return Response
     */
    public function show(Brocante $brocante, Request $request, ObjectManager $manager, PlaceRepository $placeRepository, $id)
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

        $form = $this->createForm(ParticipeType::class, $new_participe)
            ->add('place', ChoiceType::class, [
                'mapped'      => false,
                'placeholder' => "Choisissez le type de place que vous désirez",
                'choices'     => $choices,
                'choice_attr' => function ($choice, $key, $value) {
                    $explodeValue = explode("_", $value);

                    $nbPlacesDispo = $explodeValue[2];

                    if ($nbPlacesDispo == 0) {
                        return ['disabled' => 'disabled'];
                    } else {
                        return [];
                    }
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire à la brocante",
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->get('submit')->isClicked()) {
            if ($form["role_brocante"]->getData() === "Brocanteur") {
                $explodeValue = explode("_", $form["place"]->getData());

                $surface = $explodeValue[0];
                $prix = $explodeValue[1];

                $place = $placeRepository->findPlaceDispoByBrocanteAndSizeAndPrice($brocante, $surface, $prix);

                $place->setDisponible(false);
                $place->setUtilisateur($this->getUser());

                $manager->persist($place);
                $manager->flush();
            }

            $manager->persist($new_participe);
            $manager->flush();

            return $this->redirectToRoute('brocante_show', ['id' => $id]);
        }

        return $this->render('brocante/show.html.twig', [
            'brocante'        => $brocante,
            'nb_participants' => $nb_participants,
            'form'            => $form->createView(),
            'userParticipe'   => $userParticipe,
            'role'            => $role,
            'place'           => $place,
        ]);
    }

    /**
     * @Route("/brocante/consulter/dept/{villes_dep}/{page}", name="br_show_departement", defaults={"page": 1},
     *                                                        requirements={"page": "\d+"})
     * @param Villesfr $villes_dep
     * @param          $page
     *
     * @return Response
     */
    public function show_departement_brocantes($villes_dep, $page)
    {
        setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR@euro', 'fr_FR_', 'french'); // Conversions en FR

        $repo = $this->getDoctrine()->getRepository(Villesfr::class);
        $villes = $repo->findBy(['ville_departement' => $villes_dep]);

        $brocante = $this->getDoctrine()->getRepository(Brocante::class);

        $bb = $brocante->trouveParDepartement($villes_dep);

        dump($bb);

        // On créé le pager
        $adapter = new ArrayAdapter($bb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setCurrentPage($page);

        return $this->render('brocante/show_departement.html.twig', [
            'villes_dep' => $villes_dep,
            'villes'     => $villes,
            'pager'      => $pagerfanta,
        ]);
    }

    /**
     * @Route("/brocante/consulter/ville/{ville}/{page}", name="br_show_ville", defaults={"page": 1},
     *                                                        requirements={"page": "\d+"})
     * @param Villesfr $ville
     * @param          $page
     *
     * @return Response
     */
    public function show_ville_brocantes($ville, $page)
    {
        $repo = $this->getDoctrine()->getRepository(Villesfr::class);
        $villes = $repo->findBy(['ville_nom_reel' => $ville]);

        $brocante = $this->getDoctrine()->getRepository(Brocante::class);

        $bb = $brocante->trouveParVille($ville);

        // On créé le pager
        $adapter = new ArrayAdapter($bb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setCurrentPage($page);

        return $this->render('brocante/show_ville.html.twig', [
            'ville'     => $ville,
            'villes'    => $villes,
            'brocantes' => $bb,
            'pager'     => $pagerfanta,
        ]);
    }


    /**
     * @Route("/brocante/comment-organiser-brocante", name="comment_brocante")
     *
     * @return Response
     */
    public function comment_organiser_brocante()
    {
        return $this->render('aide/comment_brocante.html.twig');
    }

    /**
     * @Route("/brocante/quelle-difference-entre-brocante-vide-greniers", name="diff_brocante")
     *
     * @return Response
     */
    public function diff_brocante()
    {
        return $this->render('aide/diff_brocante.html.twig');
    }

    /**
     * @Route("/brocante/exposer-lors-d-un-vide-greniers-ce-que-dit-la-loi", name="loi_brocantes")
     *
     * @return Response
     */
    public function loi_brocantes()
    {
        return $this->render('aide/loi_brocantes.html.twig');
    }

}
