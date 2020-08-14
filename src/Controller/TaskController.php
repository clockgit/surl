<?php
namespace App\Controller;

use App\Entity\ShortUrl;
use App\Form\NewShortUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{
  /**
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   * @Route("/")
   */
  public function new(Request $request)
  {
    // creates a task object and initializes some data for this example
    $task = new ShortUrl();

    $form = $this->createForm(NewShortUrl::class, $task);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $task = $form->getData();
      // save to db using doctrine
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($task);
      $entityManager->flush();
      // redirect user to /view/{short}
      return $this->redirectToRoute('url_show',['short' => $task->getShort()]);
    }

    return $this->render('new.html.twig', [
      'form' => $form->createView(),
    ]);
  }

/*
 * @Route("/view/{id}", name="url_show")

  public function show($id)
  {
    $shortUrl = $this->getDoctrine()
      ->getRepository(ShortUrl::class)
      ->find($id);

    if (!$shortUrl) {
      throw $this->createNotFoundException(
        'No url found for id ' . $id
      );
    }

    //return new Response('change to a template: ' . $shortUrl->getUrl());
    return $this->render('view.html.twig', ['shortUrl' => $shortUrl]);
  }*/

  /**
   * @Route("/view/{short}", name="url_show")
   */
  public function showByShort($short)
  {
    $shortUrl = $this->getDoctrine()
      ->getRepository(ShortUrl::class)
      ->findByShort($short);

    if (!$shortUrl) {
      throw $this->createNotFoundException(
        'No url found for code ' . $short
      );
    }

    //return new Response('change to a template: ' . $shortUrl->getUrl());
    return $this->render('view.html.twig', ['shortUrls' => $shortUrl]);
  }

  /**
   * @Route("/stats", name="stats")
   */
  public function stats()
  {
    $list = $this->getDoctrine()
      ->getRepository(ShortUrl::class)
      ->findAll();

    if (!$list) {
      throw $this->createNotFoundException(
        'No short URL\'s found'
      );
    }

    //return new Response('change to a template: ' . $shortUrl->getUrl());
    return $this->render('stats.html.twig', ['shortUrls' => $list]);
  }

  /**
   * @Route("/{short}", name="url_go")
   * @param $short
   * @return Response
   */
  public function go($short)
  {
    $shortUrl = $this->getDoctrine()
      ->getRepository(ShortUrl::class)
      ->findOneByShort($short);

    if (!$shortUrl) {
      throw $this->createNotFoundException(
        'No url found for code: ' . $short
      );
    }

    $entityManager = $this->getDoctrine()->getManager();
    $shortUrl->setCount($shortUrl->getCount() + 1);
    $entityManager->persist($shortUrl);
    $entityManager->flush();

    return $this->redirect($shortUrl->getUrl());
  }
}
