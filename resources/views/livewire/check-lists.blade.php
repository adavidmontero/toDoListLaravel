<div class="p-2 border rounded">
    <h1 class="my-2 text-3xl">Mis Listas</h1>
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
        <form class="flex" wire:submit.prevent="addCheckList">
            <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="¿Qué lista necesitas crear?"
                wire:model.debounce.500ms="newTitle">
            <div class="py-2">
                <button type="submit" class="p-2 bg-blue-500 w-20 rounded shadow text-white">Crear</button>
            </div>
        </form>
    </div>
    @forelse ($checkLists as $checkList)
        <div class="flex items-center my-2 gap-2 border border-gray-200 rounded-md 
            {{ $active === $checkList['id'] ? 'bg-gray-200' : '' }}" wire:key="{{ $checkList['id'] }}">
            <div class="w-full p-2 cursor-pointer" wire:click="$emit('listSelected', {{ $checkList['id'] }})">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-lg">
                        {{ $checkList['title'] }}
                    </p>
                    <p class="text-xs text-gray-600 font-semibold">
                        {{ $checkList['created_at'] }}
                    </p>
                </div>
                <p class="text-sm">tareas totales: {{ $checkList['total_tasks'] }} / tareas completadas: {{ $checkList['completed_tasks'] }} / tareas incompletas: {{ $checkList['incompleted_tasks'] }}</p>
                <progress class="w-full h-3 mt-2 bg-indigo-900 shadow-inner" value="{{ $checkList['completed_tasks'] }}" max="{{ $checkList['total_tasks'] }}"> </progress>
            </div>
            <div class="w-auto px-2">
                <i class="fas fa-times text-red-400 hover:text-red-700 cursor-pointer"
                    wire:click="remove({{ $checkList['id'] }})"></i>
            </div>
        </div>
        {{-- <div class="rounded border shadow p-3 my-2 {{ $active === $checkList->id ? 'bg-gray-200' : '' }}" 
            wire:key="{{ $checkList->id }}">
            <div class="flex justify-between my-2">
                <div wire:click="$emit('listSelected', {{ $checkList->id }})" class="cursor-pointer">
                    <p class="py-1 text-xs text-gray-600 font-semibold capitalize">
                        {{ $checkList['created_at']->diffForHumans() }}
                    </p>
                    <p class="mx-3 font-bold text-lg">
                        {{ $checkList->title }}
                    </p>
                </div>
                <i class="fas fa-times text-red-400 hover:text-red-700 cursor-pointer"
                    wire:click="remove({{ $checkList->id }})"></i>
            </div>
            <p class="mx-3 text-gray-800">
                Aquí va el progreso
            </p>
        </div> --}}
    @empty
        <div class="p-3 mb-4 text-sm bg-blue-300 text-blue-800 font-semibold rounded-sm shadow-sm">
            ¡Escriba un título para crear una nueva Check List 🤫! 
        </div>
    @endforelse

    {{-- {{ $checkLists->links('pagination-links') }} --}}
</div>
