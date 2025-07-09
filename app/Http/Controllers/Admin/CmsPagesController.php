<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CmsPagesController extends Controller
{
    public function index(){
        $cmsPages = CmsPage::orderByDesc('id')->paginate(10);

        return view('admin.cms-pages.index', compact('cmsPages'));
    }

    public function create(){
        return view('admin.cms-pages.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
        ]);

        CmsPage::create($request->all());

        return redirect()->route('admin.cms-pages.index')->with('success', 'CMS Page created successfully.');
    }

    public function edit(CmsPage $cmsPage){
        return view('admin.cms-pages.edit', compact('cmsPage'));
    }

    public function update(Request $request, CmsPage $cmsPage) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $cmsPage->update($request->all());

        return redirect()->route('admin.cms-pages.index')->with('success', 'CMS Page updated successfully.');
    }

    public function destroy(CmsPage $cmsPage) {
        $cmsPage->delete();

        return redirect()->route('admin.cms-pages.index')->with('success', 'CMS Page deleted successfully.');
    }
}
