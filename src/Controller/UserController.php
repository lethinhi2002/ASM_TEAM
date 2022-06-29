<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index",)
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'list' => $data
        ]);
    }

    /**
     * @Route("/create", name="app_user_create")
     */
    public function create(Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice','Submitted Successfully!!');

            return $this->redirectToRoute('user');
        }
        return $this->render('user/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, $id){

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice','Update Successfully!!');

            return $this->redirectToRoute('user');
        }
        return $this->render('user/update.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id){
        $data = $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        $this->addFlash('notice','Delete Successfully!!');

        return $this->redirectToRoute('user');
    }
}
