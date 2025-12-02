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
use Storage;

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

            $normalize = function ($value, bool $nullAsEmptyString = false) {
                if (is_string($value)) {
                    $value = trim($value);

                    if ($value === '' || strtolower($value) === 'null') {
                        return $nullAsEmptyString ? '' : null;
                    }

                    return $value;
                }

                if ($value === null) {
                    return $nullAsEmptyString ? '' : null;
                }

                return $value;
            };

            $about = $this->about->first() ?? new SiteAbout();

            if (array_key_exists('about_title', $data)) {
                $about->title = $normalize($data['about_title']);
            }

            if (array_key_exists('about_description', $data)) {
                $about->description = $normalize($data['about_description']);
            }

            $removeAboutImage = !empty($data['about_image_remove']);

            if (!empty($data['about_image'])) {
                if (!empty($about->image)) {
                    Storage::disk('public')->delete($about->image);
                }

                $file = $data['about_image'];
                $path = $file->store('site/about', 'public');
                $about->image = $path;
            } elseif ($removeAboutImage && !empty($about->image)) {
                Storage::disk('public')->delete($about->image);
                $about->image = null;
            }

            $about->save();

            $contact = $this->contatct->first() ?? new SiteContact();

            $fieldsMap = [
                'contact_phone' => 'phone',
                'contact_email' => 'email',
                'contact_city' => 'city',
                'contact_state' => 'state',
                'contact_address' => 'address',
                'contact_zipcode' => 'zipcode',
            ];

            foreach ($fieldsMap as $inputKey => $attr) {
                if (array_key_exists($inputKey, $data)) {
                    $contact->{$attr} = $normalize($data[$inputKey]);
                }
            }

            $contact->save();

            $main = $this->mainText->first() ?? new MainText();

            if (array_key_exists('main_title', $data)) {
                $main->title = $normalize($data['main_title']);
            }

            if (array_key_exists('main_text', $data)) {
                $main->text = $normalize($data['main_text']);
            }

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
                        'name' => $normalize($item['name'] ?? null, true),
                        'url' => $normalize($item['url'] ?? null, true),
                        'icon' => $normalize($item['icon'] ?? null, true),
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