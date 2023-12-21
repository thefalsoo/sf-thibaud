<?php

namespace App\Controller;

use App\Entity\Outils;
use App\Entity\Tag;
use App\Form\OutilsType;
use App\Form\TagsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/admin', name: 'login_check')]
    public function login(Request $request, KernelInterface $kernel): Response
    {
        // Chargement des variables d'environnement
        $dotenv = new Dotenv();
        $dotenv->load($kernel->getProjectDir() . '/.env');

        $correctPassword = $_ENV['PASSWORD']; // Remplacez PASSWORD par le nom de votre variable d'environnement

        if ($request->isMethod('POST')) {
            $password = $request->request->get('_password');

            if ($password === $correctPassword) {

                return $this->redirectToRoute('app_admin');
            }
        }

        return $this->render('/admin/login.html.twig');
    }

    #[Route('/admin/tool', name: 'app_admin')]
    public function index(): Response
    {
        $outils = $this->entityManager->getRepository(Outils::class)->findAll();

        return $this->render('admin/tool/index.html.twig', [
            'outils' => $outils,
        ]);
    }

    #[Route('/admin/tool/new', name: 'app_new_tool')]
    public function newTool(Request $request): Response
    {
        $outil = new Outils();
        $outil->setDateDePublication(new \DateTime());

        $form = $this->createForm(OutilsType::class, $outil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($outil);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/tool/newTool.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/tool/edit/{id}', name: 'app_edit_tool')]
    public function editTool(int $id, Request $request): Response
    {
        $outil = $this->entityManager->getRepository(Outils::class)->find($id);
        $outil->setDateDeModification(new \DateTime());

        $form = $this->createForm(OutilsType::class, $outil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($outil);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }


        return $this->render('admin/tool/editTool.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/tool/delete/{id}', name: 'app_delete_tool')]
    public function deleteTool(int $id): Response
    {
        $outil = $this->entityManager->getRepository(Outils::class)->find($id);

        if (!$outil) {
            throw $this->createNotFoundException('Outil non trouvé');
        }

        $this->entityManager->remove($outil);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/tool/description/{id}', name: 'app_description_tool')]
    public function descriptionTool(int $id): Response
    {
        $outil = $this->entityManager->getRepository(Outils::class)->find($id);
        if (!$outil) {
            throw $this->createNotFoundException('Outil non trouvé');
        }

        return $this->render('admin/tool/descriptionTool.html.twig', [
            'outil' => $outil,
        ]);
    }

    #[Route('/admin/tag', name: 'app_tag')]
    public function tag(Request $request): Response
    {
        $tags = new Tag();

        $form = $this->createForm(TagsType::class, $tags);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($tags);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_tag');
        }

        $tagsList = $this->entityManager->getRepository(Tag::class)->findAll();

        return $this->render('admin/tag/index.html.twig', [
            'tagsList' => $tagsList,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/tag/delete/{id}', name: 'app_delete_tag')]
    public function deleteTag(int $id): Response
    {
        $tag = $this->entityManager->getRepository(Tag::class)->find($id);

        if (!$tag) {
            throw $this->createNotFoundException('Tag non trouvé');
        }

        $this->entityManager->remove($tag);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_tag');
    }
}
