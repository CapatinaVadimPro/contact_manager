<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/contacts')]

class ContactsController extends AbstractController
{
    #[Route('/', name: 'app_contacts_index', methods: ['GET', 'POST'])]
    public function list(ContactRepository $contactRepository): JsonResponse
    {
        $contractList = $contactRepository->getAll();
        return $this->json(
            $contractList,
            200
        );
    }

    #[Route('/{id}', name: 'app_contacts_get_one', methods: ['GET'])]
    public function getOne(ContactRepository $contactRepository, int $id): JsonResponse
    {
        $contact = $contactRepository->find($id);
        if (!$contact) {
            return $this->json(["message" => "Contact not found"], 404);
        }
        return $this->json($contact->toJson());
    }

    #[Route('/new', name: 'app_contacts_add', methods: ['POST'])]
    public function new(Request $request, ContactRepository $contactRepository): JsonResponse
    {
        $requestBody = [];
        if ($request->getContentType() === 'json') {
            $requestBody = json_decode($request->getContent(), true);

            $newContact = new Contact();
            $newContact->setFirstname($requestBody["firstname"]);
            $newContact->setLastname($requestBody["lastname"]);
            $newContact->setEmail($requestBody["email"]);
            $newContact->setPhone($requestBody["phone"]);
            $newContact->setAddress($requestBody["address"]);
            $newContact->setAge($requestBody["age"]);

            $contactRepository->save($newContact, true);

            return $this->json(['message' => 'contact added'], 200);
        }

        return $this->json([
            'message' => 'POST',
        ]);
    }

    #[Route('/{id}', name: 'app_contacts_update', methods: ['PUT'])]
    public function update(Request $request, ContactRepository $contactRepository, int $id): JsonResponse
    {
        $requestBody = [];
        if ($request->getContentType() === 'json') {
            $requestBody = json_decode($request->getContent(), true);

            $contact = $contactRepository->find($id);

            if (!$contact) {
                return $this->json(["message" => "Contact not found"], 404);
            }

            $contact->setFirstname($requestBody["firstname"]);
            $contact->setLastname($requestBody["lastname"]);
            $contact->setEmail($requestBody["email"]);
            $contact->setPhone($requestBody["phone"]);
            $contact->setAddress($requestBody["address"]);
            $contact->setAge(intval($requestBody["age"]));

            $contactRepository->save($contact, true);

            return $this->json(['message' => 'contact updated'], 200);
        }

        return $this->json([
            'message' => 'POST',
        ]);
    }

    #[Route('/{id}', name: 'app_contacts_delete', methods: ['DELETE'])]
    public function delete(ContactRepository $contactRepository, int $id): JsonResponse
    {

        $contact = $contactRepository->find($id);
        if (!$contact) {
            return $this->json(["message" => "Contact not found"], 404);
        }
        $contactRepository->remove($contact, true);
        return $this->json(["message" => "Contact removed"]);
    }
}
