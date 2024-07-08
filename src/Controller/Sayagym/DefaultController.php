<?php

namespace App\Controller\Sayagym;

use App\Entity\Sayagym\Plan;
use App\Entity\Sayagym\User;
use App\Entity\Usergym;
use App\Form\Sayagym\PlanType;
use App\Form\Sayagym\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends AbstractController
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function index(): Response
    {
        return $this->render('Sayagym/Default/Index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('Sayagym/Default/User.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function register2(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new Usergym();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $textPassword = $form->get('password')->getData();
            $hasherPassword = $hasher->hashPassword(
                $user,
                $textPassword
            );
            $user->setPassword($hasherPassword);

            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('Sayagym/Default/User.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('Sayagym/Default/Login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    public function checkLogin(Request $request)
    {
        return $this->render('Sayagym/Default/Plan.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function redirectPlan(Request $request)
    {
        return $this->render('Sayagym/Default/CrearPlan.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    public function createPlan(Request $request): Response
    {
        $user = new Plan();
        $form = $this->createForm(PlanType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('planEnt');
        }

        return $this->render('Sayagym/Default/CrearPlan.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //error
    public function showPlan(): Response
    {
        $entityManager = $this->managerRegistry->getManagerForClass(Plan::class);
        $repository = $entityManager->getRepository(Plan::class);
        $plans = $repository->findAll();
        
        if (empty($plans)) {
            throw $this->createNotFoundException(
                'No se encontraron planes de entrenamiento.'
            );
        }
        
        return $this->render('Sayagym/Default/Plan.html.twig', [
            'plans' => $plans,
        ]);
    }
}