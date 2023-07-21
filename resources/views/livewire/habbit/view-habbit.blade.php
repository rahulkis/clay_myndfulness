<div >
    @if($habbit)
    <div >
        <h4 class="text-center">{{$habbit->name}}</h4>
        <h4 class="text-center">{{$habbit->category->name ?? "NA"}}</h4>
        <div class="p-4 text-center">
            <img width="80" src="{{asset('storage/'.$habbit->image)}}" alt="">
        </div>
        <p>
            {{$habbit->description}}
        </p>
    </div>
    @endif
    <div class="loader" wire:loading></div>
</div>
