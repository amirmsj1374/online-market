<?php

namespace Modules\Website\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\Content;
use Modules\Template\Entities\Footer;
use Modules\Template\Entities\Template;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // dd(Content::find(83)->toArray());
        // dd(Content::find(83)->getFirstMedia('content')->getFullUrl());
        $template = Template::where('selected', 1)->first();
        $page = $template->pages()->orWhere('name', 'home')->orWhere('name', 'index')->first();
        $layouts = $page->layouts()->orderBy('row')->get()->groupBy('row')->map(function ($q) {
            return $q->map(function ($sec) {
                $data['row'] = $sec->row;
                $data['col'] = $sec->col;
                $data['type'] = $sec->section->element->type;
                $data['contents'] = $sec->section->contents->toArray();
                return $data;
            });
        });

        $footer = Footer::first();
        return view('website::' . $template->name . '.pages.index', compact('template', 'layouts', 'footer'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('website::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('website::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('website::edit');
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