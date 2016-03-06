<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\News\NewsRepositoryInterface;
use App\Repositories\Slide\SlideRepositoryInterface;
use Illuminate\Http\Request;
use Permission;
use Sentinel;
use TableList;
use Validation;

class HomeController extends Controller
{

    private $news;
    private $slide;

    /**
     * Create a new home controller instance.
     *
     * @return void
     */
    public function __construct(NewsRepositoryInterface $news, SlideRepositoryInterface $slide)
    {
        parent::__construct();
        $this->news = $news;
        $this->slide = $slide;
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        // we check the current user permission
        if (!Permission::hasPermission('home.view')) {
            return redirect()->route('dashboard.index');
        }

        // SEO Meta settings
        $this->seoMeta['page_title'] = trans('seo.back.home.edit');

        // we define the slides table list columns
        $columns = [
            [
                'title' => trans('home.page.label.slide.background_image'),
                'key'   => 'background_image',
                'image' => [
                    'storage_path' => $this->slide->getModel()->storagePath(),
                    'size'         => [
                        'thumbnail' => 'admin',
                        'detail'    => '767',
                    ],
                ],
            ], [
                'title' => trans('home.page.label.slide.picto'),
                'key'   => 'picto',
                'image' => [
                    'storage_path' => $this->slide->getModel()->storagePath(),
                    'size'         => [
                        'thumbnail' => 'admin',
                        'detail'    => 'picto',
                    ],
                    'class'        => 'bg-dark',
                ],
            ], [
                'title'   => trans('home.page.label.slide.title'),
                'key'     => 'title',
                'sort_by' => 'slides.title',
            ], [
                'title'     => trans('home.page.label.slide.quote'),
                'key'       => 'quote',
                'str_limit' => 75,
            ], [
                'title'           => trans('home.page.label.slide.position'),
                'key'             => 'position',
                'sort_by'         => 'slides.position',
                'sort_by_default' => 'asc',
            ],
            [
                'title'    => trans('home.page.label.slide.activation'),
                'key'      => 'active',
                'activate' => [
                    'route'  => 'slides.activate',
                    'params' => [],
                ],
            ],
        ];

        // we set the routes used in the table list
        $routes = [
            'index'   => [
                'route'  => 'home.edit',
                'params' => [],
            ],
            'create'  => [
                'route'  => 'slides.create',
                'params' => [],
            ],
            'edit'    => [
                'route'  => 'slides.edit',
                'params' => [],
            ],
            'destroy' => [
                'route'  => 'slides.destroy',
                'params' => [],
            ],
        ];

        // we instantiate the query
        $query = $this->slide->getModel()->query();

        // we prepare the confirm config
        $confirm_config = [
            'action'     => trans('home.page.action.slide.delete'),
            'attributes' => ['title'],
        ];

        $search_config = [
            [
                'key'      => trans('home.page.label.title'),
                'database' => 'slides.title',
            ],
        ];

        // we enable the lines choice
        $enable_lines_choice = true;

        // we format the data for the needs of the view
        $tableListData = TableList::prepare(
            $query,
            $request,
            $columns,
            $routes,
            $confirm_config,
            $search_config,
            $enable_lines_choice
        );

        // we get the json home content
        $home = null;
        if (is_file(storage_path('app/home/content.json'))) {
            $home = json_decode(file_get_contents(storage_path('app/home/content.json')));
        }

        // prepare data for the view
        $data = [
            'seoMeta'       => $this->seoMeta,
            'title'         => isset($home->title) ? $home->title : null,
            'description'   => isset($home->description) ? $home->description : null,
            'video_link'    => isset($home->video_link) ? $home->video_link : null,
            'tableListData' => $tableListData,
        ];

        // return the view with data
        return view('pages.back.home-edit')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // we check the current user permission
        if (!Permission::hasPermission('home.update')) {
            // we redirect the current user to the user list if he has the required permission
            if (Sentinel::getUser()->hasAccess('home.view')) {
                return redirect()->route('home.edit');
            } else {
                // or we redirect the current user to the home page
                return redirect()->route('dashboard.index');
            }
        }

        // we sanitize the entries
        $request->replace(\Entry::sanitizeAll($request->all()));

        // we check inputs validity
        $rules = [
            'title'       => 'required|string',
            'description' => 'string|min:1500',
            'video_link'  => 'url',
        ];
        // we check the inputs validity
        if (!Validation::check($request->all(), $rules)) {
            // we flash the request
            $request->flash();

            return redirect()->back();
        }

        try {
            // we store the content into a json file
            file_put_contents(
                storage_path('app/home/content.json'),
                json_encode($request->except('_token', '_method'))
            );

            \Modal::alert([
                trans('home.message.update.success'),
            ], 'success');

            return redirect()->back();
        } catch (\Exception $e) {

            // we log the error
            \CustomLog::error($e);

            // we notify the current user
            \Modal::alert([
                trans('home.message.update.failure'),
                trans('global.message.global.failure.contact.support', ['email' => config('settings.support_email')]),
            ], 'error');

            return redirect()->back();
        }
    }

    /**
     * @return $this
     */
    public function show()
    {

        // SEO Meta settings
        $this->seoMeta['page_title'] = trans('seo.front.home.show.title');
        $this->seoMeta['meta_desc'] = trans('seo.front.home.show.description');
        $this->seoMeta['meta_keywords'] = trans('seo.front.home.show.keywords');

        // we get the two last news
        $last_news = $this->news->where('active', true)->orderBy('released_at', 'desc')->take(2)->get();

        // we convert in html the markdown content of each news
        if ($last_news) {
            $parsedown = new \Parsedown();
            foreach ($last_news as $n) {
                $n->content = isset($n->content) ? $parsedown->text($n->content) : null;
            }
        }

        // we get the slides
        $slides = $this->slide->orderBy('position', 'asc')->where('active', true)->get();
        \JavaScript::put([
            'slides_count' => sizeof($slides),
        ]);

        // we get the json home content
        $home = [];
        if (is_file(storage_path('app/home/content.json'))) {
            $home = json_decode(file_get_contents(storage_path('app/home/content.json')));
        }

        // we parse the markdown content
        $parsedown = new \Parsedown();
        $description = isset($home->description) ? $parsedown->text($home->description) : null;

        // prepare data for the view
        $data = [
            'seoMeta'     => $this->seoMeta,
            'slides'      => $slides,
            'last_news'   => $last_news,
            'title'       => isset($home->title) ? $home->title : null,
            'description' => $description,
            'video_link'  => isset($home->video_link) ? $home->video_link : null,
            'css'         => url(elixir('css/app.home.css')),
            'js'          => url(elixir('js/app.home.js')),
        ];

        // return the view with data
        return view('pages.front.home')->with($data);
    }

}
