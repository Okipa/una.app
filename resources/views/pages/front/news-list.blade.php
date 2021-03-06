@extends('templates.front.full_layout')

@section('content')

    {{-- top background img --}}
    @if($background_image)
        <div class="top_background_image row">
            <div class="background_responsive_img fill" data-background-image="{{ ImageManager::imagePath(config('image.news.public_path'), $background_image) }}"></div>
        </div>
    @else
        <div class="no_top_background_image"></div>
    @endif

    <div id="content" class="news-list row">

        <div class="text-content">
            <div class="container">

                <h1><i class="fa fa-paper-plane"></i> {{ $title }}</h1>

                {!! $description !!}

                <hr>

                <div class="categories">
                    <i class="fa fa-cubes"></i> {{ trans('global.action.sort_by_cat') }} :
                    @foreach(config('news.category') as $id => $cat)
                        <a class="{{ $cat }}
                            @if($current_category == $id)
                                selected
                            @endif"
                           href="{{ route('news.index', ['category' => $id]) }}"
                           title="{{ trans('news.config.category.' . $cat) }}" rel="nofollow">{{ trans('news.config.category.' . $cat) }}</a>
                    @endforeach
                    @if($current_category)<a href="{{ route('news.index') }}" title="Annuler filtre" class="text-danger"><i class="fa fa-times"></i> Annuler filtre</a>
                    @endif
                </div>

                <table class="table table-striped table-hover">
                    <tbody>
                        @foreach($news_list as $news)
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
                                    <h2>
                                        <a href="{{ route('news.show', ['id' => $news->id, 'key' => $news->key]) }}" title="{{ $news->title }}"><i class="fa fa-newspaper-o"></i> {{ $news->title }}</a>
                                    </h2>
                                    <div class="date">
                                        <i class="fa fa-clock-o"></i> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $news->released_at)->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="category {{ config('news.category.' . $news->category_id) }}" >
                                        <i class="fa fa-cube"></i> {{ trans('news.config.category.' . config('news.category.' . $news->category_id)) }}
                                    </div>
                                    @if($news->photo_album_id)
                                        <div class="photo_album" >
                                            <i class="fa fa-camera" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                    @if($news->video_id)
                                        <div class="video" >
                                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                                        </div>
                                    @endif
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
                    <tfoot>
                        <tr class="pagination-container">
                            <td colspan="3" class="text-right">
                                {!! $news_list->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
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