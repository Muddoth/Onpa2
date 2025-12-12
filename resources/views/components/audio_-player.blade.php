@if($filePath)
    <audio controls style="width: 100%;">
        <source src="{{ asset('storage/' . $filePath) }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
@endif
