<form class="forms-sample" wire:submit.prevent="store">
    @if($habbit)
    <div class="form-group">
        <label for="name">Habit name</label>
        <input type="text" wire:model="name" class="form-control @error('name') has-danger @enderror" id="name" placeholder="Username">
        @error('name')
            <label id="name-error" class="error mt-2 text-danger" for="name">{{$message}}</label>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Category</label>
        <select wire:model='habit_category_id' name="habit_category_id" id="habit_category_id" class="form-control">
            <option value="">--SELECT--</option>
            @foreach ($categories as $id => $category_name)
                <option value="{{$id}}">{{$category_name}}</option>
            @endforeach
        </select>
        @error('habit_category_id')
            <label id="name-error" class="error mt-2 text-danger" for="name">{{$message}}</label>
        @enderror
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <div class="preview">
            <img src="{{asset('storage/'.$url)}}" alt="Preview" width="100%">
        </div>
        <input type="file"  wire:model="image" class="form-control @error('image') has-danger @enderror" id="image">
        @error('image')
            <label id="image-error" class="error mt-2 text-danger" for="image">{{$message}}</label>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea rows="5" wire:model="description" class="form-control @error('description') has-danger @enderror" id="description"></textarea>
        @error('description')
            <label id="description-error" class="error mt-2 text-danger" for="description">{{$message}}</label>
        @enderror
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" wire:loading.remove wire:target="store,image" class="btn btn-gradient-primary btn-md mr-2">Submit</button>
        <div wire:loading wire:target="store,image" class="loader"></div>
        <button type="button" class="btn btn-gradient-info btn-md" data-dismiss="modal">Cancel</button>
    </div>
    @endif
</form>
