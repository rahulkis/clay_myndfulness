<form wire:submit.prevent='store'>
    <div class="modal-body">
        <div class="form-group @error(" title") has-danger @enderror">
            <label for="title" class="label-control">Title</label>
            <input type="text" id="title" wire:model="title" placeholder="Title" class="form-control">
            @error ('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group @error(" message") has-danger @enderror">
            <label for="message" class="label-control">Message</label>
            <textarea type="text" wire:model="message" id="message" class="form-control"></textarea>
            @error ('message')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr />
    <div class="modal-footer">
        <button type="submit" wire:loading.remove class="btn btn-gradient-primary btn-md">Submit</button>
        <div class="loader" wire:loading></div>
    </div>
</form>
