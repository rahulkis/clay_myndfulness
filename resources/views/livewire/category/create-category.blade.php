<div>
    <form class="forms-sample" wire:submit.prevent="store">
        <div class="form-group">
            <label for="name">name</label>
            <input type="text" wire:model="name" class="form-control @error('name') has-danger @enderror" id="name" placeholder="Name">
            @error('name')
                <label id="name-error" class="error mt-2 text-danger" for="name">{{$message}}</label>
            @enderror
        </div>
        
        <button type="submit" wire:loading.remove wire:target="store" class="btn btn-gradient-primary mr-2">Submit</button>
        <div wire:loading wire:target="store" class="loader"></div>
    </form>    
</div>
