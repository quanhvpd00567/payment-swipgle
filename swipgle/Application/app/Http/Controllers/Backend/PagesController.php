<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    // View pages page
    public function index()
    {
        // Get pages data
        $pages = Page::orderbyDesc('id')->get();
        return view('backend.pages', ['pages' => $pages]);
    }

    // View add page
    public function add_page()
    {
        return view('backend.add.page');
    }

    // Store add page
    public function add_page_store(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:100', 'unique:pages'],
            'place' => ['required', 'numeric'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // check show in
        if ($request->place != 1 && $request->place != 2) {
            return redirect()->back()->withErrors(['You can show it only in menu or in footer']);
        }

        // Create new page
        $page = Page::create([
            'title' => $request->title,
            'slug' => str_replace(' ', '-', $request->slug),
            'content' => $request->content,
            'place' => $request->place,
        ]);

        // if created
        if ($page) {
            // Back with success message
            $request->session()->flash('success', 'Page added successfully');
            return redirect()->route('pages');
        } else {
            // Error response
            return redirect()->back()->withErrors(['Error please refresh page and try again']);
        }
    }

    // View edit page
    public function edit_page($id)
    {
        // Get page data
        $page = Page::where('id', $id)->first();
        // if data not null
        if ($page != null) {
            return view('backend.edit.page', ['page' => $page]);
        } else {
            // Abort 404 if data null
            return abort(404);
        }

    }

    // Store edit page
    public function edit_page_store(Request $request)
    {
        // Get page data
        $page = Page::where('id', $request->page_id)->first();
        // If page data is null
        if ($page != null) {
            // Validate null
            $validator = null;
            // If slug is the same validate without unique one
            if ($page->slug === $request->slug) {
                // Validate form
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string', 'max:50'],
                    'slug' => ['required', 'string', 'max:100'],
                    'place' => ['required', 'numeric'],
                ]);
            } else {
                // Validate form
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string', 'max:50'],
                    'slug' => ['required', 'string', 'max:100', 'unique:pages'],
                    'place' => ['required', 'numeric'],
                ]);
            }

            // Send errors to view page
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // check show in
            if ($request->place != 1 && $request->place != 2) {
                return redirect()->back()->withErrors(['You can show it only in menu or in footer']);
            }

            // update page
            $update = Page::where('id', $page->id)->update([
                'title' => $request->title,
                'slug' => str_replace(' ', '-', $request->slug),
                'content' => $request->content,
                'place' => $request->place,
            ]);

            // if update
            if ($update) {
                // Back with success message
                $request->session()->flash('success', 'Page updated successfully');
                return back();
            } else {
                // Error response
                return redirect()->back()->withErrors(['Error please refresh page and try again']);
            }
        } else {
            // Error response
            return response()->json([
                'error' => 'illegal request',
            ]);
        }
    }

    // Delete page
    public function delete_page($id)
    {
        // get page by id
        $page = Page::where('id', $id)->first();
        // if data not null
        if ($page != null) {
            // Delete page
            $delete = Page::where('id', $id)->delete();
            // if delete
            if ($delete) {
                // Back with success message
                session()->flash('success', 'Page deleted successfully');
                return back();
            } else {
                // Error response
                return redirect()->back()->withErrors(['Delete error please refresh page and try again']);
            }
        } else {
            // Error response
            return redirect()->back()->withErrors(['Delete error please refresh page and try again']);
        }
    }
}
