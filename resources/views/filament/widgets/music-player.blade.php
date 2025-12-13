<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .spinning {
                animation: spin 4s linear infinite;
            }
        </style>

        <h1 style="font-size: 20px; font-weight: bold; margin-bottom: 8px;">Music Player</h1>
        <div style="display: flex; align-items: center; gap: 16px; justify-content: flex-start; width: 100%;">

            {{-- Cover Image --}}
            <img id="coverImage"
                src="{{ asset($song->image_path ? 'storage/' . $song->image_path : 'storage/images/base_gradient.jpg') }}"
                alt="Cover Image"
                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; padding: 4px;">

            <div style="padding: 4px;">
                {{-- Song & Artist --}}
                <div style="padding-bottom: 2px; font-weight: 600; font-size:20px;">{{ $song->name }}</div>
                <div style="padding-bottom: 8px; color: #6b7280;font-size:10px;">{{ $song->artist->name }}</div>
            </div>

        </div>
        {{-- Audio Player --}} <audio id="audioPlayer" controls preload="metadata"
            style="width: 100%; margin-top: 16px;">
            <source src="{{ asset('storage/' . $song->file_path) }}" type="audio/mpeg"> Your browser does not support
            the audio element.
        </audio>


    </x-filament::section>
</x-filament-widgets::widget>
