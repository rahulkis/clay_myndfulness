<div >
    @if($question)
    <div >
        <h4>Question Type: </h4>
        <p>
            {{$question->type}}
        </p>
        <h4>Question : </h4>
        <p>
            {{$question->question}}
        </p>
        <h4>Explanation : </h4>
        <p>
            {{$question->explanation}}
        </p>
        @if($question->type == 'Single Answer Choice' || $question->type == 'Multiple Answer Choice')
        <h4>Options : </h4>
        @foreach($question->options as $key => $option)
        <p>{{$key + 1}} . {{$option->text}}</p>
        <h6 class="text-info">Related Habbits</h6>
        @forelse(habbitsFromCommaSeparatedIds($option->related_habbits) as $habbit)
        <span class="badge badge-dark m-2" >{{$habbit->name}}</span>
        @empty
        N/A
        @endforelse
        @endforeach
        @endif
    </div>
    @endif
    <div class="loader" wire:loading></div>
</div>
