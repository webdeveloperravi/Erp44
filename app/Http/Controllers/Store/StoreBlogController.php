<?php

namespace App\Http\Controllers\store;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Front\Blog_Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Store\blogs\BlogCategory;
use Illuminate\Support\Facades\Storage;
use App\Model\Admin\Master\ProductCategory;

class StoreBlogController extends Controller
{



    function getStoreAllBlogs()
    {

        $result['blogs'] =  Blog_Post::all();


        return view('store.blog.list_all_blogs', $result);
    }



    function create_new_post(Request $request)
    {
        dd($request->all());
        if ($request->hasFile('f_img')) {
            $f_img = $request['f_img'];
        } elseif ($request->hasFile('f_img_m')) {
            $f_img = $request['f_img_m'];
        } else {
        }


        if (isset($f_img)) {
            $imgSlug = basename($f_img->store('/public/uploads/blog_featured_imgs'));
            $request['featured_img'] = $imgSlug;
        }

        $slug = Str::random(10);
        $request['userid'] = Auth::guard('store')->id();
        $request['slug'] = $slug;
        $request['permalink'] = request()->root() . "/blog/" . $request['category_id'] . "/view_blog/" . $slug . "/" . $request['title'];

        if ($request['action'] == 'Save and Publish') {
            $request['publish'] = 1;
            $post = Blog_Post::create($request->all());

            Blog_Post::where('id', $post->id)->update(['permalink' => $request['permalink']]);

            if ($post->id) {
                return redirect()->route('store.allblogs')->with('message', 'Post saved and published successfully');
            } else {
                return redirect()->route('store.allblogs')->with('message', 'Error while saving post ');
            }
        } else {
            $request['publish'] = 0;
            $post = Blog_Post::create($request->all());

            if ($post->id) {
                return redirect()->route('store.allblogs')->with('message', 'post saved as draft successfully');
            } else {
                return redirect()->route('store.allblogs')->with('message', 'Error while saving post');
            }
        }
    }

    function getRelatedPosts($cat_id)
    {
        $result = Blog_Post::with(['users', 'comments'])->where('category_id', $cat_id)->get()->take(10);
        return $result;
    }

    function post_details($category, $slug)
    {

        $result['post'] = Blog_Post::with(['users', 'comments'])->where('slug', $slug)->first();
        $result['related_posts'] = $this->getRelatedPosts($category);
        $result['comments'] = $result['post']->comments();
        return view('front.post_details', $result);
    }

    function getBlogCategories()
    {
        $result['allCats'] = BlogCategory::all();
        // dd($result);

        return view('store.blog.blog_categories_list', $result);
    }

    function updateCatStatus($cat_id, $update_to)
    {
        $res = BlogCategory::find($cat_id)->update(['status' => $update_to]);
        if ($res) {
            return back()->with('message', 'category status updated successfully ');
        } else {
            return back()->with('message', 'error while updating category status');
        }
    }


    function deleteCat($cat_id)
    {
        $flag = BlogCategory::find($cat_id)->delete();
        if ($flag) {
            return back()->with('message', 'category deleted successfully ');
        } else {
            return back()->with('message', 'error while deleting category');
        }
    }

    function createCat(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alias' => 'required',
            'status' => 'required',
        ]);
        // dd($request->except('_token'));
        $new_cat = BlogCategory::create($request->all());
        if ($new_cat->id) {
            return redirect()->route('store.blog_list_all_cats')->with('message', 'category created successfully ');
        } else {
            return redirect()->route('store.blog_list_all_cats')->with('message', 'error while creating category');
        }
    }

    function editCat($cat_name, $cat_id)
    {
        $res['cat'] = BlogCategory::find($cat_id);
        return view('store.blog.edit_category', $res);
    }


    function editCatPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alias' => 'required',
            'status' => 'required',
        ]);

        $flag = BlogCategory::find($request->id)->fill($request->all())->save();
        // dd($updated_cat);
        if ($flag) {
            return redirect()->route('store.blog_list_all_cats')->with('message', 'category updated successfully ');
        } else {
            return redirect()->route('store.blog_list_all_cats')->with('message', 'error while updating category');
        }
    }

    function blogDelete($id)
    {
        $d_flag = Blog_Post::find($id)->delete();
        if ($d_flag) {
            return back()->with('message', 'Post deleted successfully');
        } else {
            return back()->with('message', 'Post not deleted successfully');
        }
    }

    function toggleBlogStatus($blog_id, $update_to)
    {
        // dd($update_to);
        $blog = Blog_Post::find($blog_id)->fill(['publish' => $update_to])->save();

        if ($blog) {
            return back()->with('message', 'Blog status changed successfully ');
        } else {
            return back()->with('message', 'error while updating blog status');
        }
    }

    function blogEdit($id)
    {
        $result['post'] = Blog_Post::with('category')->where('id', $id)->get()->toArray()[0];
        return view('store.blog.edit_post', $result);
    }

    function updatepost(Request $request)
    {
        // dd($request->all());

        if ($request->hasFile('f_img')) {
            $f_img = $request['f_img'];
        } elseif ($request->hasFile('f_img_m')) {
            $f_img = $request['f_img_m'];
        } else {
            //
        }

        if (isset($f_img)) {
            $post = Blog_Post::find($request['postid']);
            Storage::delete('public/uploads/blog_featured_imgs/' . $post['featured_img']);
            $img_slug = basename($f_img->store('/public/uploads/blog_featured_imgs'));
            $request['featured_img'] = $img_slug;
        }

        $request['userid'] = Auth::guard('store')->id();

        if ($request['action'] == 'Update and Publish') {

            $request['publish'] = 1;
            $post = Blog_post::find($request['postid']);
            $flag = $post->fill($request->all())->save();
            if ($flag) {
                return redirect()->route('store.allblogs')->with('message', 'post updated and published successfully');
            } else {
                return redirect()->route('store.allblogs')->with('message', 'Error while updating post');
            }
        } elseif ($request['action'] == 'Update and make Draft') {

            $request['publish'] = 0;
            $post = Blog_post::find($request['postid']);
            $flag = $post->fill($request->all())->save();

            if ($flag) {
                return redirect()->route('store.allblogs')->with('message', 'post updated and saved as draft successfully');
            } else {
                return redirect()->route('store.allblogs')->with('message', 'Error while updating post');
            }
        } else {

            $post = Blog_post::find($request['postid']);
            $flag = $post->fill($request->all())->save();

            if ($flag) {
                return redirect()->route('store.allblogs')->with('message', 'post updated successfully');
            } else {
                return redirect()->route('store.allblogs')->with('message', 'Error while updating post');
            }
        }
    }
}
