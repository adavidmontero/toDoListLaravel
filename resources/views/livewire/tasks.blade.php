<div class="p-2 border rounded {{ !$listTitle ? 'hidden' : '' }}">
    <h1 class="my-2 text-3xl">Tareas de: <span class="italic text-indigo-900">{{ $listTitle }}</span></h1>
    <div>
        @if (session()->has('message'))
            <div class="p-3 mb-4 bg-green-300 text-sm font-semibold text-green-800 rounded-sm shadow-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="my-4">
        @if ($errors->any())
            <ul class="list-disc list-inside p-2 bg-red-200 rounded-sm">
                @foreach ($errors->all() as $error)
                    <li class="text-red-500 text-sm font-semibold leading-6">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form class="flex" wire:submit.prevent="addTask">
            <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="¿Qué tarea quieres agregar?"
                wire:model.debounce.500ms="newTask">
            <div class="py-2">
                <button type="submit" class="p-2 bg-red-500 w-20 rounded shadow text-white">Agregar</button>
            </div>
        </form>
    </div>
    @forelse ($tasks as $task)
        <div class="flex items-center my-2 gap-2 border border-gray-200 rounded-md" 
            wire:key="{{ $task->id }}">
            <div class="w-full p-2 cursor-pointer" wire:click="updateTask({{ $task->id }})">
                <div class="flex justify-between items-center">
                    <p class="font-light text-lg {{ !$task->completed ? '' : 'line-through' }}">
                        {{ $task->name }}
                    </p>
                    <p class="text-xs text-gray-600 font-semibold">
                        {{ $task['created_at']->diffForHumans() }}
                    </p>
                </div>
            </div>
            <div class="w-auto px-2">
                <i class="fas fa-times text-red-400 hover:text-red-700 cursor-pointer"
                    wire:click="remove({{ $task->id }})"></i>
            </div>
        </div>
    @empty
        <div class="p-3 mb-4 text-sm bg-blue-300 text-blue-800 font-semibold rounded-sm shadow-sm">
            ¡Esta lista aún no cuenta con tareas 😥! 
        </div>
    @endforelse

    {{ $tasks->links('pagination-links') }}
</div>
