<h1>Выберите группу</h1>
<label for="group">Выберите номер группы
    <select class="multiselect form-control" data-select-type="single" name="group" id="group">
        @foreach ($groups as $group)
            <option value="{!! $group->group !!}">Группа №{!! $group->group !!}</option>
        @endforeach
    </select>
</label>