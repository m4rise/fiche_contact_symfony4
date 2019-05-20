<?php

namespace App\Notifications;

use App\Entity\Contact;
use App\Repository\DepartmentRepository;
use Swift_Mailer;
use Swift_Message;

class ContactManager
{

    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    public function __construct(Swift_Mailer $mailer, DepartmentRepository $departmentRepository)
    {
        $this->mailer = $mailer;
        $this->departmentRepository = $departmentRepository;
    }

    public function sendEmailToDepartmentManagers(Contact $contact)
    {
        $dept = $this->departmentRepository->find($contact->getDepartment()->getId());
        $managers = [];
        foreach ($dept->getManager()->getValues() as $manager) {
            $managers[] = $manager->getEmail();
        }

        $message = new Swift_Message('Message de '.$contact->getFirstname().' '.$contact->getLastname().' au département '.$contact->getDepartment()->getDepartment());
        $message
            ->setFrom($contact->getEmail())
            ->setTo($managers)
            ->setReplyTo($contact->getEmail())
            ->setBody($contact->getMessage());
        $this->mailer->send($message);
    }
}