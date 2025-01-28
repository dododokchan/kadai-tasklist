@if (isset($users))
    <ul class="list-none">
        @foreach ($users as $user)
            <li class="flex items-center gap-x-2 mb-4">
                <div>
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                        {{-- ユーザー詳細ページへのリンク --}}
                        <p><a class="link link-hover text-info" href="{{ route('tasks.show', $user->id) }}">View profile</a></p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $users->links() }}
@endif