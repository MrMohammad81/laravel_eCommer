<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tags\StoreRequest as CreateTadRequest;
use App\Models\Tag;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\Tags\UpdateRequest as UpdateTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(15);

        return view('admin.tags.index' , compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTadRequest $request)
    {
        $request->validated();

        $this->createTag($request);

        Alert::success('ایجاد تگ' , "تگ $request->name با موفقیت ثبت شد");

        return redirect()->route('admin.tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Tag $tag)
    {
        return view('admin.tags.show' , compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit' , compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $request->validated();

        $this->updateTag($request , $tag);

        Alert::success('بروزرسانی تگ' , "تگ $request->name با موفقیت بروزرسانی شد");

        return redirect()->route('admin.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        Alert::success('حذف تگ', "تگ $tag->name با موفقیت حذف شد");
        return redirect()->route('admin.tags.index');
    }

    private function createTag($request)
    {
        Tag::create(['name' => $request->name]);
    }

    private function updateTag($request , $tag)
    {
        $tag->update(['name' => $request->name]);
    }
}
