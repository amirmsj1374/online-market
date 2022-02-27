<?php

namespace Modules\Template\Interfaces;

use Modules\Template\Entities\Page;

interface PageRepositoryInterface {
    public function find($pageId);
}
