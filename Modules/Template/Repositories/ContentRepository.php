<?php

namespace Modules\Template\Repositories;

use Modules\Template\Entities\Section;
use Modules\Template\Interfaces\ContentRepositoryInterface;

class ContentRepository implements ContentRepositoryInterface
{
    public function createMultipleContents(Section $section, $arrayOfContents) {
        foreach ($arrayOfContents as $item) {
            $content = $section->contents()->create([
                'body'        => $item['body'] ?? null,
                'buttonLabel' => $item['buttonLabel'] ?? null,
                'customClass' => $item['customClass'] ?? null,
                'col'         => $item['col'] ?? null,
                'height'      => $item['height'] ?? null,
                'link'        => $item['link'] ?? null,
                'order'       => $item['order'] ?? null,
                'section_id'  => $item['section_id'] ?? null,
                'time'        => $item['time'] ?? null,
                'type'        => $item['type'] ?? null,
            ]);

            if ($item['image']) {
                $content->addMedia(public_path(str_replace(config('app.url'), '', $item['image'])))
                    ->toMediaCollection('content');
            }
        }
    }

    public function createContent(Section $section, $data)
    {
        $content = $section->contents()->create([
            'categories'  => array_key_exists('categories',  $data) && $data['categories'] && !empty($data['categories']) ? $data['categories'] : null,
            'col'         => array_key_exists('col',  $data)  && $data['col'] ?? null,
            'products'    => array_key_exists('products',  $data)  && $data['products'] && !empty($data['products']) ? $data['products'] : null,
        ]);

        if (array_key_exists('image',  $data) && $data['image']) {
            $content->addMedia(public_path(str_replace(config('app.url'), '', $data['image'])))
                ->toMediaCollection('content');
        }
    }
}
