<?php

namespace App\Http\Controllers\Store;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Store\Pages\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{

    ####Pages####


    function getStoreAllPages()
    {

        $result['pages'] =  Page::all();


        return view('store.Pages.list_all_pages', $result);
    }

    function create_new_page(Request $request)
    {

        // dd($request->all());

        $page['title'] = $request['title'];
        $page['description'] = $request['description'];
        $page['meta_title'] = $request['meta_title'];
        $page['meta_desc'] = $request['meta_desc'];
        $page['featured_img_url'] = basename($request['f_img']->store('/public/uploads/page_featured_imgs'));
        $page['featured_img_alt'] = $request['featured_img_alt'];
        $page['content'] = $request['content'];
        $page['url_slug'] = $request['url_slug'];
        $page['permalink'] = request()->root() . "/page/" . $page['url_slug'];
        $page['category_id'] = $request['category_id'];
        $page['visibility'] = $request['visibility'];
        $page['parent_page_id'] = $request['parent_page_id'];
        $page['author_id'] = Auth::guard('store')->id();

        if ($request['action'] == 'Save and Publish') {
            $page['status'] = 1;
            $page = Page::create($page);

            if ($page->id) {
                return redirect()->route('store.all_pages')->with('message', 'page saved and published successfully');
            } else {
                return redirect()->route('store.all_pages')->with('message', 'Error while saving page ');
            }
        } else {
            $page['status'] = 0;
            $page = Page::create($page);

            if ($page->id) {
                return redirect()->route('store.all_pages')->with('message', 'page saved as draft successfully');
            } else {
                return redirect()->route('store.all_pages')->with('message', 'Error while saving page');
            }
        }
    }


    function getRelatedpages($cat_id)
    {
        $result = Page::with(['users', 'comments'])->where('category_id', $cat_id)->get()->take(10);
        return $result;
    }


 

    function pageDelete($id)
    {
        $d_flag = Page::find($id)->delete();
        if ($d_flag) {
            return back()->with('message', 'page deleted successfully');
        } else {
            return back()->with('message', 'page not deleted successfully');
        }
    }


    function togglePageVisibility($page_id, $update_to)
    {


        $page = Page::find($page_id)->fill(['visibility' => $update_to])->save();

        if ($page) {
            return back()->with('message', 'Page status changed successfully ');
        } else {
            return back()->with('message', 'error while updating page status');
        }
    }

    function togglePageStatus($page_id, $update_to)
    {


        $page = Page::find($page_id)->fill(['status' => $update_to])->save();

        if ($page) {
            return back()->with('message', 'Page status changed successfully ');
        } else {
            return back()->with('message', 'error while updating page status');
        }
    }

    function pageEdit($id)
    {
        $page = Page::find($id);

        return view('store.pages.edit_page', ['page' => $page]);
    }

    function updatepage(Request $request)
    {

        // dd($request->all());
        $page = Page::find($request['pageid']);
        $data['title'] = $request['title'];
        $data['description'] = $request['description'];
        $data['meta_title'] = $request['meta_title'];
        $data['meta_desc'] = $request['meta_desc'];
        if ($request->hasFile('f_img')) {
            $flag = Storage::delete('public/uploads/page_featured_imgs/' . $page['featured_img_url']);

            $data['featured_img_url'] = basename($request['f_img']->store('/public/uploads/page_featured_imgs'));
        }



        $data['featured_img_alt'] = $request['featured_img_alt'];
        $data['content'] = $request['content'];
        $data['url_slug'] = $request['url_slug'];
        $data['permalink'] = request()->root() . "/page/" . $data['url_slug'];
        $data['category_id'] = $request['category_id'];
        $data['visibility'] = $request['visibility'];
        $data['parent_page_id'] = $request['parent_page_id'];
        $data['author_id'] = Auth::guard('store')->id();




        if ($request['action'] == 'Update and Publish') {
            $data['status'] = 1;

            $flag = $page->fill($data)->save();
            if ($flag) {
                return redirect()->route('store.all_pages')->with('message', 'page updated and published successfully');
            } else {
                return redirect()->route('store.all_pages')->with('message', 'Error while updating page');
            }
        } elseif ($request['action'] == 'Update and make Draft') {

            $data['status'] = 0;

            $flag = $page->fill($data)->save();

            if ($flag) {
                return redirect()->route('store.all_pages')->with('message', 'page updated and saved as draft successfully');
            } else {
                return redirect()->route('store.all_pages')->with('message', 'Error while updating page');
            }
        } else {


            $flag = $page->fill($data)->save();

            if ($flag) {
                return redirect()->route('store.all_pages')->with('message', 'page updated successfully');
            } else {
                return redirect()->route('store.all_pages')->with('message', 'Error while updating page');
            }
        }
    }
}
