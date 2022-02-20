<?php

namespace Modules\Template\Repositories;

use Modules\Template\Entities\Section;
use Modules\Template\Interfaces\ContentRepositoryInterface;

class ContentRepository implements ContentRepositoryInterface
{
    public function create(Section $section, $arrayOfContents) {
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

            $content->addMedia(public_path(str_replace(config('app.url'), '', $item['image'])))
                ->toMediaCollection('content');
        }
    }
}
