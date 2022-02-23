<?php

namespace Modules\Template\Repositories;

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
}
