@extends('templates.back.full_layout')

@section('content')

    <div id="content" class="config row">

        <div class="text-content">

            <div class="col-sm-12">

                {{-- Title--}}
                <h2><i class="fa fa-cogs"></i> {{ trans('settings.view.title.settings') }}</h2>

                <hr>

                <form role="form" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">

                    {{-- crsf token --}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">

                    {{-- app data --}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('settings.view.title.global') }}</h3>
                        </div>
                        <div class="panel-body">

                            {{-- site name --}}
                            <label for="input_app_name">{{ trans('settings.view.label.site_name') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_app_name"><i class="fa fa-sitemap"></i></span>
                                    <input id="input_app_name" class="form-control" type="text" name="app_name" value="{{ old('app_name') ? old('app_name') : config('settings.app_name') }}" placeholder="{{ trans('settings.view.label.site_name') }}">
                                </div>
                            </div>

                            {{-- multilingual --}}
                            <label for="input_multilingual">{{ trans('settings.view.label.multilingual') }}</label>
                            <div class="form-group">
                                <div class="input-group swipe-group">
                                    <span class="input-group-addon" for="input_multilingual"><i class="fa fa-globe"></i></span>
                                    <span class="form-control swipe-label" readonly="">
                                        {{ trans('global.action.activate') }}
                                    </span>
                                    <input class="swipe" id="input_multilingual" type="checkbox" name="multilingual"
                                           @if(old('multilingual')) checked
                                           @elseif(config('settings.multilingual')) checked
                                            @endif>
                                    <label class="swipe-btn" for="input_multilingual"></label>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- personal data --}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('settings.view.title.contact') }}</h3>
                        </div>
                        <div class="panel-body">

                            {{-- phone number --}}
                            <label for="input_phone_number">{{ trans('settings.view.label.phone_number') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_phone_number"><i class="fa fa-phone"></i></span>
                                    <input id="input_phone_number" class="form-control" type="tel" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : config('settings.phone_number') }}" placeholder="{{ trans('settings.view.label.phone_number') }}">
                                </div>
                            </div>

                            {{-- contact email --}}
                            <label for="input_contact_email">{{ trans('settings.view.label.contact_email') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_contact_email"><i class="fa fa-at"></i></span>
                                    <input id="input_contact_email" class="form-control" type="email" name="contact_email" value="{{ old('contact_email') ? old('contact_email') : config('settings.contact_email') }}" placeholder="{{ trans('settings.view.label.contact_email') }}">
                                </div>
                            </div>

                            {{-- sspport email --}}
                            <label for="input_support_email">{{ trans('settings.view.label.support_email') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_support_email"><i class="fa fa-at"></i></span>
                                    <input id="input_support_email" class="form-control" type="email" name="support_email" value="{{ old('support_email') ? old('support_email') : config('settings.support_email') }}" placeholder="{{ trans('settings.view.label.support_email') }}">
                                </div>
                            </div>

                            {{-- address --}}
                            <label for="input_address">{{ trans('settings.view.label.address') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_address"><i class="fa fa-envelope"></i></span>
                                    <input id="input_address" class="form-control" type="text" name="address" value="{{ old('address') ? old('address') : config('settings.address') }}" placeholder="{{ trans('settings.view.label.address') }}">
                                </div>
                            </div>

                            {{-- zip code --}}
                            <label for="input_zip_code">{{ trans('settings.view.label.zip_code') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_zip_code"><i class="fa fa-paper-plane"></i></span>
                                    <input id="input_zip_code" class="form-control" type="number" name="zip_code" value="{{ old('zip_code') ? old('zip_code') : config('settings.zip_code') }}" placeholder="{{ trans('settings.view.label.zip_code') }}">
                                </div>
                            </div>

                            {{-- city --}}
                            <label for="input_city">{{ trans('settings.view.label.city') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_city"><i class="fa fa-map-marker"></i></span>
                                    <input id="input_city" class="form-control" type="text" name="city" value="{{ old('city') ? old('city') : config('settings.city') }}" placeholder="{{ trans('settings.view.label.city') }}">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- social data --}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('settings.view.title.social') }}</h3>
                        </div>
                        <div class="panel-body">

                            {{-- facebook --}}
                            <label for="input_facebook">{{ trans('settings.view.label.facebook') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_facebook"><i class="fa fa-facebook"></i></span>
                                    <input id="input_facebook" class="form-control" type="tel" name="facebook" value="{{ old('facebook') ? old('facebook') : config('settings.facebook') }}" placeholder="{{ trans('settings.view.label.facebook') }}">
                                </div>
                            </div>

                            {{-- twitter --}}
                            <label for="input_twitter">{{ trans('settings.view.label.twitter') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_twitter"><i class="fa fa-twitter"></i></span>
                                    <input id="input_twitter" class="form-control" type="text" name="twitter" value="{{ old('twitter') ? old('twitter') : config('settings.twitter') }}" placeholder="{{ trans('settings.view.label.twitter') }}">
                                </div>
                            </div>

                            {{-- google+ --}}
                            <label for="input_google_plus">{{ trans('settings.view.label.google+') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_google_plus"><i class="fa fa-google-plus"></i></span>
                                    <input id="input_google_plus" class="form-control" type="text" name="google_plus" value="{{ old('google_plus') ? old('google_plus') : config('settings.google_plus') }}" placeholder="{{ trans('settings.view.label.google+') }}">
                                </div>
                            </div>

                            {{-- youtube --}}
                            <label for="input_youtube">{{ trans('settings.view.label.youtube') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_youtube"><i class="fa fa-youtube"></i></span>
                                    <input id="input_youtube" class="form-control" type="text" name="youtube" value="{{ old('youtube') ? old('youtube') : config('settings.youtube') }}" placeholder="{{ trans('settings.view.label.youtube') }}">
                                </div>
                            </div>

                            {{-- rss --}}
                            <label for="swipe_rss">{{ trans('settings.view.label.rss.title') }}</label>
                            <div class="form-group">
                                <div class="input-group swipe-group">
                                    <span class="input-group-addon" for="swipe_rss"><i class="fa fa-rss"></i></span>
                                    <span class="form-control swipe-label" readonly="">
                                        {{ trans('settings.view.label.rss.news') }}
                                    </span>
                                    <input class="swipe" id="swipe_rss" type="checkbox" name="rss"
                                           @if(old('rss')) checked
                                           @elseif(config('settings.youtube')) checked
                                           @endif>
                                    <label class="swipe-btn" for="swipe_rss"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- appearance data --}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('settings.view.title.design') }}</h3>
                        </div>
                        <div class="panel-body">

                            {{-- favicon --}}
                            <label for="input_favicon">{{ trans('settings.view.label.favicon') }}</label>
                            <div class="form-group">
                                @if(config('settings.favicon'))
                                    <div class="form-group">
                                        <img width="16" height="16" src="{{ route('image', ['filename' => '', 'folder' => 'user', 'size' => [16, 16]]) }}" alt="Favicon {{ config('settings.app_name') }}">
                                    </div>
                                @endif
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-primary btn-file">
                                            <i class="fa fa-picture-o"></i> {{ trans('global.action.browse') }} <input type="file" name="favicon">
                                        </span>
                                    </span>
                                    <input id="input_favicon" type="text" class="form-control" readonly="">
                                </div>
                                <p class="help-block quote"><i class="fa fa-info-circle"></i> {{ trans('settings.view.info.image') }}</p>
                            </div>

                            {{-- loading spinner --}}
                            <label for="input_loading_spinner">{{ trans('settings.view.label.loading_spinner') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_loading_spinner">{!! config('settings.loading_spinner') ? config('settings.loading_spinner') : '<i class="fa fa-spinner"></i>' !!}</span>
                                    <input id="input_loading_spinner" class="form-control" type="loading_spinner" name="loading_spinner" placeholder="{{ trans('settings.view.label.loading_spinner') }}" value="{{ old('loading_spinner') ? old('loading_spinner') : config('settings.loading_spinner') }}">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- SEO data --}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('settings.view.title.seo') }}</h3>
                        </div>
                        <div class="panel-body">

                            {{-- google analytics code --}}
                            <label for="input_google_analytics">{{ trans('settings.view.label.ga_code') }}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" for="input_google_analytics"><i class="fa fa-code"></i></span>
                                    <textarea id="input_google_analytics" class="form-control" type="google_analytics" name="google_analytics" placeholder="{{ trans('settings.view.label.ga_code') }}">{{ old('google_analytics') ? old('google_analytics') : config('settings.google_analytics') }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- submit login --}}
                    <button class="btn btn-primary spin-on-click" type="submit">
                        <i class="fa fa-floppy-o"></i> {{ trans('settings.view.action.save') }}
                    </button>
                </form>

            </div>
        </div>
    </div>

@endsection