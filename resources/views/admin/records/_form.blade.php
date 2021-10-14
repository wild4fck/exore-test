<div class="shadow card">
    <div class="card-header">
        <button type="submit" class="btn btn-primary float-right">Сохранить</button>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab"
                   aria-controls="general" aria-selected="true"><i class="fas fa-home"></i> Main</a>
            </li>
        </ul>
    </div>
    <div class="card-body">

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter name"
                           value="{{ $record->name ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="">Category</label>
                    <select class="form-control" name="category_id" required>
                        @include('admin.records._category')
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Picture</label>
                    <exore-multiply-crop :sizes="{{json_encode([
                        ['width' => 318, 'height' => 318]
                    ])}}" :cur-images="{{json_encode($record ? array_map(function (\App\Models\Image $image){
                                                return $image->getUrl();
                                            }, $record->images()) : [])}}">
                    </exore-multiply-crop>
                </div>

            </div>
        </div>

    </div>
</div>
