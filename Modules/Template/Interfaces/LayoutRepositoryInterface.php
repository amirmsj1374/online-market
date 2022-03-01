<?php

namespace Modules\Template\Interfaces;

use Modules\Template\Entities\Page;

interface LayoutRepositoryInterface {
    public function create(Page $page, $section_id, $order, $col) ;
}
