<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CheckList;
use Livewire\WithPagination;

class CheckLists extends Component
{
    //Trait necesario para la paginación
    use WithPagination;

    //Definimos la variable que contendrá el titulo de la lista
    public $newTitle;

    //Definimos la variable que cotrola la lista seleccionada
    public $active;

    //Definimos el array de las reglas de validación
    public $rules = [
        'newTitle' => 'required|min:5|max:30'
    ];

    //Definimos el array de los mensajes personalizados para cada una de las validaciones
    public $messages = [
        'newTitle.required' => 'El campo título es requerido.',
        'newTitle.min' => 'El campo título debe ser de al menos 5 caracteres.',
        'newTitle.max' => 'El campo título debe ser menor a 30 caracteres.'
    ];

    //Definimos el array de los escuchadores de eventos
    protected $listeners = ['listSelected', 'taskUpdated'];

    //Definimos el método que recibirá el campo a validar y luego validamos de acuerdo a las reglas
    public function updated($field)
    {
        $this->validateOnly($field, $this->rules);
    }

    //Si una lista es clickeada le asignamos a la variable active el ID de esa tarea
    public function listSelected($listId)
    {
        if (!$this->active || $this->active !== $listId) {
            $this->active = $listId;
        } else {
            $this->active = '';
        }
    }

    public function taskUpdated()
    {
        $this->TasksWithCounts();
    }

    // Definimos un método para guardar una nueva lista
    public function addCheckList()
    {
        //Verificamos que cumpla con las reglas de validación
        $this->validate($this->rules);

        //Creamos una nueva lista
        CheckList::create([
            'title' => $this->newTitle,
            'user_id' => auth()->user()->id
        ]);

        //Limpiamos los valores anteriores
        $this->newTitle = '';

        //Enviamos un mensaje al usuario
        session()->flash('message', '¡Lista agregada correctamente! 😄');
    }

    //Definimos el método para eliminar una lista, el cual recibe el ID de esta
    public function remove($checklistId)
    {
        //Buscamos el registro a partir del ID de la lista
        $checklist = CheckList::find($checklistId);

        //Eliminamos la lista
        $checklist->delete();

        //Emitimos el evento de cuando una lista es eliminada al componente Tasks
        $this->emitTo('tasks', 'listRemoved');

        //Enviamos un mensaje al usuario
        session()->flash('message', '¡Lista eliminada exitosamente! 🙂');
    }

    public function TasksWithCounts()
    {
        return collect(Checklist::where('user_id', auth()->user()->id)->latest()->get())->map(function ($checklist) {
            return collect($checklist)->merge([
                'created_at' => $checklist->created_at->diffForHumans(),
                'total_tasks' => $checklist->tasks()->count(),
                'completed_tasks' => $checklist->tasks()->where('completed', '1')->count(),
                'incompleted_tasks' => $checklist->tasks()->where('completed', '0')->count(),
            ]);
        });
    }

    public function render()
    {
        //Enviamos todas las listas ordenadas de las más nueva a la más antigua
        return view('livewire.check-lists', [
            'checkLists' => $this->TasksWithCounts()/* ->forPage(1, 6) */
        ]);
    }
}
