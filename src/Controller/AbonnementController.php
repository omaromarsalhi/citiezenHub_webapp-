<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Transport;
use App\Form\AbonnementType;
use App\Form\TransportType;
use App\Repository\AbonnementRepository;
use App\Repository\TransportRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;




class AbonnementController extends AbstractController
{


    #[Route('/showAbonnement', name: 'show_abonnement')]
    public function afficherAbn(): Response
    {
        $abonnement = $this->getDoctrine()->getManager()->getRepository(Abonnement::class)->findAll();
        return $this->render('abonnement/showAbonnement.html.twig', [
            'l' => $abonnement
        ]);
    }

    #[Route('/showAbonnement/{id}', name: 'app_abonnement_delete', methods: ['DELETE'])]
    public function deleteAbonnement($id, AbonnementRepository $abonnementRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $abonnement = $abonnementRepository->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonnement);
            $em->flush();

            return new JsonResponse('Abonnement supprimé avec succès', Response::HTTP_OK);
        }

        // Handle non-AJAX request, if needed

        return new JsonResponse('This route accepts only AJAX requests', Response::HTTP_BAD_REQUEST);
    }

//    #[Route('/showAbonnement/{id}', name: 'app_transport_delete', methods: ['DELETE'])]
//    public function delete(ManagerRegistry $doctrine, $id, AbonnementRepository $abonnementRepository, Request $req): Response
//    {
//        if ($req->isXmlHttpRequest()) {
//            $auteur = $abonnementRepository->find($id);
//            $em = $doctrine->getManager();
//            $em->remove($auteur);
//            $em->flush();
//            return new Response('Transport supprimé avec succès', Response::HTTP_OK);
//        }
//        return $this->redirectToRoute('show_abonnement');
//    }

    #[Route('/TransportAdmin', name: 'adminTransport')]
    public function afficherTransport(): Response
    {
        // $abonnement=$this->getDoctrine()->getManager()->getRepository(Transport::class)->findAll();
        return $this->render('abonnement/Admin/Transport.html.twig', [
            //     'l' => $abonnement
        ]);
    }


//    public function addAbonnement(Request $request): Response
//    {
//        $abonnement = new Abonnement();
//        $form = $this->createForm(AbonnementType::class, $abonnement);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($abonnement);
//            $em->flush();
//            return $this->redirectToRoute('show_abonnement');
//        }
//        else{
//            return $this->render('abonnement/createAbonnement.html.twig',['f' => $form->createView()]);
//        }
//
//    }

//    #[Route('/addAbonnement', name: 'addAbonnement')]
//
//    public function addAbonnement(Request $request): Response
//    {
//        $abonnement = new Abonnement();
//        $form = $this->createForm(AbonnementType::class, $abonnement);
//        $form->handleRequest($request);
//        $fichierImage = $request->files->get('createinputfile');
//
//
//
//        if ($form->isSubmitted()) {
//            if ($form->isValid()) {
//
//
//                $abonnement->setImageFile($fichierImage);
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($abonnement);
//                $em->flush();
//
//                return $this->redirectToRoute('show_abonnement');
//            } else {
//                $errors = [];
//                foreach ($form->getErrors(true) as $error) {
//                    $errors[] = $error->getMessage();
//                }
//
//                return $this->render('abonnement/createAbonnement.html.twig', [
//                    'f' => $form->createView(),
//                    'errors' => $errors,
//                ]);
//            }
//        }
//
//        return $this->render('abonnement/createAbonnement.html.twig', [
//            'f' => $form->createView(),
//        ]);
//    }


// Your other use statements and controller class declaration
//
//
//
    #[Route('/formAbonnement', name: 'app_addAbonnement')]
    public function index( ): Response
    {

        return $this->render('abonnement/createAbonnement.html.twig');
    }
    #[Route('/addAbonnement', name: 'addAbonnement')]
    public function addAbonnement(Request $request,ManagerRegistry $doc): Response
    {
        if ($request->isXmlHttpRequest()) {
            $abonnement = new Abonnement();
            $Name=$request->get('name');
            $Lastname=$request->get('lastname');
            $Type=$request->get('type');
            $Image=$request->files->get('image');

            $abonnement->setNom($Name);
            $abonnement->setPrenom($Lastname);
            $abonnement->setTypeAbonnement($Type);
            $abonnement->setImageFile($Image);

            $em = $doc->getManager();
            $em->persist($abonnement);
            $em->flush();

            return new JsonResponse(['message' => $Image], Response::HTTP_OK);
        }

        else
            return new JsonResponse(['message' => 'Abonnement non envoye'], Response::HTTP_OK);
    }
}