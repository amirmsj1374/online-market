<?php

namespace Modules\Template\Interfaces;

use Modules\Template\Entities\Element;

interface SectionRepositoryInterface
{
    public function create(Element $element);
}
