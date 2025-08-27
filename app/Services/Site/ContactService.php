<?php

namespace App\Services\Site;

use App\Repositories\Site\ContactRepository;
use App\Utils\Formatter;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getAll()
    {
        return $this->contactRepository->all();
    }

    public function find($id)
    {
        return $this->contactRepository->find($id);
    }

    public function create($data)
    {
        $dataContact = [
            "phone" => Formatter::onlyNumbers($data['phone']),
            "email" => $data['email'],
            "city" => $data['city'],
            "state" => $data['state'],
            "address" => $data['address'],
            "zipcode" => Formatter::onlyNumbers($data['zipcode']),
        ];

        return $this->contactRepository->create($dataContact);
    }

    public function update($id, $data)
    {
        return $this->contactRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->contactRepository->delete($id);
    }
}
