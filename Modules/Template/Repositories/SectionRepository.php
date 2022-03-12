<?php

namespace Modules\Template\Repositories;

use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Section;
use Modules\Template\Interfaces\SectionRepositoryInterface;

class SectionRepository implements SectionRepositoryInterface
{
    public function create($element_id, $title = null) {
        $section = Section::create([
            'element_id' => $element_id,
            'title' => $title,
        ]);

        return $section;
    }

    public function find($sectionId)
    {
        return Section::find($sectionId);
    }

    public function update($section, $data)
    {

        if (array_key_exists('title',  $data)) {
            $section->title = $data['title'];
        } elseif (array_key_exists('status',  $data)) {
            $section->title = $data['status'];
        }

        $section->save();

    }
}
