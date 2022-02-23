<?php

namespace Modules\Template\Interfaces;

use Modules\Template\Entities\Section;

interface ContentRepositoryInterface
{
    public function createMultipleContents(Section $section, $arrayOfContents);
    public function createContent(Section $section, $data);
}
