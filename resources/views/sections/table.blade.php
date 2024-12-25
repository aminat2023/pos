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
