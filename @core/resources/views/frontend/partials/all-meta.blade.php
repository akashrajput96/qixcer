@if(request()->path() == '/' || \Request::is( 'home/*') )
<title>{{get_static_option('site_'.$user_select_lang_slug.'_title')}} - {{get_static_option('site_'.$user_select_lang_slug.'_tag_line')}}</title>
<meta name="og:title" content="{{get_static_option('og_meta_'.$user_select_lang_slug.'_title')}}"/>
<meta name="og:description" content="{{get_static_option('og_meta_'.$user_select_lang_slug.'_description')}}"/>
<meta name="og:site_name" content="{{get_static_option('og_meta_'.$user_select_lang_slug.'_site_name')}}"/>
<meta name="og:url" content="{{get_static_option('og_meta_'.$user_select_lang_slug.'_url')}}"/>
{!! render_og_meta_image_by_attachment_id(get_static_option('og_meta_'.$user_select_lang_slug.'_image')) !!}
@endif


@if(request()->is([
    get_static_option('news_page_slug'),
    get_static_option('news_page_slug').'/*',
    'p/*',
    'news-tags/*',
    get_static_option('about_page_slug'),
    get_static_option('contact_page_slug'),
    get_static_option('event_page_slug'),
    get_static_option('event_page_slug').'/*',
    get_static_option('contribution_page_slug'),
    get_static_option('contribution_page_slug').'/*',

]))

<title>@yield('site-title') - {{get_static_option('site_'.$user_select_lang_slug.'_title')}}</title>

@yield('page-meta-data')
@yield('og-meta')
@else
<title>{{get_static_option('site_'.$user_select_lang_slug.'_title')}} - {{get_static_option('site_'.$user_select_lang_slug.'_tag_line')}}</title>
<meta name="description" content="{{filter_static_option_value('site_meta_'.$user_select_lang_slug.'_description',$global_static_field_data)}}">
<meta name="tags" content="{{filter_static_option_value('site_meta_'.$user_select_lang_slug.'_tags',$global_static_field_data)}}">
@endif
