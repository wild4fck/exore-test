<div class="row">
    <div class="col-sm-6">
        @foreach($list as $item)
            <div class="custom-control custom-radio">
                <input type="radio" id="published1" name="type" class="custom-control-input" value="{{$item['code']}}"
                       @if ($active === $item['code']) checked="" @endif>
                <label class="custom-control-label" for="published1">{{$item['name']}}</label>
            </div>
        @endforeach
    </div>
    <div class="col-sm-6">
        <button type="submit" class="btn btn-primary float-right">Сохранить</button>
    </div>
</div>


