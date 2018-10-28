<span class="text-muted">{{ ucwords($label) . ' ' . $model->created_date }}</span>
<div class="media mt-1">
    <a href="{{ $model->user->url }}" class="mr-2">
        <img src="{{ $model->user->avatar }}" alt="">
    </a>
    <div class="media-body mt-1">
        <a href="{{ $model->user->url }}">{{ $model->user->name }}</a>
    </div>
</div>