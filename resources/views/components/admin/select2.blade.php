<select id="{{ $id }}" name="{{ $name }}" @class($class) {{ $attributes }}>
    @if ($placeholder)
    <option {{ $selectPlaceholder ? '' : 'disabled' }} {{ empty($selected) ? 'selected' : '' }} value="">{{ $placeholder
        }}</option>
    @endif

    @foreach ($values as $key => $value)
    <option value="{{ $key }}" {{ ($selected==$key) ? 'selected' : '' }}>{{ $value }}</option>
    @endforeach
</select>
