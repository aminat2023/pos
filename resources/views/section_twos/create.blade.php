<div class="modal fade" id="addSection" wire:ignore.self data-backdrop="static">
    <div class="modal-dialog right-crud modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Section</h3>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store">
                    @csrf
                    @foreach ($addMore as $index)
                    <div class="form-row mb-3">
                        <div class="col">
                            <label for="section_name_{{ $index }}">Section Name</label>
                            <input 
                                type="text" 
                                id="section_name_{{ $index }}" 
                                wire:model.defer="section_name.{{ $index }}" 
                                class="form-control" />
                            @error('section_name.' . $index)
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-2">
                            <label>Status</label>
                            <label class="switch">
                                <input 
                                    type="checkbox" 
                                    wire:model.defer="section_status.{{ $index }}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                @endforeach
                
                

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create Section</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
