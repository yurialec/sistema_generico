<?php

namespace App\Repositories\Site;

use App\Interfaces\Site\LogoRepositoryInterface;
use App\Models\Site\SiteLogo;
use Exception;
use Log;
use Storage;

class LogoRepository implements LogoRepositoryInterface
{
    protected $logo;

    public function __construct(SiteLogo $logo)
    {
        $this->logo = $logo;
    }

    public function getLogo()
    {
        try {
            return $this->logo->first();
        } catch (Exception $err) {
            Log::error('Erro ao localizar logo', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            $logo = $this->logo->find($id);

            return [
                'id' => $logo->id,
                'name' => $logo->name,
                'image' => $logo->image,
                'imageUrl' => asset('storage/' . $logo->image),
            ];
        } catch (Exception $err) {
            Log::error('Erro ao localizar logo', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->logo->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar logo', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {

            $logo = $this->logo->find($id);
            if (isset($logo->image)) {
                Storage::disk('public')->delete($logo->image);
            }

            if (isset($data['image'])) {
                $image = $data['image'];
                $data['image_urn'] = $image->store('site/logo/images', 'public');
            } else {
                unset($data['image_urn']);
            }

            $logo = $this->logo->find($id);

            $updateData = [
                'name' => $data['name'],
            ];

            if (isset($data['image_urn'])) {
                $updateData['image'] = $data['image_urn'];
            }

            $logo->update($updateData);

            return $logo;

        } catch (Exception $err) {
            Log::error('Erro ao editar logo', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $logo = $this->logo->find($id);

            if (isset($logo->image)) {
                Storage::disk('public')->delete($logo->image);
            }

            $logo->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao deletar logo', [$err->getMessage()]);
            return false;
        }
    }
}
