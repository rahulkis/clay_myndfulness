<form class="forms-sample" wire:submit.prevent="store">
    <div class="form-group @error('category') has-danger @enderror">
        <label>Select Category</label>
        <select class="form-control" wire:model="category">
            <option>Select</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        @error('category')
        <label id="question-error" class="error mt-2 text-danger" >{{$message}}</label>
        @enderror
    </div>
    <div class="form-group @error('name') has-danger @enderror">
        <label >Group Name</label>
        <input type="text" wire:model="name" class="form-control" placeholder="Enter group name">
        @error('name')
        <label id="question-error" class="error mt-2 text-danger" >{{$message}}</label>
        @enderror
    </div>
    <div class="form-group @error('order') has-danger @enderror">
        <label >Group Order (Positive integer e.g 1,2 etc)</label>
        <input type="number" wire:model="order" class="form-control" placeholder="Enter group order">
        @error('name')
        <label id="question-error" class="error mt-2 text-danger" >{{$message}}</label>
        @enderror
    </div>

    <button type="submit" wire:loading.remove wire:target="store" class="btn btn-gradient-primary mr-2">Submit</button>
    <div wire:loading class="loader"></div>
</form>
