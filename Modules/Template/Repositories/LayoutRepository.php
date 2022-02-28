<?php

namespace Modules\Template\Repositories;

use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Page;
use Modules\Template\Interfaces\LayoutRepositoryInterface;

class LayoutRepository implements LayoutRepositoryInterface
{
   public function create(Page $page, $section_id, $col = 12)
   {
        $row    = $page->layouts->groupBy('row')->keys()->count() + 1;
        $order =$page->layouts->count()+ 1;
        Log::info([
            'order' => $order,
            'first()' => $page->layouts->last()
        ]);
        $page->layouts()->create([
            'section_id' => $section_id,
            'order'      => $order,
            'row'        => $row,
            'col'        => $col
        ]);
   }
}
