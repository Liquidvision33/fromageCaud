<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Images;
use App\Form\ArticlesFormType;
use App\Repository\ArticleRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/articles', name:'admin_articles_')]
class ArticlesController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response
    {
        return $this->render('admin/articles/index.html.twig');
    }

    #[Route('/add', name:'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger,
                        PictureService $pictureService): Response
    {
        $article = new Article();

        $articleForm = $this->createForm(ArticlesFormType::class, $article);

        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            // Vérifie si une image a été téléchargée
            $images = $articleForm->get('images')->getData();
            if (empty($images)) {
                $this->addFlash('error', 'Veuillez sélectionner une image.');
                return $this->redirectToRoute('admin_articles_add'); // Redirige vers le formulaire d'ajout
            }

            foreach($images as $image){
                $folder = 'article';

                $file = $pictureService->add($image, $folder, 300, 300);

                $img = new Images();
                $img->setName($file);
                $article->addImage($img);
            }

            $slug = $slugger->slug($article->getName());
            $article->setSlug($slug);

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            return $this->redirectToRoute('admin_articles_index');
        }

        return $this->render('admin/articles/add.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    #[Route('/edit/{id}', name:'edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $em,
                         SluggerInterface $slugger, PictureService $pictureService): Response
    {
        $articleForm = $this->createForm(ArticlesFormType::class, $article);

        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            // Vérifie si une image a été téléchargée
            $images = $articleForm->get('images')->getData();
            foreach($images as $image) {
                $folder = 'article';

                $file = $pictureService->add($image, $folder, 300, 300);

                $img = new Images();
                $img->setName($file);
                $article->addImage($img);
            }

            $slug = $slugger->slug($article->getName());
            $article->setSlug($slug);

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès');

            return $this->redirectToRoute('admin_articles_index');
        }

        return $this->render('admin/articles/edit.html.twig', [
            'articleForm' => $articleForm->createView(),
            'article' => $article,
        ]);
    }

    #[Route('/delete/{id}', name:'delete')]
    public function delete(Article $article, ArticleRepository $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $article);

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_articles_delete', ['id' => $article->getId()]))
            ->setMethod('POST')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // L'utilisateur a confirmé la suppression, supprimer l'article
            $em->remove($article, true);

            $this->addFlash('success', 'Produit supprimé avec succès');

            return $this->redirectToRoute('admin_articles_index');
        }

        return $this->render('admin/articles/delete.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/images/{id}', name:'delete_image', methods: ['DELETE'])]
    public function deleteImage(Images $image, Request $request, EntityManagerInterface $em,
                                PictureService $pictureService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])){

            $nom = $image->getName();

            if($pictureService->delete($nom, 'article', 300, 300)){
                $em->remove($image);
                $em->flush();

                return  new JsonResponse(['success' => true], 200);
            }

            return  new JsonResponse(['error' => 'Erreur de suppression'], 400);
        }

        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
