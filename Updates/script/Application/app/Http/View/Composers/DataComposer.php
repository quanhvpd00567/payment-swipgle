<?php

namespace App\Http\View\Composers;

use App\Models\Message;
use App\Models\Page;
use DB;
use Illuminate\View\View;

class DataComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */

    // Get website data from database
    public function compose(View $view)
    {
        // Get website settings
        $settings = DB::table('settings')->where('id', 1)->first();
        // Get all pages
        $pages = Page::orderbyDesc('id')->get();
        // Get footer pages
        $footer_pages = Page::where('place', 2)->orderbyDesc('id')->get();
        // Get menu pages
        $menu_pages = Page::where('place', 1)->orderbyDesc('id')->get();
        // Get unread messages count
        $messages_count = Message::where('status', 1)->count();
        // Get seo data
        $seo = DB::table('seo')->find(1);
        $view->with([
            'settings' => $settings,
            'pages' => $pages,
            'footer_pages' => $footer_pages,
            'menu_pages' => $menu_pages,
            'messages_count' => $messages_count,
            'seo' => $seo,
        ]);
    }
}
