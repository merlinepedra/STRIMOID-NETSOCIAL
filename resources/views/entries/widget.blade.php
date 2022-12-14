<div class="panel-default entry @if ($isReply) entry_reply @endif" data-id="{!! $entry->hashId() !!}" @if ($isReply) data-parent-id="{!! $entry->parent_id !!}" @endif>
    <a name="{!! $entry->hashId() !!}"></a>

    <div class="entry_avatar">
        <img src="{!! $entry->user->getAvatarPath() !!}" alt="{!! $entry->user->name !!}">
        <div class="sex_marker {!! $entry->user->getSexClass() !!}"></div>
    </div>

    <div class="panel-heading entry_header">
        <a href="{!! route('user_profile', $entry->user->name) !!}" class="entry_author"
           data-hover="user_widget" data-user="{!! $entry->user->name !!}">
            {!! $entry->user->getColoredName() !!}
        </a>

        <span class="pull-right">
            @if (!$isReply)
                <i class="fa fa-tag"></i>
                <a href="{!! route('group_entries', $entry->group) !!}" class="entry_group"
                   data-hover="group_widget" data-group="{!! $entry->group->urlname !!}">
                    g/{{{ $entry->group->urlname }}}
                </a>
            @endif

            <i class="fa fa-clock-o"></i>
            <a href="{!! $entry->getURL() !!}">
                <time pubdate datetime="{!! $entry->created_at->format('c') !!}" title="{!! $entry->getLocalTime() !!}">
                    {{ $entry->createdAgo() }}
                </time>
            </a>

            <span class="voting" data-id="{!! $entry->hashId() !!}" state="{!! $entry->getVoteState() !!}"
                  @if (!$isReply) data-type="entry" @else data-type="entry_reply" @endif>
                <button type="button" class="btn btn-light btn-xs vote-btn-up @if ($entry->getVoteState() == 'uv') btn-success @endif">
                    <i class="fa fa-arrow-up vote-up"></i> <span class="count">{!! (int) $entry->uv !!}</span>
                </button>

                <button type="button" class="btn btn-light btn-xs vote-btn-down @if ($entry->getVoteState() == 'dv') btn-danger @endif">
                    <i class="fa fa-arrow-down vote-down"></i> <span class="count">{!! (int) $entry->dv !!}</span>
                </button>
            </span>
        </span>
    </div>

    <div class="entry_text md @if ($entry->isHidden()) blocked @endif">
        {!! $entry->text !!}
    </div>

    @if ($entry->isHidden())
    <div class="entry_text">
        <a class="show_blocked_link action_link">[Odpowied?? zosta??a ukryta, kliknij aby j?? wy??wietli??]</a>
    </div>
    @endif

    <div class="entry_actions pull-right">
        @auth
            @if(!$isReply && $entry->isSaved())
                <i class="fa fa-star action_link save_entry" title="zapisz"></i>
            @elseif (!$isReply)
                <i class="fa fa-star-o action_link save_entry" title="zapisz"></i>
            @endif

            <a class="entry_reply_link action_link">@lang('common.reply')</a>
        @endauth

        @can('remove', $entry)
            <a class="entry_remove_link action_link">@lang('common.delete')</a>
        @endcan
        @can('edit', $entry)
            <a class="entry_edit_link action_link">@lang('common.edit')</a>
        @endcan

        <a href="{!! $entry->getURL() !!}">#</a>
    </div>
</div>
