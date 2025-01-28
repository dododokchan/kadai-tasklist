<div class="mt-4">
    @if (isset($tasks))
        <ul class="list-none">
            @foreach ($tasks as $task)
                    <div class="flex items-start gap-x-2 mb-4">
                        <div>
                            {{-- タスク所有者のユーザー詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('tasks.show', $task->user->id) }}">{{ $task->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $task->created_at }}</span>
                        </div>
                        <div>
                            {{-- タスク内容 --}}
                            <p class="mb-0">{!! nl2br(e($task->content)) !!}</p>
                        </div>
                        <div>
                            @if (Auth::id() == $task->user_id)
                                {{-- task削除ボタンのフォーム --}}
                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm normal-case" 
                                        onclick="return confirm('Delete id = {{ $task->id }} ?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
            @endforeach
        </ul>
        {{-- ページネーションのリンク --}}
        {{ $tasks->links() }}
    @endif
</div>