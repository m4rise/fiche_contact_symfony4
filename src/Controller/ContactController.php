<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notifications\ContactManager;
use App\Repository\DepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     * @param Request $request
     * @param ContactManager $contactManager
     * @return Response
     */
    public function index(Request $request, ContactManager $contactManager, DepartmentRepository $departmentRepository)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactManager->sendEmailToDepartmentManagers($contact);
            $this->addFlash('success', 'Votre message a été correctement envoyé !');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}