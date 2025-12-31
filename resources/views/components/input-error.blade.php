@props(['messages'])

@if ($messages)
    <ul style="color:red">
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
