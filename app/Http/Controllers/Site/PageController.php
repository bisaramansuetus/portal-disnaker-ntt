<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PageController extends Controller
{
    public function profile()
    {
        $page = Post::published()->where('type', 'page')->where('slug', 'profil-dinas')->first();
        return view('site.pages.show', [
            'page' => $page,
            'pageTitle' => 'Profil Dinas',
        ]);
    }
}