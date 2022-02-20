<?php

namespace Modules\Template\Interfaces;

use Modules\Template\Entities\Section;

interface ContentRepositoryInterface
{
    public function create(Section $section, $arrayOfContents);
}
