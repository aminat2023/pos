<?php

namespace App\Http\Livewire;

use App\Models\Section as SectionModel;
use Livewire\Component;

class Section extends Component
{
    public $addMore = [1];
    public $section_name = [];    
    public $section_status = [];

    public function mount()
    {
        // Load existing sections from the database
        $sections = SectionModel::all();
        foreach ($sections as $section) {
            $this->section_name[] = $section->section_name;
            $this->section_status[] = $section->status;
        }

        $this->addMore = [1]; // Reset to one input field initially
    }

    public function AddMore()
    {
        if (count($this->addMore) < 5) {
            $this->addMore[] = count($this->addMore) + 1;
        }
    }

    public function Remove($index)
    {
        unset($this->section_name[$index]);
        unset($this->section_status[$index]);
        unset($this->addMore[$index]);
        $this->addMore = array_values($this->addMore); // Reindex array after removal
    }

    public function store()
    {
        $this->validate([
            'section_name.*' => 'required|string|max:255',
            'section_status.*' => 'sometimes|boolean', // Make sure status can be nullable
        ]);
    
        foreach ($this->addMore as $key) { // Iterate using the key/index directly
            $name = $this->section_name[$key] ?? 'Unnamed Section';
            $status = $this->section_status[$key] ?? 0; // Default to 0 if not set
    
            SectionModel::create([
                'section_name' => $name,
                'status' => $status,
            ]);
        }
    
        session()->flash('success', 'Sections added successfully!');
        $this->reset(['section_name', 'section_status', 'addMore']);
        $this->addMore = [1]; // Reset to show only one input field by default
    }
    
    

    

    public function render()
    {
        $sections = SectionModel::all(); // Fetch all sections again to show in the table
        return view('livewire.section', ['sections' => $sections]);
    }
}
