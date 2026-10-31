<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Models\Post;
use App\Models\Program;
use Illuminate\Support\Collection;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = new Collection();

        // Halaman statis
        $urls->push(['loc' => route('home'), 'priority' => '1.0', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.profile'), 'priority' => '0.8', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.posts.index'), 'priority' => '0.9', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.announcements.index'), 'priority' => '0.9', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.jobs.index'), 'priority' => '0.9', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.programs.index'), 'priority' => '0.8', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.transmigrasi.index'), 'priority' => '0.7', 'lastmod' => now()]);
        $urls->push(['loc' => route('site.contact'), 'priority' => '0.5', 'lastmod' => now()]);

        // Konten dinamis
        Post::published()->whereIn('type', ['berita', 'pengumuman'])->get()->each(function ($p) use ($urls) {
            $urls->push(['loc' => route('site.posts.show', $p->slug), 'priority' => '0.7', 'lastmod' => $p->updated_at]);
        });

        JobVacancy::active()->get()->each(function ($j) use ($urls) {
            $urls->push(['loc' => route('site.jobs.show', $j->slug), 'priority' => '0.7', 'lastmod' => $j->updated_at]);
        });

        Program::published()->get()->each(function ($p) use ($urls) {
            $urls->push(['loc' => route('site.programs.show', $p->slug), 'priority' => '0.6', 'lastmod' => $p->updated_at]);
        });

        return response()->view('site.sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}