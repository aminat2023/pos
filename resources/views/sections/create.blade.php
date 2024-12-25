<div class="modal fade" id="addSection" wire:ignore.self data-backdrop="static">
    <div class="modal-dialog right-crud modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h3 class="modal-title">Add New Section</h3>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @forelse ($addMore as $more)
                        <div class="form-row">
                            <div class="col">
                                <label for="">Section Name</label>
                                <input type="text" wire:model.defer="section_name.{{$more}}" class="form-control" autocomplete="off">
                                @error('section_name.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-1" data-toggle="tooltip" data-placement="top" title="status">
                                <label class="switch" style="margin-top: 2.2em !important">
                                    <input type="checkbox" wire:model.defer="section_status.{{$more}}">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="col-sm-1">
                                <button class="btn-success" style="margin-top: 35px !important" wire:click.prevent="AddMore" wire:ignore>
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @if ($loop->index > 0)
                                    <button class="btn-danger" wire:click.prevent="Remove({{$loop->index}})" wire:ignore>
                                        <i class="fa fa-minus-circle"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <!-- No sections to show -->
                    @endforelse
                    <div class="modal-footer">
                        <button type="submit" class="btn-primary btn-block" :disabled="$isSubmitting">Create Section</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-danger btn-block" data-dismiss="modal">Close</button>
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