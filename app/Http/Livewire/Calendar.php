<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;


class Calendar extends Component
{
    public $name, $start_date, $end_date, $title_modal, $item, $modelId = '';
    public $isEdit = false;

    protected $rules=[
        'name' => 'required|min:3',
        'start_date' => 'required',
        'end_date' => 'required',
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'editEvent',
        'updateEventDate',
    ];

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Event';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteEvent']);
        }else if($action == 'create'){
            $this->title_modal = 'Create Event';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createEvent']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Event';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createEvent']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function editEvent($id)
    {
        $this->title_modal = 'Edit Event';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createEvent']);
        $this->emit('getModelId', $id);
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Event::find($this->modelId);
        $this->name = $model->name;
        $this->start_date = $model->start_time;
        $this->end_date = $model->end_time;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $event = Event::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $event = new Event;
            $this->validate();
        }
        
        $event->name = $this->name;
        $event->start_time = $this->start_date;
        $event->end_time = $this->end_date;
        
        $event->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createEvent']);

        $new_event =  [
            'id' => $event->id,
            'title' => $event->name,
            'start' => $event->start_time,
            'end' => $event->end_time,
        ];

        if ($this->isEdit) {
            $data = [
                'message' => 'Event updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];

            $this->dispatchBrowserEvent('eventUpdated', $new_event);

        } else {
            $data = [
                'message' => 'Event created successfully!',
                'type' => 'info',
                'icon' => 'check',
            ];
            $this->dispatchBrowserEvent('eventAdded', $new_event);
        }

        if ($data) {
            $this->sessionAlert($data);
        }

        $this->clearForm();
    }

    public function updateEventDate($id, $start, $end){
        $event = Event::findOrFail($id);
        $event->start_time = $start;
        $event->end_time = $end;

        $event->save();

        $data = [
            'message' => 'Event updated successfully!',
            'type' => 'success',
            'icon' => 'edit',
        ];

        if ($data) {
            $this->sessionAlert($data);
        }
    }

    public function delete(){
        $Event = Event::findOrFail($this->item);
        $Event->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteEvent']);
        
        $data = [        
            'message' => 'Event deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
    }

    public function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function render()
    {
        $events = Event::all();

        foreach ($events as $event) {
            $events[] =  [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_time,
                'end' => $event->end_time,
            ];
        }
        
        return view('livewire.calendar.index', [
            'events' => compact('events')
        ]);
    }
}
