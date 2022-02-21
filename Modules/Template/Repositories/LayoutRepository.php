<?php

namespace Modules\Template\Repositories;

use Modules\Template\Entities\Page;
use Modules\Template\Interfaces\LayoutRepositoryInterface;

class LayoutRepository implements LayoutRepositoryInterface
{
   public function create(Page $page, $section_id, $col = null)
   {
        $order = $page->layouts->count() + 1;

        $page->layouts()->create([
            'section_id' => $section_id,
            'order'      => $order,
            'col'        => $col
        ]);
   }
}
