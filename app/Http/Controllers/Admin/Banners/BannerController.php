<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Banners\StoreRequest as StoreBannerRequest;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Admin\Banners\UpdateRequest as UpdateBannerRequest;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(15);

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBannerRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->validated();

            $fileNameImage = generatiFileNameWithDate($request->image->getClientOriginalName());

            $request->image->move(public_path(env('BANNER_IMAGE_UPLOAD_PATCH')), $fileNameImage);

            $this->createBanner($request, $fileNameImage);

            DB::commit();

            Alert::success('ایجاد بنر', " بنر $request->title با موفقیت ایجاد شد. ");
            return redirect()->route('admin.banners.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در ایجاد بنر' , $exception->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit' , compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        try {

            DB::beginTransaction();

            $request->validated();

           if (!$request->has('image'))
           {
               $fileNameImage = '';
               $this->updateBanner($request , $banner , $fileNameImage);

               DB::commit();
               Alert::success('بروزرسانی بنر', " بنر $request->title با موفقیت بروزرسانی شد. ");
               return redirect()->route('admin.banners.index');
           }

            $fileNameImage = generatiFileNameWithDate($request->image->getClientOriginalName());
            $request->image->move(public_path(env('BANNER_IMAGE_UPLOAD_PATCH')), $fileNameImage);

            $this->updateBanner($request , $banner , $fileNameImage);

            DB::commit();

            Alert::success('بروزرسانی بنر', " بنر $request->title با موفقیت بروزرسانی شد. ");
            return redirect()->route('admin.banners.index');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            alert()->error('خطا در بروزرسانی بنر' , $exception->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        Alert::success('حذف بنر' , "بنر $banner->title با موفثیت حذف شد .");
        return redirect()->back();
    }

    private function createBanner($request , $imageName)
    {
        Banner::create([
            'image' => $imageName,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon,
        ]);
    }

    private function updateBanner($request , $banner , $imageName = null)
    {
        $banner->update([
            'image' => $request->has('image') ? $imageName : $banner->image,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon,
        ]);
    }
}
