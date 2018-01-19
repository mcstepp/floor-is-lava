<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="/profiles/{{$reply->author->name}}">{{ $reply->author->name }}</a> said
                    {{ $reply->created_at->diffForHumans() }}
                </h5>

                <div>
                    <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                            {{ $reply->favorites_count }} {{str_plural('Favorite', $reply->favorites_count)}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <article>
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>

                    <button class="btn btn-xs btn-primary" @click="update">Update</button>
                    <button class="btn btn-xs btn-link" @click="cancel">Cancel</button>

                </div>
                <div v-else class="body" v-text="body"></div>
            </article>
        </div>

        @can('update', $reply)
        <div class="panel-footer level">
            <button class="btn btn-info btn-xs mr-1" @click="edit">Edit</button>

            <form method="POST" action="/replies/{{ $reply->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
            </form>
        </div>
        @endcan

    </div>
</reply>