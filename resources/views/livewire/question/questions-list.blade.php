<div class="card-body table-responsive">
    <div class="row">
        <div class="col-md-6">
            <h4 class="card-title">QUESTIONS LIST</h4>
        </div>
        <div class="col-md-6">
            <input type="text" wire:model="search" class="form-control" id="name" placeholder="Search">
        </div>
    </div>
    @if ($questions->count())
        <table class="table table-hover" wire:loading.class='loading'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $key => $question)
                    <tr>
                        <td>{{ $questions->firstItem() + $key }}</td>
                        <td>
                            {{Str::words($question->question, 10, ' ...')}}
                        </td>
                        <td>{{ $question->type }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="{{route('questions.edit',['question_id' => $question->id])}}" class="btn btn-outline-primary btn-sm" title="Edit"><i class="mdi mdi-table-edit"></i></a>
                                <button wire:click="$emitTo('question.view-question','setQuestion',{{$question->id}})" data-toggle="modal" data-target="#view-question" type="button" class="btn btn-outline-secondary btn-sm" title="View Details"><i class="mdi mdi-eye "></i></button>
                                <button type="button" wire:click="$emit('delete',{{$question->id}})" class="btn btn-outline-danger btn-sm" title="Delete"><i class="mdi mdi-delete "></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-primary d-flex justify-content-end mt-2">
            {{ $questions->links() }}
        </div>
    @else
        <x-not-found :title="'No questions Found'" size="400"></x-not-found>
    @endif
</div>
