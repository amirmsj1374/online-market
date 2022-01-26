<?php

namespace Modules\Template\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\Page;
use Modules\Template\Entities\Template;

class ManagerController extends Controller
{
    public function getAllTemplates()
    {
        return response()->json([
            'templates' => Template::get()
        ], Response::HTTP_OK);
    }

    public function getPages(Template $template)
    {
        return response()->json([
            'pages' => $template->pages
        ], Response::HTTP_OK);
    }

    public function getElements(Page $page)
    {
        return response()->json([
            'elements' => $page->elements
        ], Response::HTTP_OK);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('template::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('template::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
