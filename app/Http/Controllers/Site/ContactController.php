<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;

class ContactController extends Controller
{
    public function index()
    {
        $faq = Post::published()->where('type', 'page')->where('slug', 'faq')->first();
        return view('site.contact', compact('faq'));
    }
}