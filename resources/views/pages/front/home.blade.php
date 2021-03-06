@extends('templates.front.full_layout')

@section('content')

    {{-- slideshow --}}
    <div id="carousel_container" class="row">
        <div id="carousel" class="glide">
            <div class="glide__arrows">
                <span class="glide__arrow prev" data-glide-dir="<">prev</span>
                <span class="glide__arrow next" data-glide-dir=">">next</span>
            </div>
            <div class="glide__wrapper">
                <ul class="glide__track">
                    @foreach($slides as $key => $slide)
                        <li class="glide__slide fill">
                            <section class="fill">
                                <div class="fill slide_content text-center">
                                    <div class="fill">
                                        <div class="fill">
                                            @if($slide->picto)
                                                @if($slide->url)
                                                    <a href="{{ $slide->url }}" title="{{ $slide->title }}">
                                                        @endif()
                                                        <img class="picto" src="{{ $slide->imagePath($slide->picto) }}" alt="{{ $slide->title }}">
                                                        @if($slide->url)
                                                    </a>
                                                @endif()
                                            @endif
                                            @if($slide->title)
                                                @if($slide->url)
                                                    <a href="{{ $slide->url }}" title="{{ $slide->title }}">
                                                        @endif()
                                                        <h2 class="title">{{ $slide->title }}</h2>
                                                        @if($slide->url)
                                                    </a>
                                                @endif()
                                            @endif
                                            @if($slide->quote)
                                                <p class="quote" class="quote">{!! $slide->quote !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="background_responsive_img fill" data-background-image="{{ $slide->imagePath($slide->background_image) }}"></div>
                            </section>
                        </li>
                    @endforeach
                </ul>
            </div>
            <ul class="glide__bullets"></ul>
        </div>
    </div>

    <div id="content" class="home row">

        @if(!$last_news->isEmpty())
            <div id="last_news" class="text-content">
                <div class="container">
                    <h2><i class="fa fa-paper-plane"></i> {{ trans('home.page.title.last_news') }}</h2>
                    <hr>
                    <table class="table table-striped table-hover">
                        <tbody>
                            @foreach($last_news as $key => $news)
                                <tr class="news">
                                    <td class="img hidden-xs">
                                        @if($news->image)
                                            <a class="btn btn-default" href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}" role="button" title="{{ $news->title }}">
                                                <img class="img-circle" width="150" height="150" src="{{ $news->imagePath($news->image, 'image', 'list') }}" alt="{{ $news->title }}">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="content">
                                        @if($news->image)
                                            <a class="img visible-xs" href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}" role="button" title="{{ $news->title }}">
                                                <img width="100%" src="{{ $news->imagePath($news->image, 'image', 'list_mobile') }}" alt="{{ $news->title }}">
                                            </a>
                                        @endif
                                        <h3>
                                            <a href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}" title="{{ $news->title }}"><i class="fa fa-newspaper-o"></i> {{ $news->title }}</a>
                                        </h3>
                                        <div class="date">
                                            <i class="fa fa-clock-o"></i> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $news->released_at)->format('d/m/Y H:i') }}
                                        </div>
                                        <div class="category {{ config('news.category.' . $news->category_id) }}" >
                                            <i class="fa fa-cube"></i> {{ trans('news.config.category.' . config('news.category.' . $news->category_id)) }}
                                        </div>
                                        <div class="author">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ $news->author->first_name . ' ' . $news->author->last_name }}
                                        </div>
                                        <div class="comments">
                                            <i class="fa fa-comment" aria-hidden="true"></i> <a href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}#disqus_thread" title="Commentaires"></a>
                                        </div>
                                        <div class="sum_up hidden-xs">
                                            {{ str_limit(strip_tags($news->content), 250) }}
                                        </div>
                                        <div class="button mobile visible-xs">
                                            <a href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}" title="{{ $news->title }}">
                                                <button class="btn" role="button">
                                                    <i class="fa fa-chevron-circle-right"></i> {{ trans('global.action.more') }}
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="button hidden-xs">
                                        <a href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}" title="{{ $news->title }}">
                                            <button class="btn" role="button">
                                                <i class="fa fa-chevron-circle-right"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div id="una-club" class="text-content">
            <div class="container">
                @if($title)
                    <h2><i class="fa fa-hand-spock-o"></i> {{ $title }}</h2>
                    <hr>
                @endif

                @if($description)
                    {!! $description !!}
                @endif

                @if($video_link)
                <hr>

                <div class="video text-center display-table">
                    <a href="{{ $video_link }}" class="table-cell" title="Vidéo promotionnelle {{ config('settings.app_name_' . config('app.locale')) }}" data-lity>
                        <i class="fa fa-youtube-square"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES * * */
        var disqus_shortname = 'una-club';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function () {
            var s = document.createElement('script'); s.async = true;
            s.type = 'text/javascript';
            s.src = '//' + disqus_shortname + '.disqus.com/count.js';
            (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        }());
    </script>

@endsection