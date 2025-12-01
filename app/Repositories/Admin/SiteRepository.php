<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SiteRepositoryInterface;
use App\Models\Site\MainText;
use App\Models\Site\SiteAbout;
use App\Models\Site\SiteCarousel;
use App\Models\Site\SiteContact;
use App\Models\Site\SiteLogo;
use App\Models\Site\SiteSocialMedia;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class SiteRepository implements SiteRepositoryInterface
{
    public $mainText;
    public $about;
    public $carousel;
    public $contatct;
    public $logo;
    public $socialMedia;

    public function __construct(MainText $mainText, SiteAbout $about, SiteCarousel $carousel, SiteContact $contatct, SiteLogo $logo, SiteSocialMedia $socialMedia)
    {
        $this->mainText = $mainText;
        $this->about = $about;
        $this->carousel = $carousel;
        $this->contatct = $contatct;
        $this->logo = $logo;
        $this->socialMedia = $socialMedia;
    }

    public function all()
    {

        $main = $this->mainText->first();
        $about = $this->about->first();
        $carousel = $this->carousel->get();
        $contatct = $this->contatct->first();
        $logo = $this->logo->first();
        $socialMedia = $this->socialMedia->get();

        try {

            return [
                'main' => $main,
                'about' => $about,
                'carousel' => $carousel,
                'contatct' => $contatct,
                'logo' => $logo,
                'socialMedia' => $socialMedia,
            ];

        } catch (Exception $err) {
            Log::error('Erro ao listar registros Site', [$err->getMessage()]);
            return false;
        }
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {

            $about = $this->about->first() ?? new SiteAbout();
            $about->title = $data['about_title'] ?? $about->title;
            $about->description = $data['about_description'] ?? $about->description;

            if (!empty($data['about_image'])) {
                $file = $data['about_image'];
                $path = $file->store('site/about', 'public');
                $about->image = $path;
            }

            $about->save();

            $logo = $this->logo->first() ?? new SiteLogo();

            if (!empty($data['logo_image'])) {
                $file = $data['logo_image'];
                $path = $file->store('site/logo', 'public');
                $logo->image = $path;
            }

            $logo->save();

            $contact = $this->contatct->first() ?? new SiteContact();

            $contact->phone = $data['contact_phone'] ?? $contact->phone;
            $contact->email = $data['contact_email'] ?? $contact->email;
            $contact->city = $data['contact_city'] ?? $contact->city;
            $contact->state = $data['contact_state'] ?? $contact->state;
            $contact->address = $data['contact_address'] ?? $contact->address;
            $contact->zipcode = $data['contact_zipcode'] ?? $contact->zipcode;

            $contact->save();

            $main = $this->mainText->first() ?? new MainText();

            $main->title = $data['main_title'] ?? $main->title;
            $main->text = $data['main_text'] ?? $main->text;

            $main->save();

            $oldIds = [];

            if (isset($data['carousel_old'])) {
                $oldIds = is_array($data['carousel_old']) ? $data['carousel_old'] : [$data['carousel_old']];
            }

            if (!empty($oldIds)) {
                $this->carousel->whereNotIn('id', $oldIds)->delete();
            } else {
                $this->carousel->query()->delete();
            }

            if (isset($data['carousel_new'])) {
                $newFiles = is_array($data['carousel_new']) ? $data['carousel_new'] : [$data['carousel_new']];

                foreach ($newFiles as $file) {
                    if (!$file) {
                        continue;
                    }

                    $path = $file->store('site/carousel', 'public');

                    $this->carousel->newQuery()->create([
                        'image' => $path,
                    ]);
                }
            }

            $social = [];

            if (!empty($data['social'])) {
                $social = json_decode($data['social'], true) ?: [];
            }

            $this->socialMedia->query()->delete();

            if (is_array($social)) {
                foreach ($social as $item) {
                    $this->socialMedia->newQuery()->create([
                        'name' => $item['name'] ?? '',
                        'url' => $item['url'] ?? '',
                        'icon' => $item['icon'] ?? '',
                    ]);
                }
            }

            DB::commit();

            return $this->all();
        } catch (Exception $err) {
            DB::rollBack();
            Log::error('Erro ao salvar registros Site', [$err->getMessage()]);
            return false;
        }
    }
}