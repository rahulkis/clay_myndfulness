<form wire:submit.prevent='store'>
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-6 @error("name") has-danger @enderror">
                {!! Form::label("name", "Name", ["class" => "label-control"]) !!}
                {!! Form::text("name", null, ["class" => "form-control", "wire:model" => "name", "placeholder" =>
                "Name"]) !!}
                @error ('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-6 @error("product_uid") has-danger @enderror">
                <label for="product_uid" class="label-control">Apple product ID</label>
                <input type="text" class="form-control" wire:model="product_uid" placeholder="Apple Product ID">
                @error ('product_uid')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-6 @error("product_uid_google") has-danger @enderror">
                <label for="product_uid_google" class="label-control">Google product ID</label>
                <input type="text" class="form-control" wire:model="product_uid_google" placeholder="Google Product ID">
                @error ('product_uid_google')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-6 @error("description") has-danger @enderror">
                {!! Form::label("description", "Description", ["class" => "label-control"]) !!}
                {!! Form::textarea("description", null, ["class" => "form-control", "placeholder" => "Description",
                "rows" => 5, "wire:model" => "description"]) !!}
                @error ('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6 @error("is_paid") has-danger @enderror">
                {!! Form::label("is_paid", "Free/Paid", ["class" => "label-control"]) !!}
                {!! Form::select("is_paid", ["" => "SELECT"] + $this->services, null, ["class" => "form-control", "wire:model" => "is_paid"]) !!}
                @error ('is_paid')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-6 @error("price") has-danger @enderror">
                {!! Form::label("price", "Plan price ", ["class" => "label-control"]) !!}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-gradient-primary text-white" id="basic-addon1">{{config('modules.currency')}}</span>
                    </div>
                {!! Form::number("price", null, ["class" => "form-control text-right", "step" => "0.01", "wire:model" => "price",
                "disabled" => !$is_paid ? true : false])
                !!}
                </div>
                @error ('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-6 @error("duration") has-danger @enderror">
                {!! Form::label("duration", "Duration <small class='text-muted'>in days</small>", ["class" =>
                "label-control"], false) !!}
                {!! Form::number("duration", null, ["class" => "form-control text-right", "step" => "0", "wire:model" =>
                "duration", "disabled" => !$is_paid ? true : false]) !!}
                @error ('duration')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">

            <div class="form-group col-6 @error("is_habit_limited") has-danger @enderror">
                {!! Form::label("is_habit_limited", "Habit Creation ".implode("/", array_values($limitTypes)), ["class"
                => "label-control"]) !!}
                {!! Form::select("is_habit_limited", ["" => "SELECT"] + $limitTypes, null, ["class" => "form-control", "wire:model" =>
                "is_habit_limited"]) !!}
                @error ('is_habit_limited')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

                <div class="form-group col-6 @error("habit_limit") has-danger @enderror">
                    {!! Form::label("habit_limit", "Habit Limit (numeric)", ["class" => "label-control"], false) !!}
                    {!! Form::number("habit_limit", null, ["class" => "form-control text-right", "step" => "0", "wire:model" =>
                    "habit_limit", "disabled" => !$is_habit_limited ? true : false]) !!}
                    @error ('habit_limit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
        </div>
        <div class="row">

            <div class="form-group col-6 @error("is_self_assessment_limited") has-danger @enderror">
                {!! Form::label("is_self_assessment_limited", "Self assessment ".implode("/", array_values($limitTypes)), ["class" => "label-control"]) !!}
                {!! Form::select("is_self_assessment_limited",  ["" => "SELECT"] + $limitTypes, null, ["class" => "form-control",
                "wire:model" => "is_self_assessment_limited"]) !!}
                @error ('is_self_assessment_limited')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
                <div class="form-group col-6 @error("self_assessment_limit") has-danger @enderror">
                    {!! Form::label("self_assessment_limit", "Self assessment Limit (numeric)", ["class" =>
                    "label-control"], false) !!}
                    {!! Form::number("self_assessment_limit", null, ["class" => "form-control text-right", "step" => "0",
                    "wire:model" => "self_assessment_limit", "disabled" => !$is_self_assessment_limited ? true : false]) !!}
                    @error ('self_assessment_limit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
        </div>
        <div class="row">

            <div class="form-group col-6 @error("is_daily_journal_limited") has-danger @enderror">
                {!! Form::label("is_daily_journal_limited", "Daily journal ".implode("/", array_values($limitTypes)),
                ["class" => "label-control"]) !!}
                {!! Form::select("is_daily_journal_limited",  ["" => "SELECT"] + $limitTypes, null, ["class" => "form-control", "wire:model"
                => "is_daily_journal_limited"]) !!}
                @error ('is_daily_journal_limited')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-6 @error("daily_journal_limit") has-danger @enderror">
                {!! Form::label("daily_journal_limit", "Daily journal Limit (numeric)", ["class" => "label-control"],
                false) !!}
                {!! Form::number("daily_journal_limit", null, ["class" => "form-control text-right", "step" => "0", "wire:model" =>
                "daily_journal_limit","disabled" => !$is_daily_journal_limited ? true : false]) !!}
                @error ('daily_journal_limit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <hr />
    <div class="modal-footer">
        <button type="submit" class="btn btn-gradient-primary btn-md">Submit</button>
    </div>
</form>
