<?php

namespace App\Repositories\Site;

use App\Interfaces\Site\ContactRepositoryInterface;
use App\Models\Site\SiteContact;
use Exception;
use Log;

class ContactRepository implements ContactRepositoryInterface
{
    protected $contact;

    public function __construct(SiteContact $contact)
    {
        $this->contact = $contact;
    }

    public function all()
    {
        try {
            return $this->contact->first();
        } catch (Exception $err) {
            Log::error('Erro ao localizar informações de contato', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->contact->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar informações de contato', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->contact->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar informações de contato', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $contact = $this->contact->find($id);
            $contact->update($data);

            return $contact;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar informações de contato', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $contact = $this->contact->find($id);
            $contact->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar informações de contato', [$err->getMessage()]);
            return false;
        }
    }
}
