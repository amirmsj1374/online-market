<?php

namespace Modules\Template\Repositories;

use Modules\Template\Entities\Element;
use Modules\Template\Interfaces\SectionRepositoryInterface;

class SectionRepository implements SectionRepositoryInterface
{
    public function create(Element $element) {
        $section = $element->sections()->create([
            'title' => $element->label,
        ]);

        return $section;
    }
}
