<table class="table" width="100%">
    <thead>
        <tr>
            <th>Section Name</th>
            <th>Section Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sections as $section)
        <tr>
            <td>{{ $section->section_name }}</td>
            <td>{{ $section->status ? 'Enabled' : 'Disabled' }}</td>
            <td>
                <button class="btn btn-sm btn-primary" wire:click="edit({{ $section->id }})">Edit</button>
                <button class="btn btn-sm btn-danger" wire:click="delete({{ $section->id }})">Delete</button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No sections found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal for Adding Section -->
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
                                <input type="text" id="section_name_{{ $index }}" wire:model="section_name.{{ $index }}" class="form-control" />
                                @error('section_name.' . $index)
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-2">
                                <label>Status</label>
                                <label class="switch">
                                    <input type="checkbox" wire:model="section_status.{{ $index }}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-sm-2 d-flex align-items-end">
                                <button class="btn btn-success" wire:click.prevent="AddMore" type="button">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                @if ($index > 0)
                                    <button class="btn btn-danger ml-2" wire:click.prevent="Remove({{ $index }})" type="button">
                                        <i class="fa fa-minus-circle"></i>
                                    </button>
                                @endif
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

